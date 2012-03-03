Пример формы:


[form]
[email=mylo@sait.com]
[redirect=http://site.com/]
[subject=Моя форма]
[ushka=ушка, которая выведется после формы]
[nocopy]
[noreset]   


[field]
require = 0   
type = text
description = Ваш город
tip = Указывайте вместе со страной
value = значение по-умолчанию
attr = class="gorod" (атрибуты поля)
[/field]

[field] 
require = 0   
type = text
type_text = url
description = Сайт
tip = Вы можете указать адрес своего сайта (если есть)
placeholder = Адрес сайта
[/field]

[field] 
require = 0   
type = text
description = Телефон
tip = Телефон лучше указывать с кодом города/страны
placeholder = Введите свой телефонный номер
[/field] 

[field]
require = 1   
type = select 
description = Тема
values = Пожелания по сайту # Нашел ошибку на сайте # Подскажите, пожалуйста
default = ожелания по сайту
tip = Выберите тему письма
[/field] 

[field] 
require = 1 
type = textarea 
description = Ваш вопрос
placeholder = О чем вы хотите написать?
[/field]

[/form]


ПАРАМЕТРЫ ПОЛЕЙ field
---------------------

type_text - тип для input
	type_text = url
	type_text = email
	type_text = password
	type_text = search
	type_text = search
	type_text = number

placeholder = Подсказка для поля

tip = Подсказка к полю

value = значение по-умолчанию

attr = class="gorod" - (html-атрибуты элемента)


ПАРАМЕТРЫ ФОРМЫ
---------------
[email=mylo@sait.com] - куда отпраляем письмо
[redirect=http://site.com/] - куда релиректим после отправки
[subject=Моя форма] - тема письма
[ushka=ушка] - ушка, которая выведется после формы
[nocopy] - отключить вывод «Отправить копию на ваш email»
[noreset] - отключить вывод кнопки «Сбросить форму»
