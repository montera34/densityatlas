<?php /* Template Name: List */
get_header();
?>

<?php
// LOOPS
// one loop per scale to make live filters
$scale_buttons = array(); // filter buttons container
$scale_tabs = array(); // tabs content container
$scale_slugs = array("all","block","neighborhood","district");
$scale_names = array("Reset","Block","Neighborhood","District");
$scale_count = 0;

foreach ( $scale_slugs as $scale_slug ) {

	$tab_tmp = ""; // temporal cointainer for tab content before add to array
	if ( $scale_slug == 'block' ) { $scale_class = $scale_slug. "k"; }
	else { $scale_class = $scale_slug; }
	// scale tab button
	if ( $scale_count == 0 ) {
	// this is the active button
		array_push( $scale_buttons,"<li class='active'><a href='#" .$scale_slug. "' class='" .$scale_slug. " btn btn-small btn-" .$scale_class. "' data-toggle='tab'>" .$scale_names[$scale_count]. "</a></li>" ); // adding this scale button to the buttons container
	} else {
		array_push( $scale_buttons,"<li><a href='#" .$scale_slug. "' class='" .$scale_slug. " btn btn-small btn-" .$scale_class. "' data-toggle='tab'>" .$scale_names[$scale_count]. "</a></li>" ); // adding this scale button to the buttons container
	}
	// scale tab contents
	if ( $scale_slug == 'all' ) {
		$args = array(
			'posts_per_page' => -1,
			'post_type' => 'case',
			'meta_key' => '_da_far',
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
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
			'meta_key' => '_da_far',
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
		);
	}
	
	$related_query = new WP_Query( $args );
	if ( $related_query->have_posts() ) :
		$tab_tmp = "<table class='table table-condensed'>
			<thead>
				<tr>
					<th>Country</th>
					<th>City</th>
					<th>Location</th>
					<th>Scale</th>
					<th>FAR</th>
					<th>DU/Area</th>
					<th>POP/Area</th>
				</tr>
			</thead>
			<tbody>
		";
		while ( $related_query->have_posts() ) : $related_query->the_post();
			$countries = get_the_terms($post->ID,"country");
			if ( $countries ) {
				foreach ( $countries as $term ) { $country = $term->name;}
			}
			$cities = get_the_terms($post->ID,"city");
			if ( $cities ) {
				foreach ( $cities as $term ) { $city = $term->name; }
			}
			$scales = get_the_terms($post->ID,"scale");
			if ( $cities ) {
				foreach ( $scales as $term ) { $scale = $term->name; }
			}
			$location = "<a href='" .get_permalink(). "'>" .get_the_title(). "</a>";
			$far = get_post_meta( $post->ID, '_da_far', true );
			$pop = get_post_meta( $post->ID, '_da_pop-ha', true );
			$du = get_post_meta( $post->ID, '_da_dus-ha', true );
			$tab_tmp .= "
				<tr>
					<td>" .$country. "</td>
					<td>" .$city. "</td>
					<td>" .$location. "</td>
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
	array_push( $scale_tabs, $tab_tmp ); // adding this scale button to the buttons container
	wp_reset_query();
	$scale_count++;

} // end scales loop

// output
?>

<div id="gallery-tit" class="row">
	<div class="container">
		<div class="row">
			<div class="span3"><h2><?php the_title();?></h2></div>
			<div class="span3">
				<h4>Sort by</h4>
				<h4><a href="" class="btn btn-small">FAR</a> <a href="" class="btn btn-small">People / Ha</a></h4>
			</div>
			<div class="span6">
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
	<div class="container tab-content">
		<?php
		$scale_count = 0;
		foreach ( $scale_tabs as $tab ) {
			if ( $scale_count == 0 ) { echo "<div id='" .$scale_slugs[$scale_count]. "' class='tab-pane active'>" .$tab. "</div>"; }
			else { echo "<div id='" .$scale_slugs[$scale_count]. "' class='tab-pane'>" .$tab. "</div>"; }
			$scale_count++;
		} ?>
	</div><!-- .container -->
</div><!-- #gallery-items -->

<?php get_footer(); ?>
