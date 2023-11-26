<?php

namespace Dcat\Admin;

use Illuminate\Contracts\Mail\Mailable;
use Dcat\Admin\Contracts\MailDepartmentInterface;
use Dcat\Admin\Contracts\DomainMailTemplateInterface;

class MailTemplateFake implements DomainMailTemplateInterface
{
    private string $subject;
    private string $template;
    private MailDepartmentInterface $department;

    public function __construct(string $subject, string $template, MailDepartmentInterface $department)
    {
        $this->subject = $subject;
        $this->template = $template;
        $this->department = $department;
    }

    public static function findForMailable(Mailable $mailable) {
        return null;
    }

    public function getSubject(): string {
        return $this->subject;
    }

    /**
     * Get the mail template.
     *
     * @return string
     */
    public function getHtmlTemplate(): string {
        return $this->template;
    }

    /**
     * Get the mail template.
     *
     * @return null|string
     */
    public function getTextTemplate(): ?string {
        return null;
    }

    public function getEmailDepartment(): ?MailDepartmentInterface
    {
        return $this->department;
    }    
}