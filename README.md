## Запуск проекта
1) убеждаемся, что в файле .env в корне проекта заданы верные параметры подключения к базе данных
2) В консоли, находясь в корне проекта выполняем команду 
php artisan custom:dbcreate
После выполнения команды должна создастся база данных с таблицами и процедурами в ней. 
Сценарий данного скрипта находится в App/Console/Commands/createDataBase.
Классы необходимые для его работы по данным путям
   Database/Custom/DatabaseСreator
   Database/Custom/TablesСreator
   Database/Custom/ProceduresCreator
3) Далее, если все прошло успешно выполняем php artisan db:seed 

