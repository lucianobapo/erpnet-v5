<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (class_exists(\Laravel\Cashier\CashierServiceProvider::class)){
            \Braintree_Configuration::environment(config('services.braintree.environment'));
            \Braintree_Configuration::merchantId(config('services.braintree.merchant_id'));
            \Braintree_Configuration::publicKey(config('services.braintree.public_key'));
            \Braintree_Configuration::privateKey(config('services.braintree.private_key'));
            \Laravel\Cashier\Cashier::useCurrency('brl', 'R$');
        }

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        if (config('app.env')=='local' && class_exists(\Barryvdh\Debugbar\ServiceProvider::class))
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);

        if (class_exists(\Laravel\Cashier\CashierServiceProvider::class))
            $this->app->register(\Laravel\Cashier\CashierServiceProvider::class);

        if (class_exists(\ErpNET\Bot\Providers\ErpnetBotServiceProvider::class))
            $this->app->register(\ErpNET\Bot\Providers\ErpnetBotServiceProvider::class);

        if (class_exists(\ErpNET\Migrates\Providers\ErpnetMigratesServiceProvider::class))
            $this->app->register(\ErpNET\Migrates\Providers\ErpnetMigratesServiceProvider::class);

        if (class_exists(\ErpNET\Models\Providers\ErpnetModelsServiceProvider::class))
            $this->app->register(\ErpNET\Models\Providers\ErpnetModelsServiceProvider::class);

        if (class_exists(\ErpNET\Delivery\Providers\ErpnetDeliveryServiceProvider::class))
            $this->app->register(\ErpNET\Delivery\Providers\ErpnetDeliveryServiceProvider::class);

        if (class_exists(\ErpNET\Auth\Providers\ErpnetAuthServiceProvider::class))
            $this->app->register(\ErpNET\Auth\Providers\ErpnetAuthServiceProvider::class);

        if (class_exists(\ErpNET\WidgetResource\Providers\ErpnetWidgetResourceServiceProvider::class))
            $this->app->register(\ErpNET\WidgetResource\Providers\ErpnetWidgetResourceServiceProvider::class);

        if (class_exists(\ErpNET\SocialAuth\Providers\ErpnetSocialAuthServiceProvider::class))
            $this->app->register(\ErpNET\SocialAuth\Providers\ErpnetSocialAuthServiceProvider::class);

    }
}
