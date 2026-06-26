<?php
error_reporting(E_ALL ^ E_NOTICE) ;
@ini_set('display_errors', true) ;
@ini_set('html_errors', false) ;
@ini_set('error_reporting', E_ALL ^ E_NOTICE) ;
define('DATALIFEENGINE', true) ;
define('ROOT_DIR', dirname(__file__)) ;
define('ENGINE_DIR', ROOT_DIR . '/engine') ;
include ENGINE_DIR . '/data/config.php' ;
include ENGINE_DIR . '/bullet_energy/data/forum_config.php' ;
require_once ENGINE_DIR . '/bullet_energy/library/language/' . $config['charset'] . '/' . $config['langs'] . '/install.lng' ;
if(!$bullet_energy_config['version']) {
  die($bullet_energy_lang_install['lng_36']) ;
}
require_once ENGINE_DIR . '/modules/functions.php' ;
require_once ENGINE_DIR . '/classes/mysql.php' ;
require_once ENGINE_DIR . '/data/dbconfig.php' ;
require_once ENGINE_DIR . '/modules/sitelogin.php' ;
if($member_id['user_group'] != 1) {
  die($bullet_energy_lang_install['lng_28']) ;
}
require_once ENGINE_DIR . '/bullet_energy/library/install/install_function.php' ;
$option = array() ;
$htaccess = '' ;
$tableSchema = array() ;
$lastVersion = "1.3" ;
if($bullet_energy_config['version'] == $lastVersion) {
  die($bullet_energy_lang_install['lng_41']) ;
}
if($bullet_energy_config['version'] == '1.1' or $bullet_energy_config['version'] == '1') {
  installAdminCP(array('version' => '1.2')) ;
  $bullet_energy_config['version'] = '1.2' ;
  $bullet_energy_config['cpu'] = '1' ;
  $bullet_energy_config['is_cpu_type'] = '1' ;
  $bullet_energy_config['handler_cpu'] = '0' ;
  $bullet_energy_config['slash'] = '0' ;
  require_once ENGINE_DIR . '/bullet_energy/library/install/query/1_2.php' ;
} elseif($bullet_energy_config['version'] == '1.2') {
  installAdminCP(array('version' => '1.3')) ;
  $bullet_energy_config['robot_name'] = 'site_robot' ;
  $bullet_energy_config['version'] = '1.3' ;
  $bullet_energy_config['size_w'] = '110' ;
  $bullet_energy_config['size_h'] = '25' ;
  $bullet_energy_config['text_upload'] = '' . $bullet_energy_lang_install['lng_16'] . '' ;
  $bullet_energy_config['fire_topic_day'] = '3' ;
  $bullet_energy_config['move_pm'] = '1' ;
  $bullet_energy_config['txt_post_edit'] = '3' ;
  $bullet_energy_config['txt_post_time'] = '5' ;
  $bullet_energy_config['legend_group'] = '1' ;
  $bullet_energy_config['complaint_time'] = '3' ;
  require_once ENGINE_DIR . '/bullet_energy/library/install/query/1_3.php' ;
}
$option['message'] = '' ;
if($roocke) {
  foreach ($roocke as $value) {
    $option['message'] .= $value['paste'] ;
  }
}
if(empty($tableSchema)) {
  die($bullet_energy_lang_install['lng_41']) ;
} else {
  foreach ($tableSchema as $table) {
    $db->query($table) ;
  }
  $handler = fopen(ENGINE_DIR . '/bullet_energy/data/forum_config.php', "w") or die($bullet_energy_lang_install['lng_38']) ;
  fwrite($handler, "<?PHP \n\n//System Configurations\n\n\$bullet_energy_config = array (\n\n") ;
  foreach ($bullet_energy_config as $name => $value) {
    fwrite($handler, "'{$name}' => \"{$value}\",\n\n") ;
  }
  fwrite($handler, ");\n\n?>") ;
  fclose($handler) ;
}
$option['title'] = $bullet_energy_lang_install['lng_39'] ;
@header("Content-type: text/html; charset=" . $config['charset']) ;
echo <<< HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={$config['charset']}" />
<title>{$bullet_energy_lang_install['lng_40']}</title>
<style type="text/css">
/*
 * YUI reset-fonts.css
 *
Copyright (c) 2009, Yahoo! Inc. All rights reserved.
Code licensed under the BSD License:
http://developer.yahoo.net/yui/license.txt
version: 2.7.0
*/
html {
	color:#000;
	background:#FFF;
}
body, div, dl, dt, dd, ul, ol, li, h1, h2, h3, h4, h5, h6, pre, code, form, fieldset, legend, input, button, textarea, p, blockquote, th, td {
	margin:0;
	padding:0;
}
table {
	border-collapse:collapse;
	border-spacing:0;
}
fieldset, img {
	border:0;
}
address, caption, cite, code, dfn, em, strong, th, var, optgroup {
	font-style:inherit;
	font-weight:inherit;
}
del, ins {
	text-decoration:none;
}
textarea {
    border: 1px solid #999999;
    padding: 2px;
    resize: none;
    width: 672px;
}
li {
	list-style:square outside none;margin-left:20px;
}
caption, th {
	text-align:left;
}
h1, h2, h3, h4, h5, h6 {
	font-size:100%;
	font-weight:normal;
}
q:before, q:after {
	content:'';
}
abbr, acronym {
	border:0;
	font-variant:normal;
}
sup {
	vertical-align:baseline;
}
sub {
	vertical-align:baseline;
}
legend {
	color:#000;
}
input, button, textarea, select, optgroup, option {
	font-family:inherit;
	font-size:inherit;
	font-style:inherit;
	font-weight:inherit;
}
input, button, textarea, select {
*font-size:100%;
}
body {
	font:11px/1.231 arial, helvetica, clean, sans-serif;
*font-size:small;
*font:x-small;
}
select, input, button, textarea, button {
	font:99% arial, helvetica, clean, sans-serif;
}
table {
	font-size:inherit;
	font:100%;
}
pre, code, kbd, samp, tt {
	font-family:monospace;
*font-size:108%;
	line-height:100%
}
body {
	font-family:'Trebuchet MS', Helvetica, Arial, sans-serif
}
html {
	color:#000;
	background:#D5D8DB
}
strong {
	font-weight:bold
}
.mainBox .mainBoxInnert {
	margin:100px auto 0;
	width:700px
}
.mainBoxInnert {
	padding:10px;
	border:1px solid white;
	border-color: rgba(255, 255, 255, 0.75);
	background: rgba(255, 255, 255, 0.2);
	-moz-border-radius:0.8em;
	-webkit-border-radius: 0.8em;
	-webkit-background-clip:padding-box;
	border-radius:10px;
	-webkit-border-radius:10px;
	-moz-border-radius:10px;
	-khtml-border-radius:10px;
	-moz-box-shadow:0 0 4px rgba(50, 50, 50, 0.5);
	-webkit-box-shadow: 0 0 4px rgba(50, 50, 50, 0.5);
	box-shadow:0 0 4px rgba(50, 50, 50, 0.5)
}
.mainBoxInnert form {
	border:1px solid #999999;
	border-radius:4px;
	-webkit-border-radius:4px;
	-moz-border-radius:4px;
	-khtml-border-radius:4px;
	-webkit-background-clip: padding-box;
	border-radius: 0.25em;
	padding:10px;
	background: white;
	-moz-box-shadow: 0 0 0.8em rgba(255, 255, 255, 0.5);
	-webkit-box-shadow: 0 0 0.8em rgba(255, 255, 255, 0.5);
	box-shadow: 0 0 0.8em rgba(255, 255, 255, 0.5);
	position:relative;
	min-height:350px
}
div.contentBox dl{ }
.mainBoxInnert form h1 {
	color:white;
	font-size:14px;
	font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Sans", Arial, Helvetica, sans-serif;
	border:1px solid;
	border-color:#50a3c8 #297cb4 #083f6f;
	background:#0c5fa5 url(title-bg.png) repeat-x top;
	-webkit-background-size:100% 100%;
	-moz-background-size:100% 100%;
	-o-background-size:100% 100%;
	background-size:100% 100%;
	background:-moz-linear-gradient(top, white, #72c6e4 4%, #0c5fa5);
	background:-webkit-gradient(linear, left top, left bottom, from(white), to(#0c5fa5), color-stop(0.03, #72c6e4));
	-moz-text-shadow: -1px -1px 0 rgba(0, 0, 0, 0.2);
	-webkit-text-shadow:-1px -1px 0 rgba(0, 0, 0, 0.2);
	text-shadow: -1px -1px 0 rgba(0, 0, 0, 0.2);
	padding:4px 6px;
	position:absolute;
	left:10px;
	top:-5px;
	z-index:100;
	-moz-box-shadow:0 1px 3px rgba(0, 0, 0, 0.5);
	-webkit-box-shadow:0 1px 3px rgba(0, 0, 0, 0.5);
	box-shadow:0 1px 3px rgba(0, 0, 0, 0.5);
	-webkit-background-clip: padding-box;
	border-radius:4px;
	-webkit-border-radius:4px;
	-moz-border-radius:4px;
	-khtml-border-radius:4px
}
div.contentBox {
	margin-top:15px
}
div.license {
	padding:10px 0;
	font-size:11px;
	height:350px;
	overflow:auto
}
div.license dl dd{border-bottom: 1px solid #D9D9D9;margin-bottom:3px;padding-bottom:3px}
div.license dl dt{display:none}
div.license dl dd strong.green{color:green;float:right;padding-right:5px}
div.license dl dd strong.red{color:red;float: right;padding-right:5px}
div.textProcess {
	border-bottom:1px solid #999999;
	padding-bottom:10px
}
div.submitBox {
	background-color:#E4E4DC;
	margin-bottom:10px;
	padding:5px;
	border-top:1px solid #999999;
	text-align:right
}
.mt5 {
	margin-top:5px
}
input[type="radio"], input[type="checkbox"] {
	vertical-align:-10%
}
input[type="submit"], input[type="button"]{
	font-size:12px;
	text-decoration:none;
	cursor:pointer;
	display:inline-block;
	position: relative;
	padding:2px;
	color:#4c4c4c;
	-webkit-border-radius:4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	text-shadow: 0 1px 0 rgba(255, 255, 255, 0.3);
	background: #f6f6f6;
	background: -webkit-gradient(linear, left top, left bottom, from(#f6f6f6), to(#d4d4d4));
	background: -webkit-linear-gradient(#f6f6f6, #d4d4d4);
	background-image: -moz-linear-gradient(top, #f6f6f6, #d4d4d4);
	background-image: -moz-gradient(top, #f6f6f6, #d4d4d4);
	border: 1px solid #a1a1a1
}
input[type="submit"]:hover, input[type="button"]:hover{
	background: #f6f6f6;
	background: -webkit-gradient(linear, left top, left bottom, from(#f6f6f6), to(#ececec));
	background: -webkit-linear-gradient(#f6f6f6, #ececec);
	background-image: -moz-linear-gradient(top, #f6f6f6, #ececec);
background-image: -moz-gradient(top, #f6f6f6, #ececec)text-decoration:none!important
}
input[type="submit"]:active, input[type="button"]:active {
	top: 1px;
	background: #ececec;
	background: -webkit-gradient(linear, left top, left bottom, from(#ececec), to(#f6f6f6));
	background: -webkit-linear-gradient(#ececec, #f6f6f6);
	background-image: -moz-linear-gradient(top, #ececec, #f6f6f6);
	background-image: -moz-gradient(top, #ececec, #f6f6f6);
	-webkit-box-shadow: inset 0 0 3px 0 rgba(0, 0, 0, 0.4), 0 1px 0 0 #ffffff;
	-moz-box-shadow: inset 0 0 3px 0 rgba(0, 0, 0, 0.4), 0 1px 0 0 #ffffff;
	box-shadow: inset 0 0 3px 0 rgba(0, 0, 0, 0.4), 0 1px 0 0 #ffffff
}
label {
	-moz-user-select:none;
	-khtml-user-select:none;
	user-select:none;
	padding-left:5px
}
</style>
</head>
<body>
<div class="mainBox">
  <div class="mainBoxInnert">
    <form action="" method="post" id="install_form" name="install_form">
      <h1>{$bullet_energy_lang_install['lng_40']}</h1>
      <div class="contentBox">
        <div class="textProcess">{$option['title']}</div>
         {$option['message']}
        <div class="submitBox">
          {$option['click']}
        </div>
      </div> 
    </form>
  </div>
</div>
</body>
</html>
HTML;

?>