<li class="treeItem {status}">
  <div class="boxTreeItem"><span id="treeId_{treeId}" class="treeIcon" title="{statusTitl}"></span>
    <div class="treeInfoBox">
      <h4>[linckTree]{nameTree}[/linckTree]</h4>
      [blockInfo]
      <div class="countBox">
        <dl>
          <dt>Тем:</dt>
          <dd>{topic}</dd>
          <dt>Сообщений:</dt>
          <dd>{message}</dd>
        </dl>{TreeChild}{rssTree}
      </div>
      [/blockInfo]
      [LastMessage]
      <div class="replyLast">
        <p title="Перейти к последнему сообщению">Тема: <a href="{lastTopicLinck}"> {lastTopicName} </a></p>
        <p>[popupUserCard]{lastAutorName}[/popupUserCard], <i>{lastMessageDate}</i></p>
      </div>
      [/LastMessage]</div>
  </div>
</li>