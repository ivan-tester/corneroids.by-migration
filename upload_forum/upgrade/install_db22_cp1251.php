<?php

/****************************************/
// ИНФОРМАЦИЯ:
// ==== Форум: LogicBoard
// ==== Автор: Никита Курдин (ShapeShifter)
// ==== Copyright © Никита Курдин Игоревич 2011-2012
// ==== Данный код защищен авторскими правами
// ==== Официальный сайт: http://logicboard.ru

/****************************************/

if (! defined('LogicBoard_Install') )
{
	@include '../../logs/save_log.php';
	exit ( "Error, wrong way to file.<br><a href=\"/\">Go to main</a>." );
}

$time = time();

$install_db = array();

$install_db[] = "ALTER TABLE ".DLE_USER_PREFIX."_users ADD `ulogin_key` varchar(255) NOT NULL default '' AFTER `name`";
$install_db[] = "ALTER TABLE `".LB_DB_PREFIX."_staticpage` ADD `html_br` tinyint(1) NOT NULL default '1'";
$install_db[] = "ALTER TABLE `".LB_DB_PREFIX."_groups` ADD `g_tc_time` smallint(5) unsigned NOT NULL default '0'";
$install_db[] = "ALTER TABLE `".LB_DB_PREFIX."_groups` ADD `g_pc_time` smallint(5) unsigned NOT NULL default '0'";
$install_db[] = "ALTER TABLE `".LB_DB_PREFIX."_groups` ADD `g_show_ip` tinyint(1) NOT NULL default '0'";
$install_db[] = "ALTER TABLE `".LB_DB_PREFIX."_groups` ADD `g_html_allowed` tinyint(1) NOT NULL default '0'";
$install_db[] = "ALTER TABLE `".LB_DB_PREFIX."_groups` ADD `g_metatopic` tinyint(1) NOT NULL default '0'";
$install_db[] = "DROP TABLE IF EXISTS `".LB_DB_PREFIX."_logs_mysql`";
$install_db[] = "ALTER TABLE `".LB_DB_PREFIX."_forums` ADD `flink` varchar(255) NOT NULL default ''";
$install_db[] = "ALTER TABLE `".LB_DB_PREFIX."_forums` ADD `flink_npage` tinyint(1) NOT NULL default '0'";
$install_db[] = "UPDATE `".LB_DB_PREFIX."_configuration_group` SET conf_gr_name = 'Списки: онлайн, пользователи, статусы', conf_gr_desc = 'Настройки вывода списков: онлайн пользователи, все пользователи и статусы пользователей.' WHERE conf_gr_id = '7'";
$install_db[] = "UPDATE `".LB_DB_PREFIX."_configuration` SET conf_desc = 'Выберите кодировку форума.<br /><b>Внимание!</b> <a href=\"http://logicboard.ru/support/cat-faq/topic-196.html\" target=\"_blank\">Подробная инструкция</a> на официальном сайте.' WHERE conf_key = 'general_coding'";
$install_db[] = "ALTER TABLE `".LB_DB_PREFIX."_topics` ADD `metatitle` varchar(255) NOT NULL default ''";
$install_db[] = "ALTER TABLE `".LB_DB_PREFIX."_topics` ADD `metadescr` varchar(200) NOT NULL default ''";
$install_db[] = "ALTER TABLE `".LB_DB_PREFIX."_topics` ADD `metakeys` text NOT NULL";
$install_db[] = "ALTER TABLE `".LB_DB_PREFIX."_topics_files` ADD `file_name_mini` varchar(255) NOT NULL default '' AFTER `file_name`";
$install_db[] = "DELETE FROM `".LB_DB_PREFIX."_configuration` WHERE conf_id = '133'";
$install_db[] = "INSERT INTO `".LB_DB_PREFIX."_history_update` (`vid`, `date`) VALUES ('2.2', '".$time."')";
$install_db[] = "ALTER TABLE `".LB_DB_PREFIX."_topics_sharelink` ADD `send_url` tinyint(1) NOT NULL default '0'";
$install_db[] = "UPDATE `".LB_DB_PREFIX."_topics_sharelink` SET `send_url` = '1' WHERE id = '3'";

$install_db[] = "DROP TABLE IF EXISTS ".LB_DB_PREFIX."_discuss";
$install_db[] = "CREATE TABLE ".LB_DB_PREFIX."_discuss (
  `id` int(11) NOT NULL auto_increment,
  `nid` int(10) NOT NULL default '0',
  `tid` int(10) NOT NULL default '0',
  `date` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `nid` (`nid`),
  KEY `tid` (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=".$coding_forum;

foreach($install_db as $table)
{
    $DB->not_filtred($table);
}

$DB->free();

$DB->not_filtred( "UPDATE `".LB_DB_PREFIX."_groups` SET g_tc_time = '0', g_pc_time = '0', g_show_ip = '1', g_html_allowed = '0', g_metatopic = '1'  WHERE g_id < '3'");
$DB->not_filtred( "UPDATE `".LB_DB_PREFIX."_groups` SET g_tc_time = '0', g_pc_time = '0', g_show_ip = '0', g_html_allowed = '0', g_metatopic = '0'  WHERE g_id > '2'");

$DB->not_filtred( "INSERT INTO `".LB_DB_PREFIX."_configuration` (`conf_posi`, `conf_name`, `conf_desc`, `conf_group`, `conf_type`, `conf_key`, `conf_option`, `conf_value`, `conf_protect`) VALUES
(3, 'Максимальный размер картинки', 'Введите максимальный размер картинки для загрузки в килобайтах.<br />Для снятия ограничения введите 0.', 19, '3', 'upload_maxsize_pic', '', '1024', 1),
(5, 'Изменять размер картинки с помощью PHP', 'Все картинки будут уменьшаться пропорционально с помощью php.<br />Возможно увеличение времени обработки сообщений.', 8, '0', 'pic_smallphp', '', '1', 1),
(5, 'Кол-во онлайн пользователей в блоке статистики', 'Введите количество онлайн пользователей, которые будут выводиться в блоке статистики.<br />Введите 0, чтобы убрать лимит.', 7, '3', 'online_limitblock', '', '100', 1),
(4, 'Количество статусов на одной странице', 'Количество статусов пользователей, которые будут выводиться на одной странице.', 7, '3', 'status_page', '', '17', 1),
(16, 'Объединить счётчик ответов и новых тем', 'Если нет - каждая новая тема не будет прибавлять +1 к счётчику сообщений/ответов.', 21, '0', 'forums_unitetp', '', '0', 1),
(10, 'Выводить все форумы, где распологается тема', 'Опция относится к списку последних тем, активных тем, всех тем пользователя, избарнных тем и тем, на которые подписался пользователь, также список последних сообщений, всех сообщений пользователей.<br /><br />Будет выводится не только форум, в котором находится тема или сообщение, но все родительские форумы.', 9, '0', 'topic_allforums', '', '1', 1),
(7, 'Разрешить авторизацию с помощью uLogin', 'Разрешить пользователям авторизовываться и регистрироваться через сервис uLogin?<br />Если данная опция будет отключена - не забудьте убрать код от uLogin из файла шаблона login.tpl', 5, '0', 'regist_ulogin', '', '1', 1)");

$DB->free();

?>