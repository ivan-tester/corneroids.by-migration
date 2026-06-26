<?php
require "core/init.php";

$live = intval( $live ? $live : 300 );
$template = $template ? $template : "whoonline";

class whoonline_function
{
	private $user_id		=	null;
	private $user_name		=	null;
	private $user_foto		=	null;
	private $user_group		=	null;
	private $user_groupid	=	null;
	private $user_position	=	null;
	private $user_os		=	"неизвестная";
	private $user_browser	=	"неизвестный";
	private $robots			=	false;
	protected $date_ajust	= 	0;
	
	protected function info()
	{
		global $_IP, $config;
		$this->date_adjust = intval( $config["date_adjust"] ) * 60;
		$this->robots($_SERVER["HTTP_USER_AGENT"]);
		if(!$this->robots)
		{
			$this->user_os($_SERVER["HTTP_USER_AGENT"]);
			$this->user_browser($_SERVER["HTTP_USER_AGENT"]);
		}
		$this->user_info();
		$this->user_position();
		
		return array(
			"time"		=>	time() + $this->date_adjust,
			"ip"		=>	$_IP ? $_IP : $_SERVER["REMOTE_ADDR"],
			"name"		=>	$this->user_name,
			"id"		=>	$this->user_id,
			"foto"		=>	$this->user_foto,
			"group"		=>	$this->user_group,
			"groupid"	=>	$this->user_groupid,
			"os"		=>	$this->user_os,
			"browser"	=>	$this->user_browser,
			"position"	=>	$this->user_position
		);
	}
	
	private function robots($useragent)
	{
        $arr = array("#.*(yandex|yadirectbot).*#si" => "<img src={THEME}/images/whoonline/bots/yandex.png />", "#.*(google|accoona|gsa-crawler).*#si" => "<img src={THEME}/images/whoonline/bots/google.png />", "#.*rambler.*#si" => "<img src={THEME}/images/whoonline/bots/rambler.png />", '#.*mail.ru.*#si' => "<img src={THEME}/images/whoonline/bots/mail_ru.png />", "#.*aport.*#si" => "<img src={THEME}/images/whoonline/bots/aport.png />", "#.*TurtleScanner.*#si" => "Turtle", "#.*slurp.*#si" => "<img src={THEME}/images/whoonline/bots/Inktomi-Spider.png />", "#.*msnbot.*#si" => "<img src={THEME}/images/whoonline/bots/msn.png />", "#.*(askjeeves|ask jeeves).*#si" => "<img src={THEME}/images/whoonline/bots/ask_com.png />", "#.*yahoo.*#si" => "<img src={THEME}/images/whoonline/bots/yahoo.png />", "#.*scooter.*#si" => "<img src={THEME}/images/whoonline/bots/altavista.png />", "#.*lycos.*#si" => "Lycos.com", "#.*libwww.*#si" => "<img src={THEME}/images/whoonline/bots/Punto.png />", "#.*picsearch.*#si" => "<img src={THEME}/images/whoonline/bots/picsearch.png />", "#.*mnogosearch.*#si" => "<img src={THEME}/images/whoonline/bots/mnogosearch.png />", "#.*(is_archiver|archive_org).*#si" => "<img src={THEME}/images/whoonline/bots/Archive.org.png />", "#.*W3C_Validator.*#si" => "<img src={THEME}/images/whoonline/bots/w3cvalidator.png />", "#.*W3C_CSS_Validator.*#si" => "<img src={THEME}/images/whoonline/bots/w3c_css_validator.png />", "#.*antabot.*#si" => "antabot (private)", "#.*Asterias.*#si" => "Singingfish Spider", "#.*Baiduspider.*#si" => "Baidu Spider", "#.*Feedfetcher-Google.*#si" => "Feedfetcher-Google", "#.*GameSpyHTTP.*#si" => "GameSpy HTTP", "#.*GigaBlast.*#si" => "GigaBlast", "#.*Gigabot.*#si" => "Gigabot", "#.*Googlebot-Image.*#si" => "Googlebot-Image", "#.*Googlebot.*#si" => "Googlebot", "#.*grub-client.*#si" => "Grub", "#.*slurp@inktomi.*#si" => "Hot Bot", "#.*whatuseek.*#si" => "What You Seek", "#.*ia_archiver.*#si" => "Alexa", "#.*YandexBlog.*#si" => "YandexBlog", "#.*YandexSomething.*#si" => "YandexSomething", "#.*StackRambler.*#si" => "Rambler", "#.*WebAlta Crawler.*#si" => "WebAlta Crawler", "#.*zyborg@looksmart.*#si" => "WiseNut", "#.*WebCrawler.*#si" => "Fast", "#.*Openbot.*#si" => "Openfind", "#.*booch.*#si" => "booch_Bot", "#.*WebZIP.*#si" => "WebZIP", "#.*GetSmart.*#si" => "GetSmart", "#.*NaverBot.*#si" => "NaverBot", "#.*Vampire.*#si" => "Net_Vampire", "#.*ZipppBot.*#si" => "ZipppBot");
        $result = preg_replace(array_keys($arr), $arr, $useragent);
        $this->robots = $result == $useragent ? $this->robots : $result;
	}
	
