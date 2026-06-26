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

Основная директория для хранения и поиска официальных лицензированных архивов DLE во время миграции:

```text
Z:\Ванина папка\1САЙТ\Движки\DLE\ЛИЦЕНЗИЯ\
```

Эту директорию считать primary source для следующих upgrade-шагов. Локальная папка проекта `.local_migration/dle_versions/` может содержать уже распакованные/скопированные рабочие версии, но недостающие архивы нужно брать из primary source выше.

На 2026-06-26 доступ к primary source подтверждён из Windows/PowerShell и из WSL. В ней лежат архивы:

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

Важно: часть архивов не имеет `_utf8` в имени. Перед использованием каждой версии нужно проверять содержимое архива и кодировку дистрибутива. После перехода сайта на UTF-8 нельзя накладывать windows-1251 дистрибутив и нельзя вручную перекодировать файлы ядра DLE.

Диск `Z:` смонтирован в WSL через `drvfs`. Предпочтительный путь для дальнейших команд миграции:

```text
/mnt/z/Ванина папка/1САЙТ/Движки/DLE/ЛИЦЕНЗИЯ/
```

Если после перезапуска WSL `/mnt/z` снова не смонтирован, выполнить от root:

```bash
mkdir -p /mnt/z
mount -t drvfs Z: /mnt/z
```

Если `/mnt/z` недоступен, fallback: работать с primary source через Windows/PowerShell и копировать или распаковывать нужные версии в проект:

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

### 22.1. TODO: вернуть и адаптировать whoonline snippet

На текущем мигрированном стенде DLE 15.1 в сайдбаре шаблона `Pisces` видна ошибка:

```text
File engine/modules/snippets/whoonline.php not found.
```

Точка подключения:

```text
templates/Pisces/main.tpl
{include file="engine/modules/snippets/whoonline.php"}
```

Шаблон вывода при этом существует:

```text
templates/Pisces/whoonline.tpl
```

Старый исходник модуля найден в legacy-копиях:

```text
engine/modules/snippets/whoonline.php
.local_migration/legacy/domains/corneroids.by/public_html/engine/modules/snippets/whoonline.php
.local_migration/www/engine/modules/snippets/whoonline.php
```

Задача:

```text
1. Не копировать старый whoonline.php вслепую в текущую миграцию.
2. После выхода на DLE 20.0 портировать модуль из legacy-версии.
3. Адаптировать код под актуальные API DLE 20.0 и PHP 8.x.
4. Проверить, что модуль не использует удалённые/старые глобальные переменные, SQL-паттерны и небезопасный вывод.
5. Проверить отображение через templates/Pisces/whoonline.tpl.
```

Рекомендация по сроку выполнения: делать это после завершения core-migration до DLE 20.0, а не сейчас. Причина: модуль сторонний/кастомный, и при каждом дальнейшем overlay официальных файлов и смене DLE API его придётся перепроверять заново. До конца миграции достаточно держать ошибку как известный визуальный дефект или временно убрать include из локального шаблона отдельным patch, если он будет мешать просмотру страниц.

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

На текущем этапе Docker установлен, cp1251 baseline, UTF-8 baseline и upgrades до DLE 11.2 проверены локально. От пользователя сейчас требуется только то, что нельзя безопасно сделать без доступа к внешним данным или интерактивному окружению:

```text
1. Если нужен доступ через http://corneroids.by:8074/8075 в браузере Windows, добавить hosts-записи вручную.
2. По мере прохождения следующих шагов распаковывать официальные архивы DLE из Z:\Ванина папка\1САЙТ\Движки\DLE\ЛИЦЕНЗИЯ\ или OneDrive в .local_migration/dle_versions/.
3. Подтвердить, что можно начинать следующий официальный upgrade: DLE 11.2 UTF-8 -> DLE 11.3 UTF-8.
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
Начать официальный upgrade DLE 11.2 UTF-8 -> DLE 11.3 UTF-8.
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
См. разделы 33-34: upgrade до DLE 11.2 уже выполнен, следующий шаг DLE 11.2 UTF-8 -> DLE 11.3 UTF-8.
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

Важное парольное изменение: после успешного входа на DLE 11.2 локальный migration-admin `Personage` автоматически перешёл со старого 32-символьного MD5-хеша на bcrypt-хеш `$2y$` длиной 60 символов.

Текущее состояние локальной Docker-БД:

```text
Drage:    исходный 32-символьный MD5-хеш из бэкапа сохранён.
Personage: bcrypt-хеш после успешного входа на DLE 11.2.
```

Это подтверждает, что в этой части маршрута DLE начинает поддерживать новую схему хеширования и может обновлять парольный хеш при логине. Основной аккаунт `Drage` не использовался для технического входа, поэтому его исходный хеш сохранён.

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

## 35. Контрольный аудит DLE 11.2 от 2026-06-26

Git и GitHub:

```text
origin/main обновлён.
tag: checkpoint-11.2-utf8-php74-ok-password-verified
tracked worktree: clean before this audit note
```

Текущая локальная версия:

```text
web74_utf8: http://localhost:8075
engine/data/config.php: version_id = 11.2
charset = utf-8
```

Пароли администраторов в локальной Docker-БД:

```text
Drage:    32-символьный исходный MD5-хеш из бэкапа сохранён.
Personage: bcrypt-хеш $2y$ длиной 60 символов после успешного входа на DLE 11.2.
```

Проверка страниц:

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
/sitemap.xml                 404
/engine/opensearch.php       200
```

Основные HTML-страницы и админка открываются. Свежие логи `web74_utf8` после проверки не содержали fatal/parse/warning/notice/deprecated/error.

Известные замечания текущего DLE 11.2 на PHP 7.4:

```text
/rss.xml и /engine/opensearch.php выводят Deprecated:
Array and string offset access syntax with curly braces is deprecated
/var/www/html/engine/classes/templates.class.php on line 226
```

`templates.class.php` в `.local_migration/www_utf8` совпадает с оригинальным файлом официального DLE 11.2 UTF-8 архива. Вручную ядро не править; это предупреждение нужно закрывать следующим официальным upgrade или переходом на версию, где DLE уже исправил этот синтаксис.

