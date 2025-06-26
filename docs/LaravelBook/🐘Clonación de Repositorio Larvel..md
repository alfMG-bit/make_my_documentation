---
tags:
  - git
  - Laravel
---
## **1. Clonar el Repositorio**

Abre una terminal y ejecuta:

```bash
git clone <https://github.com/usuario/repositorio.git>

```

Reemplaza `https://github.com/usuario/repositorio.git` con la URL del repositorio Laravel.

---

## **2. Ingresar al Directorio del Proyecto**

```bash
cd repositorio

```

---

## **3. Instalar Dependencias con Composer**

Si no tienes **Composer** instalado, descárgalo desde [getcomposer.org](https://getcomposer.org/).

Luego, ejecuta dentro del proyecto:

```bash
composer install

```

Esto instalará todas las dependencias de Laravel.

---

## **4. Configurar el Archivo `.env`**

Laravel usa un archivo `.env` para configuraciones. Si no existe, cópialo desde el de ejemplo:

```bash
cp .env.example .env

```

---

## **5. Generar la Clave de Aplicación**

Laravel requiere una clave única para encriptar datos sensibles. Genera una con:

```bash
php artisan key:generate

```

---

## **6. Configurar la Base de Datos**

Edita el archivo `.env` y ajusta los valores según tu base de datos:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_bd
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña

```

Si usas **XAMPP**, asegúrate de que el servidor MySQL esté corriendo.

---

## **7. Ejecutar Migraciones**

Si el proyecto usa migraciones para la base de datos, ejecútalas con:

```bash
php artisan migrate

```

Si necesitas datos de prueba, usa:

```bash
php artisan db:seed

```

---

## **8. Configurar los Permisos de Carpetas (Linux/macOS)**

Laravel necesita permisos adecuados para la carpeta `storage` y `bootstrap/cache`:

```bash
chmod -R 775 storage bootstrap/cache

```

Si sigues teniendo problemas de permisos, intenta:

```bash
sudo chown -R www-data:www-data storage bootstrap/cache

```

---

## **9. Iniciar el Servidor de Laravel**

Para probar la aplicación, ejecuta:

```bash
php artisan serve

```

Por defecto, la aplicación estará en:

[](http://127.0.0.1:8000/)[http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## **10. Configurar Node.js (Opcional, si el proyecto usa assets compilados)**

Si el proyecto usa Vue, React o Tailwind, instala las dependencias de NPM:

```bash
npm install

```

Y compila los assets:

```bash
npm run dev

```

(O `npm run build` para producción)

---

### **¡Listo!** Ahora tu proyecto Laravel debería estar funcionando correctamente. 🚀

# Instalación de tailwind

```shell
npm install tailwindcss @tailwindcss/vite
```