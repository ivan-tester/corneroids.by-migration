<link rel="stylesheet" href="{THEME}/css/validationEngine.jquery.css" type="text/css" />
<script src="{THEME}/js/jquery.validationEngine.js" type="text/javascript"></script>
<div class="tlf2">[registration]Регистрация нового пользователя[/registration][validation]Обновление профиля пользователя[/validation]</div>
<div class="allcf"><div class="incf">
[registration] 
<script type="text/javascript">get_capcha();</script>
          
<div class="specform">        
<strong>Здравствуйте, уважаемый посетитель!</strong><br />
            <br />
          Регистрация на нашем сайте позволит Вам быть его полноценным участником. <br />Вы сможете добавлять новости на сайт, создавать новости и скачивать файлы, просматривать скрытый текст,<br /> Вы станете полноправным членом нашего общества и многое другое.<br />
          <br />
          В случае возникновения проблем с регистрацией, обратитесь к администрации сайта.<br />
          <br />
<div class="regix">
Логин (имя пользователя):
<div class="subreg">от 3 до 15 символов соответствующий правилам сайта</div>
<input type="text" name="name" id='name' class="validate[required,custom[noSpecialCaracters],length[3,15]]" onBlur="CheckLogin(); return false;" />
      <div id='result-registration'></div>
</div>
<div class="regix">
Пароль:
<div class="subreg">от 6 до 32 символов. Только латиница и цифры без пробелов</div>
<input class="validate[required,length[6,32]] text-input" id="password1" name="password1" type="password" /><br /><br />
Повторите пароль:<br />
<input  class="validate[required,confirm[password1]] text-input" id="password2" name="password2" type="password" />
</div>
<div class="regix">
Ваш E-Mail:
<div class="subreg">
<font color="red">Внимание! </font>Вводите реально действующий адрес email.
</div>
<input type="text" name="email" class="validate[required,custom[email]] text-input" id="email" />
</div>
[question]
  <div class="regix">Вопрос: {question}<br />
<input type="text" name="question_answer" id="question_answer" class="f_input" />
</div>
[/question]
[sec_code]
  <div class="regix">
Код безопасности:
<div class="subreg" style="padding-bottom:10px;">Введите код с картинки</div>
{reg_code}<br /><br />
<input type="text" name="sec_code" class="validate[required] text-input" style="width:120px;" />
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
      <input  type="submit" name="submit" class="but" value="Отправить" />
<div class="clear"> </div>
<noscript>
<div class="hinfo">
<div><span style="color:#FF0000;">Внимание!</span> Для продолжения регистрации включите <b>JavaScript</b>.  <img src="{THEME}/images/bomb.gif"><br /></div>
</div>
</noscript>
[/registration]

[validation]
<strong>Уважаемый посетитель!</strong><br />
        <br />
      Ваш аккаунт был зарегистрирован на нашем сайте, однако информация о Вас является неполной, поэтому заполните дополнительные поля в Вашем профиле.<br />
      <br />
<div class="regix">
Ваше Имя:
<div class="subreg">Желательно вводить настоящее имя</div>
<input type="text" name="fullname" class="plog" />
</div>
<div class="regix">
Место жительства:
<div class="subreg">Страна / Город</div>
<input type="text" name="land" class="plog" />
</div>
<div class="regix">
Номер ICQ:
<div class="subreg">Облегчает связь с Вами</div>
<input type="text" name="icq" class="plog" />
</div>
<div class="regix">
Фото:
<div class="subreg">Ваша фотография, или аватар</div>
<input type="file" name="image" style="width:280px; height:18px" class="plog" />
</div>
<div class="regix">
О себе:
<div class="subreg">Ваш профессиональный статус, увлечения и т.д.</div>
<textarea name="info" class="comments" /></textarea>
</div>
{xfields}
<input  type="submit" name="submit" class="but" value="Отправить" /><div class="clear"> </div>
[/validation]
</div>
</div><div class="botf"> </div>