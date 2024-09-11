<?php

declare(strict_types=1);

namespace Galeas\Api\BoundedContext\Messaging\OneToOneConversation\CommandHandler\PullOneToOneConversation;

use Galeas\Api\Common\ExceptionBase\NotFoundException;

class ConversationDoesNotExist extends NotFoundException
{
    public static function getErrorIdentifier(): string
    {
        return 'Messaging_OneToOneConversation_PullOneToOneConversation_ConversationDoesNotExist';
    }
}
