[votelist]
                              <!-- Voting question start -->
                              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td align="left">
					<div style="background-color:#f9f9f9; background-repeat:repeat-y; border:1px solid #d0d0d0; padding-top:3px; padding-bottom:3px; padding-left:3px;"><strong>{title}</strong> <a href="" onclick="ShowAllVotes(); return false;">[?]</a></div>
				</td>
                                </tr>
                              </table>
                              <!-- Voting question end -->
                              <!-- Voting answers start -->
                              <form method="post" name="vote" action=''><div style="padding-bottom:30px;">{list}</div>
                                <div style="float:left; margin-top:-25px;"><input type="hidden" name="vote_action" value="vote" />
                                      <input type="hidden" name="vote_id" id="vote_id" value="1" />
                                      <input type="submit" onclick="doVote('vote'); return false;" class="but" value="Голосовать" />
				</div>
                              </form>
                              <!-- Voting answers end -->
                              <!-- Voting results start -->
                              <form method="post" name="vote_result" action=''>
                                <div style="float:right; margin-top:-25px;">
					<input type="hidden" name="vote_action" value="results" />
                                       <input type="hidden" name="vote_id" value="1" />
                                       <input type="submit" onclick="doVote('results'); return false;" class="but" value="Результаты" />
				</div>
                              </form>
                              <!-- Voting results end -->
[/votelist]
[voteresult]
                              <!-- Voting question start -->
                              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td align="left"><strong>{title}</strong></td>
                                </tr>
                              </table>
                              <!-- Voting question end -->
                              <br />
                              <!-- Voting answers start -->
                              <table width="100%" cellpadding="0" cellspacing="0" border="0">{list}
                              </table>
                              <!-- Voting answers end -->
                              <!-- Summary start -->
                              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td align="left"><br /><strong>Всего проголосовало:</strong> {votes}</td>
                                </tr>
                              </table>
                              <!-- Summary end -->
[/voteresult]