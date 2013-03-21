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

<?php wp_footer(); ?>
</body>
</html>
