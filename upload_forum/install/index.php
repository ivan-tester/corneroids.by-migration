<?php

/****************************************/
// ИНФОРМАЦИЯ:
// ==== Форум: LogicBoard
// ==== Автор: Никита Курдин (ShapeShifter)
// ==== Copyright © Никита Курдин Игоревич 2011-2012
// ==== Данный код защищен авторскими правами
// ==== Официальный сайт: http://logicboard.ru

/****************************************/

error_reporting(E_ERROR);
@ini_set('display_errors', true);
@ini_set('html_errors', false);
@ini_set('error_reporting', E_ERROR);

define ( 'LogicBoard_Install', true );
define ( 'LB_MAIN', realpath("../") );
define ( 'LB_CONFIG', LB_MAIN . '/components/config' );
define ( 'LB_CLASS', LB_MAIN . '/components/class' );

require  LB_MAIN . '/install/template.class.php';
$control_center = new Сontrol_Сenter ( );

$find_errors = false;

if ($_REQUEST['step'] != 4)
{
    if(@file_exists(LB_CONFIG . '/board_db.php'))
    {
        $control_center->header("Установка", "Установка");
        $onl_location = "Установка";
        $control_center->errors = array ();
        $control_center->errors[] = "Установка остановлена. На сервере найден файл с настройками от базы данных. Если вы хотите произвести повторную установку - необходимо вручную удалить данный файл: <b>components/config</b> (путь относительно папки форума).";
        $control_center->errors_title = "Ошибка.";
        $control_center->message();
        $control_center->footer();
        $find_errors = true;
    }
}

