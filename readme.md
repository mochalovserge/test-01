## Установка проекта

Для установки проекта необходим docker-compose.
Перейти в каталог проекта и выполнить:
`$docker-compose up -d --build`

Для отправки запросов Rest можно использовать программу Postman (https://www.getpostman.com/)
Адрес для тестирования: http://localhost/

- GET /api/products - список товаров
- GET /api/cart - содержимое корзины
- POST /api/cart - добавление в корзину (id={id}&quantity=<quantity>)
- DELETE /api/cart/<product_id> - удаление из корзины 
