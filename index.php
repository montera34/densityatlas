<?php get_header(); ?>

<?php // loop for featured stories
$args = array(
	'post_type' => 'post',
	'posts_per_page' =>  -1,
	'meta_query' => array(
		array(
			'key' => '_da_story_featured',
			'value' => 'on',
			'compare' => '='
		),
	),
	'meta_key' => '_da_story_order',
	'orderby' => 'meta_value_num',
	'order' => 'ASC',
);
$related_query = new WP_Query( $args );
if ( $related_query->have_posts() ) :
	while ( $related_query->have_posts() ) : $related_query->the_post();
		if ( has_post_thumbnail() ) {
			$featured_img = get_the_post_thumbnail($post->ID,'thumbnail');
			$featured_tit = get_the_title();
			$loop_out[] = "
				<div class='home-item span3'>
					" .$featured_img. "
					<p>".$featured_tit."</p>
				</div>
			";
		} else {}

	endwhile;
else :
// if no related posts, code in here
endif;
wp_reset_query();
?>
<div id="case-tit" class="row">
	<div class="container">
		<div class="row">
				<div id="home-gallery">
					<?php foreach ( $loop_out as $loop ) { echo $loop; } ?>
				</div>
		</div>
	</div>
</div><!-- #gallery-tit -->

<div id="content" class="row">
	<div class="container">
		<div class="row">
			<div class="span4">Aqui el contenido</div>
		</div>
	</div>
</div><!-- #content -->

<div id="case-metrics" class="row">
	<div class="container">
		<div class="row">
			<div class="span4">Aqui el contenido destacado</div>
		</div>
	</div>
</div><!-- #content -->

<?php get_footer(); ?>
