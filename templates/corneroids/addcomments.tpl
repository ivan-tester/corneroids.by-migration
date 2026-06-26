<link rel="stylesheet" href="{THEME}/css/validationEngine.jquery.css" type="text/css" />
<script src="{THEME}/js/jquery.validationEngine.js" type="text/javascript"></script>
<div class="tlf2">Написать комментарий</div>
<div class="allcf"><div class="incf">
<noscript>
<div class="hinfo">
<div><span style="color:#FF0000;">Внимание!</span> Для добавления комментария включите <b>JavaScript</b>.  <img src="{THEME}/images/bomb.gif"><br /></div>
</div>
</noscript> 
<script type="text/javascript">get_capcha();</script>[not-logged]<!--<div class="specform"> Ваше Имя:<br /><input type="text" name="name" id="name" class="validate[required] text-input" /><br /><br />
Ваш E-Mail:<br /><input type="text" name="mail" id="mail" class="validate[required,custom[email]] text-input" /><br />
<br />></div>-->Зарегистрируйтесь для возможности оставлять комментарии![/not-logged] [not-group=5]{editor}
<br />
[question]
Вопрос: {question}<br />
Ответ:<span class="impot">*</span><br />
<input type="text" name="question_answer" id="question_answer" class="f_input" /></div>
<br />
[/question]
[sec_code] 
Код:<br />{sec_code}<br /><br />Введите код:<br />
<div class="specform">
<input type="text" name="sec_code" id="sec_code" class="validate[required] text-input" style="width:120px;" />
</div>
<br />
[/sec_code] 
[recaptcha]
<tr>
<td colspan="2" height="25"><strong>Введите два слова, показанных на изображении:</strong></td>
</tr>
<tr>
<td colspan="2" height="25">{recaptcha}</td>
</tr><br />
[/recaptcha]<input onclick="doAddComments();return false;" name="submit" type="submit" class="but" value="Отправить" /><div class="clear"> </div>
</div></div><div class="botf"> </div>[/not-group]