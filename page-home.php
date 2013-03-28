<?php /* Template name: Home Page */
get_header(); ?>

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
			$featured_cols = get_post_meta( $post->ID, '_da_story_cols', true );
			if ( $featured_cols == '' ) { $featured_cols = "span3"; }
			if ( $featured_cols == 'span1' || $featured_cols == 'span2' ) { $img_size = "thumbnail"; }
			elseif ( $featured_cols == 'span3' || $featured_cols == 'span6' ) { $img_size = "medium"; }
			elseif ( $featured_cols == 'span9' ) { $img_size = "large"; }
			elseif ( $featured_cols == 'span12' ) { $img_size = "full"; }
			$featured_img = get_the_post_thumbnail($post->ID,$img_size);
			$featured_tit = get_the_title();
			$featured_link = get_permalink();
			$loop_out[] = "
				<div class='home-item " .$featured_cols. "'>
					<div class='home-box'>
						<a href='" .$featured_link. "'>" .$featured_img. "
						<h3 class='home-tit'>".$featured_tit."</h3></a>
					</div>
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

<?php // home page loop
while ( have_posts() ) : the_post();
	$featured_1 = get_post_meta( $post->ID, '_da_home_featured_1', true );
	$featured_2 = get_post_meta( $post->ID, '_da_home_featured_2', true );
?>
<div id="case-data" class="row">
	<div class="container">
		<div class="row">
			<div class="span3 offset2">
				<img src="<?php echo $genvars['blogtheme']. "/images/home.img.1.png"; ?>" alt="<?php echo $genvars['blogname'] ?>" />
			</div>
			<div class="span5">
				<div class="featured-sentence">
					<p><?php echo $featured_1 ?></p>
				</div>
				<div class="home-menu"></div>
				<div class="text">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</div>
</div><!-- #content -->

<div id="case-metrics" class="row">
	<div class="container">
		<div class="row">
			<div class="span3 offset2">
				<img src="<?php echo $genvars['blogtheme']. "/images/home.img.2.png"; ?>" alt="<?php echo $genvars['blogname'] ?>" />
			</div>
			<div class="span5">
				<div class="featured-sentence">
					<p><?php echo $featured_2 ?></p>
				</div>
				<div class="home-menu"></div>
			</div>
		</div>
	</div>
</div><!-- #case-metrics -->

<?php endwhile;
wp_reset_query();
// end home page loop ?>

<?php get_footer(); ?>
