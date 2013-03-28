<?php
global $genvars;
require_once( get_stylesheet_directory(). '/general-vars.php' );
?>

	</div><!-- #hoja -->
	<div id="epi" class="row">
		<div class="container">
		<div class="row">
		<div class="span12">
			<p>&copy; <?php echo date("Y"); ?> Density Atlas</p>
		</div>
		</div>
		</div>
	</div><!-- #epi -->

</div><!-- #super -->

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="<?php echo $genvars['blogtheme']; ?>/js/bootstrap.min.js"></script>
<?php if ( is_front_page() ) {
// if home page ?>
<script src="<?php echo $genvars['blogtheme']; ?>/js/jquery.masonry.min.js"></script>
<script>
$('#home-gallery').masonry({
	itemSelector: '.home-item',
//	columnWidth: 240,
	columnWidth: function( containerWidth ) {
		return containerWidth / 4;
	},
//	gutterWidth: 10,
	isAnimated: true,
//	isFitWidth: true,
//	isResizable: true,
	animationOptions: {
		duration: 400
	}
});
</script>
<?php } // end if home page ?>

<?php if ( is_single() && get_post_type() == 'post' ) {
// if is a story (post) ?>
<script src="<?php echo $genvars['blogtheme']; ?>/rcarousel/widget/lib/jquery.ui.core.min.js"></script>
<script src="<?php echo $genvars['blogtheme']; ?>/rcarousel/widget/lib/jquery.ui.widget.min.js"></script>
<script src="<?php echo $genvars['blogtheme']; ?>/rcarousel/widget/lib/jquery.ui.rcarousel.min.js"></script>
<script type="text/javascript">
	jQuery(function($) {
		winwidth = $(window).width();
		if ( winwidth > 1200 ) {
			$( "#case-carousel" ).rcarousel( {visible: 4, step: 1, width: 300, height: 300, margin: 10} );
		} if ( winwidth > 768 && winwidth < 1200 ) {
			$( "#case-carousel" ).rcarousel( {visible: 3, step: 1, width: 300, height: 300, margin: 10} );
		} else {
			$( "#case-carousel" ).rcarousel( {visible: 1, step: 1, width: 300, height: 300, margin: 10, orientation: "vertical"} );
		}
	});
</script>
<?php } // end if is a story (post) ?>

<?php wp_footer(); ?>
</body>
</html>