	private function user_os($useragent)
	{
		$arr = array("#.*Windows NT 5.1.*#si" => "<img src={THEME}/images/whoonline/system/xp.png /> Windows XP", "#.*Windows NT 5.2.*#si" => "<img src={THEME}/images/whoonline/system/xp64.png /> Windows XP x64 or Server 2003", "#.*Windows NT 6.0.*#si" => "<img src={THEME}/images/whoonline/system/vista.png /> Windows Vista", "#.*Windows NT 6.1.*#si" => "<img src={THEME}/images/whoonline/system/win7.png /> Windows 7", "#.*Windows NT 5.0.*#si" => "<img src={THEME}/images/whoonline/system/win2000.png /> Windows 2000", "#.*(Windows NT 4.0|Windows NT 3.5).*#si" => "Windows NT", "#.*Windows CE.*#si" => "Windows CE or Mobile", "#.*Windows Me.*#si" => "Windows ME", "#.*Windows 98.*#si" => "Windows 98", "#.*Windows 95.*#si" => "Windows 95", "#.*(Linux|Lynx|Unix).*#si" => "<img src={THEME}/images/whoonline/system/linux.png /> Linux", "#.*(Macintosh|PowerPC).*#si" => "<img src={THEME}/images/whoonline/system/mac.png /> MacOS", "#.*OS/2.*#si" => "OS/2", "#.*BeOS.*#si" => "BeOS");
		$result = preg_replace(array_keys($arr), $arr, $useragent);
		$this->user_os = $result == $useragent ? $this->user_os : $result;
	}
	
	private function user_browser($useragent)
 	{
 		$arr = array("#.*MSIE (\S*);.*#si" => "<img src={THEME}/images/whoonline/browser/ie.png /> Internet Explorer \\1", "#.*(Opera.*Version|Opera)/(\S*).*#si" => "<img src={THEME}/images/whoonline/browser/opera.png /> Opera \\2", "#.*Navigator/(\S*).*#si" => "Navigator \\1", "#.*Flock/(\S*).*#si" => "Flock \\1", "#.*Firefox/(\S*).*#si" => "<img src={THEME}/images/whoonline/browser/firefox.png /> Firefox \\1", "#.*Chrome/(\S*).*#si" => "<img src={THEME}/images/whoonline/browser/chrome.png /> Chrome \\1", "#.*Version/(\S*).*Safari.*#si" => "Safari \\1", "#.*Safari/(\S*).*#si" => "<img src={THEME}/images/whoonline/browser/safari.png /> Safari \\1", "#.*K-Meleon.*#si" => "K-Meleon", "#.*SeaMonkey.*#si" => "SeaMonkey", "#.*Camino.*#si" => "Camino", "#.*Epiphany.*#si" => "Epiphany", "#.*America Online Browser.*#si" => "America Online Browser", "#.*avantbrowser.*#si" => "Avant Browser.");
        $result = preg_replace(array_keys($arr), $arr, $useragent);
        $this->user_browser = $result == $useragent ? $this->user_browser : $result;
	}
	
	private function user_info()
	{
		global $is_logged, $member_id, $user_group;
		if($this->robots)
		{
			$this->user_id = 2;
			$this->user_name = $this->robots;
			$this->user_group = "Роботы";
		}
		elseif($is_logged)
		{
			$this->user_id = 1;
			$this->user_name = $member_id["name"];
			$this->user_foto = $member_id["foto"] ? $member_id["foto"] : null;
			$this->user_group = $user_group[$member_id["user_group"]]["group_name"];
			$this->user_groupid = $member_id["user_group"];
		}
		else
		{
			$this->user_id = 0;
			$this->user_name = "Гость";
			$this->user_group = "Гости";
		}
	}
	
