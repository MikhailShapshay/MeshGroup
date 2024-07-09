## Laravel (Docker, Laravel echo, redis, mariadb)
- Развернуть laravel в docker с установкой laravel cron и сервером очередей rabbitmq
- Реализовать контроллер с валидацией и загрузкой excel файла
- Загруженный файл через jobs поэтапно (по 1000 строк) парсить в бд (таблица rows)
- Прогресс парсинга файла хранить в redis (уникальный ключ + количество обработанных строк)
- Поля excel:
  - id
  - name
  - date (d.m.Y)
- Для парсинга excel можете использовать maatwebsite/excel
- Реализовать контроллер для вывода данных (rows) с группировкой по date - двумерный массив
- Будет плюсом если вы реализуете через laravel echo передачу event-а на создание записи в rows
- Написать тесты
- Пример файла:
https://docs.google.com/spreadsheets/d/1BZJ4iV5lEd9GqWu-FsC55zVyGqoAzcqbjXyJyXK2hbs/edit?usp=sharing

## Запуск
- composer install
- npm install
- php artisan queue:work

## Routes
- http://localhost:8876/ - загрузка Excel
- http://localhost:8876/api/rows - группировка записей
