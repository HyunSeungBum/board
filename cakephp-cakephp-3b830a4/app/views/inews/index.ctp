<!-- 본문 내용을 div 로 만든다. -->
		<div id="content">
		<!-- aside는 본문내용에 부스러기 들을 넣는다. -->
			<aside> 
				<section> 
					<header> 
						<h3>목록</h3> 
					</header> 
					<ul> 
					<?php
					foreach($cates as $cate) {
					?>
						<li><a href="/inews/index/Inews.id:<?=$cate['Inews']['id']?>"><?=$cate['Inews']['site']?></a></li> 
					<?php
					}
					?>
					</ul> 
				</section> 
			</aside> 
			<div id="mainContent"> 
				<section id="blogHeader"> 
					<h2><?=$html->link($site,$siteLink,array('target'=>'_blank','alt'=>$siteDescription))?></h2> 
				</section> 
				<section id="blogContent">
					<?php
					foreach($feeds as $feed) {
					?>
					<article style="padding-bottom:10px;padding-left:10px;">
						<header>
							<?=$html->link($feed->get_title(), $feed->get_permalink(), array('class' => 'rsslink', 'target' => '_blank'))?>
						</header>
						<div style="width:765px;">
							<?=$text->truncate($feed->get_description(),200)?><br /><br />
							<p style="font-style:italic;"><?=$feed->get_date()?></p>
						</div>
					</article>
					<?php } ?>
				</section>
			</div> 
		</div>
