<?php

namespace LaMomo\Console\Commands;

use Illuminate\Console\Command;
use LaMomo\Support\Traits\SDKConsole;
use Illuminate\Support\Str;

class MomoInitialization extends Command
{
    use SDKConsole;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'momo:init
        {--f|force : Skip confirmation when overwriting an existing key.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets Momo APi environment variables';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->showWelcome();
        $this->runInit();
    }
    private function runInit()
    {
        $path = $this->envPath();
        //set base url
        if (Str::contains(file_get_contents($path), 'MOMO_BASE') === false) {
            $momo_base = $this->ask("Enter Momo EndPoint :", 'https://sandbox.momodeveloper.mtn.com/');
            $this->writekey($path, 'MOMO_BASE', $momo_base);
        } else if ($this->isConfirmed("Do you want to overwrite Momo Endpoint?")) {
            $momo_base = $this->ask("Enter Momo EndPoint :", 'https://sandbox.momodeveloper.mtn.com/');
            if (is_null($momo_base)) {
                $momo_base = "https://sandbox.momodeveloper.mtn.com/";
            }
            $this->overwritekey($path, 'MOMO_BASE', $momo_base, 'base_uri');
        }

        //set version
        if (Str::contains(file_get_contents($path), 'MOMO_API_VERSION') === false) {
            $momo_version = $this->ask("Enter Momo Version :", 'v1_0');
            $this->writekey($path, 'MOMO_API_VERSION', $momo_version);
        } else if ($this->isConfirmed("Do you want to overwrite Momo Version?")) {
            $momo_version = $this->ask("Enter Momo Version :", 'v1_0');
            if (is_null($momo_version)) {
                $momo_version = "v1_0";
            }
            $this->overwritekey($path, 'MOMO_API_VERSION', $momo_version, 'api_version');
        }
        //set environment
        if (Str::contains(file_get_contents($path), 'MOMO_ENVIRONMENT') === false) {
            $momo_environ = $this->ask("Enter Momo Version :", 'sandbox');
            $this->writekey($path, 'MOMO_ENVIRONMENT', $momo_environ);
        } else if ($this->isConfirmed("Do you want to overwrite Momo Environment?")) {
            $momo_environ = $this->ask("Enter Momo Environment :", 'sandbox');
            if (is_null($momo_environ)) {
                $momo_environ = "sandbox";
            }
            $this->overwritekey($path, 'MOMO_ENVIRONMENT', $momo_environ, 'environment');
        }
        //set tags
        if (Str::contains(file_get_contents($path), 'DISABLE_TAGS') === false) {
            $momo_tags = $this->askWithCompletion(" Disable cache tags :", [true, false], false);
            $this->writekey($path, 'DISABLE_TAGS', $momo_tags);
        } else if ($this->isConfirmed("Do you want to disable cache tags?")) {
            $momo_tags = $this->askWithCompletion(" Disable cache tags :", [true, false], false);
            $this->overwritekey($path, 'DISABLE_TAGS', $momo_tags, 'tagsenabled');
        }

        //set tags
        if (Str::contains(file_get_contents($path), 'MOMO_HOST') === false) {
            $momo_host = $this->ask(" Enter Callback Host :", '');
            $this->writekey($path, 'MOMO_HOST', $momo_host);
        } else if ($this->isConfirmed("Do you want to edit Callback Host?")) {
            $momo_host = $this->ask(" Enter Callback Host :", '');
            $this->overwritekey($path, 'MOMO_HOST', $momo_host, 'hostname');
        }
    }
}
