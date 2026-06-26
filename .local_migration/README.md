# Corneroids.by: контекст и план миграции DLE

Этот документ описывает текущий контекст работ по старому сайту Corneroids.by, состояние локальной копии, известные проблемы, подготовленный локальный стенд и пошаговый план миграции с DLE 10.5 / Windows-1251 на новую версию DLE / UTF-8.

Документ написан как рабочая инструкция, чтобы можно было продолжить миграцию без восстановления контекста из переписки.

## 1. Исходная ситуация

Сайт старый, на DataLife Engine.

Текущая старая версия сайта:

```text
DLE 10.5
PHP на новом хостинге: 8.3
Кодировка сайта: windows-1251 / cp1251
Шаблон: templates/corneroids
```

На новом хостинге используется PHP 8.3. Старый DLE 10.5 и сторонние модули не рассчитаны на PHP 8.3, поэтому при переносе начали появляться fatal errors.

Бэкапы, которые используются для локальной миграции:

```text
db.sql.gz
site.tar.gz
```

Оба файла лежат в корне проекта:

```text
/home/ivandechenko/dev/corneroids.by/db.sql.gz
/home/ivandechenko/dev/corneroids.by/site.tar.gz
```

Важно: эти бэкапы являются исходной точкой без текущих частичных PHP 8.3-правок.

## 2. Что уже было исправлено на рабочей копии

В процессе переноса на PHP 8.3 уже были исправлены отдельные ошибки старого сайта. Эти правки помогали запускать сайт на текущем хостинге, но не являются полноценным обновлением DLE.

### 2.1. templates.class.php

Были ошибки:

```text
Array and string offset access syntax with curly braces is no longer supported
Cannot use empty array elements in arrays
```

Причина:

```php
$var{0}
```

и старый синтаксис массивов, несовместимый с PHP 8.

### 2.2. vote.php

Была ошибка:

```text
array_rand(): Argument #1 ($array) cannot be empty
```

Причина: в PHP 8 `array_rand()` больше не терпит пустой массив и выбрасывает `ValueError`.

### 2.3. whoonline.php

Была ошибка:

```text
Unsupported operand types: string * int
```

Причина: старый код рассчитывал, что строка автоматически приведётся к числу.

### 2.4. links.php

Была ошибка:

```text
count(): Argument #1 ($value) must be of type Countable|array, null given
```

Причина: в PHP 8 нельзя делать `count(null)`.

### 2.5. engine/inc/include/init.php

В админке была ошибка:

```text
Array and string offset access syntax with curly braces is no longer supported
... eval()'d code ...
```

Файл был зашифрован через `base64_decode + eval`. Был декодирован локально и сохранён как обычный PHP-файл.

Внутри была строка:

```php
$hash .= $salt{mt_rand( 0, 39 )};
```

Исправлено на:

```php
$hash .= $salt[mt_rand( 0, 39 )];
```

### 2.6. Стандартная капча

Капча не показывалась, вместо картинки был битый `<img>`.

Проблемы:

```php
$this->keystring{$i}
```

и передача float-координат/цветов в GD-функции.

Исправлялись файлы:

```text
engine/modules/antibot/antibot.php
engine/modules/antibot.php
```

Также был добавлен fallback на SVG, если на сервере нет GD или не читаются PNG-шрифты.

### 2.7. keygen.php

Была ошибка:

```text
Call to undefined function eregi()
```

Причина: функции `ereg`, `eregi`, `ereg_replace`, `eregi_replace` удалены из PHP.

Исправление:

```php
eregi(...)
```

заменено на:

```php
preg_match(... /i)
```

Файл:

```text
engine/modules/keygen.php
```

Также были найдены и заменены оставшиеся `ereg_*` в старом форумном модуле:

```text
upload_forum/control_center/board/sharelink_add.php
upload_forum/control_center/board/sharelink_edit.php
upload_forum/components/global/functions.php
```

### 2.8. engine/inc/main.php и другие админские файлы

Была ошибка:

```text
Undefined constant "p_info"
```

Причина: старый PHP позволял обращаться к ключу массива без кавычек:

```php
{$lang[p_info]}
```

В PHP 8 это fatal error. Исправлено на:

```php
{$lang['p_info']}
```

Были исправлены похожие конструкции в:

```text
engine/inc/main.php
engine/inc/addnews.php
engine/inc/editnews.php
engine/inc/static.php
engine/inc/addvote.php
engine/inc/usergroup.php
engine/inc/mass_user_actions.php
engine/inc/blockip.php
engine/inc/banners.php
```

### 2.9. Security-fix патчи DLE 2016-2018

Были упомянуты официальные security-fix патчи DLE:

```text
07.12.2016
04.04.2017
11.08.2017
13.02.2018
```

Применялись правки к:

```text
engine/classes/parse.class.php
engine/go.php
engine/ajax/typograf.php
engine/classes/masha/masha.js
```

`masha.js` был заменён из официального архива:

```text
https://dle-news.ru/files/dle113_path.zip
```

### 2.10. Тёмная тема для templates/corneroids

Для шаблона `templates/corneroids` была добавлена тёмная тема по умолчанию и переключатель темы.

Файлы:

```text
templates/corneroids/main.tpl
templates/corneroids/css/theme-toggle.css
```

Тема включается по умолчанию через класс на `<html>`:

```text
theme-dark
```

Выбор сохраняется в браузере через `localStorage`.

## 3. Почему эти PHP 8.3-правки не являются финальным решением

Текущая задача не должна сводиться к бесконечной починке DLE 10.5 под PHP 8.3.

Причины:

```text
1. DLE 10.5 очень старый.
2. Он небезопасен без большого количества security-patch правок.
3. Новые версии DLE давно перешли на UTF-8.
4. Поддержка Windows-1251 в DLE была прекращена начиная с DLE 13.0.
5. Сторонние модули тоже старые и могут ломаться на PHP 8.
6. Новые хостинги уже не всегда позволяют выбрать старую версию PHP.
```

Поэтому текущие PHP 8.3-правки стоит считать временным мостом, а не конечной целью.

Цель миграции:

```text
DLE 10.5 cp1251
-> локальная проверенная копия
-> конвертация в UTF-8
-> обновление DLE
-> проверка на PHP 8.x
-> перенос на хостинг
```

## 4. Кодировка: текущая проблема cp1251 -> UTF-8

В текущем старом сайте явно задана кодировка Windows-1251:

```text
engine/data/config.php:
'charset' => 'windows-1251'

engine/data/dbconfig.php:
define ("COLLATE", "cp1251");
```

Новые версии DLE работают в UTF-8. Поддержка cp1251 прекращена много лет назад.

Нельзя просто поменять:

```php
'charset' => 'windows-1251'
```

на:

```php
'charset' => 'utf-8'
```

Если сделать только это, текст на сайте и в админке превратится в кракозябры.

Нужно переводить вместе:

```text
1. Базу данных.
2. Файлы шаблонов.
3. Языковые файлы.
4. Конфиги.
5. Кастомные модули.
6. Сторонние дополнения.
```

## 5. Особенность текущего db.sql.gz

Был просмотрен `db.sql.gz`.

В начале дампа указано:

```sql
/*!40101 SET NAMES utf8mb4 */;
```

Но таблицы создаются как:

```sql
DEFAULT CHARSET=cp1251 COLLATE=cp1251_general_ci
```

Пример:

```sql
CREATE TABLE `dle_admin_logs` (
  ...
) ENGINE=MyISAM AUTO_INCREMENT=7471 DEFAULT CHARSET=cp1251 COLLATE=cp1251_general_ci;
```

При просмотре дампа через `gzip -dc db.sql.gz` русский текст отображался нормально.

Это значит, что дамп нужно конвертировать осторожно. Нельзя автоматически предполагать, что файл целиком является настоящим CP1251 или настоящим UTF-8 только по строке `SET NAMES`.

Перед боевым импортом нужно локально проверить:

```text
1. Как отображается текст после импорта.
2. Как отображаются новости.
3. Как работает поиск.
4. Как отображаются пользователи.
5. Как отображается админка.
```

## 6. Локальный стенд

Создана папка:

```text
.local_migration/
```

В ней находится локальный стенд для миграции.

### 6.1. Структура

```text
.local_migration/
  docker-compose.yml
  README.md
  docker/
    php74/
      Dockerfile
      php.ini
    php82/
      Dockerfile
      php.ini
  legacy/
    domains/corneroids.by/public_html/
  mysql-init/
    001-db.sql
  scripts/
    prepare-db.sh
    convert-files-to-utf8.py
    create-utf8-copy.sh
  www/
  www_utf8/
```

### 6.2. Что где лежит

Исходный чистый бэкап сайта из `site.tar.gz` распакован сюда:

```text
.local_migration/legacy/domains/corneroids.by/public_html/
```

Рабочая локальная копия сайта для Docker лежит здесь:

```text
.local_migration/www/
```

SQL для локального автоимпорта базы:

```text
.local_migration/mysql-init/001-db.sql
```

Он был создан из:

```text
db.sql.gz
```

командой:

```bash
.local_migration/scripts/prepare-db.sh
```

### 6.3. Что изменено в локальной копии dbconfig.php

В локальной копии сайта файл:

```text
.local_migration/www/engine/data/dbconfig.php
```

был переключён на локальную Docker-БД:

```php
define ("DBHOST", "db");
define ("DBNAME", "corneroids");
define ("DBUSER", "corneroids");
define ("DBPASS", "corneroids");
```

Остальное пока оставлено как в старой копии, включая:

```php
define ("COLLATE", "cp1251");
```

## 7. Docker-стенд

В `.local_migration/docker-compose.yml` подготовлены сервисы:

```text
web74       PHP 7.4 + Apache
web82       PHP 8.2 + Apache
web74_utf8  PHP 7.4 + Apache, UTF-8 copy
web82_utf8  PHP 8.2 + Apache, UTF-8 copy
db          MariaDB 10.11
phpmyadmin  phpMyAdmin
```

Порты:

```text
web74:      http://localhost:8074
web82:      http://localhost:8082
web74_utf8: http://localhost:8075
web82_utf8: http://localhost:8083
phpmyadmin: http://localhost:8081
MariaDB:    localhost:3307
```

Локальная база:

```text
database: corneroids
user:     corneroids
password: corneroids
root pw:  root
```