if (!$find_errors)
{
    $control_center->errors = array ();
    
    if ($_REQUEST['step'] == 1)
    {
        $link_speddbar = "<a href=\"index.php\">Установка</a>|Шаг 1. Лицензионное соглашение.";
        $control_center->header("Установка LogicBoard", $link_speddbar);
        
echo <<<HTML

<form  method="post" name="ustanovka" action="" id="licence_form">
<script language='javascript'>
check_eula = function()
{
    if( document.getElementById( 'licence_box' ).checked == true )
    {
        return true;
    }
    else
    {
        alert( 'Для продолжения установки необходми согласиться с условиями лицензии.' );
        return false;
    }
}
document.getElementById( 'licence_form' ).onsubmit = check_eula;
</script>

                   <div class="headerGray">
                        <div class="headerGrayL"></div>
                        <div class="headerGrayR"></div>
                        <div class="headerGrayBg">Лицензионное соглашение.</div>
                    </div>
                    <div class="borderL">
                        <div class="borderR">
                           <table>
                                <tr>
                                    <td align=left>
                                       <div style="height: 300px; border: 1px solid #76774C; background-color: #FDFDD3; padding: 5px; overflow: auto;">
<b>Предмет лицензионного соглашения.</b>
<br /><br />
В рамках данного лицензионного соглашения покупатель (далее Заказчик) программного обеспечения LogicBoard (далее Система) получает право на однократную установку Системы только на один URL адрес сайта (далее Адрес), указанный при заказе.<br />
Исключительные права на Систему остаются у физического лица Курдина Никиты Игоревича. (далее Исполнитель).
<br /><br />
<b>Права и обязанности сторон.</b>
<br /><br />
<b>Вы имеете право:</b><br />
- Изменять дизайн и структуру программного продукта, в соответствии с нуждами вашего сайта, но не нарушая других условий данного соглашения.<br />
- Разрабатывать и распространять инструкции по созданным вами модификациям, стилям и другим дополнительным компонентам к Системе, но в них должно указываться на настоящего разработчика Системы до ваших модификаций, т.е. на Исполнителя. Модификации, произведенные вами самостоятельно, не являются собственностью Исполнителя, если не содержат исходный код Системы.<br />
- Создавать модули, код которых будет взаимодействовать с Системой, указав, что это ваш оригинальный продукт.
<br /><br />
<b>Вы не имеете право:</b>
<br /><br />
- Передавать права на использование Системы третьим лицам, кроме случаев перечисленных выше.<br />
- Изменять структуру исходного кода, функции программы или создавать собственные продукты, базирующиеся на исходном коде Системы, либо использовать Систему вне вашего сайта.<br />
- Изменять или удалять любые упоминания об авторских правах (copyrights) в Системе, указываемые в нижней части каждой страницы форума (кроме случаев, когда вы приобрели разрешение на удаление этих строк), а также указанные в верхней части исходного кода каждого файла.<br />
- Распространять или содействовать распространению индивидуальных копии файлов, библиотек и другого исходного кода Системы.<br />
- Модифицировать Систему для работы одного комплекта исходных файлов сразу на нескольких Адресах (URL, доменах, поддоменах, и т.д.). Для каждого форума требуется отдельная лицензия.<br />
<br /><br />
<b>Ограничение гарантийных обязательств.</b>
<br /><br />
Несмотря на то, что мы прилагаем максимум усилий на обеспечение безопасности Системы, мы не может гарантировать абсолютную защиту вашего сайта или форума от хакеров (взломов). Также наша гарантия и техническая поддержка не распространяются на модификации, произведенные третьей стороной, включая изменения программного кода, стиля, а также на изменения перечисленных частей, внесенные владельцем лицензии самостоятельно. Если программный продукт изменен Вами или третьей стороной, то мы вправе отказать Вам в технической поддержке. Вы должны быть ознакомлены, что программный продукт Система не подлежит возврату или обмену из-за отсутствия гарантий, защищающих программный продукт от копирования.
<br /><br />
<b>Расторжение лицензионного соглашения.</b>
<br /><br />
Данное соглашение расторгается автоматически, если вы нарушаете его условия. После расторжения вы обязуетесь удалить все имеющиеся у вас копии Системы в течение 48 часов. Расторжение лицензионного соглашения лицензии из-за нарушения его условий не приводит к выплатам покупателю за лицензию.
<br /><br />
<b>Содержание.</b>
<br /><br />
Исполнитель оставляет за собой право публиковать списки избранных клиентов своих программных продуктов. Исполнитель оставляет за собой право в любое время изменять условия данного лицензионного соглашения, но данные действия не имеют и не будут иметь обратной силы. Изменения данного договора будут отправлены клиентам по электронной почте. Отсутствие у клиентов письма с уведомлением не является причиной невыполнения изменившихся условий использования наших программных продуктов. Копия данного лицензионного соглашения и его изменения будут доступны на сайте Исполнителя.
<br /><br />
Пакеты стилей и языковые пакеты также защищены договорами, как и наши программные коды, тексты файлов и графика, если вы получили их с нашего сайта.
<br /><br />
<b>Права на интеллектуальную собственность.</b>
<br /><br />
Название <b>LogicBoard</b>, а также входящие в данный продукт скрипты являются собственностью Исполнителя, за исключением случаев, когда для компонента системы применяется другой тип лицензии. Программный продукт защищен законом об авторских правах. Любые публикуемые оригинальные материалы, создаваемые в результате использования нашего скрипта, и связанные с этим права на них, являются собственностью пользователя и защищены законом. Исполнитель не несет никакой ответственности за содержание сайтов, создаваемых пользователем при помощи Системы. 
  
                                       </div>
                                       <div class="clear" style="height:18px;"></div>
                                       <div><input type="checkbox" name="licence" id="licence_box" ><b>Я принимаю данное соглашение</b></div>
                                       <div class="clear" style="height:18px;"></div>
                                       <div><input type="submit" name="step2" value="Продолжить" class="btnGreen" /></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div>
                        <div class="borderBtmR"></div>
                        <div class="borderBtmL"></div>
                        <div class="borderBtm"></div>
                    </div>
<input type="hidden" name="step" value="2" />
</fotm> 
      
HTML;
        
        $control_center->footer();
        
    }
    elseif ($_REQUEST['step'] == 2)
    {          
        $link_speddbar = "Шаг 2. Проверка.";
        $control_center->header("Установка LogicBoard", $link_speddbar);
        
        $status_php = phpversion() < '5.0' ? '<font color=red><b>Нет</b></font>' : '<font color=green><b>Да</b></font>';
        $status_mysql = function_exists('mysql_connect') ? '<font color=green><b>Да</b></font>' : '<font color=red><b>Нет</b></font>';
        $status_zlib = extension_loaded('zlib') ? '<font color=green><b>Да</b></font>' : '<font color=red><b>Нет</b></font>';
        $status_xml = extension_loaded('xml') ? '<font color=green><b>Да</b></font>' : '<font color=red><b>Нет</b></font>';
        
        $important_files = array(
                                '../cache/',
                                '../cache/minify/',
                                '../components/config/',
                                '../logs/',
                                '../uploads/',
                                '../uploads/attachment/'
                                );
          
echo <<<HTML

<form  method="post" name="ustanovka" action="">
                   <div class="headerGray">
                        <div class="headerGrayL"></div>
                        <div class="headerGrayR"></div>
                        <div class="headerGrayBg">Проверка установленных компонентов</div>
                    </div>
                    <div class="borderL">
                        <div class="borderR">
                           <table>
                                <tr>
                                    <td align=left>
                                       <div>
                                       <table class="colorTable">
                                       <tr class="appLine"><td align=left width="300"><h6>Минимальные требования</h6></td><td align=left><h6>Текущее значение</h6></td></tr>
                                       <tr class="appLine dark"><td align=left width="200">PHP 5.0 и выше</td><td align=left>{$status_php}</td></tr>
                                       <tr class="appLine"><td align=left width="200">Поддержка MySQL</td><td align=left>{$status_mysql}</td></tr>
                                       <tr class="appLine dark"><td align=left width="200">Поддержка сжатия ZLib</td><td align=left>{$status_zlib}</td></tr>
                                       <tr class="appLine"><td align=left width="200">Поддержка XML</td><td align=left>{$status_xml}</td></tr>
                                       </table>
                                       </div>
                                       <div><font class="smalltext">Если любой из этих пунктов выделен красным, то пожалуйста выполните действия для исправления положения. В случае несоблюдения минимальных требований скрипта возможна его некорректная работа в системе.</font></div>
                                       <div class="clear" style="height:18px;"></div>
                                       <div>
                                       <table class="colorTable">
                                       <tr class="appLine"><td align=left width="220"><h6>Папка</h6></td><td align=left><h6>Текущий CHMOD атрибут</h6></td><td align=left><h6>Нужный CHMOD атрибут</h6></td><td align=left><h6>Статус проверки</h6></td></tr>
                                       
HTML;
                                       
        $chmod_errors = 0;
        $not_found_errors = 0;
        $i = 0;
        foreach($important_files as $file)
        {
            $i ++;
            if ($i%2)
                $class = "appLine";
            else
                $class = "appLine dark";
        
            if(!file_exists($file))
            {
                $file_status = "<font color=red>не найден!</font>";
                $not_found_errors ++;
            }
            //elseif(is_writable($file))
            elseif((@decoct(@fileperms($file)) % 1000) == "777")
            {
                $file_status = "<font color=green>правильно</font>";
            }
            else
            {
                @chmod($file, 0777);
                //if(is_writable($file))
                if((@decoct(@fileperms($file)) % 1000) == "777")
                    $file_status = "<font color=green>правильно</font>";
                else
                    @chmod($file, 0755);
                    
                //if(is_writable($file))
                if((@decoct(@fileperms($file)) % 1000) == "777")
                    $file_status = "<font color=green>правильно</font>";
                else
                {
                    $file_status = "<font color=red>ошибка</font>";
                    $chmod_errors ++;
                }
            }
            
            $chmod_value = @decoct(@fileperms($file)) % 1000;
            
            echo "<tr class=\"".$class."\"><td align=left width=\"200\">".$file."</td><td align=left>".$chmod_value."</td><td align=left>777</td><td align=left>".$file_status."</td></tr>";
            
        }
        
echo <<<HTML

                                       </table>
                                       </div>
 
HTML;
         
$status_report = "";
                                    
if($chmod_errors == 0 and $not_found_errors == 0)
    $status_report = "Проверка успешно завершена! Можете продолжить установку!";
else
{
    if($chmod_errors > 0)
        $status_report .= "<font color=red><b>Внимание!</b></font><br />Во время проверки обнаружены ошибки: <b>".$chmod_errors."</b>. Запрещена запись в файл.<br />Вы должны выставить для папок CHMOD 777, используя ФТП-клиент.<br /><font color=red><b>Настоятельно не рекомендуется</b></font> продолжать установку, пока не будут произведены изменения.";
    if($not_found_errors > 0)
        $status_report .= "<font color=red><b>Внимание!</b></font><br />Во время проверки обнаружены ошибки: <b>".$not_found_errors."</b>. Файлы не найдены!<br /><font color=red><b>Обязательно загрузите указанные файлы.</b></font>";
}

echo <<<HTML
                                        <div class="clear" style="height:18px;"></div>
                                        <div>{$status_report}</div>
                                       <div class="clear" style="height:18px;"></div>
                                       <div><input type="submit" name="step3" value="Продолжить" class="btnGreen" /></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div>
                        <div class="borderBtmR"></div>
                        <div class="borderBtmL"></div>
                        <div class="borderBtm"></div>
                    </div>
<input type="hidden" name="step" value="3" />
</fotm> 
      
HTML;
        
        $control_center->footer();
        
    }
    elseif ($_REQUEST['step'] == 3)
    {
        $link_speddbar = "<a href=\"index.php\">Установка</a>|Шаг 3. Настройка.";
        $control_center->header("Установка LogicBoard", $link_speddbar);
              
        if ($_SERVER['HTTP_REFERER'])
        {
            $url = preg_replace( "#install/index.php#", "", $_SERVER['HTTP_REFERER']);
            $url = preg_replace( "#\?(.*)#", "", $url);
        }
        else
        {
            $url = "http://".$_SERVER['HTTP_HOST'];
            $url .= preg_replace( "#install(.*)#", "", $_SERVER['REQUEST_URI']);
        }
        
echo <<<HTML

<form  method="post" name="ustanovka" action="">

                   <div class="headerGray">
                        <div class="headerGrayL"></div>
                        <div class="headerGrayR"></div>
                        <div class="headerGrayBg">Настройка важных параметров</div>
                    </div>
                    <div class="borderL">
                        <div class="borderR">
                           <table>
                                <tr>
                                    <td align=left>
                                        <div>
                                            <div><h6>Данные для доступа к базе данных сайта на CMS DLE</h6></div>
                                        </div>
                                        <div class="clear" style="height:18px;"></div>
                                       <div>
                                            <div class="inputCaption2">Сервер MySQL:<br><font class="smalltext">Обычно: localhost</font></div>
                                            <div><input type="text" name="host" value="localhost" class="inputText" /></div>
                                        </div>
                                        <div class="clear" style="height:18px;"></div>
                                       <div>
                                            <div class="inputCaption2">Имя базы данных:</div>
                                            <div><input type="text" name="db_name" class="inputText" /></div>
                                        </div>
                                        <div class="clear" style="height:18px;"></div>
                                       <div>
                                            <div class="inputCaption2">Имя пользователя:</div>
                                            <div><input type="text" name="db_user_name" class="inputText" /></div>
                                        </div>
                                        <div class="clear" style="height:18px;"></div>
                                       <div>
                                            <div class="inputCaption2">Пароль:</div>
                                            <div><input type="text" name="db_pass" class="inputText" /></div>
                                        </div>
                                        <div class="clear" style="height:18px;"></div>
                                       <div>
                                            <div class="inputCaption2">Префикс:<br><font class="smalltext">Не изменяйте параметр, если не знаете его предназначение</font></div>
                                            <div><input type="text" name="db_pref" value="LB" class="inputText" /></div>
                                        </div>
                                        <div class="clear" style="height:18px;"></div>
                                       <div>
                                            <div class="inputCaption2">Префикс таблиц CMS DLE:<br><font class="smalltext">Не изменяйте параметр, если не знаете его предназначение</font></div>
                                            <div><input type="text" name="db_pref_dle" value="dle" class="inputText" /></div>
                                        </div>
                                        <div class="clear" style="height:18px;"></div>
                                       <div>
                                            <div class="inputCaption2">Префикс таблицы пользователей CMS DLE:<br><font class="smalltext">Не изменяйте параметр, если не знаете его предназначение</font></div>
                                            <div><input type="text" name="db_pref_userdle" value="dle" class="inputText" /></div>
                                        </div>
                                        <div class="clear" style="height:18px;"></div>
                                       <div>
                                            <div><h6>Настройки форума</h6></div>
                                        </div>
                                        <div class="clear" style="height:18px;"></div>
                                       <div>
                                            <div class="inputCaption2">Название форума:<br><font class="smalltext">Название форума будет использоваться в заголовке браузера, заголовке сообщений и страниц</font></div>
                                            <div><input type="text" name="general_name" value="LogicBoard" class="inputText" /></div>
                                        </div>
                                        <div class="clear" style="height:18px;"></div>
                                       <div>
                                            <div class="inputCaption2">Адрес форума:<br><font class="smalltext">Укажите путь без имени файла, знак слеша <b>/</b> на конце обязателен</font></div>
                                            <div><input type="text" name="url_forum" value="{$url}" class="inputText" /></div>
                                        </div>  
                                        <div class="clear" style="height:18px;"></div>
                                       <div>
                                            <div class="inputCaption2">Адрес сайта:<br><font class="smalltext">Адрес сайта на CMS DLE.<br />Укажите путь без имени файла, знак слеша <b>/</b> на конце обязателен</font></div>
                                            <div><input type="text" name="url_site" value="" class="inputText" /></div>
                                        </div>  
                                        <div class="clear" style="height:18px;"></div>
                                       <div>
                                            <div class="inputCaption2">Файл админпанели:<br><font class="smalltext">Укажите название файла админпанели CMS DLE.</font></div>
                                            <div><input type="text" name="url_adminsite" value="admin.php" class="inputText" /></div>
                                        </div> 
                                        <div class="clear" style="height:18px;"></div>
                                       <div>
                                            <div class="inputCaption2">E-Mail:<br><font class="smalltext">Укажите E-Mail администратора.</font></div>
                                            <div><input type="text" name="admin_email" class="inputText" /></div>
                                        </div>
                                        <div class="clear" style="height:18px;"></div>
                                       <div>
                                            <div class="inputCaption2">Включить ЧПУ:<br><font class="smalltext">Веб-адреса, удобные для восприятия человеком.<br />Пример: http://site.ru/forum/category/topic-1.html</font></div>
                                            <div><select name="general_rewrite_url"><option value="1" selected>Да</option><option value="0">Нет</option></select></div>
                                        </div>
                                        <div class="clear" style="height:18px;"></div>
                                       <div>
                                            <div class="inputCaption2">Кодировка:<br><font class="smalltext">Укажите кодировку форума.</font></div>
                                            <div><select name="general_coding"><option value="windows-1251" selected>windows-1251</option><option value="utf-8">UTF-8</option></select></div>
                                        </div>      
                                       <div class="clear" style="height:18px;"></div>
                                       <div><input type="submit" name="step4" value="Продолжить" class="btnGreen" /></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div>
                        <div class="borderBtmR"></div>
                        <div class="borderBtmL"></div>
                        <div class="borderBtm"></div>
                    </div>
<input type="hidden" name="step" value="4" />
</fotm> 
      
HTML;
        
        $control_center->footer();
        
    }
    elseif ($_REQUEST['step'] == 4)
    {
        $link_speddbar = "<a href=\"index.php\">Установка</a>|Шаг 4. Создание форума.";
        $control_center->header("Установка LogicBoard", $link_speddbar);
        
        function utf8_strlen($word, $charset = "cp1251")
        {
            if (strtolower($charset) == "utf-8")
                return mb_strlen($word, "utf-8");
        	else
                return strlen($word);
        }
                
        $time = time();
        $member_sk = md5(md5(time().$_SERVER['REMOTE_ADDR']));
        $email = trim( strtolower( $_POST['admin_email'] ) );
        
        $url_forum = strip_tags($_POST['url_forum']);
        $url_site = strip_tags($_POST['url_site']);
        $url_adminsite = strip_tags($_POST['url_adminsite']);
        
        $general_name = addslashes(strip_tags(trim($_POST['general_name'])));
        if (!$general_name)
            $general_name = "LogicBoard";
            
        $general_rewrite_url = intval($_POST['general_rewrite_url']);
        
        if (!$url_adminsite)
            $control_center->errors[] = "Вы не указали файл админпанели.";
        
        if(!preg_match("#http://#i", $url_forum))
			$control_center->errors[] = "Неверно указан адрес форума.";
            
        if (preg_match("#[\||\'|\"|\!|\$|\@|\~\*\+|<|>|=]#", $url_forum))
            $control_center->errors[] = "В адресе форума использованы запрещённые символы.";
            
        if(!preg_match("#http://#i", $url_site))
			$control_center->errors[] = "Неверно указан адрес сайта.";
            
        if (preg_match("#[\||\'|\"|\!|\$|\@|\~\*\+|<|>|=]#", $url_site))
            $control_center->errors[] = "В адресе сайта использованы запрещённые символы.";
            
        if( !preg_match('/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])'.'(([a-z0-9-])*([a-z0-9]))+' . '(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i', $email) or empty( $email ) )
			$control_center->errors[] = "Вы не заполнили поле E-mail или заполнили не верно.";
            
        if(substr($url_forum, -1) != "/")
            $url_forum .= "/";
            
        if(substr($url_site, -1) != "/")
            $url_site .= "/";
            
        $mysql_host = $_POST['host'];
        $mysql_name = $_POST['db_name'];
        $mysql_user = $_POST['db_user_name'];
        $mysql_password = $_POST['db_pass'];
        $mysql_pref = $_POST['db_pref'];
        $mysql_pref_dle = $_POST['db_pref_dle'];
        $mysql_pref_userdle = $_POST['db_pref_userdle'];
        
        if ($_POST['general_coding'] == "utf-8")
            $coding_forum = "utf8";
        else
            $coding_forum = "cp1251";
        
        if (!$mysql_pref)
            $mysql_pref = "LB";
   
        if ( extension_loaded('mysqli') AND version_compare("5.0.5", phpversion(), "!=") )
        {       
            if(!@mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_name))
                $control_center->errors[] = "Не удалось подключиться к базе данных.";
        }
        else
        {
            if(!@mysql_connect($mysql_host, $mysql_user, $mysql_password))
                $control_center->errors[] = "Не удалось подключиться к базе данных.";
            else
            {
                if (!@mysql_select_db($mysql_name))
                    $control_center->errors[] = "Указанная база данных не найдена.";
            }
        }

            
        if (!$control_center->errors)
        {
            
$dbconfig = <<<HTML
<?php

if (! defined ( 'LogicBoard' ))
{
	@include '../../logs/save_log.php';
	exit ( "Error, wrong way to file.<br><a href=\"/\">Go to main</a>." );
}

define ("LB_DB_HOST", "{$mysql_host}"); 

define ("LB_DB_NAME", "{$mysql_name}");

define ("LB_DB_USER", "{$mysql_user}");

define ("LB_DB_PASS", "{$mysql_password}");  

define ("LB_DB_PREFIX", "{$mysql_pref}"); 

define ("DLE_PREFIX", "{$mysql_pref_dle}");

define ("DLE_USER_PREFIX", "{$mysql_pref_userdle}"); 

define ("LB_DB_COLLATE", "{$coding_forum}"); 

\$DB = new DB;
 
?>
HTML;

            $con_file = fopen(LB_CONFIG . '/board_db.php', 'w+') or die("Извините, но невозможно создать файл <b>components/config/board_db.php</b>.<br />Проверьте CHMOD атрибут файла!");
            fwrite($con_file, $dbconfig);
            fclose($con_file);
            @chmod(LB_CONFIG . '/board_db.php', 0666);
            
            $cache_config['security_mysql']['conf_value'] = $_SERVER['REMOTE_ADDR'];
            
            if ($coding_forum == "utf8")
            {
                include  LB_MAIN . '/install/install_db_utf-8.php';
echo <<<HTML

                   <div class="headerGray">
                        <div class="headerGrayL"></div>
                        <div class="headerGrayR"></div>
                        <div class="headerGrayBg">UTF-8 версия</div>
                    </div>
                    <div class="borderL">
                        <div class="borderR">
                           <table>
                                <tr>
                                    <td align=left>
                                       <div>
                                            Вы выбрали кодировку <b>utf-8</b>. Вам необходимо внести изменения в один файл скрипта.<br /><br />
                                            <b>Инструкция:</b><br /><br />
                                            1) Откройте файл <b>/components/scripts/ajax/savetext.php</b> и замените строку:<br />
                                            \$LB_charset = "windows-1251";<br /><br />
                                            На:<br />
                                            \$LB_charset = "utf-8";<br /><br />
                                            
                                            2) Откройте файл <b>/language/Russian/board/scripts.js</b> и смените кодировку на UTF-8:<br /><br />
                                            Более подробную инструкцию по смене кодировки форума Вы можете прочитать <a href="http://logicboard.ru/support/cat-faq/topic-196.html" target="_blank">здесь</a>.<br />
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div>
                        <div class="borderBtmR"></div>
                        <div class="borderBtmL"></div>
                        <div class="borderBtm"></div>
                    </div>
                    <div class="clear" style="height:10px;"></div>
HTML;
            }
            else
                include  LB_MAIN . '/install/install_db.php';
            
