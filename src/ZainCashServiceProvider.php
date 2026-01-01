<?php

namespace Ht3aa\ZainCash;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Ht3aa\ZainCash\Commands\ZainCashCommand;

class ZainCashServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('zain-cash')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_zain_cash_table')
            ->hasCommand(ZainCashCommand::class);
    }
}
