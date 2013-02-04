<?php // common vars
$post_perma = get_permalink();
$post_tit = get_the_title();
$excerpt = get_the_excerpt( ); 
$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 300,300 ), false, '' ); ?>


<?php echo "<div class=\"span3 box-basic\" style=\"background-image:url('";
	echo $src[0]; 	
	echo "')\">";?>
	<?php // the_post_thumbnail('medium'); ?>
	<div class="box-content">
		<?php echo "<a href='" .$post_perma. "' title='Permalink to " .$post_tit. "' rel='bookmark'>";?>
			<h4><?php the_title();?></h4>
		</a><br>
		<?php echo get_the_term_list( $post->ID, 'city', '', ', ', '' );?>
		<br>
		<?php 
		//for Block and Neighborood Scales
		echo 'FAR ' .get_post_meta( $post->ID, 'far', true ); 
		echo '<br>';
		//common to all scales
		echo 'POP/Ha ' .get_post_meta( $post->ID, 'pop-ha', true );?>
	</div>
	<div class="row-fluid">
		<div class='span12 box-bottom'>
		<?php echo get_the_term_list( $post->ID, 'scale', '<br>', ', ', '' );?>
		</div>
	</div>
</div>

