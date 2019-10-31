<?php

namespace LaMomo\Console\Commands;

use Illuminate\Console\Command;
use LaMomo\Facades\Remittances;
use LaMomo\Support\Traits\SDKConsole;

class MomoRemittances extends Command
{
    use SDKConsole;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'momo:remittances';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets remittances product environment variables';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->_product = "Remittances product";
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $this->showWelcome();
        $apiUser = Remittances::getApiUser();
        dump($apiUser);
    }
    //REMITTANCES_PRIMARY
    // REMITTANCES_SECONDARY
    // REMITTANCES_API_KEY
    // REMITTANCES_API_USER
    // REMITTANCES_CALLBACK_URL
}
