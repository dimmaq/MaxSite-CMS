<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * MaxSite CMS
 * Language file
 * (c) http://max-3000.com/
 * Author: (c) Alexander Schilling
 * Author URL: http://alexanderschilling.net
 * Update URL: http://alexanderschilling.net
 * Core
 */

# common.php
$lang['Доступ запрещен'] = 'Zugriff verweigert';
$lang['Сайдбар'] = 'Sidebar';
$lang['Виджет'] = 'Widget';

# inifile.php
$lang['Сохранить'] = 'Speichern';
$lang['Настройка'] = 'Einstellung';
$lang['Значение'] = 'Wert';

# page.php
$lang['Далее'] = 'Weiter';
$lang['(черновик)'] = '(Entwurf)';
$lang['Редактировать'] = 'Bearbeiten';
$lang['Подписаться'] = 'Abonnieren';
$lang['Данная запись защищена паролем.'] = 'Dieser Beitrag ist mit Passwort geschützt.';
$lang['<strong>Ошибочный пароль!</strong> Повторите ввод.'] = '<strong>Falsches Passwort!</strong> Nochmal eingeben.';
$lang['Обсудить'] = 'Kommentare';
$lang['Посмотреть комментарии'] = 'Kommentare anzeigen';
$lang['<span>Прочтений:</span> '] = '<span>Gelesen:</span> '; // пробел в конце!
$lang['Пароль:'] = 'Passwort:';

# comments.php
$lang['Комментатор'] = 'Kommentator';
$lang['анонимно'] = 'anonym';

# template_options

$lang['Вывод записей'] = 'Einträge-Optionen';
$lang['Оформление'] = 'Theme';
$lang['Прочее'] = 'Verschiedenes';
$lang['Блок другие записи'] = 'Block mit andere Einträge';
$lang['Форма обратной связи'] = 'Kontakt Formular';
$lang['Персональные настройки'] = 'Persönliche Einstellungen';
$lang['Настройка блоков'] = 'Blocks-Einstellungen';
$lang['Количество записей на главной'] = 'Anzahl der Einträge aus der Startseite';
$lang['Укажите количество записей, которые будут выводиться на главной странице сайта.'] = 'Wieviel Einträge sollen auf der Startseite angezeigt werden?';
$lang['Количество записей на остальных'] = 'Anzahl der Einträge auf andere';
$lang['Укажите количество записей, которые будут выводиться на остальных страницах (рубрики, архивы и т.д.)'] = 'Wieviel Einträge sollen auf andere Seiten angezeigt werden? (Kategorien, Archiv etc...)';
$lang['Количество записей в RSS'] = 'Anzahl der Einträge bei RSS';
$lang['Укажите количество записей, которые будут выводиться в rss-ленте'] = 'Wieviel Einträge sollen bei dem RSS Feed angezeigt werden?';
$lang['Количество комментариев'] = 'Anzahl der Kommentare';
$lang['Укажите количество записей, которые будут выводиться на странице комментариев.'] = 'Wieviel Kommentare sollen auf einer Seite angezeigt werden?';
$lang['Полные записи в RSS'] = 'Ganze Einträge in RSS-Feed';
$lang['Отметьте, если нужно отдавать в RSS полные записи. Если нет, то будет только до [cut].'] = 'Wählen Sie aus, wenn Sie den gesamten Eintrag in RSS-Feed ausgeben möchten. Wenn nicht, wird der Eintrag bist [cut] angezeigt.';
$lang['Полные или короткие записи для главной'] = 'Gesamt oder Kurz Version der Einträge für Startseite';
$lang['Полные записи']='Ganze Einträge';
$lang['Только заголовки']='Nur Überschrift';
$lang['Выберите тип отображения записей для главной страницы.'] = 'Wählen Sie ein Typ aus (für Startseite).';
$lang['Полные или короткие записи для рубрик'] = 'Gesamt oder Kurz Version der Einträge für Kategorien';
$lang['Выберите тип отображения записей для страницы рубрик.'] = 'Wählen Sie ein Typ aus (für Kategorien).';
$lang['Полные или короткие записи для меток'] = 'Gesamt oder Kurz Version der Einträge für Schlagwörter';
$lang['Выберите тип отображения записей для страницы меток.'] = 'Wählen Sie ein Typ aus (für Schlagwörter)';
$lang['Номера записей для главной'] = 'Nummern der Einträge für Startseite';
$lang['Укажите номера страниц, которые следует вывести на главной. Если указать «0», будут выведены все последние записи.'] = 'Geben Sie die Nummern der Seiten, die auf der Startseite Angezeigt werden sollen. Wenn «0», werden alle Einträge Angezeigt.';
$lang['Номера рубрик для главной'] = 'Nummern der Kategorien für Startseite';
$lang['Укажите номера рубрик, которые следует выводить на главной. Если указать «0», будут выведены все.'] = 'Geben Sie die Nummern der Kategorien, die auf der Startseite Angezeigt werden sollen. Wenn «0», werden alle Einträge aus alle Kategorien Angezeigt.';
$lang['Номер top-записи для главной'] = 'Nummer des Top-Eintrags für Startseite';
$lang['Укажите номер страницы, которую следует вывести на главной перед всеми записями. Если указать «0», то ничего не выводится.'] = 'Geben Sie die Nummer der Seiten an, die auf der Startseite (am Anfang) Angezeigt werden sollen. Wenn «0», wird nichts Angezeigt.';
$lang['Текст для главной перед всеми записями'] = 'Text für Startseite, vor allen Einträge';
$lang['Текст будет отображен перед всеми записями. Можно использовать HTML-тэги. Если ничего выводить не нужно, оставьте это поле пустым.'] = 'Text wird vor allen Einträge Angezeigt. Man kann HTML-Tag benutzen. Wenn Sie nichts anzeigen möchten, lassen Sie dieses Feld frei.';
$lang['Блоки рубрик на главной'] = 'Kategorien Block für Startseite';
$lang['Отметьте, если нужно выводить записи блоками по отдельной указанной (в «Номера рубрик для главной») рубрике на главной.'] = 'Wählen Sie aus, wenn Sie die Einträge in Blocks ausgeben möchten.';
$lang['Последняя запись на главной'] = 'Letzter Eintrag auf Startseite';
$lang['Отметьте, если нужно выводить перед блоками (при включеннм «Блоки рубрик на главной») последнюю запись блога.'] = 'Wählen Sie aus, wenn Sie den letzten Eintrag vor allen anderen Einträge anzeigen möchten. («Kategorien Block für Startseite» muss angeschaltet sein).';
$lang['Свои CSS-стили'] = 'Eigenes CSS-Style';
$lang['Вы можете указать произвольные css-стили'] = 'Hier können Sie ein beliebiges CSS-Style eingeben';
$lang['Текст для «Далее»'] = 'Text für «Weiterlesen»';
$lang['Далее...']='Weiter...';
$lang['Использование canonical для записей']='Canonical für Einträge verwenden';
$lang['Разрешить указывать для страниц meta-тэг canonical. Поисковики могут учитывать этот параметр для определения основного адреса страницы, если она доступна по нескольким адресам одновременно. Это позволяет избежать дублей страниц при индексировании.'] = 'Cononical für Seiten in Meta-Tags erlauben. Suchmaschinen können diese Option nutzen, um die Haupt Web-Adresse zu bestimmen, wenn die Seite unter mehreren Web-Adressen gleichzeitig vorhanden ist. Dann Hilft um Wiederholungen bei Indizierung zu vermeiden.';