`/sitemap.xml` сейчас отдаёт 404. Это не PHP fatal и не ошибка миграции БД, но перед финальным переносом нужно отдельно проверить генерацию sitemap/ЧПУ в актуальной финальной версии DLE.

## 36. Адаптация шаблона Pisces под DLE 10.5 -> 11.2 от 2026-06-26

Источник требований:

```text
https://dle-news.ru/templates-changelog.html
разделы "Изменения в шаблонах" для переходов 10.5 -> 10.6 -> 11.0 -> 11.1 -> 11.2
```

Важное ограничение источника: официальный список "Изменения в шаблонах" написан для стандартного шаблона DLE `Default`. Это не готовый patch для текущего сайта. При переносе каждого пункта нужно сначала понять, какую функциональность добавляет новый тег/CSS/файл, затем найти соответствующее место в активном шаблоне сайта и адаптировать разметку под его структуру.

Для этого проекта нельзя механически копировать файлы из `Default` поверх `Pisces`: у `Pisces` другая HTML-структура, другие классы и существующая навигация. Корректный подход:

```text
1. взять официальный changelog как список обязательных возможностей;
2. сравнить с текущим активным шаблоном Pisces;
3. добавить недостающие теги/CSS в существующую разметку Pisces;
4. не менять main.tpl и другие layout-файлы автоматически, если changelog говорит "при необходимости";
5. после каждой адаптации проверять публичные страницы и логи PHP.
```

Активный шаблон сайта:

```text
.local_migration/www_utf8/templates/Pisces
```

Применённые изменения в рабочей UTF-8 копии шаблона:

```text
templates/Pisces/style/engine.css
  добавлен блок DLE 10.6-11.2 template compatibility:
  .emoji, .sort, .xfieldsrow, .xfieldscolleft, .xfieldscolright,
  .file-box, .qq-uploader, .qq-upload-*, .uploadedfile,
  .progress, .progress-bar, .progress-blue,
  .xfieldimagegallery, .btn.disabled, .dle-captcha, .xfieldsnote

templates/Pisces/attachment.tpl
  добавлен [allow-online] с {online-view-link} внутри существующей разметки Pisces

templates/Pisces/userinfo.tpl
  старый ручной checkbox name="subscribe" удалён из строки email
  добавлены теги DLE 11.x:
  {twofactor-auth}
  {news-subscribe}
  {comments-reply-subscribe}
  {unsubscribe}

templates/Pisces/categorymenu.tpl
  создан файл для нового DLE 11.2 category menu
```

`main.tpl` намеренно не менялся. Официальный changelog говорит добавлять `{catmenu}` только при необходимости вывода меню категорий. У Pisces уже есть собственная навигация, поэтому автоматическая вставка `{catmenu}` могла бы изменить/сломать макет. Файл `categorymenu.tpl` создан, и тег можно будет разместить отдельно после решения по дизайну.

BB-редактор отдельно не переписывался: блок `/*---BB Редактор---*/` в Pisces уже соответствует структуре Default 11.2 и содержит актуальные `.bb-pane`, `.bb-btn`, `.bb-editor textarea`.

Воспроизводимый patch по этим изменениям сохранён в Git:

```text
.local_migration/patches/pisces-template-10.5-to-11.2.patch
```

Важно: рабочая копия `.local_migration/www_utf8` не трекается Git напрямую, чтобы не загружать локальные артефакты миграции, дампы и потенциальные секреты. Поэтому в Git фиксируется README + patch-файл с изменениями шаблона.

Проверка после правок на `web74_utf8`:

```text
/                                             200
/index.php                                    200
/6-ustanovka.html                             200
/news/                                        200
/plugins/                                     200
/index.php?do=feedback                        200
/index.php?subaction=userinfo&user=Personage  200
/templates/Pisces/style/engine.css            200
```

В HTML этих ответов не найдено `fatal error`, `parse error`, `warning`, `notice`, `deprecated`. Свежие логи `web74_utf8` после запросов не содержат новых PHP fatal/parse/warning/notice/deprecated/error; видны только стартовые Apache notice.

## 37. Обновление статуса: DLE 11.3 UTF-8 от 2026-06-26

Официальный архив:

```text
source: /mnt/z/Ванина папка/1САЙТ/Движки/DLE/ЛИЦЕНЗИЯ/dle11.3_utf8.zip
local:  .local_migration/dle_versions/11.3_utf8/
```

Проверка архива:

```text
upload/upgrade/index.php: $dle_version = "11.3"
upload/upgrade/index.php: $distr_charset = "utf-8"
```

Официальная инструкция `Documentation/upgrade.html` для этого архива:

```text
1. Обновить все файлы из /upload/, кроме /templates/.
2. Если отсутствует templates/smartphone, скопировать его из дистрибутива.
3. Запустить /upgrade/index.php.
4. Удалить /upgrade/ и install.php.
```

Перед upgrade создан checkpoint текущей DLE 11.2 с уже адаптированным шаблоном Pisces:

```text
.local_migration/checkpoints/11.2-utf8-php74-template-ok/
  README.txt
  db.sql
  www_utf8.tar.gz
```

Файлы 11.3 наложены штатно:

```text
source: .local_migration/dle_versions/11.3_utf8/extracted/upload/
target: .local_migration/www_utf8/
excluded:
  /templates/
  /engine/data/
  /uploads/
  /backup/
```

`/templates/` сохранён, поэтому рабочие правки `Pisces` не были затёрты. Файлы ядра вручную не правились.

Upgrade `/upgrade/index.php` успешно завершён:

```text
11.2 -> 11.3
engine/data/config.php: version_id = 11.3
charset = utf-8
skin = Pisces
```

После upgrade удалены:

```text
.local_migration/www_utf8/upgrade/
.local_migration/www_utf8/install.php
```

Локальная админка показала предупреждение о правах на cache-директории; для Docker-стенда выставлены права:

```text
.local_migration/www_utf8/engine/cache
.local_migration/www_utf8/engine/cache/system
```

Пароли администраторов:

```text
Drage:    32-символьный исходный MD5-хеш из бэкапа сохранён.
Personage: временно использовался как migration-admin; после обычного входа в admin.php снова имеет bcrypt-хеш $2y$ длиной 60.
```

`Drage` для технического входа не использовался.

