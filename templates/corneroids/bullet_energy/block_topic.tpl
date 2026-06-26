[infoBox]
<div class="treeTitl infoBox">
  <div class="inertBox">
    <h3>{infoTitl}</h3>
    <div class="treeDesc">{infoText}</div>
  </div>
</div>
[/infoBox]
<h3 class="treeNameList">{treeName}</h3>
<div id="desTtee">{treeDescription}{treeOption}{treeRss}</div>
<div class="contentBoxTopicList">
  <dl class="headerBox boxList">
    <dt class="avatarMini"><span>Аватар:</span></dt>
    <dd class="topicTitl"><span class="sortTitl">Заголовок</span></dd>
    <dd class="answerTopic"> <span class="sortView">Просмотров</span> <span class="sortAnswer">Ответов</span> </dd>
    <dd class="lastMsg"><span class="sortLastPost">Последнее сообщение</span></dd>
  </dl>
  <ol class="listTopicBlock" id="contentBoxAppendTo">
    {listTopic}
  </ol>
  <div class="sepBoxBot"><span>{optionList}</span></div>
</div>
{navigation}
<!--IMPORTANT listTopicBlock, class span sortXXX-->
<script language="javascript" type="text/javascript">
function MenuBuild(m_id) {
  var menu = new Array()
  menu[0] = '<a onclick="topicConfigure(\'clozed\'); return false;" href="#">Закрыть темы</a>';
  menu[1] = '<a onclick="topicConfigure(\'open\'); return false;" href="#">Открыть темы</a>';
  menu[2] = '<a onclick="topicConfigure(\'pin\'); return false;" href="#">Прикрепить темы</a>';
  menu[3] = '<a onclick="topicConfigure(\'unpin\'); return false;" href="#">Открепить темы</a>';
  menu[4] = '<a onclick="topicConfigure(\'move\'); return false;" href="#">Переместить темы</a>';
  menu[5] = '<a onclick="topicConfigure(\'merge\'); return false;" href="#">Объединить темы</a>';  
  menu[6] = '<a onclick="topicConfigure(\'delete\'); return false;" href="#">Удалить темы</a>';  
  return menu;
}
</script>