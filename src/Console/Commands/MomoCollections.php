<?php

namespace LaMomo\Console\Commands;

use Illuminate\Console\Command;
use LaMomo\Facades\Collections;
use LaMomo\Support\Traits\SDKConsole;

class MomoCollections extends Command
{
    use SDKConsole;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'momo:collections';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets collections product environment variables';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->_product = "Collections product";
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
        $apiUser = Collections::getApiUser();
        dump($apiUser);
    }

    // COLLECTIONS_PRIMARY
    // COLLECTIONS_SECONDARY
    // COLLECTIONS_API_USER
    // COLLECTIONS_API_KEY
    // COLLECTIONS_CALLBACK_URL
}
