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

class Сontrol_Сenter
{
	PUBLIC $errors_title = '';
	PUBLIC $errors = Array ();

	function header ($title, $speedbar = "")
	{

echo <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
    <title>LogicBoard 2.2 (DLE Edition) &raquo; {$title}</title>
    <link href="style.css" rel="stylesheet" type="text/css"/>
</head>
<body style="text-align:center;">
<div class="clear" style="height:15px;"></div>
<div id="siteWidthTop">
    <div style="padding:0px 17px">
        <div class="clear" style="height:11px;"></div>
        <div id="header">
            <div id="headerR">
                <div style="height:132px; overflow:hidden;">
                    <div id="logoContainer"><a href="index.php" title="LOGICBOARD"><img src="images/logo.gif" alt="LOGICBOARD" /></a></div>
                    <div id="headerInfoContainer">
                        <div id="headerInfoL"></div>
                        <div id="headerInfo">
                            <div id="headerInfoR">
                                <div style="padding-top:16px;">
                                    <p>Вы находитесь в мастере установки форума LogicBoard.</p>
                                    <p>Версия форума: 2.2 (DLE Edition)<br />
                                    Официальный сайт: <a href="http://logicboard.ru/"><font color="white">LogicBoard.ru</font></a><br />
                                    Автор: Курдин Никита (ShapeShifter)</p><br />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clear" style="height:1px;"></div>
                </div>
                <div style="padding-left:13px;">
HTML;

		$speedbar = explode ("|", $speedbar);
echo <<<HTML
                    <div class="headerTab">
                        <div class="headerTabL"></div>
                        <div class="headerTabBg"><a href="index.php">Установка LogicBoard</a></div>
                        <div class="headerTabR"></div>
                    </div>
HTML;

if ($speedbar[0] == "")
{
echo <<<HTML
                    <div class="headerTabActive">
                        <div class="headerTabL"></div>
                        <div class="headerTabBg"><i>Не определено</i></div>
                        <div class="headerTabR"></div>
                    </div>
HTML;
}
else
{
	$speedbar_end = end($speedbar);
	reset($speedbar);

	foreach ($speedbar as $link)
	{

		if($link != $speedbar_end)
		{
echo <<<HTML
                    <div class="headerTab">
                        <div class="headerTabL"></div>
                        <div class="headerTabBg">{$link}</div>
                        <div class="headerTabR"></div>
                    </div>
HTML;
		}
	}

echo <<<HTML
                    <div class="headerTabActive">
                        <div class="headerTabL"></div>
                        <div class="headerTabBg">{$speedbar_end}</div>
                        <div class="headerTabR"></div>
                    </div>
HTML;
}

echo <<<HTML
                </div>
            </div>
        </div>
    </div>
</div>
<div id="siteWidth">
    <div id="generalPadding">
        <div class="clear" style="height:11px; width:970px;"></div>
        <table>
            <tr>
                <td id="ramkaTL"><div></div></td>
                <td id="ramkaT"><div></div></td>
                <td id="ramkaTR"><div></div></td>
            </tr>
            <tr>
                <td id="ramkaL">
                    <div class="leftMenu">
                        <div id="menu5">
                            <div class="clear" style="height:12px;"></div>
                            <div id="menu5Closed">
                                <div class="menuItem" style="background:url('images/left_menu_ico_1.gif') 10px 0px no-repeat;"><a href="index.php">Установка</a></div>
                                <div class="clear" style="height:6px;"></div>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
HTML;
	}

	function speedbar ($links)
	{ 
		global $cache_config;

echo <<<HTML
<table width="100%" border=0>
<tr><td align=left><a href="index.php">Установка LogicBoard</a> &raquo; {$links}</td></tr>
</table>
HTML;
	}

	function footer ()
	{
		global $cache_config;
echo <<<HTML
                   <div class="clear" style="height:25px;"></div>
                </td>
                <td id="ramkaR"></td>
            </tr>
            <tr>
                <td id="ramkaBL"><div></div></td>
                <td id="ramkaB"><div></div></td>
                <td id="ramkaBR"><div></div></td>
            </tr>
        </table>
    </div>
</div>
<div id="siteWidthBtm">
    <div style="padding:0px 17px">
        <div class="clear" style="height:11px;"></div>
        <div id="btmBg">
            <div id="btmR">
                <div id="btmL">
                    <div class="btnWhite">
                        <div class="btnWhiteL"></div>
                        <div class="btnWhiteBg">©2011-2012 <a href="http://logicboard.ru/"><font color="black">LogicBoard</font></a></div>
                        <div class="btnWhiteR"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clear" style="height:20px;"></div>
</body>
</html>
HTML;
	}

	function message ()
	{
		if ($this->errors)
		{
			$mes = "<ul style=\"text-align:left;\">";
			foreach ($this->errors as $mes_data)
			{
				$mes .= "<li>".$mes_data."</li>";
			}
			$mes .= "</ul>";

echo <<<HTML
		<div class="clear" style="height:20px;"></div>
                   <div class="headerRed">
                        <div class="headerRedArr"><div></div></div>
                        <div class="headerRedL"></div>
                        <div class="headerRedR"></div>
                        <div class="headerRedBg">{$this->errors_title}</div>
                    </div>
                    <div class="borderL">
                        <div class="borderR">{$mes}</div>
                    </div>
                    <div>
                        <div class="borderBtmR"></div>
                        <div class="borderBtmL"></div>
                        <div class="borderBtm"></div>
                    </div>
                    <div class="clear" style="height:20px;"></div>

HTML;
		}
	}
}

?>