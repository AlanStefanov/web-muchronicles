#!/bin/bash

IMAGE_NAME="chronicles-web"
CONTAINER_NAME="chronicles-web"

echo "Deteniendo y eliminando cualquier contenedor existente con el nombre $CONTAINER_NAME..."
docker stop $CONTAINER_NAME > /dev/null 2>&1
docker rm -f $CONTAINER_NAME || true

echo "Construyendo la imagen Docker $IMAGE_NAME..."
# Asume que el Dockerfile y los archivos de WebEngine CMS están en el directorio actual
docker build -t $IMAGE_NAME .

echo "Ejecutando el nuevo contenedor $CONTAINER_NAME en el puerto 80..."
docker run -d --name $CONTAINER_NAME -p 80:80 $IMAGE_NAME

echo "Operación completada."
echo "Puedes acceder a tu aplicación en http://localhost"
echo "Para ver los logs del contenedor, usa: docker logs $CONTAINER_NAME"
echo "Para entrar al contenedor, usa: docker exec -it $CONTAINER_NAME bash"
