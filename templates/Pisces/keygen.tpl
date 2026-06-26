<form method="post">
<div class="pheading"><h2>Генератор ключей</h2></div>
[if-hash]
<div class="baseform">
	<table class="tableform">
		<tr>
			<td class="label">
				Введите домен:<span class="impot">*</span><br /><font size="-5" color="#666666">Пример:</font> <font size="-5" color="#FF0000">{domain_example}</font>
			</td>
			<td><input type="text" maxlength="35" name="domain" value="{domain}" class="f_input" /></td>
		</tr>
		<tr>
			<td class="label">
				Актуальная версия:<br /><font size="-5">
                <a href="http://dle-news.ru/" target="_blank">http://dle-news.ru/</a></font>
			</td>
			
		</tr>
		<tr>
			<td class="label">
				Версия скрипта:<span class="impot">*</span>
			</td>
			<td>
                <select name="hash_version">
                    <option value="dle000" selected="selected">-- Выберите версию --</option>
                    <option disabled="disabled">-------------------------------</option>
<option value='dle105'>DataLife Engine v.10.5</option>
<option value='dle104'>DataLife Engine v.10.4</option>
                    <option value='dle103'>DataLife Engine v.10.3</option>
                    <option value='dle102'>DataLife Engine v.10.2</option>
                    <option value='dle101'>DataLife Engine v.10.1</option>
                    <option value='dle100'>DataLife Engine v.10.0</option>
                    <option disabled="disabled">-------------------------------</option>
                    <option value='dle098'>DataLife Engine v.9.8</option>
                    <option value='dle097'>DataLife Engine v.9.7</option>
                    <option value='dle096'>DataLife Engine v.9.6</option>
                    <option value='dle095'>DataLife Engine v.9.5</option>
                    <option value='dle094'>DataLife Engine v.9.4</option>
                    <option value='dle093'>DataLife Engine v.9.3</option>
                    <option value='dle092'>DataLife Engine v.9.2</option>
                    <option value='dle090'>DataLife Engine v.9.0</option>
                    <option disabled="disabled">-------------------------------</option>
                    <option value='dle085'>DataLife Engine v.8.5</option>
                    <option value='dle083'>DataLife Engine v.8.3</option>
                    <option value='dle082'>DataLife Engine v.8.2</option>
                    <option value='dle080'>DataLife Engine v.8.0</option>
                    <option disabled="disabled">-------------------------------</option>
                    <option value='dle075'>DataLife Engine v.7.5</option>
                    <option value='dle073'>DataLife Engine v.7.3</option>
                    <option value='dle072'>DataLife Engine v.7.2</option>
                    <option value='dle070'>DataLife Engine v.7.0</option>
                </select>
            </td>
		</tr>
		[sec_code]<tr>
			<td class="label">
				Введите код:<span class="impot">*</span>
			</td>
			<td>
				<div>{code}</div>
				<div><input type="text" maxlength="45" name="sec_code" style="width:155px" class="f_input" /></div>
			</td>
		</tr>[/sec_code]
		[recaptcha]<tr>
			<td class="label">
				Введите два слова, показанных на изображении:<span class="impot">*</span>
			</td>
			<td>
				<div>{recaptcha}</div>
			</td>
		</tr>[/recaptcha]
	</table>
    
	<div class="fieldsubmit">
		<input type="submit" name="keygen" class="fbutton" style="width:150px;" type="submit" value="Генерировать" />&nbsp;&nbsp;&nbsp;&nbsp;<span class="small">Об использовании пиратской версии прочтите  [ <a href="javascript:ShowOrHide('pr_keygen')"><b>ПИРАТСКАЯ ВЕРСИЯ</b></a> ] </span>
	</div>
</div>
</form>
[/if-hash]
[else-hash]
<div class="baseform">
	<table class="tableform">
		<tr>
			<td class="label">
				Доменное имя:
			</td>
			<td>{domain}</td>
		</tr>
		<tr>
			<td class="label">
				Версия скрипта:
			</td>
			<td>
                {hash_version}
            </td>
		</tr>
		<tr>
			<td class="label">
				Хеш домена:
			</td>
			<td><input type="text" maxlength="35" class="f_input" value="{hash_domain}" readonly="readonly" /></td>
		</tr>
        <tr>
            <td class="label">DataLife Engine:</td>
            <td>Откройте файл <b>/engine/data/config.php</b><br />Добавьте строку <font style="background:#235300; color:#FFFFFF; font-weight:bold; padding:1px 4px 1px 4px;">'key' => "{hash_domain}",</font></td>
        </tr>
	</table>
	<div class="fieldsubmit">
		<button onclick="window.history.back();" class="fbutton" name="send_btn" style="width:150px;" type="submit"><span>Вернутся назад</span></button>&nbsp;&nbsp;&nbsp;&nbsp;<span class="small">Об использовании пиратской версии прочтите  [ <a href="javascript:ShowOrHide('pr_keygen')"><b>ПИРАТСКАЯ ВЕРСИЯ</b></a> ] </span>
	</div>
</div>
[/else-hash]
<div id="pr_keygen" style="display:none;">
    <div class="basecont">
        <div class="dpad">
            <div class="storenumber" style="color:#060; margin-bottom:3px;">Преимущества приобретения лицензионной версии:</div>
            &bull; Вы получаете лицензию, оформленную на вас<br />
            &bull; Право на неограниченное по времени использование DLE<br />
            &bull; Лицензионное соглашение и чек о легальности покупки - БЕСПЛАТНО<br />
            &bull; Право на БЕСПЛАТНОЕ обновление всех будущих версий<br />
            &bull; Возможность получения индивидуальных критических обновлений и патчей<br />
            &bull; Возможность полного доступа к официальному сайту http://dle-news.ru<br />
            &bull; Идентификацию Вас, как официального пользователя DLE<br />
            &bull; Ваши предложения будут учтены при разработке новых версий DLE<br /><br />
            
            <div class="storenumber" style="color:#900; margin-bottom:3px;">При использовании пиратской версии:</div>
            &bull; Эта версия может внезапно начать работать неправильно, или совсем перестать работать<br />
            &bull; Никто не будет отвечать за неработоспособность "крякнутого" DLE<br />
            &bull; Вы не сможете получать обновления/патчи<br />
            &bull; У вас не будет технической поддержки<br />
            &bull; Не будет официальных документов, подтверждающих покупку<br />
            &bull; Попадаете под статью 146 УК РФ "Нарушение авторских и смежных прав"<br />
            &bull; Не сделаете лучше ни для себя, ни для разработчиков
        </div>
    </div>
</div>