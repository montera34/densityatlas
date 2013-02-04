<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>> 
	
	<?php if (is_page(array(4,'case-studies'))) { //conditional if is Case Studies page ?>
	<div class="row">
		<h2 class="span2"><?php the_title();?></h2>
		<h4 class="span2 offset2">Sort by</h4>
		<h4 class="span4">Filter by Scale</h4>
		<h4 class="span2 offset2"><a href="">FAR</a> <a href="">People / Ha</a></h4>
		<h4 class="span4"><a href="?scale=block" class="block">Block</a>  <a href="?scale=neighborhood"  class="neighborhood">Neighborhood</a> <a href="?scale=district" class="district">District</a> </h4>
	</div>
	<?php } else { ?>
	<h2><?php the_title();?></h2>
	<?php } ?>	
	<?php the_content(); ?>
</article>
