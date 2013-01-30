<?php 
the_title();
the_post_thumbnail('thumbnail');	
echo get_the_term_list( $post->ID, 'scale', 'Scale: ', ', ', '' );
echo get_the_term_list( $post->ID, 'city', 'City: ', ', ', '' );
echo get_the_term_list( $post->ID, 'district', 'District: ', ', ', '' );
echo get_the_term_list( $post->ID, 'neighborhood', 'NH: ', ', ', '' );
echo '<br>Data<br>';
//common to all scales
echo 'POP/Ha ' .get_post_meta( $post->ID, 'pop-ha', true );
echo 'Population ' .get_post_meta( $post->ID, 'population', true );
//for Block and Neighborood Scales
echo 'FAR ' .get_post_meta( $post->ID, 'far', true );
echo 'DUs/Ha ' .get_post_meta( $post->ID, 'dus-ha', true );
echo 'm2/Ha ' .get_post_meta( $post->ID, 'm2-ha', true );
echo 'Gross Building Area ' .get_post_meta( $post->ID, 'gross-building-area', true );
echo 'Site Area ' .get_post_meta( $post->ID, 'site-area', true );
echo 'Range of Heights ' .get_post_meta( $post->ID, 'range-of-heights', true );
echo 'Dwelling Units ' .get_post_meta( $post->ID, 'dwelling-units', true );
echo 'Parking Spaces ' .get_post_meta( $post->ID, 'parking-spaces', true );
echo 'Location ' .get_post_meta( $post->ID, 'location', true );
echo 'Income ' .get_post_meta( $post->ID, 'income', true );
echo 'Demographic group ' .get_post_meta( $post->ID, 'demographic-group', true );
//common to all scales
echo 'References ' .get_post_meta( $post->ID, 'references', true );
the_content();
?>
