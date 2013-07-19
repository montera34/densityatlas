<?php /* Template Name: Case Studies */
get_header();
?>

<?php
// visualization and order GET vars
$vis = sanitize_text_field( $_GET['vis'] );
$base_url = get_permalink();
preg_match('/\?/',$base_url,$matches); // check if pretty permalinks enabled
if ( $matches[0] == "?" && $vis == "map" ) { // if no pretty permalinks and map vis
	$base_url = get_permalink()."&vis=".$vis;
} elseif ( $matches[0] != "?" && $vis == "map" ) { // if pretty permalinks and map vis
	$base_url = get_permalink()."?vis=".$vis;
}
preg_match('/\?/',$base_url,$matches); // recheck after add vis var
if ( $matches[0] == "?" ) { $param_url = "&order="; }
else { $param_url = "?order="; }
$order = sanitize_text_field( $_GET['order'] );
// active tab when page loads
// 0 for all | 1 for Block | 2 for Neighborhood | 3 for District
if ( $order == '' ) { $active_tab = 2; }
else { $active_tab = 2; }
//echo $order; echo $active_tab;


$order_buttons = array(); // order buttons container
if ( $order != 'ha' ) { // if FAR order
	$order = "_da_far";
	array_push( $order_buttons,"<li><a href='" .$base_url . $param_url. "far' class='active btn btn-small'>FAR</a></li>" );
	array_push( $order_buttons,"<li><a href='" .$base_url . $param_url. "ha' class='btn btn-small'>People/ha</a></li>" );
}
else { // if POP/ha order
	$order = "_da_pop-ha";
	array_push( $order_buttons,"<li><a href='" .$base_url . $param_url. "far' class='btn btn-small'>FAR</a></li>" );
	array_push( $order_buttons,"<li><a href='" .$base_url . $param_url. "ha' class='active btn btn-small'>People/ha</a></li>" );
}


// LOOPS
// one loop per scale to make live filters
$scale_buttons = array(); // filter buttons container
$scale_tabs = array(); // tabs content container
$scale_slugs = array("all","block","neighborhood","district");
$scale_names = array("All","Block","Neighborhood","District");
$scale_count = 0;

foreach ( $scale_slugs as $scale_slug ) {

	$tab_tmp = ""; // temporal cointainer for tab content before add to array
	if ( $scale_slug == 'block' ) { $scale_class = $scale_slug. "k"; }
	else { $scale_class = $scale_slug; }
	// scale tab button
	if ( $scale_count == $active_tab ) {
	// this is the active button
		array_push( $scale_buttons,"<li class='active'><a href='#" .$scale_slug. "' class='" .$scale_slug. " btn-" .$scale_class. "' data-toggle='tab'>" .$scale_names[$scale_count]. "</a></li>" ); // adding this scale button to the buttons container
	} else {
		array_push( $scale_buttons,"<li><a href='#" .$scale_slug. "' class='" .$scale_slug. " btn-" .$scale_class. "' data-toggle='tab'>" .$scale_names[$scale_count]. "</a></li>" ); // adding this scale button to the buttons container
	}
	// scale tab contents
	if ( $scale_slug == 'all' ) {
		$args = array(
			'posts_per_page' => -1,
			'post_type' => 'case',
			'meta_key' => $order,
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
			'tax_query' => array(
      				array(
      				'taxonomy'  => 'scale',
       				'field'     => 'slug',
       				'terms'     => 'city', 	    
				'operator'  => 'NOT IN')
			)
		);
	} else {
		$args = array(
			'posts_per_page' => -1,
			'post_type' => 'case',
			'tax_query' => array(
				array(
				'taxonomy' => 'scale',
				'field' => 'slug',
				'terms' => $scale_slug
				)
			),
			'meta_key' => $order,
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
		);
	}
	
	$related_query = new WP_Query( $args );
	if ( $related_query->have_posts() ) :
		$count = 0;
		while ( $related_query->have_posts() ) : $related_query->the_post();
			$count++;
			if ( $count == 1 ) { $tab_tmp .= "<div class='row'>"; }
			include("loop.boxes.php");
			if ( $count == 4 ) { $tab_tmp .= "</div><!-- .row -->"; $count = 0; }
		endwhile;
	else :
	// if no related posts, code in here
	endif;
	if ( $count != 0 ) { $tab_tmp .= "</div><!-- .row -->"; }
	array_push( $scale_tabs, $tab_tmp ); // adding this scale button to the buttons container
	wp_reset_query();
	$scale_count++;

} // end scales loop

// output
if ( $vis == "map" ) {
// if map visualization
	include "map.php";
}
?>

<div id="gallery-tit" class="row">
	<div class="container">
		<div class="row">
			<div class="span4"><h2><?php the_title();?></h2></div>
			<div class="span4">
				<h4>Sort by</h4>
				<ul id="orders" class="inline">
					<?php foreach ( $order_buttons as $button ) { echo $button; } ?>
				</ul>
			</div>
			<div class="span6">
				<h4>FILTER BY SCALE</h4>
				<ul id="filters" class="inline">
					<?php foreach ( $scale_buttons as $button ) { echo $button; } ?>
				</ul>
			</div>
		</div>
	</div>
</div><!-- #gallery-tit -->
	<?php 
	if ( have_posts() ) :
		while ( have_posts() ) : the_post();
			include("loop.page.php");
		endwhile;
	else :
	endif;
	rewind_posts(); ?>

<div id="gallery-items" class="row">
	<div class="container tab-content">
		<?php
		$scale_count = 0;
		foreach ( $scale_tabs as $tab ) {
			if ( $scale_count == $active_tab ) { echo "<div id='" .$scale_slugs[$scale_count]. "' class='tab-pane active'>" .$tab. "</div>"; }
			else { echo "<div id='" .$scale_slugs[$scale_count]. "' class='tab-pane'>" .$tab. "</div>"; }
			$scale_count++;
		} ?>
	</div><!-- .container -->
</div><!-- #gallery-items -->

<?php get_footer(); ?>
