# (NOMBRE DE LA APP)
---
## Configuración básica git
---
```shell
git config --global user.name "tu_nombre"
git config --global user.email "tu@email.com"
git config --global core.editor code
git config --gloabl core.autocrlf true (si eres windows) input (si eres linux)
```
---
## Crear su rama en git
---
```shell
git checkout -b "Nombre_de_tu_rama"
git add .
git commit -m "mensaje"
git push -u origin Nombre_de_tu rama
```
