<?php

namespace Dcat\Admin\Contracts;

use Spatie\MailTemplates\Interfaces\MailTemplateInterface;

interface DomainMailTemplateInterface extends MailTemplateInterface
{
    public function getEmailDepartment(): ?MailDepartmentInterface;
}
