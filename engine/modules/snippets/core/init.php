<?php
if(!defined('DATALIFEENGINE'))  die("Hacking attempt!");

global $config;			#массив с конфигурационными данными
global $category_id;	#id активной категории или id категории которой принадлежит активная новость через ajax всегда неопределена 
global $member_id;		#массив с полной информацией о пользователе если гость то определено только $member_id['user_group']=5
global $_IP;			#ip адрес пользователя
global $is_logged;		#= 1 если пользователь прошел авторизацию иначе = 0
global $PHP_SELF;		#домен сайта на конце с index.php
global $_TIME;			#время сайта (сервера) с учетом часового пояса
global $news_page;		#???
global $news_name;		#псевдоним активной новости через ajax всегда неопределена
global $newsid;			#id активной новости через ajax всегда = 0
global $cstart;			#= 1 когда мы находимся на главной странице сайта в остальных случаях = 0 при запросе через ajax всегда = 0
global $category;		#псевдоним активной категории через ajax всегда неопределена
global $user_group;		#массив содержащий информацию обовсех группах пользователей
global $fulllink;		#
global $full_link;		#
global $cat_info;		#массив содержащий информацию обовсех новостных категориях
global $allowed_sort;	#массив задающий порядок сортировки новостей
global $db;				#класс реализующий работу с БД
global $tpl;			#класс реализующий работу с шаблонами DLE
global $static_result;	#массив с полной информацией об активной статической странице через ajax всегда неопределена
global $metatags;		#???
global $nam_e;			#???
global $category_skin;	#???
global $allow_sql_skin;	#???
global $year;			#???
global $month;			#???
global $day;			#???
global $user;			#???
global $catalog;		#???
global $do;				#???
global $view;
global $cache;
global $AJAX;
global $prefix;
global $dle_api;

$AJAX = 0;
if(!$config){require_once "ajax.php";unset($dle_login_hash,$dle_user_id,$dle_password,$salt,$hash);}
if(!$config) die("Error!");
$prefix = PREFIX;

require_once "class.php";
if(!$view)	$view = new View(ROOT_DIR."/templates/{$config['skin']}/");
if(!$cache)	$cache = new Cache(ENGINE_DIR."/cache");
?>