Адаптация шаблона Pisces по официальному `templates-changelog` для 11.2 -> 11.3:

```text
templates/Pisces/style/styles.css
  добавлено: .instagram-media, .twitter-tweet { display: inline-block !important; }

templates/Pisces/feedback.tpl
  добавлен блок [attachments] с input name="attachments[]" type="file" multiple
```

Официальный changelog написан для `Default`; изменения перенесены в структуру `Pisces`, а не скопированы механически.

Воспроизводимый patch сохранён в Git:

```text
.local_migration/patches/pisces-template-11.2-to-11.3.patch
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
/admin.php                   200
/rss.xml                     200
/sitemap.xml                 404
/engine/opensearch.php       200
```

Основные HTML-страницы и админка открываются без PHP diagnostic text. Свежие логи `web74_utf8` после проверки не содержат новых PHP fatal/parse/warning/notice/deprecated/error.

Известные замечания DLE 11.3:

```text
/rss.xml и /engine/opensearch.php выводят Deprecated:
Array and string offset access syntax with curly braces is deprecated
/var/www/html/engine/classes/templates.class.php on line 232

PHP 8.2 всё ещё падает на этой же несовместимости:
Fatal error: Array and string offset access syntax with curly braces is no longer supported
/var/www/html/engine/classes/templates.class.php on line 232

/sitemap.xml отдаёт 404
```

`templates.class.php` оставлен оригинальным из официального DLE 11.3 UTF-8 архива. Ядро вручную не править; это должно закрыться последующим официальным upgrade.

Создан локальный checkpoint:

```text
.local_migration/checkpoints/11.3-utf8-php74-ok/
  README.txt
  db.sql
  www_utf8.tar.gz
```

Следующий практический шаг:

```text
Начать официальный upgrade DLE 11.3 UTF-8 -> DLE 12.0 UTF-8.
```

## 38. Обновление статуса: DLE 12.0 UTF-8 от 2026-06-26

Официальный архив:

```text
source: /mnt/z/Ванина папка/1САЙТ/Движки/DLE/ЛИЦЕНЗИЯ/dle12_0_utf8.zip
local:  .local_migration/dle_versions/12.0_utf8/
```

Проверка архива:

```text
upload/upgrade/index.php: $dle_version = "12.0"
upload/upgrade/index.php: $distr_charset = "utf-8"
```

Официальная инструкция `Documentation/upgrade.html`:

```text
1. Обновить все файлы из /upload/, кроме /templates/.
2. Если отсутствует templates/smartphone, скопировать его из дистрибутива.
3. Запустить /upgrade/index.php.
4. Удалить /upgrade/ и install.php.
```

Файлы 12.0 наложены штатно:

```text
source: .local_migration/dle_versions/12.0_utf8/extracted/upload/
target: .local_migration/www_utf8/
excluded:
  /templates/
  /engine/data/
  /uploads/
  /backup/
```

`/templates/` сохранён; рабочие правки `Pisces` после 11.3 не затёрты. Файлы ядра вручную не правились.

Upgrade `/upgrade/index.php` успешно завершён:

```text
11.3 -> 12.0
engine/data/config.php: version_id = 12.0
charset = utf-8
skin = Pisces
```

После upgrade удалены:

```text
.local_migration/www_utf8/upgrade/
.local_migration/www_utf8/install.php
```

Пароли администраторов:

```text
Drage:    32-символьный исходный MD5-хеш из бэкапа сохранён.
Personage: bcrypt-хеш $2y$ длиной 60 символов.
```

Официальный `templates-changelog` для 11.3 -> 12.0:

```text
Изменений в шаблонах между данными версиями не требуется.
```

Проверка страниц на `web74_utf8`:

```text
/                            200
/index.php                   200
/6-ustanovka.html            200
/news/                       200
/plugins/                    200
/index.php?do=feedback       200
/index.php?do=lastcomments   200
/admin.php                   200
/rss.xml                     200
/sitemap.xml                 404
/engine/opensearch.php       200
```

Основные HTML-страницы и админка открываются без PHP diagnostic text. Свежие логи `web74_utf8` после проверки не содержат новых PHP fatal/parse/warning/notice/deprecated/error.

Известные замечания DLE 12.0:

```text
/rss.xml и /engine/opensearch.php выводят Deprecated:
Array and string offset access syntax with curly braces is deprecated
/var/www/html/engine/classes/templates.class.php on line 243

PHP 8.2 всё ещё падает на этой же несовместимости:
Fatal error: Array and string offset access syntax with curly braces is no longer supported
/var/www/html/engine/classes/templates.class.php on line 243

/sitemap.xml отдаёт 404
```

`templates.class.php` оставлен оригинальным из официального DLE 12.0 UTF-8 архива. Ядро вручную не править; это должно закрыться последующим официальным upgrade.

Создан локальный checkpoint:

```text
.local_migration/checkpoints/12.0-utf8-php74-ok/
  README.txt
  db.sql
  www_utf8.tar.gz
```

Следующий практический шаг:

```text
Начать официальный upgrade DLE 12.0 UTF-8 -> DLE 12.1 UTF-8.
```

## 39. Обновление статуса: DLE 12.1 UTF-8 от 2026-06-26

Официальный архив:

```text
source: /mnt/z/Ванина папка/1САЙТ/Движки/DLE/ЛИЦЕНЗИЯ/dle12_1_utf8.zip
local:  .local_migration/dle_versions/12.1_utf8/
```

Проверка архива:

```text
upload/upgrade/index.php: $dle_version = "12.1"
upload/upgrade/index.php: $distr_charset = "utf-8"
```

Официальная инструкция `Documentation/upgrade.html`:

```text
1. Обновить все файлы из /upload/, кроме /templates/.
2. Если отсутствует templates/smartphone, скопировать его из дистрибутива.
3. Запустить /upgrade/index.php.
4. Удалить /upgrade/ и install.php.
```

Файлы 12.1 наложены штатно:

```text
source: .local_migration/dle_versions/12.1_utf8/extracted/upload/
target: .local_migration/www_utf8/
excluded:
  /templates/
  /engine/data/
  /uploads/
  /backup/
```

`/templates/` сохранён. Файлы ядра вручную не правились.

