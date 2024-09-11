<?php

declare(strict_types=1);

namespace Galeas\Api\BoundedContext\Messaging\OneToOneConversation\CommandHandler\RejectOneToOneConversation;

use Galeas\Api\Common\ExceptionBase\AccessDeniedException;

class ConversationIsExpired extends AccessDeniedException
{
    public static function getErrorIdentifier(): string
    {
        return 'Messaging_OneToOneConversation_RejectOneToOneConversation_ConversationIsExpired';
    }
}
