<script type="text/javascript">//<![CDATA[
	$(document).ready(function() {
		xed = new xq.Editor("xqEditor"); 
		xed.isSingleFileUpload = true; 
		xed.addPlugin('FileUpload'); 
		xed.setFileUploadTarget('/examples/single_upload_submit.php', null); 
		xed.setEditMode('wysiwyg'); 
		xed.setWidth("100%");

		var form = $('form[name=frm]')
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
                                                $.Zebra_Dialog('captchaID',{'title':'Error','type':'error'});
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
						<form id="TipsAddForm" method="post" action="/tip/reply" accept-charset="utf-8" name="frm">
							<input type="hidden" name="_method" value="POST" />
							<input type="hidden" name="data[Tip][id]" value="<?=$Tips['id']?>">
							<input type="hidden" name="data[Tip][sid]" value="<?=$Tips['sid']?>">
							<input type="hidden" name="data[Tip][thread]" value="<?=$Tips['thread']?>">
							<input type="hidden" name="data[Tip][page]" value="<?=$page?>">
							제목: <input name="data[Tip][subject]" type="text"  size="80"/ value="<?=$Tips['subject']?>" id="title"> <br><br>
							비밀번호: <input id="password" name="data[Tip][secure]" type="password" size="10" id="password" /><br /><br />
							<textarea name="data[Tip][content]" id="xqEditor" rows="10" cols="100" id="xqEditor"> <?=$Tips['content']?></textarea><br>
							<img src="http://memolog.pe.kr/tip/captcha" style="" vspace="2" alt="" /><br />
							<input name="data[Tip][captcha]" type="text" autocomplete="off" id="captchaID" /><br /><br />
							<input type="submit" value="확인"> <input type="reset" value="취소"> <a href="javascript:history.back();"><button type='button'>되돌아가기</button></a>
						</form>
					</div>
				</section>
			</div> 
		</div>
