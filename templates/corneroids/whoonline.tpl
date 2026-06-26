<script type="text/javascript" src="/engine/skins/default.js"></script>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
<style type="text/css">
.online_robot{color:gray;cursor:pointer;margin-right:10px} /*настраиваем цвет поисковых роботов*/
.online_guest{color:blue;cursor:pointer;margin-right:10px}  /*настраиваем цвет гостей*/
.online_user, .online_user:visited, .online_user:hover{color:#C8C4A7;text-decoration:none;margin-right:10px} /*настраиваем цвет посетителей*/
.group_1, .group_1:visited, .group_1:hover{color:red;font-weight:bold}   /*настраиваем цвет группы 1 (админ)*/
.group_2, .group_2:visited, .group_2:hover{color:#8A2BE2} /*настраиваем цвет группы 2 (главный редактор)*/
.group_3, .group_3:visited, .group_3:hover{color:#0BDA51} /*настраиваем цвет группы 3 (журналист)*/
.group_4, .group_3:visited, .group_4:hover{color:#C8C4A7} /*настраиваем цвет группы 4 (обычные юзеры)*/
.group_6, .group_6:visited, .group_6:hover{color:#FFCC33} /*настраиваем цвет группы 6 (VIP)*/
#hintbox{width:170px;position:absolute;top:0;margin:10px 0 0 0;padding:3px 5px;font-size:10px;color:#000;border:1px solid #AAA;background-color:#fff;layer-background-color:#a396d9;visibility:hidden;z-index:1000;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(opacity=80)";filter:progid:DXImageTransform.Microsoft.Alpha(opacity=80);-moz-opacity:0.80;-khtml-opacity:0.80;opacity:0.80;}</style>
<?php
$g = $r = $u = 0;
$robots = $users = $guest = "";
foreach ($this->online as $key=>$val)
{
	if($val['id'] == 2) {$r++; $robots .= "<b class=\"online_robot\" onmouseover=\"showhint('<b>Бот:</b> {$val['name']}<br /><b>Группа:</b> {$val['group']}<br /><b>IP:</b> {$val['ip']}<br />{$val['position']}<br /><b>Был здесь в:</b> ".date("H:i:s", $val['time'])."', this, event, '180px');\">{$val['name']}</b>";}
	elseif($val['id'] == 1) {$u++; 
    if($val['foto']) $foto = "<center><img src=/uploads/fotos/{$val['foto']} /></center>"; else $foto = "<center><img src=/templates/{$this->config['skin']}/images/noavatar.png /></center>";
    if($val['foto']) $foto2 = "<img border=\"1\" bordercolor=\"online_user group_{$val['groupid']}\" src=/uploads/fotos/{$val['foto']} width=39 />"; else $foto2 = "<img border=\"1\" bordercolor=\"online_user group_{$val['groupid']}\" src=/templates/{$this->config['skin']}/images/noavatar.png width=38 />"; 
    if($this->config["allow_alt_url"]!="no") $profile = "/user/".urlencode($val['name'])."/"; else $profile = "/?subaction=userinfo&user=".urlencode($val['name']); $popup = "onclick=\"ShowProfile('".urlencode($val['name'])."', '".htmlspecialchars($profile)."'); return false;\""; $users .= "<a {$popup} class=\"online_user group_{$val['groupid']}\" onmouseover=\"showhint('$foto <b>Ник:</b> {$val['name']}<br /><b>Группа:</b> {$val['group']}<br /><b>ОС:</b> {$val['os']}<br /><b>Браузер:</b> {$val['browser']}<br />{$val['position']}<br /><b>Был здесь в:</b> ".date("H:i:s", $val['time'])."', this, event, '180px');\" href=\"$profile\">$foto2</a>";}
	elseif ($val['id'] == 0) {$g++; $foto3 = "<img src=/templates/{$this->config['skin']}/images/noavatar.png width=40 />"; $guest .= "<b class=\"online_guest\" onmouseover=\"showhint('<b>Группа:</b> {$val['group']}<br /><b>IP:</b> {$val['ip']}<br /><b>ОС:</b> {$val['os']}<br /><b>Браузер:</b> {$val['browser']}<br />{$val['position']}<br /><b>Был здесь в:</b> ".date("H:i:s", $val['time'])."', this, event, '180px');\">$foto3</b>";}
}
?>
<div class="whoonline">
<table border="0" width="100%">
  <tr>
    <td><b>Юзеры</b></td>
    <td><b> (<?php echo $u; ?>):</b></td>
  </tr>
  <tr>
    <td colspan="2"><div style="width:210px"><?php echo $users; ?></div></td>
  </tr>
  <tr>
    <td><b>Гости</b></td>
    <td><b> (<?php echo $g; ?>):</b></td>
  </tr>
   <tr>
    <td colspan="2"><div style="width:210px"><?php echo $guest; ?></div></td>
  </tr> 
  <tr>
    <td><b>Боты</b></td>
    <td><b> (<?php echo $r; ?>):</b></td>
  </tr>

<tr>
    <td colspan="2"><div style="width:210px"><?php echo $robots; ?></div></td>
</tr>

  <tr>
    <td colspan="2"><b>Всего на сайте:</b> <?php echo $u+$g+$r; ?></td>
  </tr>
</table>
</div>