	private function user_position()
	{
		global $cat_info, $category_id, $dle_module, $nam_e, $titl_e, $bbr_name, $bbr_fname, $bbr_tname, $tid;
		$result = "Просматривает главную страницу";
		switch($dle_module)
		{
			case "main":			$result = "На главной"; break;
			case "showfull":		$result = $titl_e ? "Смотрит: $titl_e" : "Просматривает страницу: Error 404"; break;
			case "alltags":			$result = "Смотрит облако тегов"; break;
			case "cat":				$result = $cat_info[$category_id]["name"] ? "Смотрит категорию: {$cat_info[$category_id]["name"]}" : "Просматривает категорию: Error 404"; break;
			case "favorites":		$result = "Смотрит избранное"; break;
			case "lastcomments":	$result = "Смотрит последние комментарии"; break;
			case "lastnews":		$result = "Смотрит последние новости"; break;
			case "rules":			$result = "Смотрит правила сайта"; break;
			case "static":			$result = $titl_e ? "Смотрит: $titl_e" : "Просматривает страницу: Error 404"; break;
			case "stats":			$result = "Смотрит статистику"; break;
			case "tags":			$result = "Смотрит облако тегов"; break;
			case "userinfo":		$result = $nam_e ? "Смотрит профиль: $nam_e" : "Смотрит профиль: Error 404"; break;
			case "addcomment":		$result = "Добавляет комментарий"; break;
			case "addnews":			$result = "Добавляет новость"; break;
			case "comments":		$result = "Добавляет комментарий"; break;
			case "allnews":			$result = $nam_e ? "Смотрит: $nam_e" : "Находится в разделе: Errror 404"; break;
			case "feedback":		$result = $nam_e ? "Смотрит: $nam_e" : "Находится в разделе: Errror 404"; break;
			case "pm":				$result = $nam_e ? "Смотрит: $nam_e" : "Находится в разделе: Errror 404"; break;
			case "forum":			$result = "Смотрит форум $bbr_name $bbr_fname $tid"; break;
			case "horoscope":		$result = $titl_e ? "Смотрит: $titl_e" : "Просматривает страницу: Error 404"; break;
			case "sonnik":			$result = $titl_e ? "Смотрит: $titl_e" : "Просматривает страницу: Error 404"; break;
			case "chat":			$result = "Смотрит чат"; break;
			case "mchat":			$result = "Смотрит чат"; break;
			case "statususer":		$result = $nam_e ? "Смотрит: $nam_e" : "Просматривает страницу: Error 404"; break;
			case "repa_edit":		$result = $nam_e ? "Смотрит: $nam_e" : "Просматривает: Errror 404"; break;
			case "repa_changes":	$result = $nam_e ? "Смотрит: $nam_e" : "Просматривает: Errror 404"; break;
			case "topusers":		$result = $nam_e ? "Смотрит: $nam_e" : "Просматривает: Errror 404"; break;
			case "repa_list":		$result = $nam_e ? "Смотрит: $nam_e" : "Просматривает: Errror 404"; break;
			case "reputation":		$result = "Смотрит репутацию"; break;
//дополнено Модуль На Линии, 2.6.2
			case "numerology":		$result = "Смотрит Нумерологию чисел"; break;
			case "members":			$result = "Смотрит список пользователей"; break;
//дополнено Модуль На Линии, 2.7 for DLE 9.0
			case "register":		$result = "Регистрируется"; break;
			case "newposts":		$result = "Смотрит новые темы"; break;
			case "search":			$result = "Ищет на сайте"; break;
//дополнено Модуль На Линии, 2.7.1 for DLE 9.0
			case "points":		$result = "Смотрит Магазин стилей и подарков"; break;
			

		}
		$this->user_position = addslashes(htmlspecialchars($result));
	}
}

class whoonline extends whoonline_function
{
	private $template = null;
	private $live = null;
	private $whoonlock = null;
	private $whoonline = null;
	private $online = array();
	
	public function __construct()
	{
		$this->whoonlock = ENGINE_DIR."/data/whoonlock.txt";
		$this->whoonline = ENGINE_DIR."/data/whoonline.txt";
	}
	
	private function read()
	{
		$lines = $result = array();
		$result[] = $this->info();
		$lines = (array)unserialize(@file_get_contents($this->whoonline));
		foreach($lines as $arr)
		{
			if((in_array($result[0]["id"], array(1,2))) && (time() + $this->date_adjust - $arr["time"] < $this->live) && ($result[0]["ip"] != $arr["ip"]) && ($result[0]["name"] != $arr["name"])) $result[] = $arr;
			elseif(($result[0]["id"] == 0) && (time() + $this->date_adjust - $arr["time"] < $this->live) && ($result[0]["ip"] != $arr["ip"])) $result[] = $arr;
		}
		$this->online = $result;
	}
	
	private function write()
	{
		$lock = fopen($this->whoonlock, "a+");
		if(flock($lock, LOCK_EX+LOCK_NB)) 
		{
			$file = fopen($this->whoonline, "w");
			fwrite($file, serialize($this->online));
			fflush($file);
			fclose($file);
			flock($lock, LOCK_UN);
		}
		fclose($lock);
	}
	
	public function view($template, $live)
	{
		global $config, $view;
		$this->live = $live;
		$this->template = $template;
		$this->read();
		$this->write();
		$view->set("online", $this->online);
		$view->set("config", array("allow_alt_url" => $config["allow_alt_url"], "seo_type" => $config["seo_type"], "skin" => $config["skin"], "home_url" => $config["http_home_url"]));
		
		return $view->display($this->template);		
	}
}

$whoonline = new whoonline();
echo $whoonline->view($template, $live);
unset($live, $template, $whoonline);
?>