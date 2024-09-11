<?php

declare(strict_types=1);

namespace Galeas\Api\BoundedContext\Library\Folder\Query;

class GetFolderContents
{
    /**
     * @var string
     */
    public $authorizerId;

    /**
     * @var array
     */
    public $metadata;

    /**
     * @var string
     */
    public $folderId;
}
