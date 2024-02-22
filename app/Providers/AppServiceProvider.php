<?php

namespace App\Providers;

use AmoCRM\Client\AmoCRMApiClient;
use App\Contracts\Crm\AddLeadInterface;
use App\Contracts\Crm\AddNotesInterface;
use App\Contracts\Crm\GetAmoCRMApiClientInterface;
use App\Contracts\Crm\SaveTokenInterface;
use App\Http\Controllers\LayoutComposer;
use App\Services\AmoCrm\AddLead;
use App\Services\AmoCrm\AddNotesProducts;
use App\Services\AmoCrm\GetAmoCRMApiClient;
use App\Services\AmoCrm\SaveToFileAccessToken;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Dashboard;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SaveTokenInterface::class, SaveToFileAccessToken::class);

        $this->app->bind(AmoCRMApiClient::class, function () {
            $clientId = env('AMOCRM_CLIENT_ID');
            $clientSecret = env('AMOCRM_CLIENT_SECRET');
            $redirectUri = env('AMOCRM_REDIRECT_URI');

            return new AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
        });

        $this->app->bind(GetAmoCRMApiClientInterface::class, GetAmoCRMApiClient::class);
        $this->app->bind(AddLeadInterface::class, AddLead::class);

        $this->app->bind(AddNotesInterface::class, AddNotesProducts::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dashboard $dashboard)
    {
        Paginator::useBootstrap();

        View::composer('layout', LayoutComposer::class);
    }
}
