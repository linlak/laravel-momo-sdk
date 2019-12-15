<?php

namespace LaMomo\Support;

use Illuminate\Cache\CacheManager;
use LaMomo\Contracts\Remittances;

class RemittancesService extends BaseMomoModel implements Remittances
{
    public function __construct(CacheManager $cache)
    {
        parent::__construct($cache, 'remittance');
    }
}
