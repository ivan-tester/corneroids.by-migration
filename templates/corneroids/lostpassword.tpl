<link rel="stylesheet" href="{THEME}/css/validationEngine.jquery.css" type="text/css" />
<script src="{THEME}/js/jquery.validationEngine.js" type="text/javascript"></script>
<div class="tlf2">Восстановление забытого пароля</div>
<div class="allcf"><div class="incf">
<div class="specform">
<div class="regix">
Ваш логин или E-Mail:
<div class="subreg" style="padding-bottom:10px;">Введите логин, или адрес почты, указанные Вами при регистрации</div>
<input type="text" name="lostname" class="validate[required] text-input" />
</div>
[sec_code]
<div class="regix">
Код безопасности:
<div class="subreg" style="padding-bottom:10px;">Введите символы, которые видите на картинке</div>
{code}<br /><br />
<input type="text" name="sec_code" style="width:120px" class="validate[required] text-input" />
</div>
[/sec_code]
[recaptcha]
<tr>
<td colspan="2" height="25"><strong>Введите два слова, показанных на изображении:</strong></td>
</tr>
<tr>
<td colspan="2" height="25">{recaptcha}</td>
</tr>
[/recaptcha]
</div>
<input type="submit" name="submit" class="but" value="Отправить" />
<div class="clear"> </div></div></div><div class="botf"> </div>