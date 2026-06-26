<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="google-site-verification" content="44WOIMWUdoHcsw7_GV0ozBi-x26j_xdUqoClYr5JtzQ" />
{headers}
	<script type="text/javascript">
	(function(){
		var mode = "dark";
		try { mode = localStorage.getItem("corneroids-theme") || "dark"; } catch(e) {}
		document.documentElement.className += (mode == "light" ? " theme-light" : " theme-dark");
	})();
	</script>
        <link rel="stylesheet" title="style" type="text/css" href="{THEME}/css/style.css" />   
        <link rel="stylesheet" title="style1" type="text/css" href="{THEME}/css/style1.css" />
<link rel="stylesheet" type="text/css" href="{THEME}/css/vblaststyle.css" />
        <link rel="stylesheet" type="text/css" href="{THEME}/css/engine.css" />
        <link rel="stylesheet" type="text/css" href="{THEME}/css/theme-toggle.css" />  
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /> 
    <meta name="wot-verification" content="8db3caa88e9e64278dd1"/>
	<!--[if lte IE 7]>
	<link rel="stylesheet" href="{THEME}/css/style-ie.css" type="text/css" />
	<![endif]-->
	<!--[if IE 8]>
	<link rel="stylesheet" href="{THEME}/css/style-ie8.css" type="text/css" />
	<![endif]-->
	<!--[if IE 6]>
	<script src="{THEME}/js/DD_belatedPNG.js"></script>
	<script>
		DD_belatedPNG.fix('.logo, .n-link span, .slider-title, .center-news-block-title');
	</script>
	<![endif]-->
 <script type="text/javascript" src="{THEME}/js/jquery.hoverIntent.minified.js"></script>
	<script type="text/javascript" src="{THEME}/js/js.js"></script>
	<script type="text/javascript" src="{THEME}/js/jquery.tooltip.min.js"></script>
<script type="text/javascript" src="{THEME}/js/styleswitcher.js"></script>
	<script type="text/javascript" src="{THEME}/js/slider.js"></script>
<script type="text/javascript">
function showOkno() {
$(function(){

    $('#okno').dialog({
        autoOpen: true,
        show: 'fade',
        hide: 'fade',
        width: 550,
                buttons: {
            "Закрыть окно" : function() {
                $(this).dialog("close");
            }
               }
    });
});
}
</script>
<script type="text/javascript" src="{THEME}/js/scripts.js"></script>
<script type="text/javascript"> 
function add_favorite(a) { 
  title=document.title; 
  url=document.location; 
  try { 
    window.external.AddFavorite(url, title); 
  } 
  catch (e) { 
    try { 
      window.sidebar.addPanel(title, url, ""); 
    } 
    catch (e) { 
      if (typeof(opera)=="object") { 
        a.rel="sidebar"; 
        a.title=title; 
        a.url=url; 
        return true; 
      } 
      else { 
        alert('Нажмите Ctrl-D чтобы добавить страницу в закладки'); 
      } 
    } 
  } 
  return false; 
}
</script> 
<script type="text/javascript">
function setCorneroidsTheme(mode) {
	var html = document.documentElement;
	html.className = html.className.replace(/\btheme-dark\b|\btheme-light\b/g, "");
	html.className += mode == "light" ? " theme-light" : " theme-dark";
	try { localStorage.setItem("corneroids-theme", mode); } catch(e) {}
	var label = document.getElementById("theme-toggle-label");
	if(label) label.innerHTML = mode == "light" ? "&#1058;&#1105;&#1084;&#1085;&#1072;&#1103;" : "&#1057;&#1074;&#1077;&#1090;&#1083;&#1072;&#1103;";
}
function toggleCorneroidsTheme() {
	var isDark = /\btheme-dark\b/.test(document.documentElement.className);
	setCorneroidsTheme(isDark ? "light" : "dark");
	return false;
}
</script> 
<script type="text/javascript">
if(!window.slider) var slider={};slider.data=[{"id":"slide-img-1","client":"nature beauty","desc":"nature beauty photography"},{"id":"slide-img-2","client":"nature beauty","desc":"add your description here"}];
</script>
	<script type="text/javascript">
