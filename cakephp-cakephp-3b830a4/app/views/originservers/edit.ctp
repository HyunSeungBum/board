<?php

#pr($originservers);

?>
<!--
<script type="text/javascript">//<![CDATA[
    var xed;
    window.onload = function() {
        xed = new xq.Editor("xqEditor");
        xed.setEditMode('source');
		xed.setWidth("100%");
    }
    //]]></script>
/-->
<!-- 본문 내용을 div 로 만든다. -->
		<div id="content">
		<!-- aside는 본문내용에 부스러기 들을 넣는다. -->
			<aside> 
				<section> 
					<header> 
						<h3>원판서버목록</h3> 
					</header> 
					<ul> 
						<li><a href="/originservers/index/Originservers.category:호스팅">호스팅</a></li> 
						<li><a href="/originservers/index/Originservers.category:기타 호스팅">기타 호스팅</a></li>
					</ul> 
				</section> 
			</aside> 
			<div id="mainContent"> 
				<section id="blogHeader"> 
					<h2>서버정보 입력</h2> 
				</section> 
				<section id="blogContent">
					<div>
						<form id="OriginserversAddForm" method="post" action="/originservers/edit/<?=$originservers['id']?>" accept-charset="utf-8">
						카테고리: <select name="data[Originserver][category]">
						  <option value="호스팅" <?php if(trim($originservers['category'])=='호스팅') echo 'selected'; ?>>호스팅</option>
						  <option value="기타 호스팅" <?php if(trim($originservers['category'])=='기타 호스팅') echo 'selected'; ?>>기타 호스팅</option>
						</select><br><br>
						Domain: <input name="data[Originserver][domain]" type="text"  size="20" value="<?=trim($originservers['domain'])?>" />,
						Ip: <input name="data[Originserver][ip]" type="text"  size="20" value="<?=trim($originservers['ip'])?>" /> <br> <br>
						<textarea name="data[Originserver][memo]" id="xqEditor" rows="10" cols="100"><?=trim($originservers['memo'])?> </textarea><br>
						<br >
						<input type="submit" value="확인"> <a href="/originservers/delete/<?=$originservers['id']?>" onclick="return confirm(&#039;Are you sure?&#039;);"><button type="button">삭제</button></a><a href="javascript:history.back();"><button type="button">되돌아 가기</button></a>
						</form>
					</div>
				</section> 
			</div> 
		</div>