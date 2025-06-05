# API MVC en PHP

Este es un ejemplo sencillo de una API RESTful utilizando PHP puro con una estructura tipo MVC. Los datos de ejemplo se guardan en un archivo JSON para mantener la simplicidad.

## Estructura

```
app/
  controllers/
  models/
  core/
public/
  index.php
vendor/
  autoload.php
```

## Uso rápido

1. Levanta el servidor embebido de PHP apuntando a la carpeta `public`:

```bash
php -S localhost:8000 -t public
```

2. Utiliza un cliente HTTP (curl, Postman, etc.) para consumir los endpoints:

- `GET /tasks`
- `POST /tasks` con cuerpo `{ "title": "Tarea" }`
- `GET /tasks/{id}`
- `PUT /tasks/{id}` con cuerpo `{ "title": "Nuevo titulo" }`
- `DELETE /tasks/{id}`


