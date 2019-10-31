<?php

namespace LaMomo\Console\Commands;

use Illuminate\Console\Command;
use LaMomo\Facades\Disbursements;
use LaMomo\Support\Traits\SDKConsole;

class MomoDisbursents extends Command
{
    use SDKConsole;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'momo:disbursements
        {--f|force : Skip confirmation when overwriting an existing key.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets disbursements product environment variables';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->_product = "Disbursements product";
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

        $apiUser = Disbursements::getApiUser();
        dump($apiUser);
    }
    public function initDisbursements()
    {
        $path = $this->envPath();

        if (Str::contains(file_get_contents($path), 'DISBURSEMENTS_PRIMARY') === false) {
            $disbursements_primary = $this->ask("Enter DISBURSEMENTS_PRIMARY :", '');
            $this->writekey($path, 'DISBURSEMENTS_PRIMARY', $disbursements_primary);
        } else if ($this->isConfirmed("Do you want to overwrite DISBURSEMENTS_PRIMARY?")) {
            $disbursements_primary = $this->ask("Enter DISBURSEMENTS_PRIMARY :", '');

            $this->overwritekey($path, 'DISBURSEMENTS_PRIMARY', $disbursements_primary, 'disbursement.primarykey');
        }


        if (Str::contains(file_get_contents($path), 'DISBURSEMENTS_SECONDARY') === false) {
            $disbursements_sec = $this->ask("Enter DISBURSEMENTS_SECONDARY :", '');
            $this->writekey($path, 'DISBURSEMENTS_SECONDARY', $disbursements_sec);
        } else if ($this->isConfirmed("Do you want to overwrite DISBURSEMENTS_SECONDARY?")) {
            $disbursements_sec = $this->ask("Enter DISBURSEMENTS_SECONDARY :", '');

            $this->overwritekey($path, 'DISBURSEMENTS_SECONDARY', $disbursements_sec, 'disbursement.secondarykey');
        }
    }


    // DISBURSEMENTS_API_KEY

    // DISBURSEMENTS_API_USER

    // DISBURSEMENTS_CALLBACK_URL


}