phpMyAdmin:

```text
http://localhost:8081
server: db
user: root
password: root
```

## 8. Что установлено для локального стенда

Docker Desktop через Windows не использовался, потому что установка требовала интерактивного UAC, а пользователь работал с мобильного.

Вместо этого Docker Engine установлен напрямую внутри WSL Ubuntu:

```text
Docker Engine: 29.1.3
Docker Compose: 2.40.3
Docker service: active/running через systemd
```

Проверка в WSL:

```bash
docker compose version
```

Если команда работает, можно запускать стенд.

## 9. Эмуляция домена corneroids.by

Для локальной эмуляции выбран домен:

```text
corneroids.by
www.corneroids.by
```

В Windows нужно открыть файл `hosts` от имени администратора:

```text
C:\Windows\System32\drivers\etc\hosts
```

и добавить:

```text
127.0.0.1 corneroids.by
127.0.0.1 www.corneroids.by
```

После запуска Docker сайт открывать так:

```text
http://corneroids.by:8074
```

или для PHP 8.2:

```text
http://corneroids.by:8082
```

UTF-8 копия DLE 10.5 на PHP 7.4:

```text
http://corneroids.by:8075
```

UTF-8 копия на PHP 8.2:

```text
http://corneroids.by:8083
```

Важно: hosts-подмена помогает локальному сайту видеть `HTTP_HOST=corneroids.by`, но не гарантирует прохождение онлайн-проверки лицензии на стороне `dle-news.ru`.

## 10. Лицензия DLE

Важный риск: если DLE во время обновления или активации отправляет онлайн-запрос на `dle-news.ru`, то локальная подмена `hosts` не доказывает серверу лицензий, что домен реально обслуживается снаружи.

Если на реальном `corneroids.by` сейчас ничего нет, онлайн-проверка может не пройти.

Допустимые варианты:

```text
1. Локально делать только подготовку, конвертацию и тесты.
2. Онлайн-активацию проходить на реальном домене.
3. Использовать официальный офлайн-ключ, если он доступен в личном кабинете/у поддержки DLE.
4. Уточнить у поддержки DLE корректный путь переноса старой лицензии.
```

Не нужно пытаться обходить лицензионную проверку. План миграции должен оставаться в рамках официальной лицензии.

## 11. Найденные официальные версии DLE

В WSL была найдена распакованная версия DLE 19.0:

```text
/mnt/h/dle19_0
```

По файлам:

```text
/mnt/h/dle19_0/upload/install.php
/mnt/h/dle19_0/upload/engine/inc/include/init.php
```

это:

```text
DLE 19.0
```

В `install.php` указано минимальное требование:

```text
PHP 8.0+
```

Также в Windows найдена папка с официально скачанными лицензированными архивами:

```text
Z:\Ванина папка\1САЙТ\Движки\DLE\ЛИЦЕНЗИЯ\
```

В ней лежат архивы:

```text
dle10.5_utf8.zip
dle10.6_utf8.zip
dle11.0.zip
dle11.1.zip
dle11.2_utf8.zip
dle11.3_utf8.zip
dle12_0_utf8.zip
dle12_1_utf8.zip
dle13_0.zip
dle13_1.zip
dle13_2.zip
dle13_3.zip
dle14_0.zip
dle14_1.zip
dle14_2.zip
dle14_3.zip
dle15_0.zip
dle15_1.zip
dle15_2.zip
dle15_3.zip
dle16_0.zip
dle16_1.zip
dle17_0.zip
dle17_1.zip
dle17_2.zip
dle17_3.zip
dle18_0.zip
dle18_1.zip
dle19_0.zip
dle19_1.zip
dle20_0.zip
```

Папка `Z:` в WSL ранее не была найдена как `/mnt/z`, но путь доступен из Windows/PowerShell. Для удобной работы из WSL архивы лучше скопировать или распаковать в проект, например:

```text
.local_migration/dle_versions/
```

Рекомендуемая структура:

```text
.local_migration/dle_versions/
  10.5/
  10.6/
  11.0/
  ...
  20.0/
```

## 12. Запуск локального стенда

Docker уже установлен в WSL Ubuntu. Запуск стенда:

```bash
cd /home/ivandechenko/dev/corneroids.by/.local_migration
docker compose up -d --build
```

Проверить контейнеры:

```bash
docker compose ps
```

Открыть старую копию на PHP 7.4:

```text
http://corneroids.by:8074
```

Открыть ту же копию на PHP 8.2:

```text
http://corneroids.by:8082
```

Открыть phpMyAdmin:

```text
http://localhost:8081
```

## 13. Полный сброс локальной базы

Если нужно начать заново:

```bash
cd /home/ivandechenko/dev/corneroids.by/.local_migration
docker compose down -v
./scripts/prepare-db.sh
docker compose up -d --build
```

`docker compose down -v` удалит локальный volume базы. Это безопасно для исходных файлов `db.sql.gz` и `site.tar.gz`, но уничтожит все изменения в локальной Docker-БД.

## 14. План миграции: общий маршрут

Рекомендуемый маршрут:

