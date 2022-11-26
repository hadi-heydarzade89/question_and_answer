<?php declare(strict_types=1);

namespace HadiHeydarzade89\QuestionAndAnswer;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class QuestionAndAnswerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/' => config_path('/'),
            __DIR__ . '/database/migrations/' => database_path('migrations'),
            __DIR__ . '/database/seeders' => database_path('seeders'),
            __DIR__ . '/Enums/' => app_path('Enums'),
            __DIR__ . '/lang/en/' => base_path('lang/en/'),
            __DIR__ . '/Models/' => app_path('Models'),
            __DIR__ . '/Providers' => app_path('Providers'),
            __DIR__ . '/Repositories' => app_path('Repositories'),
            __DIR__ . '/routes' => base_path('routes'),
            __DIR__ . '/Services' => app_path('Services'),
        ]);


        (new Filesystem)->copyDirectory(__DIR__ . '/Http/', app_path('Http'));
        (new Filesystem)->copy(__DIR__ . '/Exceptions/Handler.php', app_path('Exceptions/Handler.php'));

    }

    public function register()
    {

    }

}
