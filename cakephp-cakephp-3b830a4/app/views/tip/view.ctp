<script type="text/javascript">//<![CDATA[

	$(document).ready(function(){
		
		$("a[href^=#]").click(function() {
			centerPopup();
			loadPopup();
		});

		$("input[type=reset]").click(function() {
			disablePopup();
		});

		//CLOSING POPUP
		//Click the x event!
		$("#popupContactClose").click(function(){
			disablePopup();
		});

		//Click out event!
		$("#backgroundPopup").click(function(){
			disablePopup();
		});

		//Press Escape event!
		$(document).keypress(function(e){
			if(e.keyCode==27 && popupStatus==1){
				disablePopup();
			}
		});

		var form = $('form[name=frm]');
		form.submit(function() {
			if ($('#password').val().trim() == "") {
                                $.Zebra_Dialog('패스워드를 입력하세요',{'title':'Error','type':'error'});
                                $('#password').focus();
                                return false;
                        } else {
                                return checkpasswd();
                        }
		
			return true;
		});

                function checkpasswd() {
                        pwdValue = $('#password').val();
                        idValue = $('input[name=id]').val();

                        chk = false;
                        $.ajax({
                                url: '/tip/checkpasswd',
                                type: 'POST',
                                data: {"password":pwdValue, "id":idValue},
                                dataType: 'json',
                                async: false,
                                success: function(data) {
                                        if (data == 'false') {
                                                $.Zebra_Dialog('패스워드가 다릅니다.',{'title':'Error','type':'error'});
                                                chk = false;
                                        } else {
                                                chk = true;
                                        }
                                },
                                error: function() {
                                        if(error.length != 0) {
                                                $('#captchaID').after('<div class="error-message" id="'+ fieldName +'-exists">' + error + '</div>');
                                        } else {
                                                $('#' + fieldName + '-exists').remove();
                                        }
                                }
                        });

                        return chk;
                }
	});




//]]></script>
<!-- 본문 내용을 div 로 만든다. -->
		<div id="content">
		<!-- aside는 본문내용에 부스러기 들을 넣는다. -->
			<aside> 
				<section> 
					<header> 
						<h3>목록</h3> 
					</header> 
					<ul> 
						<li><a href="/tip">Tip</a></li> 
					</ul> 
				</section> 
			</aside> 
			<div id="mainContent">
				<section id="blogHeader"> 
					<h2><?=$Tips['subject']?></h2> 
					<p>[Posted on <time datetime="<?=date('Y-m-d\Th:i:sT',$Tips['wdate'])?>"><?=date("D M j G:i:s T Y",$Tips['wdate'])?></time> by <?=$Tips['writer']?> - <?=$rcount?> comments]</p>
				</section>
				<section id="blogContent">
					<article>
						<div style="padding: 10px;">
							<?=nl2br($Tips['content'])?>
						</div>
					</article>
				</section>
				<section id="viewbuttonarea">
					<span>
						<ul>
							<li><a href="/tip/index/page:<?=$page?>">[리스트]</a></li>
							<li><a href="/tip/reply/<?=$Tips['id']?>/page:<?=$page?>">[답글]</a></li>
							<li><a href="/tip/edit/<?=$Tips['id']?>/page:<?=$page?>">[수정]</a></li>
							<li><a href="#">[삭제]</a></li>
						</ul>
					</span>
				</section>
				<section id="comments">
					<h3>Comments</h3>
					<?php foreach($Comments as $Comment): ?>
					<article>
						<header>
							<strong><?=$Comment['Tips_comment']['writer']?></strong><br /> <time datetime="<?=date('Y-m-d\Th:i:sT',$Tips['wdate'])?>"><?=date("Y.m.d G:i:s",$Tips['wdate'])?></time>
						</header>
						<p><?=nl2br($Comment['Tips_comment']['comment'])?></p>
					</article>
					<?php endforeach; ?>
				</section>
				<form id="TipsCommentForm" action="/tip/addcomment" method="post" accept-charset="utf-8" style="padding-top:20px">
				<input type="hidden" name="_method" value="POST" />
				<input type="hidden" name="data[Tips_comment][id]" value="<?=$Tips['id']?>" />
					<h3>Post a comment</h3>
					<p>
						<label for="writer">writer</label>
						<input name="data[Tips_comment][writer]" id="writer" type="text" required />
					</p>
					<p>
						<label for="secure">password</label>
						<input name="data[Tips_comment][secure]" id="secure" type="password" required />
					</p>
					<p>
						<label for="comment">Comment</label>
						<textarea name="data[Tips_comment][comment]" id="comment" required rows="5" cols="80"></textarea>
					</p>
					<p><input type="submit" value="Post comment" /></p>
				</form>
			</div>
		</div>
		<div id="popupContact">
			<a id="popupContactClose">x</a>
			<h1>패스워드를 입력해주세요.</h1>

			<p id="contactArea">
				<form id="TipsPopupDelete" action="/tip/deletememo/<?=$Tips['id']?>" method="post" accept-charset="utf-8" name="frm" />
				<input type="hidden" name="_method" value="POST" />
				<input type="hidden" name="id" value="<?=$Tips['id']?>" />
				<input type="password" name="data[Tips_delete][secure]" required id="password" />
				<input type="submit" value="확인" /> <input type="reset" value="취소" />
				</form>
			</p>
		</div>

		<div id="backgroundPopup"></div>

