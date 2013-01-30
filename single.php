<?php get_header(); ?>

<?php 
if ( have_posts() ) :
	while ( have_posts() ) : the_post();
	include "loop.single.php";
	endwhile;

else :
endif; ?>

<?php get_footer(); ?>
