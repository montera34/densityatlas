<?php
// common vars
$case_tit = get_the_title();

if ( get_post_type( $post->ID ) == 'case' ) {
// case study vars
	$countries = get_the_terms( $post->ID, "country" );
	if ( $countries != '' ) {
		foreach ( $countries as $country ) {
			$case_country = $country->name;
		}
	}
	$case_year = get_post_meta( $post->ID, '_da_year', true );
	$case_far = get_post_meta( $post->ID, '_da_far', true );
	$case_pop = get_post_meta( $post->ID, '_da_pop-ha', true );
	$max_width = 700;
	$far_max = 9;
	$case_segment = ($max_width / $far_max) -1;
	if ( $case_far > 8 ) { $far_per == $max_width; }
	else { $far_per = $case_far * $max_width / $far_max; }
	$pop_max = 4500;
	if ( $case_pop > 4000 ) { $pop_per == $max_width; }
	else { $pop_per = $case_pop * $max_width / $pop_max; }
}

if ( get_post_type( $post->ID ) == 'post' ) {
// story vars
	$sentence_tit = get_post_meta( $post->ID, '_da_sentence_tit', true );
	$sentence = get_post_meta( $post->ID, '_da_sentence', true );
}

// output
?>
<div id="case-tit" class="row">
	<div class="container">
		<div class="row">
			<?php if ( get_post_type( $post->ID ) == 'case' ) {
			// if case study post type ?>
			<div class="span6">
				<h2><?php echo $case_tit. ", " .$case_country. "&nbsp;&nbsp;" .$case_year; ?></h2>
			</div>
			<div class="span6">
				<ul class="nav nav-pills">
				<?php $taxs = array(
					array('slug' => 'scale','name' => 'Scale'),
				//	array('slug' => 'country','name' => 'Country'),
					array('slug' => 'city','name' => 'City'),
					array('slug' => 'district','name' => 'District'),
					array('slug' => 'neighborhood','name' => 'Neighborhood'),
				);
				foreach ( $taxs as $tax ) {
					$tax_name = $tax['name'];
					$args = array(
						'hide_empty' => false,
						'orderby' => 'name',
						'order' => 'ASC'
					);
					$terms = get_terms( $tax['slug'], $args );
					$term_list_out = "";
					$select_count = 1;
					foreach ( $terms as $term ) {
						$term_link = get_term_link( $term );
						if ( has_term($term->term_id, $tax['slug']) && $select_count == 1 ) {
							$select_count++;
							$term_select_out = "<a class='btn btn-small dropdown-toggle' data-toggle='dropdown' href='#'>" .$term->name. "</a>";
						} else {
							$term_list_out .= "<li><a href='" .$term_link. "'>" .$term->name. "</a></li>";
						}
					}
				?>
					<li class="dropdown">
						<?php echo $tax_name; ?><br />
						<?php if ( $term_select_out != '' ) {
							echo $term_select_out;
							unset($term_select_out);
						} else {
							echo "<a class='btn btn-small dropdown-toggle' data-toggle='dropdown' href='#'>Not aplicable</a>";
						} ?>
						<ul class="dropdown-menu">
							<?php echo $term_list_out; ?>
						</ul>
					</li>
				<?php } // end loop taxonomies
				?>
				</ul><!-- .nav-pills -->
			</div>
			<?php } // if case study post type
			else {
			// if story ( if post ) ?>
			<div class="span6">
				<h2><?php echo $case_tit; ?></h2>
			</div>
			<?php } // if story ( if post ) ?>
		</div>
	</div>
</div><!-- #case-tit -->
<div id="case-img" class="row">
	<div class="container">
		<div class="row">
			<?php if ( get_post_type( $post->ID ) == 'case' ) {
			// if case study post type ?>
			<iframe class="span6" height="300" scrolling="no" frameborder="no" src="https://www.google.com/fusiontables/embedviz?viz=MAP&amp;q=select+col4+from+1uJv8cueGs0ibGwGmCcUjDha6-hRuFgDLu00PhNo&amp;h=false&amp;lat=35.70219412474616&amp;lng=139.70619167330935&amp;z=16&amp;t=3&amp;l=col4"></iframe>
			<div class="span6">
				<?php the_post_thumbnail(array(450,400)); ?>	
			</div>
			<?php } // end if case study post type
			else {
			// if story ( if post ) 
				// carousel
				$img_amount = -1;
				$img_post_parent = get_the_ID();
	//			$mini_size = array(100,100);
				$medium_size = "medium";
	//			$large_size = "large";
				include "loop.attachment.php";
				if ( isset($img_medium) ) { ?>
			<div id="case-carousel" class="carousel slide">
				<div class="carousel-inner">
					<?php $count = 0;
					foreach ( $img_medium as $img ) {
						$count++;
						if ( $count == 1 ) { ?>
						<div class="active item">
						<?php } else { ?>
						<div class="item">
						<?php } ?>
							<?php echo $img ?>
						</div><!-- end .item -->
				<?php } // end foreach ?>
				<?php } // end if img is set
				if ( count($img_medium) > 1 ) { ?>
					<a class="carousel-control left" href="#case-carousel" data-slide="prev">&lsaquo;</a>
					<a class="carousel-control right" href="#case-carousel" data-slide="next">&rsaquo;</a>
				<?php } // end if more than 1 img ?>
				</div><!-- .carousel-inner -->
			</div><!-- #case-carousel -->
			<?php } ?>
		</div><!-- .row -->
	</div><!-- .container -->
