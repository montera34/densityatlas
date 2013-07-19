<?php get_header(); ?>

<div id="page">
	<div class="container">
		<div class="row">
			<div id="case-sidebar" class="span4"> -</div>
			<div class="span10 offset1 text-content">
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


