<?php

namespace LaMomo\Support;

use Illuminate\Cache\CacheManager;
use LaMomo\Contracts\Disbursements;
use LaMomo\Contracts\MomoProduct;

class DisbursementsService extends BaseMomoModel implements Disbursements
{
    public function __construct(CacheManager $cache)
    {
        parent::__construct($cache, 'disbursement');
    }
}