</div><!-- #case-img -->
<div id="case-metrics" class="row">	
	<div class="container">
		<?php if ( get_post_type( $post->ID ) == 'case' ) {
		// if case study post type ?>
		<div class="row">
			<div class="span12">
				<div class="nav-header">Key Density Metrics</div> 
			</div>
		</div>
		<style>.case-metric-unit, .case-metric-segment { width: <?php echo $case_segment ?>px;}</style>
		<?php if ( has_term("block","scale") || has_term("neighborhood","scale") ) {
		// if is a block or a neighborhood ?>
		<div id="case-far" class="row">
			<div class="span2">FAR</div>
			<div class="span1"><?php echo $case_far; ?></div>
			<div class="span9">
				<div class="case-metric-line">
					<div class="case-metric-unit">0</div>
					<div class="case-metric-unit">South End Boston</div>
					<div class="case-metric-unit">2</div>
					<div class="case-metric-unit">South End Boston</div>
					<div class="case-metric-unit">4</div>
					<div class="case-metric-unit">South End Boston</div>
					<div class="case-metric-unit">6</div>
					<div class="case-metric-unit">South End Boston</div>
					<div class="case-metric-unit">8</div>
				</div><!-- .case-metric-line -->
				<div class="case-metric-line">
					<div class="case-metric-segment"></div>
					<div class="case-metric-segment"></div>
					<div class="case-metric-segment"></div>
					<div class="case-metric-segment"></div>
					<div class="case-metric-segment"></div>
					<div class="case-metric-segment"></div>
					<div class="case-metric-segment"></div>
					<div class="case-metric-segment"></div>
					<div class="case-metric-segment">
						<?php if ( $case_far > 8 ) { echo "<i style='position: absolute; right: 0; bottom: 1px;' class='icon-plus'></i>"; }?>
					</div>
				</div><!-- .case-metric-line -->
				<div class="case-metric-line case-metric-bg">
					<div class="case-metric-far" style="width: <?php echo $far_per ?>px;"></div>
				</div><!-- .case-metric-line -->
			</div>
		</div><!-- #case-far -->
		<?php } // if is a block or a neighborhood ?>
		<div id="case-pop" class="row">
			<div class="span2">POP/Ha</div>
			<div class="span1"><?php echo $case_pop; ?></div>
			<div class="span9">
				<div class="case-metric-line">
					<div class="case-metric-unit">0</div>
					<div class="case-metric-unit">South End Boston</div>
					<div class="case-metric-unit">1,000</div>
					<div class="case-metric-unit">South End Boston</div>
					<div class="case-metric-unit">2,000</div>
					<div class="case-metric-unit">South End Boston</div>
					<div class="case-metric-unit">3,000</div>
					<div class="case-metric-unit">South End Boston</div>
					<div class="case-metric-unit">4,000</div>
				</div><!-- .case-metric-line -->
				<div class="case-metric-line">
					<div class="case-metric-segment"></div>
					<div class="case-metric-segment"></div>
					<div class="case-metric-segment"></div>
					<div class="case-metric-segment"></div>
					<div class="case-metric-segment"></div>
					<div class="case-metric-segment"></div>
					<div class="case-metric-segment"></div>
					<div class="case-metric-segment"></div>
					<div class="case-metric-segment">
						<?php if ( $case_pop > 4000 ) { echo "<i style='position: absolute; right: 0; bottom: 1px;' class='icon-plus'></i>"; }?>
					</div>
				</div><!-- .case-metric-line -->
				<div class="case-metric-line case-metric-bg">
					<div class="case-metric-far" style="width: <?php echo $pop_per ?>px;"></div>
				</div><!-- .case-metric-line -->
			</div>
		</div><!-- #case-far -->
	<?php } // end if case study post type
	else { // if story ( post type )
		if ( $sentence_tit != '' ) { // if sentence tit ?>
		<div class="row">
			<div class="span12">
				<div class="nav-header"><?php echo $sentence_tit ?></div> 
			</div>
		</div>
		<?php } // if sentence tit
		if ( $sentence != '' ) { // if sentence ?>
		<div class="row">
			<div class="span12">
				<p><?php echo $sentence ?></p>
			</div>
		</div>
		<?php } // if sentence
	} // if story ?>
	</div><!-- .container -->
