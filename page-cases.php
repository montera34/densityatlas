<?php /* Template Name: Case Studies */
get_header();
?>

<div id="content" class="span9">
	<?php 
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
			include("loop.page.php");
		endwhile;
	else :
	endif;
	rewind_posts(); ?>

	<div class="container-fluid">
		<div class="row-fluid">
			<?php 
			$args = array(
			    'posts_per_page' => -1,
				'post_type' => 'case');

			$related_query = new WP_Query( $args );
			if ( $related_query->have_posts() ) :
				while ( $related_query->have_posts() ) : $related_query->the_post();
					include("loop.boxes.php");
				endwhile;
			else :
			// if no related posts, code in here
			endif; ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
