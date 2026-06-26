<!DOCTYPE html>
<html>
<head>
{headers}
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="{THEME}/css/engine.css" rel="stylesheet">
<link href="{THEME}/css/style.css" rel="stylesheet">
<script src="{THEME}/js/libs.js" type="text/javascript"></script>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<!--[if lt IE 9]><script src="{THEME}/js/html5shiv.js" type="text/javascript"></script><![endif]-->
</head>
<body>
	{AJAX}
	<div id="toolbar">
		<div id="in-toolbar">
			{login}
			<a id="menu-btn">
				<span id="hamburger"></span>
			</a>
		</div>
		<!-- Head Menu -->
		<nav id="menu-head">
		<a href="/news/">Новости</a>
        <a href="/galereya">Галерея</a>
        <a href="/video">Видео</a>
        <a href="/mods">Моды (итемсеты)</a>
        <a href="/servers">Сервера</a>
        <a href="/maps">Карты</a>
        <a href="/texture">Текстуры</a>
        <a href="/help">Гайды/Помощь</a>
		</nav>
		<!-- Head Menu [E] -->
	</div>
	<div class="background"></div>
	<header id="header">
		<!-- LogoType -->
		<a id="logo" href="/">
			<b id="logo-text">CORNEROIDS.BY</b>
			<span>Всё Для Corneroids</span>
		</a>
		<!-- LogoType [E] -->
		<!--Search-->
		<form id="quicksearch" method="post" action=''>
			<input type="hidden" name="do" value="search">
			<input type="hidden" name="subaction" value="search">
			<div class="quicksearch">
				<input class="f_input" placeholder="Поиск..." name="story" value="" type="search">
				<button type="submit" title="Search" class="thd">Найти</button>
			</div>
		</form>
		<!--Search [E]-->
		<a id="go2full" class="ico" href="/index.php?action=mobiledisable">Полная версия сайта</a>
        	</header>
	<section id="content">
		{info}
		{content}
	</section>
	<div id="footmenu">
		<h3>Навигация</h3>
		<nav class="main-nav">
			<a href="/news/">Новости</a>
        	<a href="/galereya">Галерея</a>
        	<a href="/video">Видео</a>
        	<a href="/mods">Моды (итемсеты)</a>
        	<a href="/servers">Сервера</a>
        	<a href="/maps">Карты</a>
        	<a href="/texture">Текстуры</a>
        	<a href="/help">Гайды/Помощь</a>
		<span class="nav-sep"></span>
			<a href="/index.php?do=lastnews" target="_blank">Все последние новости</a>
			<a href="/index.php?action=mobiledisable">Полная версия сайта</a>
            <a href="/?do=lastcomments">Последние комментарии</a>
			<a href="/index.php?do=feedback">Связаться с нами</a>
		</nav>
	</div>
	<footer id="footer">
		<div class="background"></div>
		<div id="copyright">Powered by <a href="/user/Drage/" target="_blank">CorneRoids.By</a> © 2015</div>
	</footer>
	<script type="text/javascript">
	// <![CDATA[
		(function(doc) {

		var addEvent = 'addEventListener',
		type = 'gesturestart',
		qsa = 'querySelectorAll',
		scales = [1, 1],
		meta = qsa in doc ? doc[qsa]('meta[name=viewport]') : [];

		function fix() {
		meta.content = 'width=device-width,minimum-scale=' + scales[0] + ',maximum-scale=' + scales[1];
		doc.removeEventListener(type, fix, true);
		}

		if ((meta = meta[meta.length - 1]) && addEvent in doc) {
		fix();
		scales = [.25, 1.6];
		doc[addEvent](type, fix, true);
		}

		}(document));
	// ]]>
	</script>
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
</body>
</html>