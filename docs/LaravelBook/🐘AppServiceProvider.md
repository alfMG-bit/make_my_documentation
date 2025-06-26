#laravel-blade #Laravel 

# ¿Qué es?

En resumidas cuentas, es un archivo llamado `Providers/AppServiceProvider.php` que configura los proveedores de servicios para el entorno de Laravel. 

# Configuraciones.

## Proveedor de Estilos.

```php
<?php
namespace App\Providers;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Paginator::useBootstrap();
    }
}
```

En la función `boot()` se configura (en este caso específico) que estilos se le darán a las [[🐘Paginación en Laravel|paginaciones]] en Laravel. Si serán en base a Tailwind o a Bootstrap, en este caso, por defecto vienen configuradas para Tailwind, pero también se puede usar Bootstrap, como en este caso.