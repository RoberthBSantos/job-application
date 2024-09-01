<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * O namespace do controlador para o roteamento da aplicação.
     *
     * Quando presente, os URLs do gerador de rota do Laravel serão automaticamente
     * prefixados com este namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Defina suas rotas de aplicativo.
     *
     * @return void
     */
    public function map()
    {
        // Defina as rotas da API
        $this->mapApiRoutes();

        // Defina as rotas da Web
        $this->mapWebRoutes();
    }

    /**
     * Defina as rotas da API para o aplicativo.
     *
     * Essas rotas recebem middleware "api" e fazem parte do grupo "api".
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::middleware('api')
            ->namespace($this->namespace . '\API')
            ->group(base_path('routes/api.php'));
    }

    /**
     * Defina as rotas da Web para o aplicativo.
     *
     * Essas rotas recebem middleware "web" e fazem parte do grupo "web".
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace . '\Web')
            ->group(base_path('routes/web.php'));
    }
}