```text
1. Поднять локальную копию DLE 10.5 на PHP 7.4.
2. Проверить, что старая копия работает с исходной БД.
3. Зафиксировать состояние.
4. Конвертировать базу и файлы в UTF-8.
5. Проверить DLE 10.5 уже в UTF-8.
6. Подготовить официальные файлы следующей версии DLE.
7. Запустить официальный upgrade только до следующей версии.
8. Проверить результат.
9. Повторить шаги 6-8 для каждой следующей версии до DLE 20.0.
10. Исправить шаблон и сторонние модули.
11. Проверить на PHP 8.x.
12. Перенести на хостинг.
```

Важно: не обновлять сайт сразу с DLE 10.5 до DLE 20.0. Миграцию нужно проходить последовательно по одной доступной версии:

```text
10.5 -> 10.6 -> 11.0 -> 11.1 -> 11.2 -> 11.3 -> 12.0 -> 12.1
-> 13.0 -> 13.1 -> 13.2 -> 13.3 -> 14.0 -> 14.1 -> 14.2 -> 14.3
-> 15.0 -> 15.1 -> 15.2 -> 15.3 -> 16.0 -> 16.1
-> 17.0 -> 17.1 -> 17.2 -> 17.3 -> 18.0 -> 18.1
-> 19.0 -> 19.1 -> 20.0
```

После каждого шага нужно проверить, что сайт и админка открываются, база обновилась без ошибок, русский текст не сломан, и можно переходить к следующей версии.

## 15. Этап 1: проверка чистой старой копии

Цель: убедиться, что исходный бэкап вообще корректно запускается локально.

Запустить:

```bash
cd /home/ivandechenko/dev/corneroids.by/.local_migration
docker compose up -d --build
```

Открыть:

```text
http://corneroids.by:8074
```

Проверить:

```text
1. Главная страница.
2. Новости.
3. Страница новости.
4. Админка.
5. Авторизация.
6. Шаблон.
7. Картинки из uploads.
8. Комментарии.
9. Капча.
```

На этом этапе сайт может быть неидеален, но должен дать понимание, в каком состоянии исходный бэкап.

## 16. Этап 2: конвертация базы в UTF-8

Нужна отдельная новая локальная база, а не правка боевой.

Варианты:

```text
1. Конвертировать SQL-файл.
2. Импортировать cp1251 в MariaDB, затем выполнить ALTER/CONVERT по таблицам.
```

Из-за неоднозначности текущего `db.sql.gz` безопаснее сначала импортировать как есть, проверить текст, а потом уже делать конвертацию внутри базы.

Общий подход:

