<?php get_header(); ?>

<div id="page">
	<div class="container">
		<div class="row">
			<div id="case-sidebar" class="span3"> -</div>
			<div class="span6 offset1">
				<?php 
				if ( have_posts() ) :
					while ( have_posts() ) : the_post();
						include("loop.page.php");
					endwhile;
				else :
				endif;?>
			</div>
		</div>
	</div>
</div><!-- #page -->

<?php get_footer(); ?>


