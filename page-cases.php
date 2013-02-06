<?php /* Template Name: Case Studies */
get_header();
?>

<div id="content" class="row">
	<?php 
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
			include("loop.page.php");
		endwhile;
	else :
	endif;
	rewind_posts(); ?>

	<div class="container-fluid main-content">
			<?php 
			$args = array(
			    'posts_per_page' => -1,
				'post_type' => 'case');

			$related_query = new WP_Query( $args );
			if ( $related_query->have_posts() ) :
				$count = 0;
				while ( $related_query->have_posts() ) : $related_query->the_post();
					$count++;
					if ( $count == 1 ) { echo "<div class='row-fluid'>"; }
					include("loop.boxes.php");
					if ( $count == 4 ) { echo "</div><!-- .row-fluid -->"; $count = 0; }
				endwhile;
			else :
			// if no related posts, code in here
			endif;
			if ( $count != 0 ) { echo "</div><!-- .row-fluid -->"; } ?>
	</div><!-- .main-content -->
</div><!-- #content -->

<?php get_footer(); ?>
