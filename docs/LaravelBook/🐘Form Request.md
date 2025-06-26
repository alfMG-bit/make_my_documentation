#DataBases #models #controllers #Laravel 

# Contenido

1. [[#¿Qué es?]]
2. [[#Programación.]]
3. [[#Programación.]]
	1. [[#Método Authorize.]]
4. [[#Método rules.]]
	1. [[#Hacer mensajes personalizados para los errores]]
	2. [[#Cambiar el nombre de los atributos de los campos.]]
		1. [[#Personalizar en el uso de la clase ``Request``]]
	3. [[#Para el método ``update()``.]]

# ¿Qué es?

Al igual que muchas otras funciones de Laravel, el objetivo de los ``form request`` es resumir código en menos líneas. En un formulario pequeño, no hay problema en hacer las validaciones individualmente, pero cuando hablamos de formularios con 30 o 40 campos a llenar, serían 30 o 40 líneas de código, las cuales ensuciarían las funciones hechas. En este escenario es cuando se presentan los ``form request``. Consiste en llevar todas las validaciones a un archivo a parte donde, posteriormente, se mandará a llamar dende el método que se use, ya sea ``store()`` o ``update()``.

# Programación.

En la terminal se escribirá el siguiente comando:

```shell
php artisan make:request <req_name>
```

El archivo request debe tener un nombre. Sería bueno el el nombre siga una convención, así que se debería seguir el siguiente orden:

```shell
MethodModelRequest
```

- ``Method``: Refiere al método en el que se implementara dicha validación, puede ser ``store`` o ``update``.
- ``Model``: Refiere al modelo al cual se le esta refiriendo la validación que vamos a hacer.
- ``Request``: Request es el nombre por defecto de este tipo de archivos

En el ejemplo de artistas, este quedaría como:

```shell
php artisan make:request StoreArtistRequest
```

Al ejecutar el respectivo comando, creará el siguiente archivo PHP:

```php
<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;


class StoreArtistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
```

La clase ``Request`` cuenta con una función o método llamado ``authorize()`` y la segunda función se llama ``rules()``.

## Método Authorize.

Este método lo que busca es validar al usuario que esta queriendo modificar la base de datos. Si no es un usuario autorizado, no dejara hacer modificaciones. En este capitulo no se verán este tipo de cuestiones. De momento, el valor que tiene por defecto, que es ``false``, se cambiará por ``true``.

```php
public function authorize(): bool
{
	return true;
}
```

# Método rules.

Lo que se debe hacer en este archivo es llevar las reglas de validación que se habían puesto en el controlador a este archivo, dentro del arreglo que se retorna, dentro de la función.

```php
public function rules(): array
{
	return [
		'name' => "required|min:4|max:200",
		'slug' => "required|unique:artists",
		'email' => "required|email",
		'register_date' => "required"
	];
}
```

En este caso es para el método ``store()`` por lo tanto, el llamado a la clase ``Request`` se cambiará por el llamado a la clase ``StoreArtistRequest`` (para este ejemplo). Para ello primeramente se debe importar la clase de la request, y en segundo lugar reemplazarla en la línea de parámetros del método en cuestión.

```php
//...
use App\Http\Requests\StoreArtistRequest;
//...
public function store(StoreArtistRequest $request)
    {
        Artist::create($request->all());
        return redirect()->route('artists.index');
    }
```

De este modo, ya quedarían las validaciones definidas, automáticamente, en la línea ``Artist::create($request->all());`` ya se realiza la validación, debido a que se esta haciendo desde la clase ``StoreArtistRequest`` y no desde ``Request``.

## Hacer mensajes personalizados para los errores

Dentro de la clase del ``request`` en cuestión se agregara el método ``messages()``, dentro de este método se retornará un ``array`` que tendrá la siguiente estructura:

```php
"CampoAllenar.validacion" => "Mensaje Personalizado"
```

En este ejemplo, refiriendo al campo `name`, sería de la siguiente manera:

```php
public function messages(): array
{
	return [
		'name.required' => "El campo nombre es necesario",
		// demas validaciones ...
	];
}
```

## Cambiar el nombre de los atributos de los campos.

Muchas veces en los mensajes de error de validación, en lugar del nombre del campo, se quiere mostrar otro valor, en este caso, para la devolución de un mensaje de error inclusive se puede personalizar el nombre del campo. Esto se puede gracias al método `attributes`

```php
public function attributes() : array 
{
	return [
		'name' => "Artist Name",
		'slug' => "identifier",
		'email' => "Email",
		'register_date' => "register day"
	];
}
```

En este ejemplo en lugar de mostrar ``the field name is required`` mostrará ``the field Artist Name is required``.

Si se quiere mostrar el mensaje personalizado junto con el nombre personalizado, en la función ``message()``, en el lugar donde se planea mostrar el nombre del campo se debe colocar `:attribute`:

```php
public function messages() : array
{
	return [
		'name.required' => "The campo :attribute field es requerido",
	];
}
```

El resultado a mostrar sería el siguiente:

```shell
The campo Artist Name field es requerido
```

### Personalizar en el uso de la clase ``Request``:

Si se busca personalizar los mensajes de la parte del controlador, se crean dos ``arrays`` mas, el primero define los mensajes, mientras que el tercero define los nombres personalizados:

```php
public function store(Request $request)
{
	$request->validate([
		//primer arreglo que define las validaciones
	],
	[
		//Segundo que define los mensajes personalizados
	],
	[
		// tercero define los nombres personalizados
	]);
	Artist::create($request->all());
}
```

## Para el método ``update()``.

