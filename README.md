# (NOMBRE DE LA APP)
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
eval "$(ssh-agent -s)"
> Agent pid 59566
ssh-add ~/.ssh/id_ed25519
```

**Ahora simplemente accedes desde root ejecutando este comando**

```shell
cd .ssh
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