```sql
ALTER TABLE table_name CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Но делать это нужно по таблицам после проверки, что текст не станет двойной кодировкой.

Проверять нужно таблицы:

```text
dle_post
dle_users
dle_comments
dle_static
dle_category
dle_options / config-related tables
форумные таблицы upload_forum, если они используются
```

## 17. Этап 3: конвертация файлов сайта в UTF-8

Файлы, которые обычно требуют перекодировки:

```text
templates/
language/
engine/data/
engine/modules/
engine/inc/
engine/classes/
upload_forum/
```

Но нельзя перекодировать бинарные файлы:

```text
*.png
*.jpg
*.jpeg
*.gif
*.webp
*.ico
*.zip
*.gz
*.rar
*.7z
*.ttf
*.woff
*.woff2
*.swf
*.pdf
```

Пример ручной перекодировки одного файла:

```bash
iconv -f CP1251 -t UTF-8 file.php > file.php.utf8
mv file.php.utf8 file.php
```

После конвертации нужно поменять:

```php
'charset' => 'windows-1251'
```

на:

```php
'charset' => 'utf-8'
```

и:

```php
define ("COLLATE", "cp1251");
```

на:

```php
define ("COLLATE", "utf8mb4");
```

Если старая версия DLE не понимает `utf8mb4`, временно использовать:

```php
define ("COLLATE", "utf8");
```

## 18. Этап 4: проверка DLE 10.5 уже в UTF-8

До обновления DLE нужно добиться, чтобы старая версия хотя бы открывалась в UTF-8.

Проверить:

```text
1. Нет кракозябр на главной.
2. Нет кракозябр в админке.
3. Можно открыть новость.
4. Можно открыть список новостей в админке.
5. Можно открыть редактирование новости.
6. Работает поиск.
7. Работают категории.
8. Работают пользователи.
9. Работают комментарии.
```

Если текст сломан, не идти дальше к обновлению. Сначала исправить кодировку.

## 19. Этап 5: последовательное обновление DLE

Обновление нужно выполнять не одним прыжком, а цепочкой официальных upgrade-процедур от текущей версии к следующей.

Первый шаг после успешной UTF-8-конвертации:

```text
DLE 10.5 UTF-8 -> DLE 10.6 UTF-8
```

Дальше идти по списку из раздела 14 до DLE 20.0.

Для каждого архива нужно:

```text
1. Распаковать архив конкретной версии в .local_migration/dle_versions/<version>/.
2. Прочитать Documentation/upgrade.html именно этой версии.
3. Сделать копию текущей рабочей папки www и дамп текущей локальной БД.
4. Наложить файлы новой версии поверх рабочей копии, сохранив свои конфиги и пользовательские данные.
5. Запустить официальный upgrade для этой версии.
6. Проверить сайт, админку, новости, комментарии, пользователей и кодировку.
7. Только после успешной проверки переходить к следующей версии.
```

Пример для найденной распакованной DLE 19.0:

```text
/mnt/h/dle19_0/upload/
/mnt/h/dle19_0/Documentation/upgrade.html
```

Общий принцип обновления:

```text
1. Сделать копию текущей локальной папки www.
2. Сохранить свои шаблоны.
3. Сохранить engine/data/dbconfig.php.
4. Сохранить важные пользовательские файлы uploads.
5. Залить файлы новой DLE поверх.
6. Запустить официальный upgrade.
7. Проверить базу и админку.
```

Официальный upgrade может находиться в админке как `mod=upgrade`, либо быть описан в документации конкретной версии. Перед запуском читать `Documentation/upgrade.html`.

## 20. Что не затирать при обновлении

Нужно быть осторожным с:

```text
engine/data/dbconfig.php
engine/data/config.php
templates/corneroids
templates/Pisces, если он используется
uploads/
backup/
.htaccess
robots.txt
кастомные модули
upload_forum/
```

Но новая DLE может требовать новую структуру шаблонов. Старый шаблон может не работать без адаптации.

## 21. Шаблоны

В старом бэкапе в `config.php` был указан:

```php
'skin' => 'Pisces'
```

Но ранее правки делались для:

```text
templates/corneroids
```

Перед миграцией нужно определить, какой шаблон реально должен использоваться:

```text
1. Pisces
2. corneroids
3. другой шаблон из базы/админки
```

После обновления DLE шаблон почти наверняка потребует адаптации:

```text
1. Новые теги шаблонов.
2. Новые CSS/JS подключения.
3. Новая форма комментариев.
4. Новая форма логина.
5. Новая капча/recaptcha.
6. Новая структура профиля пользователя.
```

## 22. Сторонние модули и риски

На сайте есть/были сторонние модули:

```text
iChat
whoonline
keygen
vote
links
upload_forum
snippets
EasyLike
```

Риски:

```text
1. Они могут не работать на новой DLE.
2. Они могут не работать на PHP 8.
3. Они могут быть небезопасными.
4. Они могут использовать старые функции PHP.
5. Они могут конфликтовать с UTF-8.
```

Рекомендуемый подход:

```text
1. Сначала обновить ядро DLE без сторонних модулей.
2. Потом подключать модули по одному.
3. После каждого модуля проверять сайт.
4. Всё, что не нужно, не переносить.
```

## 23. Работа с удалённой базой

Пользователь предоставил часть данных для удалённой БД. В публичных/репозиторных заметках реальные значения не хранить:

```php
define ("DBHOST", "<production-db-host>");
define ("DBNAME", "<production-db-name>");
define ("DBUSER", "<production-db-user>");
```

Пароль не предоставлен.

Но даже при наличии пароля не рекомендуется конвертировать живую удалённую БД напрямую.

Правильнее:

```text
1. Работать с локальной копией.
2. Проверить конвертацию.
3. Проверить обновление.
4. Только потом переносить результат на хостинг.
```

## 24. Что требуется от пользователя сейчас

На текущем этапе Docker установлен, cp1251 baseline, UTF-8 baseline и upgrade до DLE 10.6 проверены локально. От пользователя сейчас требуется только то, что нельзя безопасно сделать без доступа к внешним данным или интерактивному окружению:

```text
1. Если нужен доступ через http://corneroids.by:8074/8075 в браузере Windows, добавить hosts-записи вручную.
2. По мере прохождения следующих шагов распаковывать официальные архивы DLE из Z:\Ванина папка\1САЙТ\Движки\DLE\ЛИЦЕНЗИЯ\ в .local_migration/dle_versions/.
3. Подтвердить, что можно начинать следующий официальный upgrade: DLE 10.6 UTF-8 -> DLE 11.0.
```

## 25. Команды для запуска стенда

```bash
cd /home/ivandechenko/dev/corneroids.by/.local_migration
docker compose up -d --build
```

Проверка:

```bash
docker compose ps
```

Логи:

```bash
docker compose logs -f web74
docker compose logs -f db
```

Открыть:

```text
http://corneroids.by:8074
http://corneroids.by:8075
http://localhost:8081
```

## 26. Критерии успешной локальной подготовки

Перед любым переносом на хостинг должны быть выполнены условия:

```text
1. Локальная старая копия открывается.
2. База импортирована.
3. Русский текст читается.
4. Админка открывается.
5. Кодировка UTF-8 проверена.
6. Обновление DLE проходит локально.
7. Новая админка открывается.
8. Новости и комментарии на месте.
9. Нет критических PHP fatal errors.
10. Есть список отключённых/неперенесённых модулей.
```

## 27. Финальный перенос на хостинг

После успешной локальной миграции:

```text
1. Сделать свежий бэкап текущего хостинга.
2. Перевести сайт в maintenance/offline.
3. Экспортировать локальную обновлённую базу.
4. Залить обновлённые файлы.
5. Импортировать обновлённую базу.
6. Проверить engine/data/dbconfig.php под боевой хостинг.
7. Проверить права на uploads, engine/cache, backup.
8. Очистить кеш DLE.
9. Проверить сайт.
10. Проверить админку.
11. Проверить формы.
12. Проверить ЧПУ и .htaccess.
```

## 28. Чего не делать

Не делать:

```text
1. Не конвертировать живую БД без проверенной локальной копии.
2. Не менять только charset в config.php.
3. Не заливать новую DLE поверх старой без бэкапа.
4. Не запускать upgrade на рабочем сайте первым шагом.
5. Не обходить лицензионную проверку.
6. Не переносить все старые модули вслепую.
7. Не удалять старые бэкапы до успешной миграции.
```

## 29. Текущий статус

На момент создания этого документа:

```text
1. Бэкапы найдены.
2. Чистая копия сайта распакована.
3. Локальная рабочая копия сайта подготовлена в .local_migration/www.
4. SQL для автоимпорта подготовлен.
5. Docker Compose конфиг создан.
6. Домен для эмуляции выбран: corneroids.by.
7. Найдена распакованная DLE 19.0 в /mnt/h/dle19_0.
8. Найдены официальные архивы DLE 10.5-20.0 в Z:\Ванина папка\1САЙТ\Движки\DLE\ЛИЦЕНЗИЯ\.
9. Зафиксировано требование проходить upgrade последовательно по одной версии, без прыжка сразу на DLE 20.0.
10. Docker Engine установлен и работает внутри WSL Ubuntu.
11. cp1251 baseline проверен на PHP 7.4.
12. UTF-8 baseline проверен на PHP 7.4.
13. hosts-записи ещё нужно добавить вручную в Windows, если нужен доступ по домену из браузера Windows.
```

Следующий практический шаг:

```text
Начать официальный upgrade DLE 10.6 UTF-8 -> DLE 11.0.
```

## 30. Обновление статуса от 2026-06-26

Docker Desktop через Windows не был установлен, потому что установка требовала интерактивного UAC, а пользователь работал с мобильного без доступа к экрану компьютера.

Вместо этого Docker Engine установлен напрямую внутри WSL Ubuntu:

```text
Docker Engine: 29.1.3
Docker Compose: 2.40.3
Docker service: active/running через systemd
```

Локальный стенд успешно поднят командой:

```bash
cd /home/ivandechenko/dev/corneroids.by/.local_migration
docker compose up -d --build
```

Сервисы:

```text
web74:      http://localhost:8074
web82:      http://localhost:8082
phpmyadmin: http://localhost:8081
MariaDB:    localhost:3307
```

Проверка состояния:

```text
1. PHP 7.4 открывает старый сайт DLE 10.5 cp1251.
2. Главная страница отдаёт HTTP 200.
3. Заголовок сайта читается: "Всё для игры Corneroids!".
4. Активный шаблон в HTML: Pisces.
5. База импортирована: 64 таблицы.
6. В dle_post найдено 113 новостей.
7. phpMyAdmin открывается.
```

Для локальной рабочей копии были выставлены write-права на runtime-директории, чтобы Apache/PHP мог писать cache/data/uploads:

```text
.local_migration/www/engine/cache
.local_migration/www/engine/data
.local_migration/www/backup
.local_migration/www/uploads
.local_migration/www/upload_forum/cache
.local_migration/www/upload_forum/logs
.local_migration/www/upload_forum/uploads
```

Создан локальный checkpoint:

```text
.local_migration/checkpoints/10.5-cp1251-php74-ok/
  README.txt
  db.sql
  www.tar.gz