$lang['Этот текст будет выводится в ссылке на полный текст страницы.'] = 'Dieser Text wird bei dem Link «Weiterlesen» angezeigt.';
$lang['Текст для «Оставьте комментарий»'] = 'Text für «Hinterlasse eine Antwort!»';
$lang['Этот текст будет выводится как призыв оставить комментарий.'] = 'Dieser Text wird als Aufruf sein, um einen Kommentar zu schreiben.';
$lang['Граватарка по-умолчанию'] = 'Gravatar als Standart';
$lang['стандарт']='Standart';
$lang['Силуэт']='Schattenbild';
$lang['Геометрический рисунок']='Geometrische Muster';
$lang['Монстрики']='Monsters';
$lang['Смешные лица']='Lustige Gesichter';
$lang['8-битное лицо']='8-Bit-Gesichter';
$lang['Выберите тип граватарки, которая будет отображаться для незарегистрированных email'] = 'Wählen Sie ein Typ des Gravatar aus, die für nicht registrierte Benutzer verwendet wird.';
$lang['Размер граватарки'] = 'Größe des Gravatars';
$lang['Укажите размер изображения граватарки от 1px до 512px'] = 'Geben Sie die Größe des Gravatars von 1px bis 512px';
$lang['Главное меню'] = 'Hauptmenü';

$lang['Подсчет количества просмотров']='Anzahl der Ansichten';
$lang['Нужно ли считать количество просмотров страниц.']='Anzahl der Seitenaufrufe zählen?';
$lang['Включить подсчет с помощью cookies']='Zählen mit Hilfe von Cookies';
$lang['Включить подсчет с помощью session']='Zählen mit Hilfe von Session';
$lang['Включить подсчет неуникальных просмотров']='Alle besuche Zählen';
$lang['Не вести счет']='Nicht Zählen';

$lang['404 http-заголовок']='404 http-Überschrift';
$lang['Отметьте, если нужно отправлять 404-ошибку, при ненайденных страницах.']='Wählen Sie aus, wenn eine Fehlermeldung angezeigt werden soll, wenn die Webseite nicht gefunden wurde.';
$lang['Глобальное кэширование']='Globale Caching';
$lang['Можно ли кэшировать страницы целиком? Если вы включите эту опцию, то в кэш будет добавляться полностью сгенерированные страницы, что значительно ускоряет работу сайта. Рекомендуется для сайтов с большой посещаемостью. Данный кэш занимает много места на диске. Работает, только если установлен плагин глобального кэширования.']='';

$lang['Блок ссылок на другие записи этой рубрики']='Block mit Links auf andere Einträge in einer Kategorie';
$lang['Выводить ли этот блок ссылок под текстом записи (только одиночной страницы)? Если не нужно выводить, то оставьте поле пустым. Иначе укажите заголовок блока.']='';
$lang['Количество ссылок на другие записи этой рубрики']='';
$lang['Если вы отметили отображать ссылки на другие записи этой рубрики, то можно указать количество ссылок.']='';
$lang['Критерий сортировки для ссылок на другие записи этой рубрики']='';
$lang['По дате публикации']='Nach Datum';
$lang['По id рубрики']='Nach ID der Kategorien';
$lang['По названию записи']='Nach Überschrift der Beiträge';

# End of file