<li class="topicList {status}" id="topic_item-{id}">
  <div class="boxTopic avatarMini"><span class="treeIcon" title="{statusTitl}"></span></div>
  <div class="boxTopic topicInfo">
    <h3>{unreadLinck}{uniqueStatusTopic}[linck]{title}[/linck]</h3>{pageList}
    <div class="icon">{icon}</div>
    <div class="topicPublicInfo">Тема создана: {topicPostDate}</div>
    <div class="topicControl">{edit}</div>
  </div>
  <div class="boxTopic statistic">
    <p><strong>Ответов:</strong> {replyCount}</p>
    <p><strong>Просмотров:</strong> {viewCount}</p>
  </div>
  [LastMessage]
  <div class="boxTopic topicLastPost">
    [popupUserCard]<img class="avatarLastAutor" src="{lastAutorAvatarLinck}" alt="" />[/popupUserCard] 
    <p><strong>Автор</strong>: [profile]{lastAutorName}[/profile]</p>
    <p title="Перейти к последнему сообщению"><strong>[lastMessageLinck]{lastMessageDate}[/lastMessageLinck]</strong></p>
  </div>
  [/LastMessage]
</li>