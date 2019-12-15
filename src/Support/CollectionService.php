<?php

namespace LaMomo\Support;

use Illuminate\Cache\CacheManager;
use LaMomo\Commons\MomoLinks;
use LaMomo\Contracts\Collections;
use LaMomo\Support\Traits\PerformsTransfer;

class CollectionService extends BaseMomoModel implements Collections
{
    use PerformsTransfer;

    public function __construct(CacheManager $cache)
    {
        parent::__construct($cache, 'collection');
        $this->transfer_uri = $this->getUri(MomoLinks::REQUEST_TO_PAY_URI);
    }
}
