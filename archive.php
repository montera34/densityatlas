<?php 
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
			include("loop.boxes.php");
		endwhile;
	else :
	endif;
rewind_posts(); ?>
