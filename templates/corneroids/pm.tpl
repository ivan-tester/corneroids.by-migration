<b><center><br />[inbox]<img src="{THEME}/img/otp3.png" alt="Входящие сообщения" />[/inbox] &nbsp; [outbox]<img src="{THEME}/img/otp.png" alt="Отправленные сообщения" />[/outbox] &nbsp; [new_pm]<img src="{THEME}/img/otp2.png" alt="Отправить сообщение" />[/new_pm]</center></b>
<br />
[pmlist]
<div class="tlf2">Список сообщений</div>
<div class="pm_status">
	<div class="pm_status_head">Состояние папок</div>
	<div class="pm_status_content">Папки персональных сообщений заполнены на:
{pm-progress-bar}
{proc-pm-limit}% от лимита ({pm-limit} сообщений)
	</div>
</div>
<div class="allcf"><div class="incf" style="line-height:18px;">
{pmlist}
</div></div><div class="botf"> </div>
[/pmlist]
[newpm]
<div class="tlf2">Отправка персонального сообщения</div>
<div class="allcf"><div class="incf" style="line-height:18px;">
Получатель:<br />
<input type="text" name="name" value="{author}" class="plog" /><br /><br />
Тема:<br />
<input type="text" name="subj" value="{subj}" class="plog" /><br /><br />
{editor}<br />
[question]
Вопрос: {question}<br />
<input type="text" name="question_answer" id="question_answer" class="plog" style="width:120px;" /><br />
<br />
[/question]
[sec_code]
Код:<br />
{sec_code}<br /><br />
Введите код:<br />
<input type="text" name="sec_code" id="sec_code" class="plog" style="width:120px;" /><br />
[/sec_code]
[recaptcha]
<tr>
<td colspan="2" height="25"><strong>Введите два слова, показанных на изображении:</strong></td>
</tr>
<tr>
<td colspan="2" height="25">{recaptcha}</td>
</tr>
[/recaptcha]
<div style="line-height:22px; padding-bottom:20px;">
<input type="checkbox" class="styled" name="outboxcopy" value="1" /> Сохранить сообщение в папке &quot;Отправленные&quot;<br / >
</div>
<input type="submit" name="submit" class="but" value="Отправить" /><div class="clear"> </div>
</div></div><div class="botf"> </div>
[/newpm]
[readpm]
<div class="tlf2">{subj}</div>
<div class="allcf"><div class="incf" style="line-height:18px;">
{text}
<div class="regix">
<span class="but" style="padding:5px 7px;">Отправил: <strong>{author}</strong></span> <span class="but" style="padding:5px 7px;">[reply]ответить[/reply]</span> <span class="but" style="padding:5px 7px;">[complaint]пожаловаться[/complaint]</span> <span class="but" style="padding:5px 7px;">[ignore]игнорировать[/ignore]</span> <span class="but" style="padding:5px 7px;">[del]удалить[/del]</span>
<div class="clear"> </div>
</div></div></div><div class="botf"> </div>
[/readpm]