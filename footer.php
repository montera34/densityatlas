<?php
global $genvars;
require_once( get_stylesheet_directory(). '/general-vars.php' );
?>

	</div><!-- #hoja -->
	<div id="epi" class="row">
		<div class="span12">
			<p>&copy; <?php echo date("Y"); ?> Density Atlas</p>
		</div>
	</div><!-- #epi -->

</div><!-- #super -->

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="<?php echo $genvars['blogtheme']; ?>/js/bootstrap.min.js"></script>

<?php wp_footer(); ?>
</body>
</html>
