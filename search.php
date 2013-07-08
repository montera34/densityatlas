<?php get_header();

$tit = "Search results";
?>


<div id="gallery-tit" class="row">
	<div class="container">
		<div class="row">
			<div class="span3"><h2><?php echo $tit ?></h2></div>
		</div>
	</div>
</div><!-- #gallery-tit -->
<div id="gallery-items" class="row">
	<div class="container">
			<?php 
			if (have_posts() ) :
				$tab_tmp = "";
				$count = 0;
				while ( have_posts() ) : the_post();
					$count++;
					if ( $count == 1 ) { $tab_tmp .= "<div class='row'>"; }
					include("loop.boxes.php");
					if ( $count == 4 ) { $tab_tmp .= "</div><!-- .row -->"; $count = 0; }
				endwhile;
			else :
			// if no related posts, code in here
			endif;
			if ( $count != 0 ) { $tab_tmp .= "</div><!-- .row -->"; }
			echo $tab_tmp; ?>
	</div><!-- .container -->
</div><!-- #gallery-items -->
<?php get_footer(); ?>
