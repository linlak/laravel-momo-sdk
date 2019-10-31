<?php

namespace LaMomo\Support;

use Illuminate\Cache\CacheManager;
use LaMomo\Contracts\MomoProduct;

class Remittances extends BaseMomoModel implements MomoProduct
{
    public function __construct(CacheManager $cache)
    {
        parent::__construct($cache, 'remittance');
    }
}
