<li class="msg" id="message-{messageId}">
  <div class="msgAutorInfo">
    <div class="boxInert">
      <div class="avatar">[popupUserCard]<img src="{foto}" alt="" />[/popupUserCard]</div>
      [online]<span class="online"><span></span>Онлайн</span>[/online]
      [offline]<span class="offline"><span></span>Оффлайн</span>[/offline]
      <div class="autorInfo">
        <p>[profile]{autorName}[/profile]</p>
        [titleUser]
        <p>Звание: {titleUser}</p>
        [/titleUser]
        <p>{userGroup}</p>
        <p class="msgUserCount">Сообщений: {forumPostNum}</p>
        [isUserTrophies]
        <p class="trophiesCount">Трофеев: [userTrophies]{countTrophies}[/userTrophies]</p>
        [/isUserTrophies]
        [isAccessWarning]
        <p>Предупреждений: {countWarning}</p>
        [/isAccessWarning] </div>
    </div>
  </div>
  <div class="msgText">{messageText}
    [signatureBox]
    <p class="signature">{signature}</p>
    [/signatureBox] </div>
    
  <div class="msgInfo"><div class="clr"></div>
    <div>{moderatorOptionInput}{messageDate} / {messageLinck} </div>
  </div>
  [not-group=5] 
  <!--controlMsgBox important-->
  <div class="controlMsgBox msgIControl"> [complaint]Пожаловаться[/complaint]
    [deleteMsg]Удалить[/deleteMsg] 
    [msgEdit]Редактировать[/msgEdit] 
    [fast]Ответить[/fast]{like} </div>
  [/not-group] </li>
