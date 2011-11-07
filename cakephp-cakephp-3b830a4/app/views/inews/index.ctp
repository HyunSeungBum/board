<!-- 본문 내용을 div 로 만든다. -->
		<div id="content">
		<!-- aside는 본문내용에 부스러기 들을 넣는다. -->
			<aside> 
				<section> 
					<header> 
						<h3>목록</h3> 
					</header> 
					<ul> 
						<li><a href="/inews"></a></li> 
					</ul> 
				</section> 
			</aside> 
			<div id="mainContent"> 
				<section id="blogHeader"> 
					<h2><?=$cateTitle?></h2> 
				</section> 
				<section id="blogContent">
					<?php
					foreach($feeds as $feed) {
						  echo $html->link($feed->get_title(), $feed->get_permalink()) . '<br/>';
						    echo $text->truncate($feed->get_description()).'<br />';
						    echo $feed->get_date();
						    echo '<br />';
					}
					?>
				</section>
			</div> 
		</div>
