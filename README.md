# Intermodular Gestion de horarios profesores

## Funcionamiento de la web

Aplicacion para poder gestionar las faltas de los profesores del centro el profesor podra indicar que dia falta el motivo de la falta y en que franja horaria o dia va a faltar

### Roles

- Admin: puede crear centros gestionar aulas editarlas borrarlas añadir       franjas horarias

- centro: Puede crear usuarios dentro de ese centro (mirar si quitar)
- profesores: pueden asignarse a los horarios

### Frontend Tareas
- Maquetacion 
- Pagina de inicio: Listado de profesores
- Formulario de inicio de sesion 
- LLamadas a la API


### Backend Tareas

- Login con correo corporativo y contraseña 

- Formulario de faltas por dias. Incluir motivo de falta Indicar la franja horaria en la que el profesor falta  el profesor puede enviar comentarios (motivo de la falta)

- Maquetacion del panel de administracion

- Formulario de registro de profesores

#### DB

- Tablas Base de datos
  -  Aulas
  - Franja horaria
  - Horario
  - Roles 
  - Grupos
  - Faltas
  - Guardias
  - asignaturas
  - profesores

### Scrumaster
1. Documentacion git
2. Creacion de contenedores Docker:  Laravel PHP MYSQL DNS
3. Despliegue
