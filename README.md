Описание:

Форма регистрации нового токена находится на главной странице

Управление историей:

	GET /history - вывод всей истории пользователя
	GET /history/:id - вывод одной записи
	DELETE /history/:id  -удаление одной записи

API Геокодирования:

	Для вывода адреса по координатам:
		/geocoding?lat=<первая координати>&lng=<вторая координати>
	Для вывода координат по адресу:
		GET /endpoint?address=<тут адрес>
Для поиска используется API гугла, API яндекса применить не успел

Во всех запросах должен быть GET параметр key, который можно получить зайдя на главную страницу сайта
