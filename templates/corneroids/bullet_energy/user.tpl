[msg]
<li class="msg userPost">
  <div class="avatarBoxPostAction">[popupUserCard]<img src="{foto}" alt="" />[/popupUserCard]</div>
  <div class="contentPostUser">
    <h3>[linckMessage]{titleTopic}[/linckMessage]</h3>
    <div class="infoPostMsgUser">Сообщение от [profile]{messageAuthor}[/profile], в {messageDate} в разделе: [linckTree]{nameTree}[/linckTree]</div>
    <div class="postUserBox">{messageText}</div>
  </div>
</li>
[/msg]
[topic]
<li class="msg userPost">
  <div class="avatarBoxPostAction">[popupUserCard]<img src="{foto}" alt="" />[/popupUserCard]</div>
  <div class="contentPostUser">
    <h3>[linckTopic]{titleTopic}[/linckTopic]</h3>
    <div class="infoPostMsgUser">Автор темы [profile]{messageAuthor}[/profile], ответов: {replyCount}, в {messageDate} в разделе: [linckTree]{nameTree}[/linckTree]</div>
    <div class="postUserBox">{messageText}</div>
  </div>
</li>
[/topic]
[like]
<li class="msg userPost">
  <div class="avatarBoxPostAction">[popupUserLikedCard]<img src="{fotoUserLiked}" alt="" />[/popupUserLikedCard]</div>
  <div class="contentPostUser">
    <h3>[popupUserLikedCard]{userLiked}[/popupUserLikedCard] нравится Ваше сообщение в теме [linckMessage]{titleTopic}[/linckMessage].</h3>
    <div class="infoPostMsgUser"><span title="{userLiked} выразил симпатию {likedDate}">{likedDate}</span></div>
    <div class="postUserBox">{messageText}</div>
  </div>
</li>
[/like]