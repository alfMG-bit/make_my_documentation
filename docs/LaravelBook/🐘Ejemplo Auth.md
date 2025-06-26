---
tags:
  - Laravel
  - auth
  - DataBases
  - models
  - controllers
---

Para implementar dos tipos de registros y logins en Laravel (ej: usuarios normales y administradores), sigue estos pasos:

**1. Crear modelos y migraciones:**

```bash
php artisan make:model User -m
php artisan make:model Admin -m
```

En las migraciones:
```php
// users table
$table->id();
$table->string('name');
$table->string('email')->unique();
$table->timestamp('email_verified_at')->nullable();
$table->string('password');
$table->rememberToken();
$table->timestamps();

// admins table (agrega campos adicionales si necesitas)
$table->id();
$table->string('name');
$table->string('email')->unique();
$table->string('password');
$table->rememberToken();
$table->timestamps();
```

**2. Configurar guards en `config/auth.php`:**
```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    
    'admin' => [
        'driver' => 'session',
        'provider' => 'admins',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
    
    'admins' => [
        'driver' => 'eloquent',
        'model' => App\Models\Admin::class,
    ],
],
```

**3. Crear controladores de autenticación:**
```bash
php artisan make:controller UserAuthController
php artisan make:controller AdminAuthController
```

**4. Implementar métodos en los controladores (ejemplo para UserAuthController):**
```php
use Illuminate\Support\Facades\Auth;

public function showLoginForm()
{
    return view('auth.user.login');
}

public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (Auth::guard('web')->attempt($credentials)) {
        return redirect()->intended('/user/dashboard');
    }

    return back()->withErrors(['email' => 'Credenciales inválidas']);
}

// Similar para registro
public function register(Request $request)
{
    $data = $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed'
    ]);
    
    User::create($data);
    return redirect('/user/login');
}
```

**5. Crear vistas separadas:**
```
resources/views/
├── auth/
│   ├── user/
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   └── admin/
│       ├── login.blade.php
│       └── register.blade.php
```

**6. Configurar rutas en `routes/web.php`:**
```php
// Usuarios normales
Route::prefix('user')->group(function(){
    Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('user.login');
    Route::post('/login', [UserAuthController::class, 'login']);
    Route::get('/register', [UserAuthController::class, 'showRegisterForm'])->name('user.register');
    Route::post('/register', [UserAuthController::class, 'register']);
});

// Administradores
Route::prefix('admin')->group(function(){
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::get('/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('/register', [AdminAuthController::class, 'register']);
});
```

**7. Middleware de autenticación:**
```php
// Proteger rutas para usuarios
Route::middleware('auth:web')->group(function(){
    // Rutas de usuario autenticado
});

// Proteger rutas para administradores
Route::middleware('auth:admin')->group(function(){
    // Rutas de administrador
});
```

**8. Cerrar sesión:**
```php
// En UserAuthController
public function logout()
{
    Auth::guard('web')->logout();
    return redirect('/user/login');
}

// En AdminAuthController
public function logout()
{
    Auth::guard('admin')->logout();
    return redirect('/admin/login');
}
```

**9. Personalizar redirecciones:**
Modifica los métodos en los controladores para redirigir a diferentes dashboards según el tipo de usuario.

**10. Consideraciones adicionales:**
- Usar diferentes layouts para cada tipo de usuario
- Validaciones separadas si necesitan campos diferentes
- Tablas de bases de datos separadas
- Diferentes políticas de acceso (Policies)
- Configurar emails de verificación separados si es necesario

Ejemplo de formulario de login para usuarios (`auth/user/login.blade.php`):
```php
<form method="POST" action="{{ route('user.login') }}">
    @csrf
    <input type="email" name="email" required>
    <input type="password" name="password" required>
    <button type="submit">Login de Usuario</button>
</form>
```

Recuerda ejecutar las migraciones después de configurar todo:
```bash
php artisan migrate
```