Upgrade `/upgrade/index.php` успешно завершён:

```text
12.0 -> 12.1
engine/data/config.php: version_id = 12.1
charset = utf-8
skin = Pisces
```

После upgrade удалены:

```text
.local_migration/www_utf8/upgrade/
.local_migration/www_utf8/install.php
```

Пароли администраторов:

```text
Drage:    32-символьный исходный MD5-хеш из бэкапа сохранён.
Personage: bcrypt-хеш $2y$ длиной 60 символов.
```

Официальный `templates-changelog` для 12.0 -> 12.1:

```text
Изменений в шаблонах между данными версиями не требуется.
```

Проверка страниц на `web74_utf8`:

```text
/                            200
/index.php                   200
/6-ustanovka.html            200
/news/                       200
/plugins/                    200
/index.php?do=feedback       200
/index.php?do=lastcomments   200
/admin.php                   200
/rss.xml                     200
/sitemap.xml                 404
/engine/opensearch.php       200
```

Основные HTML-страницы и админка открываются без PHP diagnostic text. Свежие логи `web74_utf8` после проверки не содержат новых PHP fatal/parse/warning/notice/deprecated/error.

Известные замечания DLE 12.1:

```text
/rss.xml и /engine/opensearch.php выводят Deprecated:
Array and string offset access syntax with curly braces is deprecated
/var/www/html/engine/classes/templates.class.php on line 278

PHP 8.2 всё ещё падает на этой же несовместимости:
Fatal error: Array and string offset access syntax with curly braces is no longer supported
/var/www/html/engine/classes/templates.class.php on line 278

/sitemap.xml отдаёт 404
```

`templates.class.php` оставлен оригинальным из официального DLE 12.1 UTF-8 архива. Ядро вручную не править; это должно закрыться последующим официальным upgrade.

Создан локальный checkpoint:

```text
.local_migration/checkpoints/12.1-utf8-php74-ok/
  README.txt
  db.sql
  www_utf8.tar.gz
```

Следующий практический шаг:

```text
Подготовить upgrade DLE 12.1 UTF-8 -> DLE 13.0.
Перед наложением dle13_0.zip обязательно проверить, что дистрибутив в архиве имеет $distr_charset = "utf-8", так как имя архива не содержит _utf8.
```

## 40. Обновление статуса: DLE 13.0 UTF-8 от 2026-06-26

Локальный UTF-8 стенд успешно обновлён с DLE 12.1 до DLE 13.0.

Использованный архив:

```text
/mnt/z/Ванина папка/1САЙТ/Движки/DLE/ЛИЦЕНЗИЯ/dle13_0.zip
```

Важный нюанс: начиная с этой версии архив уже не имеет `_utf8` в имени, но перед применением было проверено, что `install.php` внутри официального дистрибутива содержит:

```text
$distr_charset = "utf-8"
$version_id = "13.0"
```

Начиная с DLE 13.0 отдельного `/upgrade/` каталога в архиве нет. Штатный upgrade выполняется через админ-панель:

```text
admin.php?mod=upgrade&action=dbupgrade
```

Процесс для локального стенда:

```text
1. Наложить files from upload/ поверх .local_migration/www_utf8.
2. Не затирать templates/, engine/data/, uploads/, backup/.
3. Войти в admin.php под локальным migration-admin Personage.
4. Выполнить AJAX upgrade action=dodbupgrade.
5. Проверить dbupgradecheck.
6. Удалить install.php.
7. Проверить публичные страницы.
```

Результат:

```text
.local_migration/www_utf8/engine/data/config.php: version_id = 13.0
charset = utf-8
skin = Pisces
```

Проверка шаблонов по официальному changelog:

```text
12.1 -> 13.0: изменений в шаблонах не требуется.
```

Создан локальный checkpoint:

```text
.local_migration/checkpoints/13.0-utf8-php74-ok
```

PHP 7.4 после upgrade: главная, новости, категории, feedback, lastcomments, admin.php и RSS открывались без PHP/MySQL диагностик.

PHP 8.2 после upgrade всё ещё не является целевой рабочей средой на этом этапе: главная падала в оригинальном core-файле:

```text
engine/modules/sitelogin.php
```

Core-файлы вручную не правились.

## 41. Обновление статуса: DLE 13.1 UTF-8 от 2026-06-26

Локальный UTF-8 стенд успешно обновлён с DLE 13.0 до DLE 13.1.

Использованный архив:

```text
/mnt/z/Ванина папка/1САЙТ/Движки/DLE/ЛИЦЕНЗИЯ/dle13_1.zip
```

Перед применением было проверено:

```text
$distr_charset = "utf-8"
$version_id = "13.1"
```

Результат:

```text
.local_migration/www_utf8/engine/data/config.php: version_id = 13.1
charset = utf-8
skin = Pisces
```

Официальный changelog для Default template требует изменений в рейтинге и upload CSS для перехода 13.0 -> 13.1. Эти изменения адаптированы под активный шаблон `Pisces`, а не скопированы вслепую из Default.

Изменённые файлы Pisces:

```text
templates/Pisces/style/engine.css
templates/Pisces/shortstory.tpl
templates/Pisces/fullstory.tpl
templates/Pisces/comments.tpl
```

Что сделано:

```text
1. Обновлены CSS-правила .uploadedfile/.uploadimage и добавлен .sortable-ghost.
2. В shortstory.tpl добавлена поддержка rating-type-4.
3. В fullstory.tpl добавлена поддержка rating-type-4.
4. В comments.tpl добавлена поддержка rating-type-4.
```

При адаптации рейтинга сохранена структура Pisces с существующими иконками и блоками `ratebox3`; SVG/HTML из Default template не переносился напрямую.

Patch-файл адаптации:

```text
.local_migration/patches/pisces-template-13.0-to-13.1.patch
```

Создан локальный checkpoint:

```text
.local_migration/checkpoints/13.1-utf8-php74-ok
```

PHP 7.4 после upgrade: проверенные страницы открывались без PHP/MySQL диагностик.

PHP 8.2: главная всё ещё падала в оригинальном core-файле `engine/modules/sitelogin.php`; core-файлы не правились.

## 42. Обновление статуса: DLE 13.2 UTF-8 от 2026-06-26

