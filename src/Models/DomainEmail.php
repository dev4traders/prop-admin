<?php

namespace Dcat\Admin\Models;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Dcat\Admin\Traits\HasDomain;
use Dcat\Admin\Traits\HasCountedEnum;
use Dcat\Admin\Models\EmailDepartment;
use Illuminate\Database\Eloquent\Model;
use Dcat\Admin\Enums\EmailDirectionType;
use Illuminate\Database\Eloquent\Builder;
use Dcat\Admin\Traits\HasDateTimeFormatter;
use Symfony\Component\Mime\MessageConverter;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DomainEmail extends Model
{
    use HasDateTimeFormatter;
    use HasDomain;
    use HasCountedEnum;
    use SoftDeletes;

    const HEADER_DEPARTMENT_ID = 'X-Mailer-Department-Id';
    const HEADER_DOMAIN_ID = 'X-Mailer-Domain-Id';
    const HEADER_CONTEXT_ID = 'X-Mailer-Context-Id';
    const HEADER_CONTEXT_TYPE = 'X-Mailer-Context-Type';

    const TABLE_NAME = 'admin_mails';

    protected $casts = [
        'direction_type' => EmailDirectionType::class
    ];

    /**
     * {@inheritDoc}
    */
    public function __construct(array $attributes = [])
    {
        $this->init();

        parent::__construct($attributes);
    }

    protected function init()
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('admin.database.domain_mails_table') ?: self::TABLE_NAME);
    }

    public function user() : BelongsTo {
        $userModel = config('admin.database.users_model');
        return $this->belongsTo($userModel, 'user_email', 'email');
    }

    public function department() : BelongsTo {
        $departmentModel = config('admin.database.email_departments_model');
        return $this->belongsTo($departmentModel, 'department_id');
    }

    public function getShortBodyAttribute() {
        return Str::words(strip_tags($this->body), 10, '...');
    }
    // public function context() : MorphOne {
    //     return $this->morphOne();
    // }

    public static function saveFromSymfonySentMessage( \Symfony\Component\Mailer\SentMessage $message ) {
        $record = new static();

        $symfonyMessage = MessageConverter::toEmail($message->getOriginalMessage());
        $headers = $symfonyMessage->getHeaders();

        $record->direction_type = EmailDirectionType::OUT;
        $record->message_id = $message->getMessageId();
        $record->user_email = $symfonyMessage->getTo()[0]->getAddress();
        $record->department_email = $symfonyMessage->getFrom()[0]->getAddress();
        $record->subject = $symfonyMessage->getSubject();
        $record->body = $symfonyMessage->getHtmlBody();

        if($headers->has(self::HEADER_DOMAIN_ID)) {
            $record->domain_id = $headers->get(self::HEADER_DOMAIN_ID)->getBodyAsString();
        }

        if($headers->has(self::HEADER_DEPARTMENT_ID)) {
            $record->department_id = $headers->get(self::HEADER_DEPARTMENT_ID)->getBodyAsString();
        }

        if($headers->has(self::HEADER_CONTEXT_ID) && $headers->has(self::HEADER_CONTEXT_TYPE)) {
            $record->context_id = $headers->get(self::HEADER_CONTEXT_ID)->getBodyAsString();
            $record->context_type = $headers->get(self::HEADER_CONTEXT_TYPE)->getBodyAsString();
        }

        $record->save();
    }

    public static function saveFromPostalWebhook(Request $request) {
        $record = new static();

        $to = $request->get('rcpt_to');

        $record->direction_type = EmailDirectionType::IN;
        $record->message_id = $request->get('message_id');
        $record->department_email = $to;
        $record->user_email = $request->get('mail_from');
        $record->subject = $request->get('subject');
        $record->body = $request->get('html_body');

        /** @var EmailDepartment $dep */
        $departmentModel = config('admin.database.email_departments_model');
        $dep = $departmentModel::with('domain')->get()->first(function($dep) use($to) {
            return $dep->emailAddress == $to;
        });

        if(!is_null($dep)) {
            $record->department_id = $dep->id;
            $record->domain_id = $dep->domain_id;
        } else {
            throw new Exception('Email Department not found. to: '. $to);
        }

        $record->save();
    }

    public function scopeIn(Builder $query) : Builder {
        return $query->where('direction_type', EmailDirectionType::IN);
    }

    public function scopeOut(Builder $query) : Builder {
        return $query->where('direction_type', EmailDirectionType::OUT);
    }

    //todo:: think more
    // public function sendReply(string $message) : void {
    //     $subject = 'RE:'.$this->subject;
    //     $reply = $message.'<blockquote>'.$this->body.'</blockquote>';

    //     dispatch(new SendCustomEmailJob(CustomMail::make($subject, $reply, $this->user, $this->department), $this->user->email));
    // }
}
