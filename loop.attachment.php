<?php
// query parameters
$args = array(
	'post_type' => 'attachment',
	'numberposts' => $img_amount,
	'post_status' => null,
	'post_parent' => $img_post_parent,
	'orderby' => 'menu_order',
	'order' => 'ASC'
);
$attachments = get_posts($args);
if ( $attachments ) {
// if there is anyone
	// defining the array containers for all the image sizes
	$img_mini = array();
	$img_medium = array();
	$img_large = array();
	foreach ( $attachments as $attachment ) {
		$img_type = $attachment->post_mime_type;
		if ( $img_type == 'image/png' || $img_type == 'image/jpeg' || $img_type == 'image/gif' ) {
		// testing if the attachment is an image
			if ( $mini_size != '' ) {
			// code to retrieve thumb version
				$img_mini_vars = wp_get_attachment_image_src($attachment->ID, $mini_size );
				array_push($img_mini, "<img src='{$img_mini_vars[0]}' width='{$img_mini_vars[1]}' height='{$img_mini_vars[2]}' />");
			} else {}
					if ( $medium_size != '' ) {
						// code to retrieve medium version
						$img_medium_vars = wp_get_attachment_image_src($attachment->ID, $medium_size );
						$img_attachment_link = get_attachment_link($attachment->ID);
						$img_caption = $attachment->post_excerpt; 
						//error, saca el excerpt del post: $imageCaption = get_the_excerpt($attachment->ID);
						$img_width = $img_medium_vars[1];
						$img_height = $img_medium_vars[2];
						if ( isset($custom_width) ) {
							if ( $img_width < $img_height ) {
								// if vertical image
								//$img_height = $custom_width;
								$img_height = "400";
								$img_width = $img_medium_vars[1] * (400/$img_medium_vars[2]);
								$img_width = round($img_width);
							} else {
								$img_width = $custom_width;
								$img_height = $img_medium_vars[2] * ($custom_width/$img_medium_vars[1]);
								$img_height = round($img_height);
							}
						}
						//array_push($img_medium, "<a href='{$img_attachment_link}'><img src='{$img_medium_vars[0]}' width='{$img_width}' height='{$img_height}'/></a><span class='img-cap'>" .$img_caption. "</span>");
						array_push($img_medium, "<img src='{$img_medium_vars[0]}' width='{$img_width}' height='{$img_height}'/>");
					} else { unset($img_medium); }

					if ( $large_size != '' ) {
						// code to retrieve large version
						$img_large_vars = wp_get_attachment_image_src($attachment->ID, $large_size );
						array_push($img_large, "<img src='{$img_large_vars[0]}' width='{$img_large_vars[1]}' height='{$img_large_vars[2]}' />");
					} else { unset($img_large); }
		} // if the attachment are images
	} // foreach attachment
} // if there are attachment
?>