</div><!-- #case-metrics -->
<div id="case-data" class="row">
	<div class="container">
	<div class="row">
		<div id="case-sidebar" class="span3">
		<?php if ( get_post_type( $post->ID ) == 'case' ) {
		// if case study post type ?>
			<table class="table table-condensed">
				<thead>
					<tr><th>Other Density Measures</th></tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo 'DUs/Ha' ?></td>
						<td class="textr"><?php echo get_post_meta( $post->ID, '_da_dus-ha', true ); ?></td>
					</tr>
					<tr>
						<td><?php echo 'm2/Ha' ?></td>
						<td class="textr"><?php echo get_post_meta( $post->ID, '_da_m2-ha', true ); ?></td>
					</tr>
				</tbody>
			</table>
			<?php if ( has_term("block","scale") || has_term("neighborhood","scale") ) {
			// if is a block or a neighborhood ?>
			<table class="table table-condensed">
				<thead>
					<tr><th>Project data</th></tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo 'Gross Building Area' ?></td>
						<td class="textr"><?php echo get_post_meta( $post->ID, '_da_gross-building-area', true ); ?></td>
					</tr>
					<tr>
						<td><?php echo 'Site Area' ?></td>
						<td class="textr"><?php echo get_post_meta( $post->ID, '_da_site-area', true ); ?></td>
					</tr>
					<tr>
						<td><?php echo 'Range of Heights' ?></td>
						<td class="textr"><?php echo get_post_meta( $post->ID, '_da_range-of-heights', true ); ?></td>
					</tr>
					<tr>
						<td><?php echo 'Dwelling Units' ?></td>
						<td class="textr"><?php echo get_post_meta( $post->ID, '_da_dwelling-units', true ); ?></td>
					</tr>
					<tr>
						<td><?php echo 'Parking Spaces' ?></td>
						<td class="textr"><?php echo get_post_meta( $post->ID, '_da_parking-spaces', true ); ?></td>
					</tr>
				</tbody>
			</table>
			<table class="table table-condensed">
				<thead>
					<tr><th>People</th></tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo 'Population' ?></td>
						<td class="textr"><?php echo get_post_meta( $post->ID, '_da_population', true ); ?></td>
					</tr>
					<tr>
						<td><?php echo 'Income' ?></td>
						<td class="textr"><?php echo get_post_meta( $post->ID, '_da_income', true ); ?></td>
					</tr>
					<tr>
						<td><?php echo 'Demographic group' ?></td>
						<td class="textr"><?php echo get_post_meta( $post->ID, '_da_demographic-group', true ); ?></td>
					</tr>
				</tbody>
			</table>
			<?php } // end if block or neighborhood
			elseif ( has_term("district","scale") ) {
			// if district ?>
			<table class="table table-condensed">
				<thead>
					<tr><th>District data</th></tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo 'Area' ?></td>
						<td class="textr"><?php echo "data"; ?></td>
					</tr>
					<tr>
						<td><?php echo 'Population' ?></td>
						<td class="textr"><?php echo get_post_meta( $post->ID, '_da_population', true ); ?></td>
				</tbody>
			</table>
			<?php } // end if district ?>
			<table class="table table-condensed">
				<thead>
					<tr><th>Author</th></tr>
				</thead>
				<tbody>
					<tr>
						<td><?php the_author(); ?></td>
					</tr>
				</tbody>
			</table>
			<table class="table table-condensed">
				<thead>
					<tr><th>References</th></tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo get_post_meta( $post->ID, '_da_references', true ); ?></td>
					</tr>
				</tbody>
			</table>
		<?php //echo 'Location ' .get_post_meta( $post->ID, 'location', true );
		} // end if case study post type
		else { // if story ( post type )
			// related case studies loop
			$count_rel = 1;
			$rel_ids = array();
			while ( $count_rel < 6 ) {
				$rel_slug = get_post_meta( $post->ID, '_da_story_rel'.$count_rel, true );
				if ( $rel_slug != '' ) {
					$rel_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '$rel_slug'");
					if ( $rel_id ) { array_push($rel_ids,$rel_id); }
				}
				$count_rel++;
				unset($rel_slug);
			}
			$args = array(
				'posts_per_page' => -1,
				'post_type' => 'case',
				'post__in' => $rel_ids
			);
			$related_query = new WP_Query( $args );
			if ( $related_query->have_posts() ) :
				$tab_tmp = "";				
				echo "<div class='nav-header'>Relevant case studies</div>";
				while ( $related_query->have_posts() ) : $related_query->the_post();
					$tab_tmp .= "<div class='row'>";
					include "loop.boxes.php";
					$tab_tmp .= "</div>";
				endwhile;
				echo $tab_tmp;
			else :
			// if no related posts, code in here
			endif; ?>
			<table class="table table-condensed">
				<thead>
					<tr><th>References</th></tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo get_post_meta( $post->ID, '_da_story_references', true ); ?></td>
					</tr>
				</tbody>
			</table>
		

		<?php } // if story ?>
		</div><!-- #case-sidebar -->
		<div class="span6 offset1">
			<h2><?php echo $case_tit ?></h2>
			<?php if ( get_post_type( $post->ID ) == 'case' ) {
				echo "<h3>" .get_the_term_list( $post->ID, 'scale', 'Scale: ', ', ', '' ). "</h3>";
			}
			the_content(); ?>
		</div>
	</div><!-- .row -->
	</div><!-- .container -->
</div><!-- #case-data -->
