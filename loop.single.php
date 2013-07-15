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
	$max_width = 300;
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
				<h2>
					<?php echo $case_tit ?>&nbsp;&nbsp;
					<div id="case-info">
						<small><?php echo get_the_term_list( $post->ID, 'district', '', '', ', ' ) ?> <?php echo get_the_term_list( $post->ID, 'city', '', ', ', '' ) ?>. <?php echo get_the_term_list( $post->ID, 'country', '', ', ', '' ) ?>
						<?php //echo $case_country; // echo  $case_year; ?></small>
					</div>
				</h2>
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
		<div class="row" style="overflow: hidden;">
			<?php if ( get_post_type( $post->ID ) == 'case' ) {
			// if case study post type
				$location = get_post_meta( $post->ID, '_da_location', true );
				$pattern = '/^[^,]*,/';
				$replacement = '';
				$lon = preg_replace($pattern, $replacement, $location);
				$pattern = '/,[^,]*$/';
				$lat = preg_replace($pattern, $replacement, $location);
				//echo "lat: " .$lat. " | lon: " .$lon;
				$zoom = get_post_meta( $post->ID, '_da_zoom', true );
				if ($zoom == '') {$zoom = '15';}
			?>
				<iframe class="span6" height="380" scrolling="no" frameborder="no" src="https://www.google.com/fusiontables/embedviz?q=select+col4+from+1uJv8cueGs0ibGwGmCcUjDha6-hRuFgDLu00PhNo&viz=MAP&h=false&lat=<?php echo $lat ?>&amp;lng=<?php echo $lon ?>&t=2&z=<?php echo $zoom ?>&l=col4&y=2&tmplt=1"></iframe>
			<div class="span6" style="overflow: hidden;">
				<?php the_post_thumbnail('large', array('class' => 'featured-image')); ?>
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
			<div class="span12" style="text-align: center; position: relative;">
			<div id="case-carousel">
					<?php $count = 0;
					foreach ( $img_medium as $img ) {
						$count++;
						//if ( $count == 1 ) { echo '<div class="active item">'; }
						echo "<div>".$img."</div>";
						//if ( $count % 3 == 0 ) { echo '</div><!-- .item--><div class="item">'; }
					} // end foreach
					//if ( $count % 3 != 0 ) { echo '</div><!-- .item-->'; }
				} // end if img is set
				?>
			</div><!-- #case-carousel -->
			<a class="carousel-control right" href="#" id="ui-carousel-next">&rsaquo;</a>
			<a class="carousel-control left" href="#" id="ui-carousel-prev">&lsaquo;</a>
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
				<h4>Key Density Metrics</h4> 
			</div>
		</div>
		<style>.case-metric-unit, .case-metric-segment { width: <?php echo $case_segment ?>px;}</style>
		<div class="row">
		<?php if ( (has_term("block","scale") || has_term("neighborhood","scale")) && $case_far != '0') { 
		// if is a block or a neighborhood and FAR value is not 0 ?>
		<div id="case-far">
			<div class="span1"><h3>FAR</h3></div>
			<div class="span1"><h3><?php echo $case_far; ?></h3></div>
			<div class="span4">
				<div class="case-metric-line">
					<div class="case-metric-unit">0</div>
					<div class="case-metric-unit">1<img src="<?php echo $genvars['blogtheme']; ?>/img/far1.png"></div>
					<div class="case-metric-unit">2<img src="<?php echo $genvars['blogtheme']; ?>/img/far2.png"></div>
					<div class="case-metric-unit">3<img src="<?php echo $genvars['blogtheme']; ?>/img/far3.png"></div>
					<div class="case-metric-unit">4<img src="<?php echo $genvars['blogtheme']; ?>/img/far4.png"></div>
					<div class="case-metric-unit">5<img src="<?php echo $genvars['blogtheme']; ?>/img/far5.png"></div>
					<div class="case-metric-unit">6<img src="<?php echo $genvars['blogtheme']; ?>/img/far6.png"></div>
					<div class="case-metric-unit">7<img src="<?php echo $genvars['blogtheme']; ?>/img/far7.png"></div>
					<div class="case-metric-unit">8<img src="<?php echo $genvars['blogtheme']; ?>/img/far8.png"></div>
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
					<div class="case-metric-far" style="width: <?php echo $far_per ?>px;" title="<?php echo $case_far ?>"></div>
				</div><!-- .case-metric-line -->
			</div>
		</div><!-- #case-far -->
		<?php } // if is a block or a neighborhood ?>
		<div id="case-pop" >
			<div class="span1"><h3>POP/Ha</h3></div>
			<div class="span1"><h3><?php echo number_format($case_pop); ?></h3></div>
			<div class="span4">
				<div class="case-metric-line">
					<div class="case-metric-unit">0</div>
					<div class="case-metric-unit"> -</div>
					<div class="case-metric-unit">1,000</div>
					<div class="case-metric-unit">-</div>
					<div class="case-metric-unit">2,000</div>
					<div class="case-metric-unit">-</div>
					<div class="case-metric-unit">3,000</div>
					<div class="case-metric-unit">-</div>
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
				<div class="case-metric-line case-metric-bg   case-metric-line-density">
					<div class="case-metric-far" style="width: <?php echo $pop_per ?>px;float:left;" title="<?php echo $case_pop ?>"></div>
				</div><!-- .case-metric-line -->
			</div>
		</div><!-- #case-far -->
		</div>
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
				<h3><?php echo $sentence ?></h3>
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
		// if case study post type
			if ( has_term("city","scale") ) {
			// if is a city
				// all case studies under this city
				// get the city term
				$tax = "city";
				$cities = get_the_terms($post->ID,$tax);
				//print_r($cities);
				foreach ( $cities as $term ) {
					$city = $term->slug;
				}
				$args = array(
					'posts_per_page' => -1,
					'post_type' => 'case',
					'tax_query' => array(
						array(
						'taxonomy' => $tax,
						'field' => 'slug',
						'terms' => $city
						)
					),
					'orderby' => 'title',
					'order' => 'ASC',
				);
				$related_query = new WP_Query( $args );
				if ( $related_query->have_posts() ) :
					$cases_block = array();
					$cases_neigh = array();
					$cases_distr = array();
					while ( $related_query->have_posts() ) : $related_query->the_post();
						//$case_id = get_the_ID();
						$tab_tmp = "";
						$tab_tmp .= "<div class='row'>";
						include "loop.boxes.php";
						$tab_tmp .= "</div>";
						if ( has_term("block","scale") ) {
							array_push($cases_block,$tab_tmp);
						}
						if ( has_term("neighborhood","scale") ) {
							array_push($cases_neigh,$tab_tmp);
						}
						if ( has_term("district","scale") ) {
							array_push($cases_distr,$tab_tmp);
							
						}
					endwhile;
				else :
				// if no related posts, code in here
				endif;
				wp_reset_query();
				// output
				if ($cases_block != '' ) {
					echo "<div class='row'><div class='nav-header'>Blocks</div></div>";
					foreach ( $cases_block as $case ) { echo $case; }
				}
				if ($cases_neigh != '' ) {
					echo "<div class='row'><div class='nav-header'>Neighborhoods</div></div>";
					foreach ( $cases_neigh as $case ) { echo $case; }
				}
				if ($cases_distr != '' ) {
					echo "<div class='row'><div class='nav-header'>Districts</div></div>";
					foreach ( $cases_distr as $case ) { echo $case; }
				}

			} else {
			// if is not a city ?>
			<table class="table table-condensed">
				<thead>
					<tr><th>Other Density Measures</th></tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo 'DUs/Ha' ?></td>
						<td class="textr"><?php echo get_post_meta( $post->ID, '_da_dus-ha', true ); ?></td>
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
						<td><?php echo 'Gross Building Area (m2)' ?></td>
						<td class="textr">
								<?php $grossbuildingarea = get_post_meta( $post->ID, '_da_gross-building-area', true ); 
									if ( $grossbuildingarea == '') {
										$grossbuildingarea = 'N/A';}
									else {
										$grossbuildingarea = number_format($grossbuildingarea);
									}
									echo $grossbuildingarea; ?>
						</td>
					</tr>
					<tr>
						<td><?php echo 'Site area (ha)' ?></td>
						<td class="textr"><?php $sitearea = get_post_meta( $post->ID, '_da_site-area', true ); 
									if (has_term("block","scale")) {
									echo number_format($sitearea/10000,2);
									} else {
									echo number_format($sitearea/10000,1);
									}
						 ?></td>
					</tr>
					<tr>
						<td><?php echo 'Range of heights (floors)' ?></td>
						<td class="textr"><?php echo get_post_meta( $post->ID, '_da_range-of-heights', true ); ?></td>
					</tr>
					<tr>
						<td><?php echo 'Dwelling Units' ?></td>
						<td class="textr">
								<?php $dwellingunits = get_post_meta( $post->ID, '_da_dwelling-units', true ); 
									if ( $dwellingunits == '') {
										$dwellingunits = 'N/A';}
									else {
										$dwellingunits = number_format($dwellingunits);
									}
									echo $dwellingunits; ?>
						</td>
					</tr>
					<tr>
						<td><?php echo 'Parking Spaces' ?></td>
						<td class="textr">
								<?php $parkingspaces = get_post_meta( $post->ID, '_da_parking-space', true ); 
									if ( $parkingspaces == '') {
										$parkingspaces = 'N/A';}
									else {
										$parkingspaces = number_format($parkingspaces);
									}
									echo $parkingspaces; ?>



						</td>
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
						<td class="textr"><?php $population = get_post_meta( $post->ID, '_da_population', true ); 
									echo number_format($population); ?></td>
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
						<td><?php $case_author = get_post_meta( $post->ID, '_da_author', true );
									if  ($case_author != '') {
										echo $case_author; 
										}
									else { 
										the_author(); 
										} ?>	
						</td>
						
					</tr>
				</tbody>
			</table>
			<table class="table table-condensed">
				<thead>
					<tr><th>References</th></tr>
				</thead>
				<tbody>
					<tr>
						<td>
						<?php $ref = get_post_meta( $post->ID, '_da_references', true );
						$ref = apply_filters( 'the_content', $ref );
						echo $ref; ?>
						</td>
					</tr>
				</tbody>
			</table>
		<?php //echo 'Location ' .get_post_meta( $post->ID, 'location', true );
			} // end if not city scale
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
		<?php wp_reset_query(); ?>
		<div id="case-study-content" class="span9 text-content">
			<h1><?php echo $case_tit ?></h1>
			<?php if ( get_post_type( $post->ID ) == 'case' ) {
				echo "<h3>" .get_the_term_list( $post->ID, 'scale', '', ', ', '' ). "</h3>";
			}
			the_content(); ?>
		</div>
	</div><!-- .row -->
	</div><!-- .container -->
</div><!-- #case-data -->
