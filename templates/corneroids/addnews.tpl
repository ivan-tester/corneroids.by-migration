<link rel="stylesheet" href="{THEME}/css/validationEngine.jquery.css" type="text/css" />
<script src="{THEME}/js/jquery.validationEngine.js" type="text/javascript"></script>
<div class="tlf2">Публикация новости на сайте</div>
<div class="allcf"><div class="incf" style="line-height:18px;">
<div class="specform">
<div class="regix">Введите заголовок:
<div class="subreg">Впишите в поле заголовок Вашей публикации. Не более 150 символов.</div>
<input type="text" name="title" value="{title}" maxlength="150" style="width:300px;" class="validate[required] text-input" /></div>
                      [urltag]
<div class="regix">URL статьи:
<div class="subreg">Впишите в поле желаемый вид ссылки на публикацию (необязательно).</div>
<input type="text" name="alt_name" value="{alt-name}" maxlength="150" class="plog" /></div>
                      [/urltag]
<div class="regix">Категория:
<div class="subreg">Выберете из списка одну, или несколько категорий для новости.</div>
{category}</div>
<div class="regix">Краткое содержание:
<div class="subreg">Часть новости, публикуемая на главной странице. Публикация должна соответствовать правилам сайта!</div>
                      [not-wysywyg]
{bbcode}
                     [/not-wysywyg]
                     [not-wysywyg]
        <textarea name="short_story" id="short_story" onclick="setFieldName(this.name)" style="width:603px; height:200px; background:#fff; border:1px solid #bcc9d2;">{short-story}</textarea>
      [/not-wysywyg]{shortarea}
</div>
<div class="regix">Полная новость: (необязательно)
<div class="subreg">Полная версия публикации. Новость должна соответствовать правилам сайта!</div>
[not-wysywyg]
        <textarea name="full_story" id="full_story" onclick="setFieldName(this.name)" style="width:603px; height:200px; background:#fff; border:1px solid #bcc9d2;">{full-story}</textarea>
      [/not-wysywyg]{fullarea}
</div>
<div class="regix">Теги:
<div class="subreg">Ключевые слова для облака тегов (не более 5, разделитель - запятая).</div>
<input type="text" name="tags" value="{tags}" maxlength="150" class="plog" /></div>
</div>
<div class="regix">Дополнительно:
<div class="subreg">Дополнительные поля и настройки публикации</div>
<div class="ssc2">
<div class="specform"><table>{xfields}</table></div>
{admintag}
</div></div>
<div class="specform">
[question]
  <div class="regix">Вопрос: {question}<br />
<input type="text" name="question_answer" id="question_answer" class="f_input" /></div>

[/question]
[sec_code]
  <div class="regix">
Код безопасности:
<div class="subreg" style="padding-bottom:10px;">Введите код с картинки</div>
{sec_code}<br /><br />
<input type="text" name="sec_code" class="validate[required] text-input" style="width:120px" />
</div> [/sec_code]
[recaptcha]
<tr>
<td>&nbsp;</td>
<td><br />Введите два слова, показанных на изображении:<br />{recaptcha}</td>
</tr>
[/recaptcha]
 </div>

<input type="submit" name="add" class="but" value="Отправить" /> <input type="button" name="nview" class="but" onclick="preview()" value="Просмотр" />
<div class="clear"> </div></div></div><div class="botf"> </div>