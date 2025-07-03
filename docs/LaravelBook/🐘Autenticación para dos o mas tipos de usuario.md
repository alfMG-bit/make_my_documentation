---
tags:
  - auth
  - config
  - Eloquent
  - controllers
  - models
  - DataBases
  - Laravel
---
Fuente: [Deepseek](https://chat.deepseek.com/a/chat/s/bc26cda4-0607-406f-b88c-0371cd508f6b)

### 1. **Configurar la base de datos**
```bash
php artisan make:migration create_artists_table
```
En la migración de `artists`, replica las columnas de la tabla `users` (incluyendo `email`, `password`, etc.) y añade campos específicos para artistas si es necesario.

Ejemplo:
```php
// En la migración artists
$table->string('nombre_artistico')->unique();
// ... otras columnas como en users
```

### 2. **Crear modelos y configurar autenticación**
a. **Modelo Artist**:
```bash
php artisan make:model Artist
```

b. Configurar ambos modelos para autenticación:
```php
// En User.php y Artist.php
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable { ... }

class Artist extends Authenticatable { ... }
```

### 3. **Configurar guards en `config/auth.php`**
```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    
    'artist' => [  // Nuevo guard
        'driver' => 'session',
        'provider' => 'artists',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
    
    'artists' => [  // Nuevo provider
        'driver' => 'eloquent',
        'model' => App\Models\Artist::class,
    ],
],
```

### 4. **Crear controladores para artistas**
```bash
php artisan make:controller ArtistAuth/RegisteredUserController
php artisan make:controller ArtistAuth/AuthenticatedSessionController
```

Ejemplo para `RegisteredUserController`:
```php
use App\Models\Artist;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

public function store(Request $request) {
    $request->validate([...]);  // Tus reglas de validación

    $artist = Artist::create([
        'nombre_artistico' => $request->nombre_artistico,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    event(new Registered($artist));
    Auth::guard('artist')->login($artist);
    return redirect(RouteServiceProvider::ARTIST_HOME);
}
```

### 5. **Configurar rutas**
En `routes/web.php`:
```php
// Rutas para usuarios normales
Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisteredUserController::class, 'create']);
    Route::post('/register', [RegisteredUserController::class, 'store']);
    // ... otras rutas de login
});

// Rutas para artistas
Route::group(['prefix' => 'artist', 'middleware' => 'guest'], function () {
    Route::get('/register', [ArtistRegisteredUserController::class, 'create'])->name('artist.register');
    Route::post('/register', [ArtistRegisteredUserController::class, 'store']);
    // ... rutas de login similares
});

// Rutas autenticadas para artistas
Route::group(['prefix' => 'artist', 'middleware' => 'auth:artist'], function () {
    Route::get('/dashboard', function () {
        return view('artist.dashboard');
    })->name('artist.dashboard');
});
```

### 6. **Duplicar y modificar vistas de Breeze**
Crea una nueva carpeta `resources/views/artist/auth` y copia aquí todas las vistas de Breeze (`register.blade.php`, `login.blade.php`, etc.).

Modifica los formularios para que apunten a las rutas de artista:
```php
// En register.blade.php (artista)
<form action="{{ route('artist.register') }}" method="POST">
```

### 7. **Modificar redirecciones**
En `app/Providers/RouteServiceProvider.php`:
```php
public const HOME = '/dashboard';
public const ARTIST_HOME = '/artist/dashboard';
```

### 8. **Middleware de redirección**
Modifica `app/Http/Middleware/RedirectIfAuthenticated.php`:
```php
public function handle($request, Closure $next, ...$guards) {
    $guards = empty($guards) ? [null] : $guards;

    foreach ($guards as $guard) {
        if (Auth::guard($guard)->check()) {
            return $guard == 'artist' 
                ? redirect()->route('artist.dashboard')
                : redirect(RouteServiceProvider::HOME);
        }
    }
    return $next($request);
}
```

### 9. **Probar el flujo**
```bash
php artisan migrate:fresh --seed
```

Visita:
- `/register` para usuarios normales
- `/artist/register` para artistas

### 10. **(Opcional) Middleware personalizado**
Crea un middleware para artistas:
```bash
php artisan make:middleware RedirectIfNotArtist
```

Implementación:
```php
public function handle($request, Closure $next) {
    if (!Auth::guard('artist')->check()) {
        return redirect()->route('artist.login');
    }
    return $next($request);
}
```

### Notas adicionales:
1. Usa diferentes layouts para cada tipo de usuario
2. Añade un selector de tipo de usuario en el registro principal si prefieres un único formulario
3. Para roles más complejos considera usar paquetes como `spatie/laravel-permission`


---

# Login
(`ArtistAuth/AuthenticatedSessionController.php`):

```php
<?php

namespace App\Http\Controllers\ArtistAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArtistAuth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        return view('artist.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('artist.dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('artist')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
```

Y el Form Request correspondiente (`app/Http/Requests/ArtistAuth/LoginRequest.php`):

```php
<?php

namespace App\Http\Requests\ArtistAuth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::guard('artist')->attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    // ... (resto de métodos del Rate Limiter igual que en el original)
}
```

**Importante:**
1. El método `attempt()` usa el guard `artist`
2. En el `destroy()` se especifica el guard para el logout
3. Las redirecciones van a las rutas de artistas
4. El Form Request está en un namespace diferente (`ArtistAuth`)

**Rutas correspondientes (en web.php):**
```php
// Login Artist
Route::prefix('artist')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
                ->name('artist.login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('artist.logout');
});
```

**Diferencia clave con el controlador normal de Breeze:**
- Usa `Auth::guard('artist')` en lugar del guard por defecto
- Las vistas están en `resources/views/artist/auth/login.blade.php`
- Las redirecciones son a las rutas de artistas
- El namespace del controlador y Form Request es diferente
