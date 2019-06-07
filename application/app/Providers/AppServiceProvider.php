<?php

namespace App\Providers;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        Schema::defaultStringLength(191);

        $events->Listen(BuildingMenu::class, function(BuildingMenu $event){

            $role = Auth::user()->role;

            switch($role){

                case 'administrator':
                    $event->menu->add(
                        [
                            'text' => 'Escritorio',
                            'route' => 'home',
                            'icon' => 'dashboard'
                        ],
                        [
                            'text' => 'Usuarios',
                            'route' => 'users.index',
                            'icon' => 'users'
                        ],
                        [
                            'text' => 'Mensajes',
                            'route' => 'messages.index',
                            'icon' => 'comments'
                        ],
                        [
                            'text' => 'Perfil',
                            'route' => 'profile',
                            'icon' => 'user'
                        ]
                    );
                break;

                case 'customer':
                    $event->menu->add(
                        [
                            'text' => 'Escritorio',
                            'route' => 'home',
                            'icon' => 'dashboard'
                        ],
                        [
                            'text' => 'Perfil',
                            'route' => 'profile',
                            'icon' => 'user'
                        ]
                    );
                break;

            }

            

       });
    }
}