```

`www.tar.gz` не включает пользовательские uploads, backup и runtime cache/logs.

PHP 8.2 сейчас не является целевым runtime для старой cp1251-копии, но используется как ранний индикатор несовместимостей. После исправления прав он падает на следующей ожидаемой проблеме DLE 10.5:

```text
Fatal error: Array and string offset access syntax with curly braces is no longer supported
/var/www/html/engine/classes/templates.class.php on line 220
```

Следующий практический шаг:

```text
См. следующий раздел: UTF-8-копия DLE 10.5 подготовлена и проверена.
```

## 31. Обновление статуса: UTF-8 baseline от 2026-06-26

Созданы скрипты:

```text
.local_migration/scripts/convert-files-to-utf8.py
.local_migration/scripts/create-utf8-copy.sh
```

`create-utf8-copy.sh` воспроизводимо создаёт отдельную UTF-8 копию:

```text
.local_migration/www_utf8
database: corneroids_utf8
charset/collation: utf8mb4 / utf8mb4_unicode_ci
```

Важно: скрипт очищает содержимое `.local_migration/www_utf8`, но не удаляет сам каталог. Это нужно для корректной работы Docker bind mount при уже запущенных контейнерах.

Проверка после полного пересоздания UTF-8 копии:

```text
web74_utf8: http://localhost:8075
HTTP/1.1 200 OK
Content-Type: text/html; charset=utf-8
HTML meta charset: utf-8
Title: Всё для  игры Corneroids!
```

База проверена:

```text
corneroids_utf8.dle_post: 113 новостей
CHARSET(title): utf8mb4
Примеры заголовков читаются корректно:
- Открытие сайта Corneroids.by
- Как установить Corneroids на компьютер
- Текстура Drage01
```

Создан локальный checkpoint:

```text
.local_migration/checkpoints/10.5-utf8-php74-ok/
  README.txt
  db.sql
  www_utf8.tar.gz
