FROM node:24-alpine

WORKDIR /app

COPY ./faltas-profesores/package*.json ./

RUN npm install -g @angular/cli

RUN npm install

COPY ./faltas-profesores/ ./

CMD ["ng", "serve", "--host", "0.0.0.0"]