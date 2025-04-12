FROM php:8.2-cli
WORKDIR /app
COPY . /app
CMD ["php", "-S", "0.0.0.0:80", "bot.php"]
EXPOSE 80