```

Этот checkpoint игнорируется git и не публикуется в репозиторий.

PHP 8.2 для UTF-8 копии пока падает на старой несовместимости DLE 10.5:

```text
Fatal error: Array and string offset access syntax with curly braces is no longer supported
/var/www/html/engine/classes/templates.class.php on line 220
```

Это ожидаемо и не блокирует следующий шаг, потому что официальный upgrade нужно начинать с проверенной DLE 10.5 UTF-8 на PHP 7.4.

## 32. Обновление статуса: DLE 10.6 UTF-8 от 2026-06-26

Официальный архив DLE 10.6 найден и распакован:

```text
source: Z:\Ванина папка\1САЙТ\Движки\DLE\ЛИЦЕНЗИЯ\dle10.6_utf8.zip
local:  .local_migration/dle_versions/10.6/
```

Инструкция `Documentation/upgrade.html` для 10.6 требует:

```text
1. Обновить файлы из /upload/, кроме /templates/.
2. Если отсутствует templates/smartphone, скопировать его из дистрибутива.
3. Запустить /upgrade/index.php.
4. После успешного upgrade удалить /upgrade/ и install.php.
5. Очистить кеш.
```

Файлы DLE 10.6 были наложены поверх `.local_migration/www_utf8` с исключениями:

```text
/templates/
/engine/data/
```

`/templates/` исключен по официальной инструкции. `/engine/data/` сохранён, чтобы не потерять локальные конфиги подключения к Docker-БД.

Для прохождения локального мастера upgrade сначала был временно задан migration-only пароль пользователю `Drage` только в базе `corneroids_utf8`. После проверки это признано нежелательным: основной админский аккаунт `Drage` не используем для технических upgrade-сессий.

Текущее состояние локальной Docker-БД:

```text
Drage: пароль возвращён на исходный хеш из бэкапа.
Personage: используется как локальный migration-admin для следующих upgrade-сессий.
```

Это изменение находится только в локальной Docker-БД/checkpoint и не публикуется в git.

Upgrade `/upgrade/index.php` пройден через HTTP с авторизованной PHP session. Выполненные изменения:

```text
dle_logs.rating добавлен
dle_comment_rating_log.rating добавлен
dle_admin_sections.name изменён на VARCHAR(100)
dle_post.date изменён на DATETIME DEFAULT '2000-01-01 00:00:00'
dle_comments.date изменён на DATETIME DEFAULT '2000-01-01 00:00:00'
engine/data/config.php: version_id = 10.6
```

После upgrade удалены:

```text
.local_migration/www_utf8/upgrade/
.local_migration/www_utf8/install.php
```

Проверка:

```text
web74_utf8: http://localhost:8075
HTTP/1.1 200 OK
Content-Type: text/html; charset=utf-8
Title: Всё для  игры Corneroids!
Свежих PHP fatal/parse/warning в логах web74_utf8 не найдено.
```

Важное правило миграции: файлы ядра DLE на промежуточных шагах не править вручную. Нужно использовать оригинальные файлы официальных дистрибутивов и проходить штатные upgrade-процедуры по версиям.

После дополнительной проверки страниц `/rss.xml` и `/engine/opensearch.php` на PHP 7.4 был найден `Deprecated` из-за старого синтаксиса доступа к символу строки в оригинальном файле DLE 10.6:

```text
engine/classes/templates.class.php
$url['path']{0}
```

Ручная правка этого файла была отклонена и отменена. Текущая `.local_migration/www_utf8/engine/classes/templates.class.php` снова совпадает с оригинальным файлом из официального архива DLE 10.6. Это предупреждение фиксируется как известная несовместимость старого ядра с PHP 7.4/8, которую должен убрать следующий официальный upgrade, а не ручной patch ядра.

Проверены страницы:

```text
/                            200
/index.php                   200
/6-ustanovka.html            200
/5-otkrytie.html             200
/7-tekstura.html             200
/news/                       200
/help/                       200
/plugins/                    200
/index.php?do=feedback       200
/index.php?do=lastcomments   200
/admin.php                   200
/rss.xml                     200
/sitemap.xml                 200
/engine/opensearch.php       200
```

Скан основных HTML-страниц по `Fatal error`, `Parse error`, `Warning`, `Notice`, `Deprecated`, `MySQL Error`, `Database Error` ничего не нашёл. Для `/rss.xml` и `/engine/opensearch.php` остаётся известный `Deprecated` из оригинального `templates.class.php`.

Отдельный важный риск следующих upgrade: в одной из новых версий DLE меняется схема хеширования паролей. Перед и после каждого такого шага нужно отдельно проверить вход в админку локальным migration-admin аккаунтом, не потерять доступ к группе администраторов и не использовать для технических проверок основной аккаунт `Drage`.

Создан локальный checkpoint:

```text
.local_migration/checkpoints/10.6-utf8-php74-ok/
  README.txt
  db.sql
  www_utf8.tar.gz
