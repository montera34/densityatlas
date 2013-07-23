<?php /* Template Name: List */
get_header();
?>

<?php
$base_url = get_permalink();
preg_match('/\?/',$base_url,$matches); // check if pretty permalinks enabled
if ( $matches[0] == "?" ) { $param_url = "&order="; }
else { $param_url = "?order="; }
$scale = sanitize_text_field( $_GET['scale'] );
$order = sanitize_text_field( $_GET['order'] );
$orderby = sanitize_text_field( $_GET['type'] );
$sense = sanitize_text_field( $_GET['sense'] );
if ( $scale == '' ) { $scale = "all"; }
if ( $order == '' ) { $order = "far"; $orderby = "meta_value_num"; }
if ( $sense == '' ) { $sense = "DESC"; }
$orders = array(
	array(
		'value_url' => 'tit',
		'type' => 'meta_value',
		'tit' => 'Location'
	),
	array(
		'value_url' => 'tax_city',
		'type' => 'meta_value',
		'tit' => 'City'
	),
	array(
		'value_url' => 'tax_country',
		'type' => 'meta_value',
		'tit' => 'Country'
	),
	array(
		'value_url' => 'tax_scale',
		'type' => 'meta_value',
		'tit' => 'Scale'
	),
	array(
		'value_url' => 'far',
		'type' => 'meta_value_num',
		'tit' => 'FAR'
	),
	array(
		'value_url' => 'dus-ha',
		'type' => 'meta_value_num',
		'tit' => 'DU/Area'
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
	array_push( $order_buttons,"<th><a class='btn-list" .$btn_class. "' href='" .$base_url . $param_url . $criteria['value_url']. "&type=" .$criteria['type']. "&sense=" .$sense_next. "&scale=" .$scale. "'>" .$criteria['tit'] . $icon. "</a></th>" );
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
		array_push( $scale_buttons,"<li class='active'><a href='" .$base_url. "?scale=" .$scale_slug. "' class='" .$scale_slug. " btn-" .$scale_class. "'>" .$scale_names[$scale_count]. "</a></li>" ); // adding this scale button to the buttons container
	} else {
		array_push( $scale_buttons,"<li><a href='" .$base_url. "?scale=" .$scale_slug. "' class='" .$scale_slug. " btn-" .$scale_class. "'>" .$scale_names[$scale_count]. "</a></li>" ); // adding this scale button to the buttons container
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
		$tab_tmp = "<table class='table table-condensed table-hover'>
			<thead>
				<tr>
		";
		foreach ( $order_buttons as $button ) { $tab_tmp .= $button; }
		$tab_tmp .= "
				</tr>
			</thead>
			<tbody>
		";
		while ( $related_query->have_posts() ) : $related_query->the_post();
			$location = "<a href='" .get_permalink(). "'>" .get_the_title(). "</a>";
			$cities = get_the_terms($post->ID,"city");
			if ( $cities ) {
				foreach ( $cities as $term ) { $city = $term->name; }
			}
			$countries = get_the_terms($post->ID,"country");
			if ( $countries ) {
				foreach ( $countries as $term ) { $country = $term->name;}
			}
			$scales = get_the_terms($post->ID,"scale");
			if ( $scales ) {
				foreach ( $scales as $term ) { $scale = $term->name; }
			}
			$far = get_post_meta( $post->ID, '_da_far', true );
			$pop = get_post_meta( $post->ID, '_da_pop-ha', true );
			$du = get_post_meta( $post->ID, '_da_dus-ha', true );
			if ( $far == '' || $far == '0' || $far == '0.00' || $far == 'n/a' ) { $far = 'N/A'; }
			if ( $pop == '' || $pop == '0' || $pop == '0.00' || $pop == 'n/a' ) { $pop = 'N/A'; }
			if ( $du == '' || $du == '0' || $du == '0.00' || $du == 'n/a' ) { $du = 'N/A'; }
			$tab_tmp .= "
				<tr>
					<td>" .$location. "</td>
					<td>" .$city. "</td>
					<td>" .$country. "</td>
					<td>" .$scale. "</td>
					<td>" .$far. "</td>
					<td>" .$du. "</td>
					<td>" .$pop. "</td>
				</tr>
			";
		endwhile;
		$tab_tmp .= "</tbody></table>";
	else :
	// if no related posts, code in here
	endif;
	//array_push( $scale_tabs, $tab_tmp ); // adding this scale button to the buttons container
	wp_reset_query();
	//$scale_count++;

//} // end scales loop

// output
?>

<div id="gallery-tit" class="row">
	<div class="container">
		<div class="row">
			<div class="span4"><h2><?php the_title();?></h2></div>
			<div class="span8 offset4">
				<h4>Filter by</h4>
				<ul id="filters" class="inline">
					<?php foreach ( $scale_buttons as $button ) { echo $button; } ?>
				</ul>
			</div>
		</div>
	</div>
</div><!-- #gallery-tit -->
	<?php 
//	if ( have_posts() ) :
//		while ( have_posts() ) : the_post();
//			include("loop.page.php");
//		endwhile;
//	else :
//	endif;
//	rewind_posts(); ?>

<div id="gallery-items" class="row">
	<div class="container">
		<?php echo $tab_tmp;
		//$scale_count = 0;
		//foreach ( $scale_tabs as $tab ) {
		//	if ( $scale_count == 0 ) { echo "<div id='" .$scale_slugs[$scale_count]. "' class='tab-pane active'>" .$tab. "</div>"; }
		//	else { echo "<div id='" .$scale_slugs[$scale_count]. "' class='tab-pane'>" .$tab. "</div>"; }
		//	$scale_count++;
		//} ?>
	</div><!-- .container -->
</div><!-- #gallery-items -->

<?php get_footer(); ?>
