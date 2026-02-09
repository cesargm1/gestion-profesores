FROM nginx:latest
# Actualiza los paquetes del sistema
RUN apt-get update && apt-get upgrade -y && apt-get clean
COPY ./default.conf /etc/nginx/conf.d/default.conf
