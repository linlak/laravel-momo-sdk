<?php

namespace LaMomo\Support;

use LaMomo\Contracts\MomoProduct;
use Illuminate\Cache\CacheManager;

class Disbursements extends BaseMomoModel implements MomoProduct
{
    public function __construct(CacheManager $cache)
    {
        parent::__construct($cache, 'disbursement');
    }
}
