<?php
/*
=====================================================
 DLE Hash Domain 1.5
=====================================================
 Файл: keygen.php
=====================================================
*/
if (!defined('DATALIFEENGINE')) {
    die("Hacking attempt!");
}
$utm = "10.5";

$domain_name = $_POST['domain'];
$domain_name = stripslashes($domain_name);
$domain_name = htmlspecialchars($domain_name);
$domain_name = trim($domain_name);
$version_view = array('dle105' => '1295', 'dle104' => '1564', 'dle103' => '1130', 'dle102' => '1002', 'dle101' => '9519', 'dle100' => '7784', 'dle098' => '8034', 'dle097' => '1347', 'dle096' => '9096', 'dle095' => '9521', 'dle094' => '6524', 'dle093' => '2470', 'dle092' => '5323', 'dle090' => '8580', 'dle085' => '8500', 'dle083' => '1083', 'dle082' => '1072', 'dle080' => '8021', 'dle075' => '7103', 'dle073' => '3412', 'dle072' => '5971', 'dle070' => '5971',);
$hash_version_view = array('1130' => '10.3', '1002' => '10.2', '9519' => '10.1', '7784' => '10.0', '8034' => '9.8', '1347' => '9.7', '9096' => '9.6', '9521' => '9.5', '6524' => '9.4', '2470' => '9.3', '5323' => '9.2', '8580' => '9.0', '8500' => '8.5', '1083' => '8.3', '1072' => '8.2', '8021' => '8.0', '7103' => '7.5', '3412' => '7.3', '5971' => '7.2', '5971' => '7.0',);

function _connect($host, $port) {
    if (fsockopen($host, $port)) {
        return true;
    } else {
        return false;
    }
}
function get_domen_hash($query) {
    $domen_md5 = explode('.', $query);
    $count_key = count($domen_md5) - 1;
    unset($domen_md5[$count_key]);
    if (end($domen_md5) == "com" or end($domen_md5) == "net") $count_key--;
    $domen_md5 = $domen_md5[$count_key - 1];
    $domen_md5 = md5(md5($domen_md5 . "780918"));
    return $domen_md5;
}
preg_match_all('~Актуальная версия скрипта: <font color="red">(.*?)</font><br />~is', $stab_version);

$tpl->load_template('keygen.tpl');
$tpl->set('{THEME}', $config['http_home_url'] . 'templates/' . $config['skin']);
$tpl->set('{domain_example}', $_SERVER['HTTP_HOST']);
$tpl->set('{domain}', $domain_name);

if ($config['allow_recaptcha']) {
    if ($_POST['recaptcha_response_field'] AND $_POST['recaptcha_challenge_field']) {
        require_once ENGINE_DIR . '/classes/recaptcha.php';
        $resp = recaptcha_check_answer($config['recaptcha_private_key'], $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);
        if ($resp->is_valid) {
            $_POST['sec_code'] = 1;
            $_SESSION['sec_code_session'] = 1;
        } else $_SESSION['sec_code_session'] = false;
    } else $_SESSION['sec_code_session'] = false;
}
if ($_POST['sec_code'] != $_SESSION['sec_code_session'] OR !$_SESSION['sec_code_session']) {
    $stop.= 1;
}
$_SESSION['sec_code_session'] = false;
if ($_POST['keygen']) {
    if ($stop) {
        $tpl->set_block("'\[else-hash\](.*?)\[/else-hash\]'si", "");
        $tpl->set('[if-hash]', "");
        $tpl->set('[/if-hash]', "");
        msgbox($lang['all_err_1'], $lang_keygen['err_01']);
    } else if (!$domain_name) {
        $tpl->set_block("'\[else-hash\](.*?)\[/else-hash\]'si", "");
        $tpl->set('[if-hash]', "");
        $tpl->set('[/if-hash]', "");
        msgbox($lang['all_err_1'], $lang_keygen['err_02']);
    } else if (preg_match('/^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}$/i', $domain_name) != 1) {
        $tpl->set_block("'\[else-hash\](.*?)\[/else-hash\]'si", "");
        $tpl->set('[if-hash]', "");
        $tpl->set('[/if-hash]', "");
        msgbox($lang['all_err_1'], $lang_keygen['err_03']);
    } else if ($_POST['hash_version'] == "dle000") {
        $tpl->set_block("'\[else-hash\](.*?)\[/else-hash\]'si", "");
        $tpl->set('[if-hash]', "");
        $tpl->set('[/if-hash]', "");
        msgbox($lang['all_err_1'], $lang_keygen['err_04']);
    } else {
        $tpl->set_block("'\[if-hash\](.*?)\[/if-hash\]'si", "");
        $tpl->set('[else-hash]', "");
        $tpl->set('[/else-hash]', "");
        foreach ($version_view as $version => $key) {
            if ($_POST['hash_version'] == $version) {
                if ($version == "dle070") {
                    $domen_hash = explode('.', $domain_name);
                    $count_key = count($domen_hash) - 1;
                    unset($domen_hash[$count_key]);
                    if (end($domen_hash) == 'com' OR end($domen_hash) == 'net') $count_key--;
                    $domen_hash = $domen_hash[$count_key - 1];
                    $hash_tpl = md5(md5($domen_hash . '780918'));
                    $hash_vetpl = $hash_version_view['5971'];
                } else {
                    $hash_tpl = md5(get_domen_hash($domain_name) . $key);
                    $hash_vetpl = $hash_version_view[$key];
                }
            }
        }
        $tpl->set('{hash_domain}', $hash_tpl);
        $tpl->set('{hash_version}', "DataLife Engine v." . $hash_vetpl);
    }
} else {
    $tpl->set_block("'\[else-hash\](.*?)\[/else-hash\]'si", "");
    $tpl->set('[if-hash]', "");
    $tpl->set('[/if-hash]', "");
}
if ($config['allow_recaptcha'] == 1) {
    $tpl->set('[recaptcha]', "");
    $tpl->set('[/recaptcha]', "");
    $tpl->set('{recaptcha}', '
	<script type="text/javascript">
	<!--
	var RecaptchaOptions = {
	theme: \'' . $config['recaptcha_theme'] . '\',
	lang: \'' . $lang['wysiwyg_language'] . '\'
	};
	
	//-->
	</script>
	<script type="text/javascript" src="//www.google.com/recaptcha/api/challenge?k=' . $config['recaptcha_public_key'] . '"></script>');
    $tpl->set_block("'\[sec_code\](.*?)\[/sec_code\]'si", "");
    $tpl->set('{code}', "");
} else {
    $tpl->set('[sec_code]', "");
    $tpl->set('[/sec_code]', "");
    $tpl->set('{code}', "<span id=\"dle-captcha\"><img src=\"" . $path['path'] . "engine/modules/antibot/antibot.php\" alt=\"{$lang['sec_image']}\" width=\"160\" height=\"80\" /><br /><a onclick=\"reload(); return false;\" href=\"#\">{$lang['reload_code']}</a></span>");
    $tpl->set_block("'\[recaptcha\](.*?)\[/recaptcha\]'si", "");
    $tpl->set('{recaptcha}', "");
}
$tpl->copy_template.= <<<HTML
<script language="javascript" type="text/javascript">
<!--
function reload () {

	var rndval = new Date().getTime(); 

	document.getElementById('dle-captcha').innerHTML = '<img src="{$path['path']}engine/modules/antibot/antibot.php?rndval=' + rndval + '" width="160" height="80" alt="" /><br /><a onclick="reload(); return false;" href="#">{$lang['reload_code']}</a>';

};
//-->
</script>
HTML;
$tpl->compile('content');
$tpl->clear();
?>