<?php get_header(); ?>
<div id="content" class="span9">
	<div class="container-fluid">
		<div class="row-fluid">
			<?php 
			if (have_posts() ) :
				while ( have_posts() ) : the_post();
					include("loop.boxes.php");
				endwhile;
			else :
			// if no related posts, code in here
			endif; ?>
		</div>
	</div>
</div>

<?php get_footer(); ?>
