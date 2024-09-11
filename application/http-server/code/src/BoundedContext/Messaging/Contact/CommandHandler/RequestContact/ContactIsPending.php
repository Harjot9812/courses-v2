<?php

declare(strict_types=1);

namespace Galeas\Api\BoundedContext\Messaging\Contact\CommandHandler\RequestContact;

use Galeas\Api\Common\ExceptionBase\AccessDeniedException;

class ContactIsPending extends AccessDeniedException
{
    public static function getErrorIdentifier(): string
    {
        return 'Messaging_Contact_RequestContact_ContactIsPending';
    }
}
