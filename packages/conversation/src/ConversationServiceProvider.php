<?php

namespace NahidFerdous\Conversation;

use Nahidferdous\Conversation\Console\InstallCommand;
use Nahidferdous\Conversation\Console\PublishCommand;
use Nahidferdous\Conversation\Conversation;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ConversationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/views', 'Conversation');
        $this->loadRoutes();

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                PublishCommand::class,
            ]);
            $this->publishable();
        }
    }

    public function publishable(): void
    {
        // Load user's avatar folder from package's config
        $userAvatarFolder = json_decode(json_encode(include(__DIR__ . '/config/conversation.php')))->user_avatar->folder;

        // Load Config ...
        $this->publishes([
            __DIR__ . '/config/conversation.php' => config_path('conversation.php'),
        ], 'conversation-config');

        // Migrations
        $this->publishes([
            __DIR__ . '/database/migrations/' => database_path('migrations')
        ], 'conversation-migrations');

        // Models
        $isV8 = explode('.', app()->version())[0] >= 8;
        $this->publishes([
            __DIR__ . '/Models' => app_path($isV8 ? 'Models' : '')
        ], 'conversation-models');

        // Controllers
        $this->publishes([
            __DIR__ . '/Http/Controllers' => app_path('Http/Controllers/vendor/Conversation')
        ], 'conversation-controllers');

        // Views
        $this->publishes([
            __DIR__ . '/views' => resource_path('views/vendor/courier'),
        ], 'conversation-views');

        // Assets
        $this->publishes([
            // CSS
            __DIR__ . '/assets/css' => public_path('css/conversation'),
            // JavaScript
            __DIR__ . '/assets/js' => public_path('js/conversation'),
            // Images
            __DIR__ . '/assets/imgs' => storage_path('app/public/' . $userAvatarFolder),
            // Sounds
            __DIR__ . '/assets/sounds' => public_path('sounds/conversation'),
        ], 'conversation-assets');
    }

    public function register()
    {
        $this->app->bind('Conversation', function () {
            return new Conversation();
        });

        $this->mergeConfigFrom(__DIR__ . '/config/conversation.php', 'conversation');
    }

    protected function loadRoutes(): void
    {
        Route::group($this->routesConfigurations(), function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        });
        Route::group($this->apiRoutesConfigurations(), function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        });
    }

    private function routesConfigurations(): array
    {
        return [
            'prefix' => config('conversation.routes.prefix'),
            'namespace' => config('conversation.routes.namespace'),
            'middleware' => config('conversation.routes.middleware'),
        ];
    }

    private function apiRoutesConfigurations(): array
    {
        return [
            'prefix' => config('conversation.api_routes.prefix'),
            'namespace' => config('conversation.api_routes.namespace'),
            'middleware' => config('conversation.api_routes.middleware'),
        ];
    }
}