echo <<<HTML

                   <div class="headerGray">
                        <div class="headerGrayL"></div>
                        <div class="headerGrayR"></div>
                        <div class="headerGrayBg">Создание форума</div>
                    </div>
                    <div class="borderL">
                        <div class="borderR">
                           <table>
                                <tr>
                                    <td align=left>
                                       <div>
                                            Поздравляем с успешной установкой форума LogicBoard!<br />
                                            Теперь вы можете перейти к просмотру и дальнейшей настройке форума.<br /><br />
                                            <b><font color=red>Внимание!</font></b> Обязательно удалите папку <b>upgrade</b> и <b>install</b> с вашего сервера!<br />
                                        </div>
                                       <div class="clear" style="height:18px;"></div>
                                       <div><a href="#" onclick="javascript:self.close();">Закрыть окно</a> или перейти на <a href="{$url_forum}">форум</a>.</div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div>
                        <div class="borderBtmR"></div>
                        <div class="borderBtmL"></div>
                        <div class="borderBtm"></div>
                    </div>
      
HTML;

        }
        else
        {
            $control_center->errors[] = "<a href=\"index.php?step=3\">Вернуться назад.</a>";
            $control_center->errors_title = "Ошибка!";
        }
            
        $control_center->message();
        
        $control_center->footer();
        
    }
    else
    {
        $link_speddbar = "Описание.";
        $control_center->header("Установка LogicBoard", $link_speddbar);
        
echo <<<HTML

<form  method="post" name="filters" action="">
                   <div class="headerGray">
                        <div class="headerGrayL"></div>
                        <div class="headerGrayR"></div>
                        <div class="headerGrayBg">Описание.</div>
                    </div>
                    <div class="borderL">
                        <div class="borderR">
                           <table>
                                <tr>
                                    <td align=left>
                                       Добро пожаловать в мастер установки LogicBoard.<br /><br />
                                       Во время установки будет создана структура базы данных, создана учётная запись администратора, а так же созданы некоторые важные настройки форума.<br />
                                       Если вы ещё не читали инструкцию по установке форума - прочитайте её сейчас, она находится в папке <b>Documentation</b> в дистрибутиве форума.<br />
                                       <br />
                                       <a href="index.php?step=1">Начать установку.</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div>
                        <div class="borderBtmR"></div>
                        <div class="borderBtmL"></div>
                        <div class="borderBtm"></div>
                    </div>
</fotm> 
      
HTML;
        
        $control_center->footer();
    }
}

exit();

?>