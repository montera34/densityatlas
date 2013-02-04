<?php // common vars
$post_perma = get_permalink();
$post_tit = get_the_title();
$excerpt = get_the_excerpt( ); 
$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), medium, false, '' ); ?>

<?php echo "<div ";
	echo post_class(array('span3','box-basic'));
	echo " style=\"background-image:url('";
	echo $src[0]; 	
	echo "')\">";?>
	<?php // the_post_thumbnail('medium'); ?>
	<div class="box-content">
		<?php echo "<a href='" .$post_perma. "' title='Permalink to " .$post_tit. "' rel='bookmark'>";?>
			<h4><?php the_title();?></h4>
		</a>
		<?php echo get_the_term_list( $post->ID, 'city', '', ', ', '' );?>
		<h4 class="box-data">
			<?php 
			//for Block and Neighborood Scales
			echo '<div style="float:left;">FAR</div> <div style="text-align:right;font-weight:bold;">' .get_post_meta( $post->ID, 'far', true ). '</div>'; 
			echo '';
			//common to all scales
			echo '<div style="float:left;">POP/Ha</div> <div style="text-align:right;font-weight:bold;"><strong>' .get_post_meta( $post->ID, 'pop-ha', true ). '</strong></div>';?>
		</h4>
	</div>

		<div class='box-bottom'>
		<?php echo get_the_term_list( $post->ID, 'scale', '', ', ', '' );?>
		</div>

</div>

