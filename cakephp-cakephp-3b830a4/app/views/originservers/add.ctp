<!--
<script type="text/javascript">//<![CDATA[
    var xed;
    window.onload = function() {
        xed = new xq.Editor("xqEditor");
        xed.setEditMode('wysiwyg');
		xed.setWidth("100%");
    }
    //]]></script>
//-->
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
						<form id="OriginserversAddForm" method="post" action="/originservers/add" accept-charset="utf-8">
							<input type="hidden" name="_method" value="POST" />
							카테고리: <select name="data[Originserver][category]">
							  <option value="호스팅">호스팅</option>
							  <option value="기타 호스팅">기타 호스팅</option>
							</select><br><br>
							Domain: <input name="data[Originserver][domain]" type="text"  size="20"/>,
							Ip: <input name="data[Originserver][ip]" type="text"  size="20" /> <br> <br >
							<textarea name="data[Originserver][memo]" id="xqEditor" rows="10" cols="100"> </textarea><br>
							<input type="submit" value="확인"> <input type="reset" value="취소"> <a href="javascript:history.back();"><button type='button'>되돌아가기</button></a>
						</form>
					</div>
				</section>
			</div> 
		</div>