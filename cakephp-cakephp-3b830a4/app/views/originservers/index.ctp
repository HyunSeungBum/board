<?php
$paging = $this->Paginator->params();
$vid = intval($paging['count']) - (intval($paging['page']) - 1) * intval($paging['options']['limit']);

?>
<!-- 본문 내용을 div 로 만든다. -->
		<div id="content">
		<!-- aside는 본문내용에 부스러기 들을 넣는다. -->
			<aside> 
				<section> 
					<header> 
						<h3>목록</h3> 
					</header> 
					<ul> 
						<li><a href="/originservers/index/Originservers.category:호스팅">호스팅</a></li> 
						<li><a href="/originservers/index/Originservers.category:기타 호스팅">기타 호스팅</a></li>
					</ul> 
				</section> 
			</aside> 
			<div id="mainContent"> 
				<section id="blogHeader"> 
					<h2><?=$cateTitle?>(<?=$paging['count']?>)</h2> 
				</section> 
				<section id="blogContent">
					<header>
						<ul>
							<li>No.</li>
							<li style="width:220px;">도메인</li>
							<li style="width:100px;">아이피</li>
							<li style="width:80px;">카테고리</li>
							<li style="width:160px;">메모</li>
						</ul>
					</header>
					<article>
					<?php foreach($originservers as $originserver): ?>
					<ul>
							<li style="width:14px;"><?=$vid?></li>
							<li style="width:225px;"><a href="/originservers/edit/<?=$originserver['Originserver']['id']?>"><?=$originserver['Originserver']['domain']?></a></li>
							<li style="width:105px;"><?=$originserver['Originserver']['ip']?></li>
							<li style="width:85px;"><?=$originserver['Originserver']['category']?></li>
							<li style="width:161px;">&nbsp;<?=nl2br($originserver['Originserver']['memo'])?></li>
						</ul>
					<?php 
						$vid--;
						endforeach; ?>
						<span id="paging">
						<!-- Shows the page numbers -->
						<?php echo $this->Paginator->prev('« Previous', null, null, array('class' => 'disabled')); ?></a>
<?php echo $this->Paginator->numbers(); ?>
<!-- Shows the next and previous links -->
<?php echo $this->Paginator->next('Next »', null, null, array('class' => 'disabled')); ?> 
						</span><span>
							<a href="/originservers/add" > 쓰기</a>
						</span>
						<div style="text-align:center">
							<form action="/originservers/search" method="post" autocomplete name="frm" id="OriginserversSearchForm">
							<input type="hidden" name="_method" value="POST" />
								<select name="data[Originservers][category]">
								  <option value="all">모두</option>
								  <option value="호스팅">호스팅</option>
								  <option value="기타 호스팅">기타 호스팅</option>
								  <option value="EC">EC</option>
								  <option value="빌더">빌더</option>
								  <option value="윈도우">윈도우</option>
								  <option value="CMC">CMC</option>
								  <option value="시스템">시스템</option>
								  <option value="linux 원판">linux 원판</option>
								</select>
								<select name="data[Originservers][mode]">
								  <option value="domain">도메인</option>
								  <option value="ip">아이피</option>
								</select>
								<input type="text" size="20" name="data[Originservers][search]"><input type="submit" value="검색">
							</form>
						</div>
					</article>
				</section> 
			</div> 
		</div>