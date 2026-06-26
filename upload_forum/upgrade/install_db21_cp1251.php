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

$install_db[] = "DELETE FROM ".LB_DB_PREFIX."_configuration WHERE conf_key = 'posts_bbhide'";
$install_db[] = "ALTER TABLE ".LB_DB_PREFIX."_forums_notice ADD show_sub tinyint(1) NOT NULL default '0'";
$install_db[] = "ALTER TABLE ".LB_DB_PREFIX."_forums ADD allow_bbcode_list varchar(100) NOT NULL default '' AFTER `allow_bbcode`";
$install_db[] = "ALTER TABLE ".LB_DB_PREFIX."_forums ADD ficon varchar(255) NOT NULL default '' AFTER `id`";
$install_db[] = "ALTER TABLE ".LB_DB_PREFIX."_topics DROP postfixed";
$install_db[] = "ALTER TABLE ".LB_DB_PREFIX."_topics ADD post_fixed smallint(5) NOT NULL default '0' AFTER `post_hiden`";
$install_db[] = "ALTER TABLE ".LB_DB_PREFIX."_posts ADD utility smallint(5) NOT NULL default '0'";
$install_db[] = "ALTER TABLE ".LB_DB_PREFIX."_members_online ADD mo_loc_fid smallint(5) NOT NULL default '0'";
$install_db[] = "ALTER TABLE ".LB_DB_PREFIX."_members_ranks ADD mid mediumint(8) NOT NULL default '0'";

