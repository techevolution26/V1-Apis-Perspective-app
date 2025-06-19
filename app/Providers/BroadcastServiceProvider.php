<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

class BroadcastServiceProvider extends ServiceProvider {
    /**
    * Bootstrap any application services.
    */

    public function boot() {
        Log::info("TEST MESSAGE - CAN YOU SEE THIS?");
        Broadcast::routes( [
            'prefix' => 'api/broadcasting',
            'middleware' => [ 'auth:sanctum' ],
        ] );

        require base_path( 'routes/channels.php' );
    }
}
