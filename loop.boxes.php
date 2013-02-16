<?php // common vars
$post_perma = get_permalink();
$post_tit = get_the_title();
$excerpt = get_the_excerpt(); 
$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), medium, false, '' );
$post_classes = get_post_class(array('span3','box-basic'));
$classes_out = "";
$classes_count = 0;
foreach ( $post_classes as $class  ) {
	if ( $classes_count == 0 ) { $classes_out .= "id='" .$class. "' class='"; }
	else { $classes_out .= $class. " "; }
	$classes_count++;
} // end classes loop
$classes_out .= "'";
$post_cities = get_the_term_list( $post->ID, 'city', '', ', ', '' );
$post_scales = get_the_term_list( $post->ID, 'scale', '', ', ', '' );
$post_far = get_post_meta( $post->ID, 'far', true );
$post_pop = get_post_meta( $post->ID, 'pop-ha', true );

$tab_tmp .= "
	<div " .$classes_out. " style='background-image:url(\"" .$src[0]. "\")'>
		<div class='box-content'>
			<a href='" .$post_perma. "' title='Permalink to " .$post_tit. "' rel='bookmark'><h4>" .$post_tit. "</h4></a>
		" .$post_cities. "
			<h4 class='box-data'>
				<!-- for Block and Neighborood Scales -->
				<div style='float:left;'>FAR</div> <div style='text-align:right;font-weight:bold;'>" .$post_far. "</div> 
				<!-- common to all scales -->
				<div style='float:left;'>POP/Ha</div> <div style='text-align:right;font-weight:bold;'><strong>" .$post_pop. "</strong></div>
			</h4>
		</div><!-- .box-content -->
		<div class='box-bottom'>
			" .$post_scales. "
		</div><!-- .box-bottom -->
	</div>
";
