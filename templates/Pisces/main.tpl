<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
                <!-- Put this script tag to the <head> of your page -->
<script type="text/javascript" src="//vk.com/js/api/openapi.js?105"></script>
    <meta name='yandex-verification' content='7898602aa92c18bd' />
    <meta name="mailru-domain" content="DmjNOxpbxRPabwPN" />
    <meta name="google-site-verification" content="44WOIMWUdoHcsw7_GV0ozBi-x26j_xdUqoClYr5JtzQ" />
{headers}
<link rel="shortcut icon" href="{THEME}/images/favicon.ico" />
<link href="{THEME}/style/styles.css" type="text/css" rel="stylesheet" />
<link href="{THEME}/style/engine.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="{THEME}/js/libs.js"></script>
</head>
<body>
{AJAX}
<div class="wwide pagebg">
	<div id="headbar">
		<div id="header">
			<div class="wrapper">
				<div class="container">
					<h1><a class="thide" href="/index.php" title="Corneroids.By Не потеряй голову!">CorneRoids.By Не потеряй голову!</a></h1>
					<div class="loginbox">{login}</div>
					<div class="headlinks">
						<ul class="reset">
							<li><a href="/index.php">Главная страница</a></li>
                            <li><a href="/?do=lastcomments">Последние комментарии</a></li>
							<li><a href="/index.php?do=feedback">Связаться с нами</a></li>
							
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div id="speedbar">
			<div class="wrapper">
				<div class="container">
					{speedbar}
				</div>
			</div>
		</div>
	</div>
	<div class="wrapper">
		<div id="toolbar" class="container">
			{include file="topmenu.tpl"}
            <form method="post" action=''>
                				<input type="hidden" name="do" value="search" />
				<input type="hidden" name="subaction" value="search" />
				<ul class="searchbar reset">
					<li class="lfield"><input id="story" name="story" value="Поиск..." onblur="if(this.value=='') this.value='Поиск...';" onfocus="if(this.value=='Поиск...') this.value='';" type="text" /></li>
					<li class="lbtn"><input title="Найти" alt="Найти" type="image" src="{THEME}/images/spacer.gif" /></li>
				</ul>
			</form>
		</div>
		<!--{include file="slider.tpl"}-->
		<div class="shadlr"><div class="shadlr">
			<div class="container">
				<div id="vseptop" class="wsh"><div class="wsh">&nbsp;</div></div>
				<div class="vsep"><div class="vsep">
					<div id="midside" class="rcol">
						<div class="hban"><div class="hban">
							<div class="dpad">{banner_google}</div>
						</div></div>
						[sort]<div class="dpad"><div class="sortn"><div class="sortn">{sort}</div></div></div>[/sort]
						{info}
						{content}
					</div>
					<div id="sidebar" class="lcol">
						{include file="sidebar.tpl"}
                        {include file="engine/modules/snippets/whoonline.php"}
                        
          
					</div>
					<div class="clr"></div>
				</div></div>
				<div id="vsepfoot" class="wsh"><div class="wsh">&nbsp;</div></div>
			</div>
		</div></div>
	</div>
</div>	
  
   <div class="ftbar">
   
	<div class="wrapper">
		<div class="container">
		        	<div class="blocktags radial">
						
            <div class="counts">
		
		<div clas"fotertags">
<ul class="reset">
               
                    
                    
                    
				
					<li><!--LiveInternet counter--><script type="text/javascript">
document.write("<a href='//www.liveinternet.ru/click' "+
"target=_blank><img src='//counter.yadro.ru/hit?t11.17;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random()+
"' alt='' title='LiveInternet: показано число просмотров за 24"+
" часа, посетителей за 24 часа и за сегодня' "+
"border='0' width='88' height='31'><\/a>")
</script><!--/LiveInternet-->
</li>
						
	</ul>
	<span class="copyright">
				Copyright &copy; 2013 <a href="/">Corneroids.by</a> All Rights Reserved.<br />
				Powered by Drage. Supported United &copy; 2013
		                </span>
		<br>
				<br><div style="margin-left: 433px;"><a href="http://corneroids.by/">CorneRoids.By</a> |  <a onclick="staticpage('about'); return false;" href="/rss.xml">RSS</a></div> 					
			</div>	
                        </div>	</div>
		
	</div>	
</div>	
      <br>                     
	<div id="scrollup"><img alt="Прокрутить вверх" src="{THEME}/images/up.png"></div>
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
    
</body>
</html>