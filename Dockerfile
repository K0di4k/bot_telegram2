# Indica la imagen base que vamos a usar. Elegimos una imagen oficial de PHP con la interfaz de línea de comandos (CLI).
# Puedes ajustar la versión de PHP (ej: 8.1, 8.3) según tus necesidades.
FROM php:8.2-cli

# Establece el directorio de trabajo dentro del contenedor Docker.
# Aquí es donde vamos a copiar tu código.
WORKDIR /app

# Copia todos los archivos de tu repositorio (incluyendo bot.php y cualquier otro archivo)
# al directorio /app dentro del contenedor.
COPY . /app

# Define el comando que se ejecutará cuando se inicie el contenedor Docker.
# Aquí, iniciamos el servidor web incorporado de PHP.
# -S 0.0.0.0:80 le dice a PHP que escuche en todas las interfaces (0.0.0.0) en el puerto 80.
# bot.php es el script que se ejecutará.
CMD ["php", "-S", "0.0.0.0:80", "bot.php"]

# Indica en qué puerto la aplicación dentro del contenedor está escuchando.
# Aunque Render gestiona los puertos externamente, es una buena práctica indicarlo.
EXPOSE 80
