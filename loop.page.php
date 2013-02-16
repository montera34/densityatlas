<article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>> 
	
	<?php if (is_page(array(4,'case-studies'))) { //conditional if is Case Studies page ?>
	<?php } else { ?>
	<h2><?php the_title();?></h2>
	<?php } ?>	
	<?php the_content(); ?>
</article><!-- #post-<?php the_ID(); ?> -->
