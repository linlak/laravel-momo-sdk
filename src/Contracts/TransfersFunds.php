<?php

namespace LaMomo\Contracts;

interface TransfersFunds extends MomoProduct
{
    public function transferStatus($refrenceId);
}
