<div id="mchat-style" style="width:100%;height:300px; overflow:auto;">
<div id="mchat_messages">{story}</div>
</div>
[isloged]
<div style="padding-top:10px">
<div class="bbeditor">
<div style="width:99%; height:25px; border:1px solid #BBB; background-image:url('{THEME}/bbcodes/bg.gif')">
<span id="b_b" onclick="DMC_simpletag('b');mChat_Display('mchat-bbcodes', 'fast');"><img src="{THEME}/bbcodes/b.png"  alt="" /></span>
<span id="b_i" onclick="DMC_simpletag('i');mChat_Display('mchat-bbcodes', 'fast');"><img src="{THEME}/bbcodes/i.png"  alt="" /></span>
<span id="b_u" onclick="DMC_simpletag('u');mChat_Display('mchat-bbcodes', 'fast');"><img src="{THEME}/bbcodes/u.png"  alt="" /></span>
<span id="b_s" onclick="DMC_simpletag('s');mChat_Display('mchat-bbcodes', 'fast');"><img src="{THEME}/bbcodes/s.png"  alt="" /></span>
<span id="b_emo" onclick="showSmile();"><img src="{THEME}/bbcodes/emo.png"  alt="" /></span>
<div id="smiles" title="Смайлики" style="display:none; " >
<table><tr><td align="center">{smiles}</td></tr></table>
</div>
</div>

<div style="padding-top:1px">
<textarea name="message" id="message" style="width:226px;height:60;padding: 2px;background:#f3fbff url({THEME}/img/chat_bg.gif) no-repeat; font-size: 9pt; border: 1px solid #B6C0CA;"></textarea>
</div>


<br>
<center><input type="button" onclick="SendMessage();" value="Отправить" class="fbutton"/><hr>
<div id="mchat-style" style="padding: 1px; text-align: center;"><a href="/mchat/history/"><b>Архив сообщений</b></a></div>


</div>
<script type="text/javascript">
function showSmile() {
$(function(){
    $('#smiles').dialog({
		autoOpen: true,
		show: 'fade',
		hide: 'fade',
		width: 220,
	});
});
}
</script>


[/isloged]