Локальный UTF-8 стенд успешно обновлён с DLE 13.1 до DLE 13.2.

Использованный архив:

```text
/mnt/z/Ванина папка/1САЙТ/Движки/DLE/ЛИЦЕНЗИЯ/dle13_2.zip
```

Перед применением было проверено:

```text
$distr_charset = "utf-8"
$version_id = "13.2"
engine/inc/upgrade/13.1.php exists
```

Upgrade выполнен штатно через `admin.php?mod=upgrade&action=dbupgrade` под локальным migration-admin `Personage`.

Результат AJAX upgrade:

```json
{"status": "ok", "version":"13.2"}
```

После upgrade:

```text
.local_migration/www_utf8/engine/data/config.php: version_id = 13.2
charset = utf-8
skin = Pisces
install.php удалён
```

Официальный changelog:

```text
13.1 -> 13.2: изменений в шаблонах не требуется.
```

Создан локальный checkpoint:

```text
.local_migration/checkpoints/13.2-utf8-php74-ok
```

Проверка PHP 7.4:

```text
/                              200 ok
/index.php                     200 ok
/6-ustanovka.html              200 ok
/news/                         200 ok
/plugins/                      200 ok
/index.php?do=feedback         200 ok
/index.php?do=lastcomments     200 ok
/admin.php                     200 ok
/rss.xml                       200 ok
/sitemap.xml                   404 ok
/engine/opensearch.php         302 ok
```

`sitemap.xml` отдаёт 404 без PHP/MySQL диагностик. `opensearch.php` отдаёт 302 redirect, как и на предыдущих шагах.

Проверка PHP 8.2:

```text
/                              200 PHP_TEXT
Fatal error: Array and string offset access syntax with curly braces is no longer supported in /var/www/html/engine/modules/sitelogin.php on line 159
/rss.xml                       200 ok
/engine/opensearch.php         302 ok
```

Это ошибка в оригинальном core-файле DLE 13.2, вручную не исправлялась. Ожидаем, что она исчезнет в одной из следующих официальных версий.

Следующий шаг:

```text
Подготовить upgrade DLE 13.2 UTF-8 -> DLE 13.3.
Перед применением проверить charset/version в официальном архиве dle13_3.zip и изменения шаблона 13.2 -> 13.3.
```

## 43. Обновление статуса: DLE 13.3 UTF-8 от 2026-06-26

Локальный UTF-8 стенд успешно обновлён с DLE 13.2 до DLE 13.3.

Использованный архив:

```text
/mnt/z/Ванина папка/1САЙТ/Движки/DLE/ЛИЦЕНЗИЯ/dle13_3.zip
```

Перед применением было проверено:

```text
install.php: version_id = 13.3
install.php: charset = utf-8
engine/inc/upgrade/13.2.php exists
```

Upgrade выполнен штатно через `admin.php?mod=upgrade&action=dbupgrade` под локальным migration-admin `Personage`.

Результат AJAX upgrade:

```json
{"status": "ok", "version":"13.3"}
```

После upgrade:

```text
.local_migration/www_utf8/engine/data/config.php: version_id = 13.3
charset = utf-8
skin = Pisces
install.php удалён
```

Официальный changelog для Default template на переходе 13.2 -> 13.3 требует добавить в `css/engine.css`:

```css
.ui-front { z-index: 1000; }
.ui-button-icon-only { overflow: hidden; text-indent: -9999px; }
```

Для активного шаблона `Pisces` это адаптировано в:

```text
templates/Pisces/style/engine.css
```

Patch-файл адаптации:

```text
.local_migration/patches/pisces-template-13.2-to-13.3.patch
```

Создан локальный checkpoint:

```text
.local_migration/checkpoints/13.3-utf8-php74-ok
```

Проверка PHP 7.4:

```text
/                              200 ok
/index.php                     200 ok
/6-ustanovka.html              200 ok
/news/                         200 ok
/plugins/                      200 ok
/index.php?do=feedback         200 ok
/index.php?do=lastcomments     200 ok
/admin.php                     200 ok
/rss.xml                       200 ok
/sitemap.xml                   404 ok
/engine/opensearch.php         302 ok
```

Проверка PHP 8.2:

```text
/                              200 PHP_TEXT
Fatal error: Array and string offset access syntax with curly braces is no longer supported in /var/www/html/engine/modules/sitelogin.php on line 159
/rss.xml                       200 ok
/engine/opensearch.php         302 ok
```

Core-файл `engine/modules/sitelogin.php` не исправлялся вручную.

Следующий шаг:

```text
Подготовить upgrade DLE 13.3 UTF-8 -> DLE 14.0.
Перед применением проверить charset/version в официальном архиве dle14_0.zip и изменения шаблона 13.3 -> 14.0.
```

## 44. Обновление статуса: DLE 14.0 UTF-8 от 2026-06-26

Локальный UTF-8 стенд успешно обновлён с DLE 13.3 до DLE 14.0.

Использованный архив:

```text
/mnt/z/Ванина папка/1САЙТ/Движки/DLE/ЛИЦЕНЗИЯ/dle14_0.zip
```

Перед применением было проверено:

```text
install.php: version_id = 14.0
install.php: charset = utf-8
engine/inc/upgrade/13.3.php exists
```

Upgrade выполнен штатно через `admin.php?mod=upgrade&action=dbupgrade` под локальным migration-admin `Personage`.

Результат AJAX upgrade:

```json
{"status": "ok", "version":"14.0"}
```

После upgrade:

```text
.local_migration/www_utf8/engine/data/config.php: version_id = 14.0
charset = utf-8
skin = Pisces
install.php удалён
```

Официальный changelog для Default template на переходе 13.3 -> 14.0 требует добавить emoji CSS в `css/engine.css`.

Для активного шаблона `Pisces` это адаптировано в:

```text
templates/Pisces/style/engine.css
```

Добавленные CSS-блоки:

```text
.emoji_box
.emoji_category
.emoji_list
.emoji_symbol
.native-emoji
```

Patch-файл адаптации:

```text
.local_migration/patches/pisces-template-13.3-to-14.0.patch
```

Создан локальный checkpoint:

```text
.local_migration/checkpoints/14.0-utf8-php74-ok
```

