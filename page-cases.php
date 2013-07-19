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
if ( $matches[0] == "?" ) { $param_url = "&scale="; }
else { $param_url = "?scale="; }

$scale = sanitize_text_field( $_GET['scale'] );
$order = sanitize_text_field( $_GET['order'] );
$orderby = sanitize_text_field( $_GET['type'] );
$sense = sanitize_text_field( $_GET['sense'] );
if ( $scale == '' ) { $scale = "neighborhood"; }
if ( $order == '' ) { $order = "far"; $orderby = "meta_value_num"; }
if ( $sense == '' ) { $sense = "DESC"; }
$orders = array(
	array(
		'value_url' => 'far',
		'type' => 'meta_value_num',
		'tit' => 'FAR'
	),
	array(
		'value_url' => 'pop-ha',
		'type' => 'meta_value_num',
		'tit' => 'POP/Area'
	),
);
$order_buttons = array(); // order buttons container
foreach ( $orders as $criteria ) {
	if ( $order == $criteria['value_url'] ) { $btn_class = " list-active"; } else { $btn_class = ""; }
	$sense_next = "DESC";
	if ( $sense == 'DESC' && $btn_class != '' ) { $sense_next = "ASC"; }
	if ( $sense_next == 'DESC' ) { $icon = "<icon class='icon-white icon-arrow-up'></icon>"; }
	else { $icon = "<icon class='icon-white icon-arrow-down'></icon>"; }
	array_push( $order_buttons,"<li><a class='btn-list" .$btn_class. "' href='" .$base_url . $param_url . $scale. "&order=" .$criteria['value_url']. "&type=" .$criteria['type']. "&sense=" .$sense_next. "'>" .$criteria['tit'] . $icon. "</a></li>" );
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
	if ( $scale == $scale_slug ) {
	// this is the active button
		array_push( $scale_buttons,"<li class='active'><a href='" .$base_url . $param_url . $scale. "' class='" .$scale_slug. " btn-" .$scale_class. "'>" .$scale_names[$scale_count]. "</a></li>" ); // adding this scale button to the buttons container
	} else {
		array_push( $scale_buttons,"<li><a href='" .$base_url . $param_url . $scale_slug. "' class='" .$scale_slug. " btn-" .$scale_class. "'>" .$scale_names[$scale_count]. "</a></li>" ); // adding this scale button to the buttons container
	}
	$scale_count++;
} // end foreach scale buttons

	// scale tab contents
	if ( $scale == 'all' ) {
		$args = array(
			'posts_per_page' => -1,
			'post_type' => 'case',
			'meta_key' => '_da_'.$order,
			'orderby' => $orderby,
			'order' => $sense,
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
				'terms' => $scale
				)
			),
			'meta_key' => '_da_'.$order,
			'orderby' => $orderby,
			'order' => $sense,
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
	//$scale_count++;

//} // end scales loop

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
	<div class="container">
		<?php echo $tab_tmp;
		//$scale_count = 0;
		//foreach ( $scale_tabs as $tab ) {
		//	if ( $scale_count == $active_tab ) { echo "<div id='" .$scale_slugs[$scale_count]. "' class='tab-pane active'>" .$tab. "</div>"; }
		//	else { echo "<div id='" .$scale_slugs[$scale_count]. "' class='tab-pane'>" .$tab. "</div>"; }
		//	$scale_count++;
		//} ?>
	</div><!-- .container -->
</div><!-- #gallery-items -->

<?php get_footer(); ?>
