<?php 
get_header();
?>

<div id="content" class="span9">
	<?php 
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
			include("loop.page.php");
		endwhile;
	else :
	endif;?>
</div><!-- #content -->

<?php get_footer(); ?>
