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

define ( 'LogicBoard', true );
define ( 'LogicBoard_Install', true );
define ( 'LB_MAIN', realpath("../") );
define ( 'LB_CONFIG', LB_MAIN . '/components/config' );
define ( 'LB_CLASS', LB_MAIN . '/components/class' );
define ( 'LB_GLOBAL', LB_MAIN . '/components/global' );

$cache_config['security_mysql']['conf_value'] = $_SERVER['REMOTE_ADDR'];

require_once LB_CLASS . '/database.php';
include_once LB_CONFIG . '/board_db.php';

require LB_CLASS . '/cache.php';
require LB_GLOBAL . '/creat_cache.php';

$version = $DB->one_select("vid", "history_update", "", "ORDER BY vid DESC");

require LB_MAIN . '/upgrade/template.class.php';
$control_center = new Сontrol_Сenter ( );

    $control_center->errors = array ();
    
    if ($_REQUEST['step'] == 1)
    {          
        $link_speddbar = "Шаг 2. Проверка.";
        $control_center->header("Обновление LogicBoard", $link_speddbar);
                
        $important_files = array(
                                '../cache/',
                                '../cache/minify/',
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
            elseif((@decoct(@fileperms($file)) % 1000) == "777")
            {
                $file_status = "<font color=green>правильно</font>";
            }
            else
            {
                @chmod($file, 0777);
                if((@decoct(@fileperms($file)) % 1000) == "777")
                    $file_status = "<font color=green>правильно</font>";
                else
                    @chmod($file, 0755);
                    
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
    $status_report = "Проверка успешно завершена! Можете продолжить обновление!";
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
</form> 
HTML;
        
        $control_center->footer();
        
    }
    elseif ($_REQUEST['step'] == 2)
    {        
        if ($version['vid'] == "2.0")
        {
            $link_speddbar = "Обновление с 2.0 на 2.1.";
            $control_center->header("Обновление LogicBoard 2.0", $link_speddbar);
        } 
        elseif ($version['vid'] == "2.1")
        {
            $link_speddbar = "Обновление с 2.1 на 2.2.";
            $control_center->header("Обновление LogicBoard 2.1", $link_speddbar);
        } 
        
        if ($cache_config['general_coding']['conf_value'] == "utf-8")
            $coding_forum = "utf8";
        else
            $coding_forum = "cp1251";
        
        if ($version['vid'] == "2.0")
            include  LB_MAIN . '/upgrade/install_db21_'.$coding_forum.'.php';
        elseif ($version['vid'] == "2.1")
            include  LB_MAIN . '/upgrade/install_db22_'.$coding_forum.'.php';
        else
            exit ("Error!");
        
        $cache->clear();
        $cache->clear("statistics", "stats_users");
        $cache->clear("template");
        $cache->clear("minify");
        $cache->clear("dle_modules");
        
        if ($version['vid'] < "2.1")
        {
             header( "Location: /upgrade/index.php" );
             exit();
        }
                    
echo <<<HTML

                   <div class="headerGray">
                        <div class="headerGrayL"></div>
                        <div class="headerGrayR"></div>
                        <div class="headerGrayBg">Обновление форума</div>
                    </div>
                    <div class="borderL">
                        <div class="borderR">
                           <table>
                                <tr>
                                    <td align=left>
                                       <div>
                                            Поздравляем с успешным обновлением форума LogicBoard!<br />
                                            <b><font color=red>Внимание!</font></b> Обязательно удалите папку <b>upgrade</b> и <b>install</b> с вашего сервера!<br />
                                        </div>
                                       <div class="clear" style="height:18px;"></div>
                                       <div><a href="#" onclick="javascript:self.close();">Закрыть окно</a>.</div>
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
        
        $control_center->footer(); 
    }
    else
    {
        $link_speddbar = "Описание.";
        
        if ($version['vid'] == "2.0")
        {
            $control_center->header("Обновление LogicBoard 2.1", $link_speddbar);
            $version_new = "2.1";
        }
        elseif ($version['vid'] == "2.1")
        {
            $control_center->header("Обновление LogicBoard 2.2", $link_speddbar);
            $version_new = "2.2";
        }
        else
        {
            $control_center->header("Обновление LogicBoard 2.2", $link_speddbar);
            $version_new = "2.2";
        }
            
        if ($version['vid'] == "2.2")
        {
            
echo <<<HTML
            <div class="headerRed">
                        <div class="headerRedArr"><div></div></div>
                        <div class="headerRedL"></div>
                        <div class="headerRedR"></div>
                        <div class="headerRedBg">Внимание!</div>
                    </div>
                    <div class="borderL">
                        <div class="borderR"><ul style="text-align:left;"><li>У Вас уже установлена версия 2.2</li></ul></div>
                    </div>
                    <div>
                        <div class="borderBtmR"></div>
                        <div class="borderBtmL"></div>
                        <div class="borderBtm"></div>
                    </div>
                    <div class="clear" style="height:20px;"></div>
HTML;

        }
        
echo <<<HTML

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
                                       Добро пожаловать в мастер обновления LogicBoard.<br /><br />
                                       Данный скрипт предназначен <u>только для обновления</u> форума LogicBoard (DLE Edition) с версии <b>{$version['vid']}</b> на <b>{$version_new}</b><br />
                                       Загрузите все папки и файлы из папки <b>upload</b> дистрибутива LogicBoard (DLE Edition) {$version_new} в папку на сервере, где находится форум.<br /> 
                                       <br />
                                       <a href="index.php?step=1">Начать обновление.</a>
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
        
        $control_center->footer();
    }

exit();

?>