Проверка PHP 7.4:

```text
/                              200 ok
/index.php                     200 ok
/6-ustanovka.html              200 ok
/news/                         200 ok
/plugins/                      200 ok
/index.php?do=feedback         200 ok
/index.php?do=lastcomments     200 ok
/admin.php                     200 ok
/rss.xml                       200 ok
/sitemap.xml                   404 ok
/engine/opensearch.php         302 ok
```

Проверка PHP 8.2:

```text
/                              200 PHP_TEXT
Fatal error: Uncaught ValueError: array_rand(): Argument #1 ($array) cannot be empty in /var/www/html/engine/modules/vote.php:80
/rss.xml                       200 ok
/engine/opensearch.php         302 ok
```

PHP 8.2 ошибка изменилась относительно 13.3: теперь проблема не в `sitelogin.php`, а в оригинальном core-файле `engine/modules/vote.php`. Core-файл вручную не исправлялся.

Следующий шаг:

```text
Подготовить upgrade DLE 14.0 UTF-8 -> DLE 14.1.
Перед применением проверить charset/version в официальном архиве dle14_1.zip и изменения шаблона 14.0 -> 14.1.
```

## 45. Обновление статуса: DLE 14.1 UTF-8 от 2026-06-26

Локальный UTF-8 стенд успешно обновлён с DLE 14.0 до DLE 14.1.

Использованный архив:

```text
/mnt/z/Ванина папка/1САЙТ/Движки/DLE/ЛИЦЕНЗИЯ/dle14_1.zip
```

Перед применением было проверено:

```text
install.php: version_id = 14.1
install.php: charset = utf-8
engine/inc/upgrade/14.0.php exists
```

Шаблонный changelog для Default template на переходе 14.0 -> 14.1 требует добавить/обновить:

```text
print.tpl
static_print.tpl
```

В `Pisces` эти файлы уже существовали, но были старого формата: XHTML/table layout и подключение старых JS. Для печатных страниц они заменены актуальными файлами из официального `templates/Default/` DLE 14.1:

```text
templates/Pisces/print.tpl
templates/Pisces/static_print.tpl
```

Это осознанная адаптация: основная верстка сайта не затронута, изменение касается только print-версий.

Patch-файл адаптации:

```text
.local_migration/patches/pisces-template-14.0-to-14.1.patch
```

Во время первого захода в upgrade DLE 14.1 показал предварительную проверку прав:

```text
/engine/cache/
/engine/cache/system/
```

После runtime-проверки из контейнера `web74_utf8` директории были доступны на запись. Повторная загрузка `admin.php?mod=upgrade&action=dbupgrade&to=14.1` отдала нормальную страницу upgrade:

```text
actualversion = 14.1
versions = ['14.0','14.1']
```

Upgrade выполнен штатно через `admin.php?mod=upgrade&action=dbupgrade` под локальным migration-admin `Personage`.

Результат AJAX upgrade:

```json
{"status": "ok", "version":"14.1"}
```

После upgrade:

```text
.local_migration/www_utf8/engine/data/config.php: version_id = 14.1
charset = utf-8
skin = Pisces
install.php удалён
```

Создан локальный checkpoint:

```text
.local_migration/checkpoints/14.1-utf8-php74-ok
```

Проверка PHP 7.4:

```text
/                              200 ok
/index.php                     200 ok
/6-ustanovka.html              200 ok
/news/                         200 ok
/plugins/                      200 ok
/index.php?do=feedback         200 ok
/index.php?do=lastcomments     200 ok
/admin.php                     200 ok
/rss.xml                       200 ok
/sitemap.xml                   404 ok
/engine/opensearch.php         302 ok
```

Проверка PHP 8.2:

```text
/                              200 PHP_TEXT
Fatal error: Uncaught ValueError: array_rand(): Argument #1 ($array) cannot be empty in /var/www/html/engine/modules/vote.php:80
/rss.xml                       200 ok
/engine/opensearch.php         302 ok
```

Core-файл `engine/modules/vote.php` не исправлялся вручную.

Следующий шаг:

```text
Подготовить upgrade DLE 14.1 UTF-8 -> DLE 14.2.
Перед применением проверить charset/version в официальном архиве dle14_2.zip и изменения шаблона 14.1 -> 14.2.
```

## 46. Обновление статуса: DLE 14.2 UTF-8 от 2026-06-26

Локальный UTF-8 стенд успешно обновлён с DLE 14.1 до DLE 14.2.

Использованный архив:

```text
/mnt/z/Ванина папка/1САЙТ/Движки/DLE/ЛИЦЕНЗИЯ/dle14_2.zip
```

Перед применением было проверено:

```text
install.php: version_id = 14.2
install.php: charset = utf-8
engine/inc/upgrade/14.1.php exists
```

Официальный changelog:

```text
14.1 -> 14.2: изменений в шаблонах не требуется.
```

Во время overlay 14.2 важно не переносить права/owner/group поверх runtime-директорий стенда. После того как `engine` получил права `700`, Apache/PHP не мог читать:

```text
/engine/classes/plugins.class.php
```

Это было исправлено нормализацией прав локального стенда:

```text
directories: 755
files: 644
engine/cache: writable for www-data
engine/data: writable for upgrade
```

Это не изменение core-файлов, а только runtime-права локального Docker-стенда.

Upgrade выполнен штатно через `admin.php?mod=upgrade&action=dbupgrade` под локальным migration-admin `Personage`.

Результат AJAX upgrade:

```json
{"status": "ok", "version":"14.2"}
```

После upgrade:

```text
.local_migration/www_utf8/engine/data/config.php: version_id = 14.2
charset = utf-8
skin = Pisces
install.php удалён
```

Создан локальный checkpoint:

```text
.local_migration/checkpoints/14.2-utf8-php74-ok
```

Проверка PHP 7.4:

```text
/                              200 ok
/index.php                     200 ok
/6-ustanovka.html              200 ok
/news/                         200 ok
/plugins/                      200 ok
/index.php?do=feedback         200 ok
/index.php?do=lastcomments     200 ok
/admin.php                     200 ok
/rss.xml                       200 ok
/sitemap.xml                   404 ok
/engine/opensearch.php         302 ok
```

