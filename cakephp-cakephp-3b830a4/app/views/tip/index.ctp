<?php
$paging = $this->Paginator->params();
$vid = intval($paging['count']) - (intval($paging['page']) - 1) * intval($paging['options']['limit']);
$recent = mktime();
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
						<li><a href="/tip">Tip</a></li> 
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
							<li style="width:490px;">제목</li>
							<li style="width:130px;">글쓴이</li>
							<li style="width:110px;">시간</li>
						</ul>
					</header>
					<article>
					<?php foreach($tips as $tip): ?>
						<ul>
							<li style="width:14px;"><?=$vid?></li>
							<li style="width:524px;text-align:left"><?php if ($tip['Tip']['thread'] > 0) { ?><img src='/img/i_reply.gif'><?php } ?> <a href="/tip/view/<?=$tip['Tip']['id']?>/page:<?=$paging['page']?>"><?=$tip['Tip']['subject']?></a><?php if(($recent - $tip['Tip']['wdate']) < 259200) { ?> <img src="/img/ico_n.gif" border="0"> <?php } ?></li>
							<li style="width:105px;"><?=$tip['Tip']['writer']?></li>
							<li style="width:115px;"><?=date('Y-m-d H:i:s', $tip['Tip']['wdate'])?></li>
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
							<a href="/tip/add" > 쓰기</a>
					</span>
					<div style="text-align:center">
					<form action="/tip/search" method="post" autocomplete name="frm" id="OriginserversSearchForm">
					<input type="hidden" name="_method" value="POST" />
						<select name="data[Tip][category]">
						  <option value="subject">제목</option>
						  <option value="sub_wr">제목+글쓴이</option>
						  <option value="writer">글쓴이</option>
						</select>
						<input type="text" size="20" name="data[Tip][search]"><input type="submit" value="검색">
					</form>
				</div>
					</article>
				</section>
			</div> 
		</div>
