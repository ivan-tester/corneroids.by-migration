<link rel="stylesheet" href="{THEME}/css/validationEngine.jquery.css" type="text/css" />
<script src="{THEME}/js/jquery.validationEngine.js" type="text/javascript"></script>
<div class="tlf2">Обратная связь</div>
<div class="allcf"><div class="incf">
<div class="specform">
[not-logged]
<div class="regix">
Ваше имя:
<div class="subreg">Указывайте настоящее имя. Это облегчит общение с Вами.</div>
<input type="text" name="name" class="validate[required] text-input" />
</div>
<div class="regix">
E-Mail:
<div class="subreg">Указывайте действительный адрес почты, на него придёт ответ.</div>
<input type="text" name="email" class="validate[required,custom[email]] text-input" />
</div>
[/not-logged]
<div class="regix">
Заголовок:
<div class="subreg">Максимально точно сформулируйте тему Вашего обращения.</div>
<input type="text" name="subject" class="validate[required] text-input" />
</div>
<div class="regix">
Получатель:
<div class="subreg">Выберете представителя администрации - получателя Вашего обращения</div>
{recipient}
</div>
<div class="regix">
Сообщение:
<div class="subreg">Письмо не должно нарушать <a href="/rules.html" target="_blank">правила сайта</a> (откроется в новом окне)</div>
<textarea name="message" class="validate[required,length[6,300]] text-input" /> </textarea>
</div>
[question]
			<tr>
				<td class="label">
					Вопрос:
				</td>
				<td>
					<div>{question}</div>
				</td>
			</tr>
			<tr>
				<td class="label">
					Ответ:<span class="impot">*</span>
				</td>
				<td>
					<div><input type="text" name="question_answer" id="question_answer" class="f_input" /></div>
				</td>
			</tr>
[/question]
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
<td>&nbsp;</td>
<td><br />Введите два слова, показанных на изображении:<br />{recaptcha}</td>
</tr>
[/recaptcha]
</div>
<input name="send_btn" type="submit" class="but" value="Отправить" onclick="document.sendform.submit();" style="cursor:hand" /><div class="clear"> </div> 
</div>
</div><div class="botf"> </div>