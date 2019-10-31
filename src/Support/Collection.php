<?php

namespace LaMomo\Support;

use Illuminate\Cache\CacheManager;
use LaMomo\Commons\MomoLinks;
use LaMomo\Support\Traits\PerformsTransfer;
use LaMomo\Contracts\MomoProduct;

class Collection extends BaseMomoModel  implements MomoProduct
{
    use PerformsTransfer;

    public function __construct(CacheManager $cache)
    {
        parent::__construct($cache, 'collection');
        $this->transfer_uri = $this->getUri(MomoLinks::REQUEST_TO_PAY_URI);
    }
}
