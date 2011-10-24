<script type="text/javascript">//<![CDATA[
    
    $(document).ready(function(){
		xed = new xq.Editor("xqEditor");
		
		xed.isSingleFileUpload = true;
		xed.addPlugin('FileUpload');
		xed.setFileUploadTarget('/examples/single_upload_submit.php', null);
		xed.setEditMode('wysiwyg');
		xed.setWidth("100%");
		
		var form = $('form[name=frm]');
		form.submit(function() {
			
			if ($('#title').val().trim() == "") {
				$.Zebra_Dialog('제목을 입력하세요',{'title':'Error','type':'error'});
				$('#title').focus();
				return false;
			}
			
			if ($('#password').val().trim() == "") {
				$.Zebra_Dialog('패스워드를 입력하세요',{'title':'Error','type':'error'});
				$('#password').focus();
				return false;
			} else {
				return checkpasswd();
			}
			
			
			if ($('#xqEditor').val().trim() == "<p>&nbsp;</p>") {
				$.Zebra_Dialog('내용을 입력하세요',{'title':'Error','type':'error'});
				return false;
			}
			
			if ($('#captchaID').val().trim() == "") {
				$.Zebra_Dialog('captchaID를 입력하세요',{'title':'Error','type':'error'});
				$('#captchaID').focus();
				return false;
			} else {
				chk = checkcaptcha()
				return chk
			}
		
			return true;
		});
		
		function checkcaptcha() {
			fieldValue = $('#captchaID').val();
			
			var chk = true;
			
			$.ajax({
				url: '/tip/checkcaptcha', 
				type: 'POST',
				data: {"captchaID":fieldValue},
				dataType: 'json',
				async: false,
				success: function(data) {
					if (data == 'false') {
						$.Zebra_Dialog('captchaID가 틀립니다.',{'title':'Error','type':'error'});
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
					chk = false;
				}
			});
			
			return chk
		}
		
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
		
		$('#password').blur(function() {
			return checkpasswd()
		});
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
					<h2>내용 입력</h2> 
				</section> 
				<section id="blogContent">
					<div>
						<form name="frm" id="TipsAddForm" method="post" action="/tip/edit/<?=$Tips['id']?>" accept-charset="utf-8">
							<input type="hidden" name="_method" value="POST" />
							<input type="hidden" name="data[Tip][page]" value="<?=$page?>">
							<input type="hidden" name="id" value="<?=$Tips['id']?>">
							제목: <input id="title" name="data[Tip][subject]" type="text"  size="80"/ value="<?=$Tips['subject']?>"> <br><br>
							비밀번호: <input id="password" name="data[Tip][secure]" type="password" size="10" /><br /><br />
							<textarea name="data[Tip][content]" id="xqEditor" rows="10" cols="100"><?=trim($Tips['content'])?></textarea><br>
							<img src="http://memolog.pe.kr/tip/captcha" style="" vspace="2" alt="" /><br />
							<input name="data[Tip][captcha]" type="text" autocomplete="off" id="captchaID" /><br />
							<input type="submit" value="확인"> <input type="reset" value="취소"> <a href="javascript:history.back();"><button type='button'>되돌아가기</button></a>
						</form>
					</div>
				</section>
			</div> 
		</div>