$(document).ready(function () {	
		setCorneroidsTheme(/\btheme-light\b/.test(document.documentElement.className) ? "light" : "dark");
	
	$('#nav li').hover(
		function () {
			//show its submenu
			$('ul', this).slideDown(100);

		}, 
		function () {
			//hide its submenu
			$('ul', this).slideUp(100);			
		}
	);
	
});
        

	</script>

	<style type="text/css">
        body{font-family:arial;font-size:11px;}#nav{list-style:none;margin:0;padding:0;}#nav li{float:left;background:url({THEME}/images/mbgo.png) repeat-x;position:relative;z-index:3000;margin:0;}#nav li a{display:block;font-weight:700;text-decoration:none;text-align:left;color:#000;}#nav li a:hover{color:#000;background:#fcdd9c url({theme}/images/mbg.png) repeat-x;}#nav a.selected{color:red;}#nav 
        ul{position:absolute;left:0;display:none;width:283px;background:url({theme}/images/bg128.jpg) no-repeat;min-height:30px;border:1px #000 solid;list-style:none;margin:0 0 0 -1px;padding:0;}#nav 
        ul li{background:#fff;float:left;border-top:1px solid #fff;}#nav ul a{display:block;height:15px;color:#666;padding:3px;}#nav ul a:hover{background:url(..{THEME}/images/bg512.png) no-repeat;}*html #nav ul{margin:0 0 0 -2px;}.kolonka{float:left;width:125px;font-family:Geneva, Arial, Helvetica, sans-serif;font-size:7pt;margin:5px;}.kolonka1{width:125px;font-family:Geneva, Arial, Helvetica, sans-serif;font-size:7pt;margin:5px;}.kolonka 
        a{width:125px;font-family:Geneva, Arial, Helvetica, sans-serif;font-size:9pt;color:#000;margin:5px;}
	</style>
</head>
<script type="text/javascript">
    snow_intensive=400;
    snow_speed=20000;
    snow_src=new Array('sneg1.gif','sneg2.gif','sneg3.gif','sneg4.png');

    $(document).ready(snow_start);

    function snow_start() {
        snow_id=1;
        snow_y=$("#container").height()-30;
        setInterval(function() {
            snow_x=Math.random()*document.body.offsetWidth-100;
            snow_img=(snow_src instanceof Array ? snow_src[Math.floor(Math.random()*snow_src.length)] : snow_src);
            snow_elem='<img class="png" id="snow'+snow_id+'" style="position:absolute; left:'+snow_x+'px; top:0;z-index:10000" src="'+snow_img+'"/>';
            $("#container").append(snow_elem);
            snow_move(snow_id);
            snow_id++;
        },snow_intensive);
    }

    function snow_move(id) {
        $('#snow'+id).animate({top:snow_y,left:"+="+Math.random()*100},snow_speed,function() {
        $(this).empty().remove();
    });}
</script>
<body>
{AJAX}
{include file="chat.tpl"}
<div class="background-image">
	<div id="top-line">

		<div class="main-center-block"><ul id="nav">
<li><a href="/"><img border=0 src="{THEME}/images/logomidori.png"></a></li>
	<li><a href="#" class="selected"><img border=0 src="{THEME}/images/vniz.png"></a>
		<ul><div class="n-link">Главное меню
<a href="/">Главная страница</a>
<!--<a href="/">Форум</a>-->
<a href="/rules.html">Правила сайта</a>
<a href="/index.php?do=feedback">Обратная связь</a>

Остальные ссылки
<a href="/rss.xml">Чтение RSS</a>
<a href="#" onclick="return add_favorite(this);">В закладки</a>
            <a href="http://vk.com/corneroids_by">Мы ВКонатакте</a>
</div>                  <div class="kolonka">Разделы сайта
						<a href="/news/">Новости</a>
                        <a href="/mods">Моды (блокссеты)</a>
                        <a href="/servers">Сервера</a>
                        <a href="/updates/">Обновления</a>
                        <a href="/index.php?do=feedback">Ваши предложения</a>
                        <a href="/help">Гайды/помощь</a>
                        <a href="/video/">Видео</a>
                        <a href="/maps/">Карты</a>
                        <a href="/plugins/">Плагины</a>
                        <a href="/texture/">Текстуры</a>
                        <a href="/cheats/">Читы</a>
                        <a href="/galereya/">Галерея</a>
</div>

		</ul>
		<div class="clear"></div>
	</li><img style="float: left;" src="{THEME}/images/linem.png">

	[not-group=5]<li><a href="#">{login}</a>
				
		<div class="clear"></div>
	</li><li><a href="#" onclick="setActiveStyleSheet('style'); return false;"><img title="Открепить панель" border=0 src="{THEME}/images/pusto.png"></a></li><li><a href="#" onclick="setActiveStyleSheet('style1'); return false;"><img border=0 title="Закрепить панель" src="{THEME}/images/scr.png"></a></li>[/not-group]

</ul>
[group=5]{login}[/group]

			<div class="theme-switcher"><a href="#" onclick="return toggleCorneroidsTheme();"><span id="theme-toggle-label">&#1057;&#1074;&#1077;&#1090;&#1083;&#1072;&#1103;</span></a></div>
			<div class="search-block">
				<form method="post" action=''>
					<input type="hidden" name="do" value="search" /><input type="hidden" name="subaction" value="search" />
					<input id="story" name="story" type="text" class="form-text" value="" onblur="if(this.value=='') this.value='';" onfocus="if(this.value=='') this.value='';" />
				</form>
			</div>

			<div class="login-panel">
				
			</div>
		</div>
	</div>
	<div class="top-line1">&nbsp;</div>
	<div class="main-center-block">
		<div class="top-menu">
			<ul id="topnav">
				<li>
					<a href="/" class="n-link"><span>Главная</span></a><img src="{THEME}/images/top-menu-line.jpg" alt="" />
				</li>
                <!--<li><a href="/" class="n-link"><span>Форум</span></a><img src="{THEME}/images/top-menu-line.jpg" alt="" /></li>-->
				<li><a href="#" class="n-link"><span>Общие разделы</span></a>
					<div class="sub">
						<ul>
							<li><a href="/index.php?do=feedback">Обратная связь</a></li>
							<li><a href="/rules.html">Правила сайта</a></li>
						</ul>

					</div>
					<img src="{THEME}/images/top-menu-line.jpg" alt="" />
                </li>
                <li><a href="/16-faq-po-corneroids.html" class="n-link"><span>FAQ</span></a><img src="{THEME}/images/top-menu-line.jpg" alt="Частозадаваемые вопросы" /></li>		
                <li><a href="/6-ustanovka.html" class="n-link"><span>Начать игру</span></a><img src="{THEME}/images/top-menu-line.jpg" alt="" /></li>		
                <li><a href="/8-kak-igrat-po-seti.html"  class="n-link"><span>Как зайти на сервер?</span></a><img src="{THEME}/images/top-menu-line.jpg" alt="" /></li>	
                <div style="float: right; padding-top: 15px; padding-right: 5px; "><a href="/rss.xml" title="чтение rss ленты" target="_blank" class="social"><img borde=0 src="{THEME}/images/rss.png"></a>
                <a href="#" onclick="return add_favorite(this);" class="social"><img borde=0 src="{THEME}/images/star.png"></a><!--<a href="/url" target="_blank" title="Сервис сокрашения ссылок" class="social"><img borde=0 src="{THEME}/images/sss.png"><a href="/" target="_blank" class="social"><img borde=0 src="{THEME}/images/twit.png"></a>-->
                    <a href="http://vk.com/corneroids_by" target="_blank" class="social"><img borde=0 src="{THEME}/images/vk.png"></a></div>
			</ul>

		</div>

<div class="slider-block transparent ie">
<div class="hello-block">
  <div id="header"><div class="wrap">
   <div id="slide-holder">
<div id="slide-runner">
    <a href="/"><img id="slide-img-1" src="{THEME}/images/01.jpg" class="slide" alt="" /></a>
    <a href="#" onclick="return add_favorite(this);"><img id="slide-img-2" src="{THEME}/images/02.jpg" class="slide" alt="" /></a>
    <div id="slide-controls">
     <p id="slide-nav"></p>
    </div>
</div>
</div>
</div>
</div>
</div>

		<div class="main-content-block">

			<table class="main-table" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top" class="td-for-content">
						<div class="main-content-block-center">
							<div class="main-content-block-top">
								<div class="main-content-block-bottom">
									{info}
									{content}
								</div>
							</div>
						</div>
 
					</td>
					<td valign="top" class="td-for-blocks">
                                        <!--<div align="center">
                                            <a class="forum_b" title="Форум " href="/">
                                        <img src="{THEME}/images/spacer.gif" alt="Наш форум"/>
                                        </a>
                                        </div>-->
						<div class="r-blocks">
							<div class="r-blocks-top">
								<div class="r-blocks-bottom">
									<div class="r-blocks-title">
										Навигация
									</div>
									<div class="r-blocks-content">
										<div id="acc-menu">
											<p class="acc-title" style="background: #ccc;">Разделы сайта</p>
											<div class="acc-list" style="display: block;">          

						<b><a href="/news/">Новости</a>
                        <a href="/mods">Моды (блоксеты)</a>
                        <a href="/servers">Сервера</a>
                        <a href="/updates/">Обновления</a>
                        <a href="/">Ваши предложения</a>
                        <a href="/help">Гайды/помощь</a>
                        <a href="/video/">Видео</a>
                        <a href="/maps/">Карты</a>
                        <a href="/igry-pohozhie-na-corneroids-i-minecraft">Игры похожие на Corneroids и Minecraft</a>
                        <a href="/programs">Программы</a>  
                        <a href="/galereya">Галерея</a>     
                        <a href="/plugins/">Плагины</a>
                        <a href="/texture/">Текстуры</a>
                            <a href="/cheats/">Читы</a></b> 
											</div>     	
											<!--<p class="acc-title"><a href="/engine/download.php?id=3">Скачать последнюю версию CorneRoids</a></p>	
<div id="oknouroka" title="Это какбе тест аякс окна." style="display:none; " >
Нормально так?-->
</div>	
                                            При поддержке <a class="okno" href="http://minecrafting.by" onclick="showOkno(); return false;" class="mainlevel">MineCrafting.By</a>
											
											
											
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="r-blocks">
							<div class="r-blocks-top">
								<div class="r-blocks-bottom">
									<div class="r-blocks-title">
										Флудильная                                 
                                    </div>
									<div class="r-blocks-content">
                                     {include file="engine/modules/iChat/show.php"}
									</div>
								</div>
							</div>
						</div>
                        <div class="r-blocks">
							<div class="r-blocks-top">
								<div class="r-blocks-bottom">
									<div class="r-blocks-title">
										ВКонтакте                                 
                                    </div>
									<div class="r-blocks-content">
                                     <script type="text/javascript" src="//vk.com/js/api/openapi.js?82"></script>

<!-- VK Widget -->
<div id="vk_groups"></div>
<script type="text/javascript">
VK.Widgets.Group("vk_groups", {mode: 0, width: "230", height: "290"}, 50179996);
</script>
									</div>
								</div>
							</div>
						</div>
                 
						<div class="center-news-block-title">
								Сейчас <span>на сайте</span>
							</div>
							<div class="calend">{include file="engine/modules/snippets/whoonline.php"}</div>
					</td>
				</tr>
			</table>
			
		</div>
		
        <div class="footer-block"><p style="float:right; padding-right: 10px; padding-top: 15px;" align="right">{banner_liveinternet}<br>{banner_rambler}</p>
		<div style="padding: 10px;"><img borde=0 src="{THEME}/images/logomidori.png">
            <!-- begin of Top100 code -->

<script id="top100Counter" type="text/javascript" src="http://counter.rambler.ru/top100.jcn?2881643"></script>
<noscript>
<a href="http://top100.rambler.ru/navi/2881643/">
<img src="http://counter.rambler.ru/top100.cnt?2881643" alt="Rambler's Top100" border="0" />
</a>

</noscript>
<!-- end of Top100 code -->
            
            <!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href='http://www.liveinternet.ru/click' "+
"target=_blank><img src='//counter.yadro.ru/hit?t50.17;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random()+
"' alt='' title='LiveInternet' "+
"border='0' width='31' height='31'><\/a>")
//--></script><!--/LiveInternet-->
            <br>
            <div style="margin-left: 433px;"><a href="http://corneroids.by/">CorneRoids.By</a> |  <a onclick="staticpage('about'); return false;" href="#">О сайте</a></div>
			</div>
		</div>
	</div>
</div>
 <!--google analitycs-->
        
       <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35656067-3']);
  _gaq.push(['_setDomainName', 'corneroids.by']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
         <!--google analitycs-->
    <!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter20723428 = new Ya.Metrika({id:20723428,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/20723428" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
    
        <script language="jvascript">
function toggle() {
var ele = document.getElementById("toggleText");
var text = document.getElementById("displayText");
if(ele.style.display == "block") {
ele.style.display = "none";
text.innerHTML = "Открыть спойлер";
}
else {
ele.style.display = "block";
text.innerHTML = "Закрыть";
}
}
</script>    

    <!-- Rating@Mail.ru counter -->
<script type="text/javascript">//<![CDATA[
(function(w,n,d,r,s){(new Image).src=('https:'==d.location.protocol?'https:':'http:')+'//top-fwz1.mail.ru/counter?id=2333762;js=13'+
((r=d.referrer)?';r='+escape(r):'')+((s=w.screen)?';s='+s.width+'*'+s.height:'')+';_='+Math.random();})(window,navigator,document);//]]>
</script><noscript><div style="position:absolute;left:-10000px;"><img src="//top-fwz1.mail.ru/counter?id=2333762;js=na"
style="border:0;" height="1" width="1" alt="Рейтинг@Mail.ru" /></div></noscript>
<!-- //Rating@Mail.ru counter -->
    
</body>

</html>