$install_db[] = "DROP TABLE IF EXISTS ".LB_DB_PREFIX."_posts_utility";
$install_db[] = "CREATE TABLE ".LB_DB_PREFIX."_posts_utility (
  `id` smallint(5) NOT NULL auto_increment,
  `pid` int(10) NOT NULL default '0',
  `mid` mediumint(8) NOT NULL default '0',
  `ip` varchar(16) default NULL,
  PRIMARY KEY  (`id`),
  KEY `pid` (`pid`),
  KEY `mid` (`mid`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=".$coding_forum;

$install_db[] = "DROP TABLE IF EXISTS ".LB_DB_PREFIX."_complaint";
$install_db[] = "CREATE TABLE ".LB_DB_PREFIX."_complaint (
  `id` int(10) NOT NULL auto_increment,
  `module` varchar(40) default NULL,
  `cid` int(10) NOT NULL default '0',
  `mid` mediumint(8) NOT NULL default '0',
  `ip` varchar(16) default NULL,
  `date` int(10) NOT NULL default '0',
  `info` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `module` (`module`),
  KEY `cid` (`cid`),
  KEY `mid` (`mid`),
  KEY `date` (`date`),
  KEY `ip` (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=".$coding_forum;

$install_db[] = "INSERT INTO `".LB_DB_PREFIX."_configuration_group` (`conf_gr_name`, `conf_gr_prefix`, `conf_gr_desc`, `conf_gr_group`, `conf_gr_group_title`) VALUES
('Система жалоб', 'complaint_', 'Настройки функции системы жалоб', 'general', 'Основные')";

$install_db[] = "INSERT INTO `".LB_DB_PREFIX."_history_update` (`vid`, `date`) VALUES ('2.1', '".$time."')";
$install_db[] = "UPDATE `".LB_DB_PREFIX."_configuration_group` SET conf_gr_name = 'Основные настройки' WHERE conf_gr_prefix = 'general_'";


foreach($install_db as $table)
{
    $DB->not_filtred($table);
}

$DB->free();

$DB->update("conf_desc = 'Включение счётчика не много увеличивает нагрузку на сервер - 1 дополнительный запрос к БД.<br /><b>Псевдо скачивание</b> - счётчик обновляется сразу как только пользователь начал скачивать файл, даже если файл не был скачан целиком.<br /><b>Реальное скачивание</b> - счётчик обновляется только после скачивания всего файла. Если же файл не был скачан целиком - счётчик не обновляется.', conf_type = '1', conf_option = '0=Нет\r\n1=Да, псевдо скачивание\r\n2=Да, реальное скачивание'", "configuration", "conf_key='upload_count'");

$complaint = $DB->one_select( "conf_gr_id", "configuration_group", "conf_gr_prefix = 'complaint_'" );
$general = $DB->one_select( "conf_gr_id", "configuration_group", "conf_gr_prefix = 'general_'" );
$posts = $DB->one_select( "conf_gr_id", "configuration_group", "conf_gr_prefix = 'posts_'" );

if (!isset($_REQUEST['ver']))
{
    $DB->not_filtred( "INSERT INTO `".LB_DB_PREFIX."_configuration` (`conf_posi`, `conf_name`, `conf_desc`, `conf_group`, `conf_type`, `conf_key`, `conf_option`, `conf_value`, `conf_protect`) VALUES
    (16, 'Кодировка форума', 'Выберите кодировку форума.<br /><b>Внимание!</b> Если Вы изменили кодировку, то не забудьте внести изменения в файл <b>/components/config/board_db.php</b>,  <b>/components/scripts/ajax/savetext.php</b> и очистить кеш.<br />Подробная инструкция на официальном сайте.', ".$general['conf_gr_id'].", '1', 'general_coding', 'windows-1251=windows-1251\r\nutf-8=UTF-8', 'windows-1251', 1)");    
}

$DB->not_filtred( "INSERT INTO `".LB_DB_PREFIX."_configuration` (`conf_posi`, `conf_name`, `conf_desc`, `conf_group`, `conf_type`, `conf_key`, `conf_option`, `conf_value`, `conf_protect`) VALUES
(17, 'Включить ЧПУ', 'Веб-адреса, удобные для восприятия человеком.<br />Пример: http://site.ru/forum/category/topic-1.html', ".$general['conf_gr_id'].", '0', 'general_rewrite_url', '', '1', 1),
(11, 'Разершить гостям голосовать за полезность сообщения', 'У каждого сообщения есть счётчик полезности, на основе этого счётчика можно определить какие сообщения являются полезными, а какие безполезными или флудом.', ".$posts['conf_gr_id'].", '0', 'posts_utility', '', '0', 1),
(1, 'Уведомлять администрацию', 'Уведомлять администраторов по ЛС о новой жалобе?<br />Модераторы форума, в котором была жалоба, автоматически будут уведомлены по ЛС о ней.<br />Если у форума нет модераторов - будут уведомлены супер-модераторы, если их тоже нет - будет уведомлена администрация.', ".$complaint['conf_gr_id'].", '0', 'complaint_admins', '', '0', 1),
(2, 'Уведомлять супер-модераторов', 'Уведомлять супер-модераторов по ЛС о новой жалобе?<br />Модераторы форума, в котором была жалоба, автоматически будут уведомлены по ЛС о ней.<br />Если у форума нет модераторов - будут уведомлены супер-модераторы, если их тоже нет - будет уведомлена администрация.', ".$complaint['conf_gr_id'].", '0', 'complaint_moders', '', '0', 1)");

$DB->free();

sleep(2);

$begin = 0;
                        
while (true)
{        
    $empty = true;
    $t_rows = $DB->select( "id", "topics", "", "ORDER BY id ASC LIMIT ".$begin.", 20");
    while ( $row = $DB->get_row($t_rows ) )
    {         
        $empty = false;
        $posts = $DB->one_select( "COUNT(*) as count", "posts", "fixed = '1' AND topic_id = '{$row['id']}'");  
        $DB->free($posts);           
                
        $DB->update("post_fixed = '{$posts['count']}'", "topics", "id = '{$row['id']}'");
    }
    $DB->free($t_rows );
            
    if ($empty) break;
                
    $begin += 20;            
    sleep(2);
}

?>