<?php

namespace Dcat\Admin;

use ReflectionClass;
use Dcat\Admin\Models\DomainEmail;
use Illuminate\Bus\Queueable;
use Dcat\Admin\Models\DomainMailTemplate;
use Illuminate\Queue\SerializesModels;
use Spatie\MailTemplates\TemplateMailable;
use Dcat\Admin\Contracts\MailDepartmentInterface;
use Dcat\Admin\Contracts\DomainMailTemplateInterface;
use Dcat\Admin\Contracts\DomainNotificationWithContextInterface;

class DomainTemplateMailable extends TemplateMailable
{
    use Queueable, SerializesModels;

    protected static $templateModelClass = DomainMailTemplate::class;

    /** @var DomainMailTemplateInterface */
    protected $mailTemplate;

    private DomainNotificationWithContextInterface $notification;
    private $layout;

    public function __construct(DomainNotificationWithContextInterface $notification) {
        $this->notification = $notification;
    }

    public static function getVariableDefaults(): array
    {
        $class = new ReflectionClass(static::class);
        $publics = self::getVariables();

        return collect($class->getDefaultProperties())
            ->filter(function($value, $key) use($publics): bool {
                return in_array($key, $publics);
            })
            ->values()
            ->all();
    }

    public static function makeWithFakeData(string $subject, string $template, MailDepartmentInterface $dep, DomainNotificationWithContextInterface $notification) : DomainTemplateMailable {
        $options = self::getVariableDefaults();
        $options[] = $notification;

        $obj = new static(...$options);
        $obj->mailTemplate = new MailTemplateFake($subject, $template, $dep);

        return $obj;
    }

    public function getMailTemplate(): DomainMailTemplateInterface
    {
        return $this->mailTemplate ?? $this->resolveTemplateModel();
    }

    public function getDomainId(): int
    {
        return $this->notification->getDomainId();
    }

    public function getEmailDepartment(): ?MailDepartmentInterface
    {
        return $this->getMailTemplate()->getEmailDepartment();
    }

    public function getHtmlLayout(): string
    {
        if(!empty($this->layout))
            return $this->layout;

        try {
            return view('emails.layout', [])->render();
        } catch (\Throwable $e) {
        }

        return "{{{body}}}";
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    protected function resolveTemplateModel(): DomainMailTemplateInterface
    {
        return $this->mailTemplate = static::$templateModelClass::findForMailable($this);
        //return $this->mailTemplate = DomainMailTemplate::findForDomainMailable($this);
    }

    public function build()
    {
        parent::build();

        $notification = $this->notification;
        $dep = $this->getEmailDepartment();

        $this->withSymfonyMessage(function ($message) use($notification, $dep) {
            $headers = $message->getHeaders();
            $headers->addTextHeader(DomainEmail::HEADER_DOMAIN_ID, $notification->getDomainId());
            $headers->addTextHeader(DomainEmail::HEADER_DEPARTMENT_ID, $dep->getId());

            $context = $notification->getContextObject();

            if(!is_null($context)) {
                $headers->addTextHeader(DomainEmail::HEADER_CONTEXT_ID, $context->getContextId());
                $headers->addTextHeader(DomainEmail::HEADER_CONTEXT_TYPE, get_class($context));
            }
        });

        return $this;
    }
}