Проверка PHP 8.2:

```text
/                              200 ok
/rss.xml                       200 ok
/engine/opensearch.php         302 ok
```

Важный рубеж: начиная с локального состояния DLE 14.2 главная страница больше не падает на PHP 8.2.

Следующий шаг:

```text
Подготовить upgrade DLE 14.2 UTF-8 -> DLE 14.3.
Перед применением проверить charset/version в официальном архиве dle14_3.zip и изменения шаблона 14.2 -> 14.3.
```

## 47. Обновление статуса: DLE 14.3 UTF-8 от 2026-06-26

Локальный UTF-8 стенд успешно обновлён с DLE 14.2 до DLE 14.3.

Использованный архив:

```text
/mnt/z/Ванина папка/1САЙТ/Движки/DLE/ЛИЦЕНЗИЯ/dle14_3.zip
```

Перед применением было проверено:

```text
install.php: version_id = 14.3
install.php: charset = utf-8
engine/inc/upgrade/14.2.php exists
```

Официальный changelog для Default template на переходе 14.2 -> 14.3 требует добавить CSS подсветки исходного кода `hljs-*` в шаблонный CSS.

Для активного шаблона `Pisces` это адаптировано в:

```text
templates/Pisces/style/engine.css
```

Patch-файл адаптации:

```text
.local_migration/patches/pisces-template-14.2-to-14.3.patch
```

Практическое правило для следующих overlay:

```text
rsync -a --no-owner --no-group --omit-dir-times --delete \
  --exclude='/templates/' \
  --exclude='/engine/data/' \
  --exclude='/engine/cache/' \
  --exclude='/uploads/' \
  --exclude='/backup/' \
  extracted/upload/ www_utf8/
```

После overlay нормализовать runtime-права локального стенда:

```text
directories: 755
files: 644
engine/cache: writable for www-data
engine/data: writable for upgrade
```

Upgrade выполнен штатно через `admin.php?mod=upgrade&action=dbupgrade` под локальным migration-admin `Personage`.

Результат AJAX upgrade:

```json
{"status": "ok", "version":"14.3"}
```

После upgrade:

```text
.local_migration/www_utf8/engine/data/config.php: version_id = 14.3
charset = utf-8
skin = Pisces
install.php удалён
```

Создан локальный checkpoint:

```text
.local_migration/checkpoints/14.3-utf8-php74-ok
```

Проверка PHP 7.4:

```text
/                              200 ok
/index.php                     200 ok
/6-ustanovka.html              200 ok
/news/                         200 ok
/plugins/                      200 ok
/index.php?do=feedback         200 ok
/index.php?do=lastcomments     200 ok
/admin.php                     200 ok
/rss.xml                       200 ok
/sitemap.xml                   404 ok
/engine/opensearch.php         302 ok
```

Проверка PHP 8.2:

```text
/                              200 ok
/rss.xml                       200 ok
/engine/opensearch.php         302 ok
```

Следующий шаг:

```text
Подготовить upgrade DLE 14.3 UTF-8 -> следующая доступная официальная версия.
В текущем архивном каталоге после dle14_3.zip виден dle16_1.zip; перед переходом обязательно проверить, нет ли пропущенных архивов DLE 15.x/16.0 в другом месте.
Если DLE 15.x/16.0 отсутствуют, нельзя считать путь "по одной версии" выполненным без отдельного решения по недостающим архивам.
```

## 48. Обновление статуса: DLE 15.0 UTF-8 от 2026-06-26

Локальный UTF-8 стенд успешно обновлён с DLE 14.3 до DLE 15.0.

Использованный архив:

```text
/mnt/z/Ванина папка/1САЙТ/Движки/DLE/ЛИЦЕНЗИЯ/dle15_0.zip
```

Перед применением было проверено:

```text
install.php: version_id = 15.0
install.php: charset = utf-8
engine/inc/upgrade/14.3.php exists
```

Официальный changelog:

```text
14.3 -> 15.0: изменений в шаблонах не требуется.
```

Важный операционный нюанс: overlay и нормализацию прав нужно выполнять последовательно, не параллельно. Иначе `rsync` может последним восстановить права каталога `engine` как `700`, и Apache/PHP получит ошибку чтения:

```text
require_once(): Failed opening required '/var/www/html/engine/classes/plugins.class.php'
```

Для 15.0 это было исправлено повторной последовательной нормализацией прав локального стенда.

Upgrade выполнен штатно через `admin.php?mod=upgrade&action=dbupgrade` под локальным migration-admin `Personage`.

Результат AJAX upgrade:

```json
{"status": "ok", "version":"15.0"}
```

После upgrade:

```text
.local_migration/www_utf8/engine/data/config.php: version_id = 15.0
charset = utf-8
skin = Pisces
install.php удалён
```

Создан локальный checkpoint:

```text
.local_migration/checkpoints/15.0-utf8-php74-ok
```

Проверка PHP 7.4:

```text
/                              200 ok
/index.php                     200 ok
/6-ustanovka.html              200 ok
/news/                         200 ok
/plugins/                      200 ok
/index.php?do=feedback         200 ok
/index.php?do=lastcomments     200 ok
/admin.php                     200 ok
/rss.xml                       200 ok
/sitemap.xml                   404 ok
/engine/opensearch.php         302 ok
```

Проверка PHP 8.2:

```text
/                              200 ok
/rss.xml                       200 ok
/engine/opensearch.php         302 ok
```

Следующий шаг:

```text
Подготовить upgrade DLE 15.0 UTF-8 -> DLE 15.1.
По changelog 15.0 -> 15.1 требуется адаптировать CSS для figure/figcaption в templates/Pisces/style/engine.css.
```

## 49. Обновление статуса: DLE 15.1 UTF-8 от 2026-06-26

Локальный UTF-8 стенд успешно обновлён с DLE 15.0 до DLE 15.1.

Использованный архив:

```text
/mnt/z/Ванина папка/1САЙТ/Движки/DLE/ЛИЦЕНЗИЯ/dle15_1.zip
```

Перед применением было проверено:

```text
install.php: version_id = 15.1
install.php: charset = utf-8
engine/inc/upgrade/15.0.php exists
```