```

Следующий практический шаг:

```text
Начать официальный upgrade DLE 10.6 UTF-8 -> DLE 11.0.
```

## 33. Попытка DLE 10.6 UTF-8 -> DLE 11.0 от 2026-06-26

Архив DLE 11.0 был найден:

```text
source: Z:\Ванина папка\1САЙТ\Движки\DLE\ЛИЦЕНЗИЯ\dle11.0.zip
local:  .local_migration/dle_versions/11.0/
```

Особенность: стандартный `unzip` не смог распаковать этот архив, но `7z` распаковал его корректно.

Проверка `upload/upgrade/index.php` показала:

```php
$dle_version = "11.0";
$distr_charset = "windows-1251";
```

При запуске официального `/upgrade/index.php` мастер обновления остановился штатной проверкой:

```text
текущий сайт: utf-8
дистрибутив: windows-1251
```

Поэтому upgrade до DLE 11.0 не был выполнен. Это правильная остановка: после перехода сайта на UTF-8 нельзя накладывать windows-1251 дистрибутив и нельзя вручную перекодировать файлы ядра, потому правило миграции требует использовать оригинальные официальные файлы.

Файлы и база были восстановлены из checkpoint:

```text
.local_migration/checkpoints/10.6-utf8-php74-ok/
```

После восстановления:

```text
web74_utf8: http://localhost:8075
HTTP/1.1 200 OK
Content-Type: text/html; charset=utf-8
engine/data/config.php: version_id = 10.6
Drage: пароль возвращён на исходный хеш из бэкапа.
Personage: локальный migration-admin.
```

Также проверен архив DLE 11.1:

```text
source: Z:\Ванина папка\1САЙТ\Движки\DLE\ЛИЦЕНЗИЯ\dle11.1.zip
local:  .local_migration/dle_versions/11.1/
```

В `upload/upgrade/index.php` DLE 11.1 также указано:

```php
$dle_version = "11.1";
$distr_charset = "windows-1251";
```

Блокер был актуален до загрузки UTF-8 архивов в OneDrive. Позже пользователь загрузил нужные архивы:

```text
D:\OneDrive\OneDrive - EPAM\Моё\dev\dle11.0_utf8.zip
D:\OneDrive\OneDrive - EPAM\Моё\dev\dle11.1_utf8.zip
D:\OneDrive\OneDrive - EPAM\Моё\dev\dle11.2_utf8.zip
```

Эти архивы проверены: в `upload/upgrade/index.php` у всех указано `$distr_charset = "utf-8"`.

## 34. Обновление статуса: DLE 11.0, 11.1, 11.2 UTF-8 от 2026-06-26

Пройден строгий маршрут:

```text
DLE 10.6 UTF-8 -> DLE 11.0 UTF-8 -> DLE 11.1 UTF-8 -> DLE 11.2 UTF-8
```

Для каждого шага использовались оригинальные файлы официального UTF-8 дистрибутива. Файлы ядра вручную не правились. При наложении файлов сохранялись:

```text
/templates/
/engine/data/
```

### DLE 11.0

Архив:

```text
.local_migration/dle_versions/11.0_utf8/dle11.0_utf8.zip
```

Upgrade `/upgrade/index.php` успешно завершён. Проверено:

```text
engine/data/config.php: version_id = 11.0
dle_xfsearch создана
dle_social_login.waitlogin добавлен
dle_links.targetblank добавлен
dle_usergroups.force_reg добавлен
```

Создан локальный checkpoint:

```text
.local_migration/checkpoints/11.0-utf8-php74-ok/
```

### DLE 11.1

Архив:

```text
.local_migration/dle_versions/11.1_utf8/dle11.1_utf8.zip
```

Upgrade `/upgrade/index.php` успешно завершён. Важное изменение:

```text
dle_users.password изменён с VARCHAR(32) на VARCHAR(255)
```

Хеши паролей не пересчитывались и остались старыми 32-символьными хешами. После upgrade проверен вход локальным migration-admin аккаунтом `Personage`.

Создан локальный checkpoint:

```text
.local_migration/checkpoints/11.1-utf8-php74-ok/
```

### DLE 11.2

Архив:

```text
.local_migration/dle_versions/11.2_utf8/dle11.2_utf8.zip
```

Upgrade `/upgrade/index.php` успешно завершён. Проверено:

```text
engine/data/config.php: version_id = 11.2
dle_twofactor создана
dle_users.twofactor_auth добавлен
dle_files.checksum добавлен
Personage login работает
Drage остаётся на исходном хеше из бэкапа
```

После upgrade удалены:

```text
.local_migration/www_utf8/upgrade/
.local_migration/www_utf8/install.php
```

Проверка страниц на `web74_utf8`:

```text
/                            200
/index.php                   200
/6-ustanovka.html            200
/5-otkrytie.html             200
/7-tekstura.html             200
/news/                       200
/help/                       200
/plugins/                    200
/index.php?do=feedback       200
/index.php?do=lastcomments   200
```

Свежие логи `web74_utf8` после проверки не содержали fatal/parse/warning/notice/deprecated/error.

Создан локальный checkpoint:

```text
.local_migration/checkpoints/11.2-utf8-php74-ok/
```

Следующий практический шаг:

```text
Начать официальный upgrade DLE 11.2 UTF-8 -> DLE 11.3 UTF-8.
```
