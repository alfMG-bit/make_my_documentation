# (NOMBRE DE LA APP)
---
## Recursos:

**Videos para hacer un crud en PHP:** https://www.youtube.com/playlist?list=PL-6S8_azQ-MpM0BaKz0VPtnczB6MiOflq

---

## 🖥️ Configuración básica git
---
```shell
git config --global user.name "tu_nombre"
git config --global user.email "tu@email.com"
git config --global core.editor code
git config --global core.autocrlf true (si eres windows) input (si eres linux)
```
---
## 📥 Clonar el respositorio en tu equipo
---
### Para linux

**Crear SSH (esto solo se hace una vez)**

```shell
ssh-keygen -t ed25519 -C "tu_correo@example.com"
> Enter a file in which to save the key (/home/YOU/.ssh/id_ALGORITHM):[solo presionen enter y ya]
> Enter passphrase (empty for no passphrase): [Aquí escribes tu contraseña]
> Enter same passphrase again: [Aquí escribes tu contraseña]
```

```shell
$ eval "$(ssh-agent -s)"
> Agent pid 59566
ssh-add ~/.ssh/id_ed25519
```

**Ahora simplemente accedes desde root ejecutando este comando**

```shell
cd .shh
cat id_ed25519.pub
```

El resultado lo copias y lo agregas en la configuración SSH de tu perfil de github.com

**clonación de repositorio en linux si usas SSH**

```shell
git clone git@github.com:alfMG-bit/make_my_documentation.git
```

### Para windows

**clonación de repositorio en windows**

```shell
git clone https://github.com/alfMG-bit/make_my_documentation.git
```

---

## Ramas (Branches)
---
### 🔗 División de ramas

| Rama/Persona           | Alan Moreno | Alfredo | Alan Martinez | Alfonso | Job |
| ---------------------- | ----------- | ------- | ------------- | ------- | --- |
| **Base de Datos**      |             | ✅       |               | ✅       |     |
| **Tailwind/Views**     |             |         | ✅             |         | ✅   |
| **Models/Controllers** | ✅           |         |               |         |     |
| **main**               | ✅           | ✅       | ✅             | ✅       | ✅   |

### 👤 ¿Quién va a crear cada rama?

| 👤Encargado       | 🔗Rama             | 🏷️Nombre que debe de llevar |
| ----------------- | ------------------ | ---------------------------- |
| **Alfonso**       | Base de datos      | **database**                 |
| **Alan Martinez** | Views              | **views**                    |
| **Alan Grajeda**  | Models/Controllers | **models_controllers**       |

### 🔨 Crear su rama en git

```shell
cd make_my_documentation
git checkout -b "Nombre_de_tu_rama"
git add .
git commit -m "mensaje"
git push -u origin Nombre_de_tu_rama
```

---

# Instalación de PHP, Composer y Laravel
----
## Windows

```powershell
Set-ExecutionPolicy Bypass -Scope Process -Force; [System.Net.ServicePointManager]::SecurityProtocol = [System.Net.ServicePointManager]::SecurityProtocol -bor 3072; iex ((New-Object System.Net.WebClient).DownloadString('https://php.new/install/windows/8.4'))
```

## Linux

```shell
/bin/bash -c "$(curl -fsSL https://php.new/install/linux/8.4)"
```

Estos comandos instalaran **automáticamente** las tres herramientas. Despues de instalar estas herramientas, **debes reiniciar tu terminal (cerrar la ventana)**.

### Instalar laravel por vía composer

```powershell
composer global require laravel/installer
```

# Instalación de MySQL

## Windows

Para windows, simplemente viajaran a la página oficial de *[MySQL](https://dev.mysql.com/downloads/windows/installer/8.0.html)* y descargaran el instalador de **357M**. **Para la instalación consulten a Alan**

## Linux

Para Linux, simplemente iran a *[MySQL repo](https://dev.mysql.com/downloads/repo/apt/)* y descargaran el paquete .deb

# Instalación de XAMPP (SOLO WINDOWS)

Para Xampp (un gestor de servidor local) necesitaran ir a https://www.apachefriends.org/es/index.html, descargan la versión de windows y ejecutan el instalador

**Para continuar con la instalación de Xampp, consulten a Alan**

# Pasos de desarrollo

```mermaid
gantt
    title A Gantt Diagram
    dateFormat YYYY-MM-DD
    section Primer Fase
        🧪Investigación :a1, 2025-06-16, 7d
        Desarrollo    :a2, 2025-06-23, 20d

```
