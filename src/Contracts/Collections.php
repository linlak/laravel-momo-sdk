<?php

namespace LaMomo\Contracts;

interface Collections extends MomoProduct
{
    public function requestToPayStatus($refrenceId);
}
