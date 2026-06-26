[not-group=5]
							<div class="login-link">
								[admin-link]<a href="{admin-link}" title="Админцентр" class="admin-link" target="_blank"><img border=0 src="{THEME}/images/icons/adm.png"></a>[/admin-link]
								<a href="{addnews-link}" title="Опубликовать новость" class="add-link"><img style="background: url(../images/bfon.png) center no-repeat;" border=0 src="{THEME}/images/icons/pub.png"></a>
                                <a href="{profile-link}"><img border=0 src="{THEME}/images/icons/inf.png"></a>
                                <a href="{pm-link}" title="Личные сообщения ({new-pm} | {all-pm})" class="pm-link"><img border=0 src="{THEME}/images/icons/mes.png"></a>
								<a href="/statistics.html" title="Статистика" class="pm-link"><img border=0 src="{THEME}/images/icons/stat.png"></a>
								 <a href="{logout-link}" title="Выход" class="lu-link"><img border=0 src="{THEME}/images/icons/ext.png"></a><img border=0 src="{THEME}/images/klite.png">
								 <div style="clear: both; height: 1px;"></div>
							</div>
[/not-group]
[group=5]
									<div class="l-color">	
										<form method="post" action='' style="margin: 0; padding: 0;">
											<div class="in-t-t">
												<input name="login_name" type="text" class="login-input-text" title="Ваше имя на сайте" value="логин" onblur="if(this.value=='') this.value='логин';" onfocus="if(this.value=='логин') this.value='';" />
											</div>
											<div class="in-t-t">
												<input name="login_password" type="password" class="login-input-text" title="Ваш пароль" value="пароль" onblur="if(this.value=='') this.value='пароль';" onfocus="if(this.value=='пароль') this.value='';" />
											</div>
											<input onclick="submit();" type="image" class="enter" src="{THEME}/images/enter.png" value="вход" /><input name="login" type="hidden" id="login" value="submit" />
											<div style="float: left;margin: -4px 0 0 0; background: none; color: #000;"><a href="{registration-link}" title="регистрация на сайте"><img border=0 src="{THEME}/images/reg.png"></a><a href="{lostpassword-link}" title="восстановление пароля"><img border=0 src="{THEME}/images/pass_rec.png"></a></div>
										</form>
									</div>
[/group]