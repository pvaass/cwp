<?php namespace Pvaass\AzureFileDriver\Provider;


use League\Flysystem\Azure\AzureAdapter;
use League\Flysystem\Filesystem;
use MicrosoftAzure\Storage\Common\ServicesBuilder;
use Pvaass\AzureFileDriver\Exception\AzureStorageException;

class AzureServiceProvider extends \Illuminate\Support\ServiceProvider
{
    const REQUIRED_CONFIG = ['account', 'key', 'container'];

    public function boot()
    {
        $this->addAzureDriver();
    }

    public function addAzureDriver()
    {
        \Storage::extend('azure', function ($app, $config) {
            $this->validateConfig($config);

            $endpoint = sprintf(
                'DefaultEndpointsProtocol=https;AccountName=%s;AccountKey=%s',
                $config['account'],
                $config['key']
            );

            $blobRestProxy = ServicesBuilder::getInstance()->createBlobService($endpoint);

            return new Filesystem(
                new AzureAdapter($blobRestProxy, $config['container'])
            );
        });
    }

    protected function validateConfig($config)
    {
        $missingConfigs = array_diff_key(array_flip(static::REQUIRED_CONFIG), $config);
        if (sizeof($missingConfigs) > 0) {
            throw new AzureStorageException(
                'Missing required config value(s) for Azure driver: ' .
                implode(array_keys($missingConfigs), ",")
            );
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}