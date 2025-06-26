---
tags:
  - Eloquent
  - DataBases
  - Laravel
---
# Contenido

1. [[#Mutadores.]]
2. [[#Accesores.]]

# Mutadores.

Dentro de los modelos, es posible regular entradas no comunes a la base de datos, por ejemplo, cuando un usuario decide escribir *hOlA mUnDo* en lugar de *hola mundo*. Las bases de datos deben de llevar un estándar cuando se trata de hacer registros.

Iremos al modelo (en este ejemplo), `Models/Artist.php` e importaremos la siguiente línea:

```php
use Illuminate\Database\Eloquent\Casts\Attribute;
```

Esta propiedad ayudará a regular estos estándares para la base de datos. Ahora, dentro de `Models/Artist.php` se debe crear una función con el nombre de la propiedad que se regulará, en este caso, `name` de `artist`. La función deberá retornar un elemento de la propiedad `Attribute`, así que se pondrá `:Attribute` después de la función.

```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Artist extends Model
{
    //
    protected $table = 'artist';

	protected function name(): Attribute
	{
		return Attribute::make(
			set: function () {
				//
			}
		);
	}
}
```

La función en cuestión deberá recibir un parámetro, en este caso `$value`. Este valor, posteriormente, lo retornara en minúsculas.

```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Artist extends Model
{
    //
    protected $table = 'artist';

	protected function name(): Attribute
	{
		return Attribute::make(
			set: function ($value) {
				//
				return strtolower($value); // retornara la cadena de texto en minusculas
			}
		);
	}
}
```

Ahora simplemente se hace el registro común y ese campo especificado en la función `set` se guardará en minúsculas:

```php
$artist = new Artist;
$artist->name = "ArTiSTa 2"; // este campo se pasará a minusculas
$artist->alias = "Alias 12";
$artist->genre = "Rock";
$artist->save();
return $artist;
```

# Accesores.

Tomando en cuenta lo anterior, si ahora se desea mostrar ese campo guardado en minúsculas de forma distinta sin alterar como es que se guardo en la base de datos, se debe crear una función `get`:

```php
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Artist extends Model
{
    //
    protected $table = 'artist';

	protected function name(): Attribute
	{
		return Attribute::make(
			set: function ($value) {
				//
				return strtolower($value); // retornara la cadena de texto en minusculas
			},
			get: function($value) {
				return ucfirst($value) // capturá y muestra solo la primera en matúscula SIN ALTERAR LA BASE DE DATOS
			}
		);
	}
}
```

