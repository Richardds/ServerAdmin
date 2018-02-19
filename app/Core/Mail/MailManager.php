<?php

namespace Richardds\ServerAdmin\Core\Mail;

use Richardds\ServerAdmin\Core\MultipleServices;

class MailManager extends MultipleServices
{
    /**
     * MailManager constructor.
     */
    public function __construct()
    {
        parent::__construct(['postfix', 'dovecot']);
    }
}
