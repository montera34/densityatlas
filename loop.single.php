<?php 
the_title();
echo get_the_term_list( $post->ID, 'scale', 'Scale: ', ', ', '' );
echo get_the_term_list( $post->ID, 'city', 'City: ', ', ', '' );
echo get_the_term_list( $post->ID, 'district', 'District: ', ', ', '' );
echo get_the_term_list( $post->ID, 'neighborhood', 'NH: ', ', ', '' );
the_content();
?>
