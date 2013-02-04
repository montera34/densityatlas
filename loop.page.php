<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>> 
	
	<?php if (is_page(array(4,'case-studies'))) { //conditional if is Case Studies page ?>
	<div class="row">
		<h2 class="span2"><?php the_title();?><br>of density</h2>
		<h4 class="span2 offset2">Sort by</h4>
		<h4 class="span4">Filter by Scale</h4>
		<h4 class="span2 offset2"><a href="" class="btn btn-small">FAR</a> <a href="" class="btn btn-small">People / Ha</a></h4>
		<h4 class="span4"><a href="?scale=block" class="btn btn-small btn-blockk">Block</a>  <a href="?scale=neighborhood" class="btn btn-small btn-neighborhood">Neighborhood</a> <a href="?scale=district" class="btn btn-small btn-district">District</a> </h4>
	</div>
	<?php } else { ?>
	<h2><?php the_title();?></h2>
	<?php } ?>	
	<?php the_content(); ?>
</article>
