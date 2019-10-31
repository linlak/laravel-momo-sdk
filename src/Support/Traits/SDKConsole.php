<?php

namespace LaMomo\Support\Traits;

trait SDKConsole
{
    protected $bar;
    protected $_product = "Momo Api";
    protected function showWelcome()
    {
        $this->line('Welcome to Laravel Momo Api package designed by Linworld Tech-Solutions');
        $this->line('You are about to setup ' . $this->_product . ' environment variables');
    }
    protected function showBar()
    {
        $this->bar = $this->output->createProgressBar(100);
        $this->bar->start(1);
        for ($i = 0; $i < 99; $i++) {
            $this->line('Now at: ' . $i);
            $this->bar->advance();
            sleep(1);
        }
        $this->bar->finish();
    }
    /**
     * Check if the modification is confirmed.
     *
     * @return bool
     */
    protected function isConfirmed($msg = 'This will invalidate all existing tokens. Are you sure you want to override the secret key?')
    {
        return $this->option('force') ? true : $this->confirm($msg);
    }
    protected function writekey($path, $key, $value)
    {
        file_put_contents($path, PHP_EOL . "$key=$value", FILE_APPEND);

        $this->info('.env file updated successfully [' . $key . '=' . $value . ']');
    }
    protected function overwritekey($path, $key, $value, $conf_item)
    {
        // create new entry
        file_put_contents($path, str_replace(
            $key . '=' . $this->laravel['config']['momosdk.' . $conf_item],
            $key . '=' . $value,
            file_get_contents($path)
        ));

        $this->info($key . ' has been replaced from ' . $this->laravel['config']['momosdk.' . $conf_item] . ' to ' . $value);
    }
    /**
     * Get the .env file path.
     *
     * @return string
     */
    protected function envPath()
    {
        if (method_exists($this->laravel, 'environmentFilePath')) {
            return $this->laravel->environmentFilePath();
        }

        // check if laravel version Less than 5.4.17
        if (version_compare($this->laravel->version(), '5.4.17', '<')) {
            return $this->laravel->basePath() . DIRECTORY_SEPARATOR . '.env';
        }

        return $this->laravel->basePath('.env');
    }
}
