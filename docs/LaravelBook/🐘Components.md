---
tags:
  - laravel-blade
  - Laravel
---
# Índice

- [[#Componentes Anónimos]]
	- [[#Creación.|Creación.]]
	- [[#Mandar a llamar el componente creado en la vista Blade.|Mandar a llamar el componente creado en la vista Blade.]]
	- [[#Valores dentro de un componente|Valores dentro de un componente]]
		- [[#Valores dentro de un componente#Slot con nombre|Slot con nombre]]
	- [[#Atributos de un componente.|Atributos de un componente.]]
	- [[#Adición de parámetros.|Adición de parámetros.]]
- [[#Componentes de Clase.]]

# Componentes Anónimos

## Creación.

Para crear un componente, dentro de un fichero llamado `components` vamos a crear nuestro componente.

**Por ejemplo: `alerta.blade.php`**. Este archivo cabe recordar que será dentro de la ruta de `Components`

```html
<div class="p-5 flex justify-center items-center bg-neutral-900 text-neutral-100">
		Esto es un etiquetado
</div>
```

## Mandar a llamar el componente creado en la vista Blade.

Dentro de nuestra vista `.blade.php` mandaremos a llamar los componentes empezando por poner las llaves de entrada y salida de una etiqueta HTML, o sea: `<></>`

Una vez puestas las llaves, dentro de estas, se pondrá el prefijo `x-`. Después del guion, se coloca el nombre del archivo `.blade.php` que tiene el componente. En este ejemplo sería `x-alerta` quedando referenciado de la siguiente manera:

```html
<body>
		<!-- Aqui nuestro componente -->
		<x-alerta></x-alerta>
</body>
```

## Valores dentro de un componente

Se puede variar el contenido de cada componente, independientemente de que se use en varios lados, este es el **principal objetivo** de los componentes. Son una especie de **plantillas** que se pueden utilizar en varios lados.

Esta propiedad de plantillas, permite a los componentes tener diferentes valores o modificarlos desde la vista principal. He aquí un ejemplo.

```html
<body>
		<x-alerta>
				Este es un valor dentro de el componente
		</x-alerta>
</body>
```

En el componente se codificará lo siguiente:

```html
<div class="p-5 flex justify-center items-center bg-neutral-900 text-neutral-100">
		{{ $slot }}
</div>
```

Aquí, lo que sucederá, es que el texto *Este es un valor dentro de el componente* se mostrará dentro del componente Blade donde hemos colocado la variable `$slot`.

### Slot con nombre

El slot con nombre es como el slot que por defecto podemos poner contenido pero con un nombre definido.

La razón de esto es porque muchas veces no solamente desearemos usar un contenido variable, sino que pueden ser varios, como el del siguiente ejemplo.

Archivo: `Components/componente.blade.php`

```html
<!-- Componente con dos slots -->
<div class="p-5 flex justify-center items-center bg-neutral-900 text-neutral-100">
		<!-- Aqui se mostrara el contenido del title -->
		{{ $title }}
		<!-- Aqui se mostrara el contenido default -->
		{{ $slot }}
</div>
```

En la vista: `Views/Vista.blade.php`

```html
<body>
		<x-componente>
				<x-slot name="title">Titulo</x-slot>
				Este es el contenido default
		</x-componente>
</body>
```

Si se comentase el slot llamado `{{ $title }}` ya sea por el lado de la `view` o por el lado del `component`, o si simplemente no se definiera esta variable en alguno de los dos archivos (ya sea la vista o el componente) daría un error.

Para prevenir este error y hacer opcional el ingreso de algún valor en cualquiera de las variables del componente, se debe hacer lo siguiente.

En: `Components/componente.blade.php`

```html
<div class="...">
		<!-- Aqui colocamos ?? y posteriormente, a lado de este, el titulo que queremos que aparezca si no se pone nada en dicha variable -->
		{{ $title ?? "Titulo por defecto" }}
		...
</div>
```

## Atributos de un componente.

Se pueden definir atributos a un componente. Estos atributos en un inicio parecieran inútiles, sin embargo, con ellos se puede definir aún mas variabilidad para el propio componente:

Archivo: `Views/view.blade.php`

```html
<body>
		<!-- Aquí definimos la variable 'type' 
		con el valor de ejemplo "success" -->
		<x-alert type="success">
				<x-slot name="title">
						Success
				</x-slot>
				Form sent successfully
		</x-alert>
</body>
```

Ahora, para recibir este atributo en el componente, sería de la siguiente manera. En el archivo: `Components/alert.blade.php`

El componente por ejemplo a usar será el siguiente

```html
<div class="flex justify-center items-center w-3/4 bg-neutral-100">
		<span class="font-semibold text-lg">{{ $title }}</span>
		{{ $slot }}
</div>
```


```html
<!-- Llamaremos a una directiva de blade llamada "props" -->
@props(['type'])

<!-- Ya que se recibio la variable 'type', ahora crearemos una porcion de código php. En este caso es una sentencia 'switch'. Dependiendo de lo que se reciba en la variable 'type', se cambiara su color. Por ejemplo, si la variable tiene 'success', como se establecio arriba, su color sera un verde. Para cada tipo se pondrá un color. -->

@php
		switch($type) {
				case 'success':
						$class="flex justify-center items-center w-3/4 bg-[#55bf7a] text-neutral-100"
						break;
				case 'danger':
						$class="flex justify-center items-center w-3/4 bg-[#bf5555] text-neutral-100"
						break;
				case 'info':
						$class="flex justify-center items-center w-3/4 bg-[#67abcd] text-neutral-100"
						break;
				case 'warning':
						...
						break;
				case 'dark':
						...
						break;
				default:
						//... En el caso de que no sea ningúna
						$class="flex justify-center items-center w-3/4 bg-neutral-100"
						break;
		}
@endphp

<div class={{ $class }}>
		...
</div>

```

Si queremos que los `props` tengan un valor por defecto, simplemente lo definiremos de esta manera:

En `Components/alert.blade.php`

```html
@props(['type'] => 'info')

...
```

## Adición de parámetros.

Si se quiere añadir más parámetros a un componente, se debe hacer de la siguiente manera.

Suponiendo que el nuevo parámetro a agregar es una clase (`class`), se debe realizar el siguiente procedimiento:

En: `Views/ejemplo.blade.php`

```html
<body>
		<!-- Se agrega el parámetro 'class' -->
		<x-component type="success" class="mb-3">
				...
		</x-component>
</body>
```

Si la variable/parámetro `type` define una clase específica para `x-component` entonces `class` es una añadidura a esa clase ya existente o que se define por `type`. Por lo tanto, deberemos entender lo siguiente.

En `Components/component.blade.php`

```html
@props(['type'] => 'info')

@php
...
@endphp

<div class="{{ $class }}">
		<span class="font-semibold text-lg">{{ $title }}</span>
		{{ $slot }}
</div>
```

Lo primero es ver que el parámetro `class` no lo recibe en los `@props`, si un atributo no se recibe en esta propiedad de Blade, lo que se hará con ese atributo es que será guardado en una variable de segundo plano llamada `$attributes`.

Para definir bien hecha la añadidura de esta clase a la clase de nuestro componente, debemos "fusionar" las clases, y eso se hace de la siguiente manera:

```html
@props(['type'] => 'info')

@php
...
@endphp

<div class="" {{ $attributes->merge(['class' => $class]) }}>
		<span class="font-semibold text-lg">{{ $title }}</span>
		{{ $slot }}
</div>
```

De esta manera concatenaremos de forma adecuada  las clases ya existentes o definidas dentro de los `@props` (en este ejemplo, que se hizo así) y las clases que vienen como parametros extra en la variable `$attributes`.

# Componentes de Clase.

Esta forma es la mejor para definir los componentes y consiste en ejecutar primeramente el comando:

```shell
php artisan make:component <nombre-del-componente>
```

Posteriormente, creara una clase, con el nombre del componente, en este caso, su nombre, tanto del archivo como de la clase, serán `<nombre-del-componente>`, para este ejemplo, le pondremos `card`.

Por cuestiones de normalización y estándares, al archivo creado en `View/Components/card.php` le cambiaremos la primer letra del nombre a mayúscula, o sea `Card.php`

A las variables pasadas por el método `@props`, se pasarán a través de la función constructora de la clase. ==Todas las propiedades definidas en la clase, podrán ser accedidas desde la vista del componente.==

```php
class Card extends Component
{
		public $class;

		public funcion __construct($type = 'info') {
				switch($type) {
						case 'success':
								$class="flex justify-center items-center w-3/4 bg-[#55bf7a] text-neutral-100"
								break;
						case 'danger':
								$class="flex justify-center items-center w-3/4 bg-[#bf5555] text-neutral-100"
								break;
						case 'info':
								$class="flex justify-center items-center w-3/4 bg-[#67abcd] text-neutral-100"
								break;
						case 'warning':
								$class="flex justify-center items-center w-3/4 bg-orange-500 text-neutral-100"
								break;
						case 'dark':
								$class="flex justify-center items-center w-3/4 bg-gray-200 text-neutral-800"
								break;
						default:
								//... En el caso de que no sea ningúna
								$class="flex justify-center items-center w-3/4 bg-neutral-100"
								break;
				}

				// Importante setear la propiedad html a la propiedad de la clase respectivamente
				$this->class = $class
		}
}
```

Esto separa la lógica de PHP con la del front-end. A este tipo de componentes se les llama **componentes de clase**