Официальный changelog для Default template на переходе 15.0 -> 15.1 требует добавить CSS для `figure`/`figcaption`.

Для активного шаблона `Pisces` это адаптировано в:

```text
templates/Pisces/style/engine.css
```

Patch-файл адаптации:

```text
.local_migration/patches/pisces-template-15.0-to-15.1.patch
```

Upgrade выполнен штатно через `admin.php?mod=upgrade&action=dbupgrade` под локальным migration-admin `Personage`.

Результат AJAX upgrade:

```json
{"status": "ok", "version":"15.1"}
```

После upgrade:

```text
.local_migration/www_utf8/engine/data/config.php: version_id = 15.1
charset = utf-8
skin = Pisces
install.php удалён
```

Создан локальный checkpoint:

```text
.local_migration/checkpoints/15.1-utf8-php74-ok
```

Проверка PHP 7.4:

```text
/                              200 ok
/index.php                     200 ok
/6-ustanovka.html              200 ok
/news/                         200 ok
/plugins/                      200 ok
/index.php?do=feedback         200 ok
/index.php?do=lastcomments     200 ok
/admin.php                     200 ok
/rss.xml                       200 ok
/sitemap.xml                   404 ok
/engine/opensearch.php         302 ok
```

Проверка PHP 8.2:

```text
/                              200 ok
/rss.xml                       200 ok
/engine/opensearch.php         302 ok
```

Следующий шаг:

```text
Подготовить upgrade DLE 15.1 UTF-8 -> DLE 15.2.
По changelog 15.1 -> 15.2 изменений в шаблонах не требуется.
```

## 50. Обновление статуса: DLE 15.2 UTF-8 от 2026-06-26

Локальный UTF-8 стенд успешно обновлён с DLE 15.1 до DLE 15.2.

Использованный архив:

```text
/mnt/z/Ванина папка/1САЙТ/Движки/DLE/ЛИЦЕНЗИЯ/dle15_2.zip
```

Перед применением было проверено:

```text
install.php: version_id = 15.2
install.php: charset = utf-8
engine/inc/upgrade/15.1.php exists
```

Официальный changelog:

```text
15.1 -> 15.2: изменений в шаблонах не требуется.
```

Upgrade выполнен штатно через `admin.php?mod=upgrade&action=dbupgrade` под локальным migration-admin `Personage`.

Результат AJAX upgrade:

```json
{"status": "ok", "version":"15.2"}
```

После upgrade:

```text
.local_migration/www_utf8/engine/data/config.php: version_id = 15.2
charset = utf-8
skin = Pisces
install.php удалён
```

Создан локальный checkpoint:

```text
.local_migration/checkpoints/15.2-utf8-php74-ok
```

Проверка PHP 7.4:

```text
/                              200 ok
/index.php                     200 ok
/6-ustanovka.html              200 ok
/news/                         200 ok
/plugins/                      200 ok
/index.php?do=feedback         200 ok
/index.php?do=lastcomments     200 ok
/admin.php                     200 ok
/rss.xml                       200 ok
/sitemap.xml                   404 ok
/engine/opensearch.php         302 ok
```

Проверка PHP 8.2:

```text
/                              200 ok
/rss.xml                       200 ok
/engine/opensearch.php         302 ok
```

Следующий шаг:

```text
Подготовить upgrade DLE 15.2 UTF-8 -> DLE 15.3.
По changelog 15.2 -> 15.3 требуется адаптировать шаблонные изменения под Pisces.
```

## 51. Операционные заметки, которые нельзя терять

### 40.1. Соответствие файлов шаблона Pisces и Default changelog

Официальная страница `templates-changelog` описывает изменения для стандартного шаблона DLE `Default`. Имена файлов и расположение CSS нужно сопоставлять с активным шаблоном сайта.

Для активного шаблона `Pisces`:

```text
Default changelog: css/styles.css
Pisces equivalent: templates/Pisces/style/styles.css
```

Причина: `templates/Pisces/main.tpl` подключает:

```html
<link href="{THEME}/style/styles.css" type="text/css" rel="stylesheet" />
<link href="{THEME}/style/engine.css" type="text/css" rel="stylesheet" />
```

Поэтому CSS-изменение из changelog 11.2 -> 11.3:

```css
.instagram-media, .twitter-tweet { display: inline-block !important; }
```

было добавлено именно в:

```text
.local_migration/www_utf8/templates/Pisces/style/styles.css
```

а не в несуществующий для Pisces путь `css/styles.css`.

### 40.2. Personage, Drage и временные пароли

Текущее правило миграции:

```text
Drage не использовать для технических входов в upgrade/admin.
Drage должен сохранять исходный 32-символьный MD5-хеш из бэкапа.
Personage использовать как локальный migration-admin.
```

Текущее состояние локальной Docker-БД после upgrade до DLE 12.1:

```text
Drage:    user_group = 1, password length = 32, prefix = b486
Personage: user_group = 1, password length = 60, prefix = $2y$
```

Важный нюанс upgrade-мастера: когда у пользователя старый MD5-хеш, DLE проверяет пароль по старой схеме:

```text
stored password = md5(md5(plain_password))
```

Во время перехода 11.3/12.0/12.1 для локального входа в upgrade-мастер использовался временный migration-only пароль `Personage`, заданный только в локальной Docker-БД. После обычного входа в `admin.php` DLE снова перевёл `Personage` на bcrypt-хеш `$2y$`.

Не сохранять реальные или временные пароли в Git/README. Значение временного пароля во время текущей сессии лежало только вне репозитория:

```text
C:\Users\Ivan\AppData\Local\Temp\personage_migration_password.txt
```

Этот файл не является источником истины и может отсутствовать после очистки temp. Если пароль потерян, безопасная процедура для локального стенда:

```text
1. Сгенерировать новый временный migration-only пароль.
2. В локальной Docker-БД установить Personage password = md5(md5(new_plain_password)).
3. Войти в /upgrade/index.php или /admin.php под Personage.
4. После обычного входа в admin.php проверить, что DLE снова перевёл Personage на bcrypt $2y$.
5. Не менять Drage.
```

Реальный пароль `Personage` от исходного сайта в README не известен и не должен требоваться для локальной миграции: локальный стенд использует управляемый migration-only доступ.
