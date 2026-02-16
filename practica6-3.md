---
theme: uncover
paginate: true
class:
  - lead
  - invert
size: 16:9
footer: "[practica 6.3 docker con laravel y DNS](https://www.hashbangcode.com)"
marp: true
--- 
# Practica 6.3 Cesar
---

## Índice
- [Paso 1: Configuración del Servidor DNS (BIND9) en Docker](#paso-1-configuración-del-servidor-dns-bind9-en-docker)

2. [Paso 2: Configuración de las zonas DNS](#paso-2-configuración-de-las-zonas-dns)
3. [Configuraciom maria db](#configuracion-maria-db)
4. [Archivo compose-yml](#archivo-compose-yml)
---

## Indice

5. [Pagina de prueba php](#pagina-de-prueba-php)
6. [Construir y ejecutar contenedores]( #construir-y-ejecutar-los-contenedores)
7. [Verficar base de datos](#7-verificar-la-base-de-datos)
8. [Instalacion Composer](#8-instalacion-composer)

9. [Creacion proyecto laravel](#9-creacion-proyecto-laravel)
10. [Configurar phpMyAdmin](#10-configurar-phpmyadmin)
---

Creamos la estructura de carpetas que nos falta

```bash
mkdir -p nginx/ssl
mkdir -p bind
mkdir -p bind/zones
```
---
## Paso 1: Configuración del Servidor DNS (BIND9) en Docker
---
```yml
---
services:
  nginx:
    build: ./nginx
    container_name: nginx-container
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./www/html:/var/www/html
      - ./nginx/ssl:/etc/nginx/ssl
    depends_on:
      - php
    networks:
      default:
        ipv4_address: 10.1.0.20

  php:
    build: ./php
    container_name: php-container
    expose:
      - "9000"
    volumes:
      - ./www/html:/var/www/html
    networks:
      default:
        ipv4_address: 10.1.0.30

  mariadb:
    image: mariadb:latest
    container_name: mariadb-container
    environment:
      MYSQL_ROOT_PASSWORD: root_password
      MYSQL_DATABASE: intermodular-gestion-profesores
      MYSQL_USER: laravel_user
      MYSQL_PASSWORD: laravel_password

    volumes:
      # Volumen persistente para los datos de la base de datos
      - mariadb_data:/var/lib/mysql
      # Volumen para scripts de inicialización
      - ./mariadb:/docker-entrypoint-initdb.d
    ports:
      - "3306:3306"
    networks:
      default:
        ipv4_address: 10.1.0.40
  dns:
    image: internetsystemsconsortium/bind9:9.18
    container_name: dns-container
    ports:
      - "53:53/udp"
      - "53:53/tcp"
    volumes:
      - ./bind:/etc/bind
    restart: 'no'
    networks:
      default:
        ipv4_address: 10.1.0.10
  phpmyadmin:
    image: phpmyadmin/phpmyadmin:latest
    container_name: phpmyadmin-container
    environment:
      PMA_HOST: mariadb
      MYSQL_ROOT_PASSWORD: root_password
    ports:
      - "8081:80"
    depends_on:
      - mariadb
    networks:
      default:
        ipv4_address: 10.1.0.50 
networks:
  default:
    driver: bridge
    ipam:
      config:
        - subnet: 10.1.0.0/24
# Declaración de volúmenes persistentes
volumes:
  mariadb_data:
```
---
Ejecutamos esto para contruir la imagen ya que la modificamos

```bash
docker compose up --build
```
---
## Paso 2: Configuración de las zonas DNS

Zona directa
```bash
$TTL 86400
@       IN SOA  ns1.daw.es. root.daw.es. (
                2024083001 ; Serial
                3600       ; Refresh
                1800       ; Retry
                1209600    ; Expire
                86400      ; Minimum TTL
                )

; Nameservers
@       IN NS   ns1.daw.es.

; Registros A
ns1     IN A    10.1.0.10
www     IN A    10.1.0.20
despliegue IN A 10.1.0.20
www.despliegue IN A 10.1.0.20
```
---

---
Zona inversa
```bash
$TTL 86400
@       IN SOA  ns1.daw.es. root.daw.es. (
                2024083001 ; Serial
                3600       ; Refresh
                1800       ; Retry
                1209600    ; Expire
                86400      ; Minimum TTL
                )

; Nameservers
@       IN NS   ns1.daw.es.

; Registros PTR (Reverse DNS)
10      IN PTR  ns1.daw.es.
20      IN PTR  www.daw.es.
20      IN PTR  www.despliegue.daw.es.
20      IN PTR  despliegue.daw.es.

```
---
Archivo: bind/named.conf.options
```bash
options {
    directory           "/var/cache/bind";
    recursion           yes;
    allow-query         { 10.1.0.0/24; 127.0.0.1; };
    forwarders {
        8.8.8.8;
        8.8.4.4;
    };
    dnssec-validation   no;
    listen-on           { any; };
    listen-on-v6        { none; };
};
```
---
Archivo: bind/named.conf.local

```bash

zone "daw.es" {
    type    master;
    file    "/etc/bind/zones/db.daw.es";
};

zone "0.1.10.in-addr.arpa" {
    type    master;
    file    "/etc/bind/zones/db.10.1.0";
};

```
---
Archivo: nginx/default.conf
```bash
server {
 listen 80;
 server_name daw.es www.daw.es despliegue.daw.es www.despliegue.daw.es;
 return 301 https://$host$request_uri;
}
server {
 listen 443 ssl;
 server_name daw.es www.daw.es despliegue.daw.es www.despliegue.daw.es;
 ssl_certificate /etc/nginx/ssl/daw.crt;
 ssl_certificate_key /etc/nginx/ssl/daw.key;
 root /var/www/intermodular/public;
 index index.php index.html;
 location / {
 try_files $uri $uri/ /index.php?$query_string;
 }
 location /phpmyadmin/ {
 proxy_pass http://phpmyadmin-container:80/;
 proxy_set_header Host $host;
 proxy_set_header X-Real-IP $remote_addr;
 proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
 proxy_set_header X-Forwarded-Proto https;
 }
 location ~ \.php$ {
 fastcgi_pass php-container:9000;
 fastcgi_index index.php;
 fastcgi_param SCRIPT_FILENAME /var/www/intermodular/public$fastcgi_script_name;
 include fastcgi_params;
 }
}
```


---

Generendo clave publica y privada

!["clave publica"](/img/ssl/claves.png)


---
Modificamos nuestro welcome.blade

```html
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bienvenido a Intermodular</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #4e73df, #1cc88a);
    overflow: hidden;
}

.content {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(15px);
    padding: 50px;
    border-radius: 20px;
    text-align: center;
    color: white;
    width: 90%;
    max-width: 600px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    animation: fadeIn 1.2s ease-in-out;
}

h1 {
    font-size: 2.8rem;
    margin-bottom: 20px;
    font-weight: 700;
}

p {
    font-size: 1.1rem;
    margin-bottom: 15px;
    font-weight: 300;
}

.button {
    display: inline-block;
    margin-top: 20px;
    padding: 12px 30px;
    border-radius: 50px;
    background: white;
    color: #4e73df;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
}

.button:hover {
    background: #f8f9fc;
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
</head>

<body>
<div class="content">
    <h1>🚀 ¡Bienvenido a Intermodular!</h1>
    <p>Esta es la página principal personalizada de nuestro proyecto Laravel.</p>
    <p>Explora las funcionalidades y disfruta del despliegue de nuestra aplicación.</p>
    <a href="#" class="button">Comenzar</a>
</div>
</body>
</html>

```
---
Construimos el contenedor
```bash
docker compose up -d --build
```

---
comprobar dns

```bash
dig daw.es @10.1.0.10
dig despliegue.daw.es @10.1.0.10
dig www.daw.es @10.1.0.10
dig www.despliegue.daw.es @10.1.0.10
```
comprobar dns inverso

```bash
dig -x 10.1.0.20 @10.1.0.10
```
---
 cambiando rutas yml

```yml
---
services:
  nginx:
    build: ./nginx
    container_name: nginx-container
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./www/html/intermodular:/var/www/html/intermodular
      - ./nginx/ssl:/etc/nginx/ssl
    depends_on:
      - php
    networks:
      default:
        ipv4_address: 10.1.0.20

  php:
    build: ./php
    container_name: php-container
    expose:
      - "9000"
    volumes:
      - ./www/html/intermodular:/var/www/html/intermodular
    networks:
      default:
        ipv4_address: 10.1.0.30

  mariadb:
    image: mariadb:latest
    container_name: mariadb-container
    environment:
      MYSQL_ROOT_PASSWORD: root_password
      MYSQL_DATABASE: intermodular-gestion-profesores
      MYSQL_USER: laravel_user
      MYSQL_PASSWORD: laravel_password

    volumes:
      # Volumen persistente para los datos de la base de datos
      - mariadb_data:/var/lib/mysql
      # Volumen para scripts de inicialización
      - ./mariadb:/docker-entrypoint-initdb.d
    ports:
      - "3306:3306"
    networks:
      default:
        ipv4_address: 10.1.0.40
  dns:
    image: internetsystemsconsortium/bind9:9.18
    container_name: dns-container
    ports:
      - "1053:53/udp"
      - "1053:53/tcp"
    volumes:
      - ./bind:/etc/bind
    restart: 'always'
    networks:
      default:
        ipv4_address: 10.1.0.10
  phpmyadmin:
    image: phpmyadmin/phpmyadmin:latest
    container_name: phpmyadmin-container
    environment:
      PMA_HOST: mariadb
      MYSQL_ROOT_PASSWORD: root_password
    ports:
      - "8081:80"
    depends_on:
      - mariadb
    networks:
      default:
        ipv4_address: 10.1.0.50 
networks:
  default:
    driver: bridge
    ipam:
      config:
        - subnet: 10.1.0.0/24
# Declaración de volúmenes persistentes
volumes:
  mariadb_data:
```