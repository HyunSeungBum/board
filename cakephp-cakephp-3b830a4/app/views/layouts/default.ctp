<?php
require_once "/usr/local/php/lib/php/header.php";
?>
<!DOCTYPE html>
<html lang="en">
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<head>
        <title><?php __('{work}Portal'); ?></title>
	<?php
		echo $javascript->link('xquared/javascripts/XQuared.js?load_others=1');
		echo $javascript->link('xquared/javascripts/plugin/FileUploadPlugin.js');
		echo $html->css('/js/xquared/stylesheets/xq_ui.css');
		echo $html->script('jquery'); // Include jQuery library
		echo $html->script('check_username');
		echo $javascript->link('zebra_dialog.js');
		echo $javascript->link('popup.js');
		echo $html->css('zebra_dialog.css');
		echo $html->css('main');
	?>
</head>
<body>
<!-- 헤더 영역 //-->
<header>
</header>
<!-- 네비게이션 //-->
<nav>
	<ul>
		<li class="logo"><a href="/">{work}Portal </a></li>
		<li><a href="/originservers">서버</a></li>
		<li><a href="/tip">TIP</a></li>
		<li><a href="#">글관리▼</a>
			<ul>
				<li><a href="#">글목록</a></li>
				<li><a href="#">댓글</a></li>
				<li><a href="#">댓글 알리미</a></li>
				<li><a href="#">트래백</a></li>
				<li><a href="#">방명록</a></li>
				<li><a href="#">휴지통</a></li>
			</ul>
		</li>
		<li><a href="#">스킨▼</a>
			<ul>
				<li><a href="#">스킨 선택</a></li>
				<li><a href="#">HTML/CSS 편집</a></li>
				<li><a href="#">사이드바 설정</a></li>
				<li><a href="#">화면출력 설정</a></li>
				<li><a href="#">카테고리 설정</a></li>
				<li><a href="#">티에디션 설정</a></li>
			</ul>
		</li>
		<li><a href="#">플러그인▼</a>
			<ul>
				<li><a href="#">플러그인 설정</a></li>
			</ul>
		</li>
		<li><a href="#">링크</a></li>
		<li><a href="#">환경설정</a></li>
	</ul>
</nav>
<?php echo $content_for_layout; ?>
<!-- 주소, 라이센스 영역 //-->
<footer>
<?php
require_once "/usr/local/php/lib/php/footer.php";
?>
</footer>
</body>
</html>
