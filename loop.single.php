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

	// common graph vars
	$max_width = 300; // width of the graph

	// far graph
	$far_max = 9; // max value of far. should it be 8?
	$far_segment = ($max_width / $far_max) -1; // segment width in px. and remove the "-1"
	// $far_per var contains width of currrent far value, in px
	if ( $case_far > $far_max ) { $far_per = $max_width; }
	else { $far_per = $case_far * $max_width / $far_max; }

	// pop/ha graph
	if ( has_term('block','scale') ) {
		$pop_min = $pop_min_label = 100; // min value of pop/ha
		$pop_max = 5000; // max value of pop/ha
		$pop_max_label = "5,000";
		$pop_segments = array(
			array('num'=>500,'label'=>'500'),
			array('num'=>1000,'label'=>'1,000'),
			array('num'=>2500,'label'=>'2,500'),
		);
	} elseif ( has_term('neighborhood','scale') ) {
		$pop_min = $pop_min_label = 50; // min value of pop/ha
		$pop_max = 4000; // max value of pop/ha
		$pop_max_label = "4,000";
		$pop_segments = array(
			array('num'=>100,'label'=>'100'),
			array('num'=>1000,'label'=>'1,000'),
			array('num'=>2000,'label'=>'2,000'),
		);
	} elseif ( has_term('district','scale') ) {
		$pop_min = $pop_min_label = 10; // min value of pop/ha
		$pop_max = 1000; // max value of pop/ha
		$pop_max_label = "1,000";
		$pop_segments = array(
			array('num'=>50,'label'=>'50'),
			array('num'=>100,'label'=>'100'),
			array('num'=>500,'label'=>'500'),
		);
	}
	$base = pow($pop_max, 1/$max_width); // log base calcule
	// $pop_per var transform this case pop/ha value to width, in px
	if ( $case_pop > $pop_max ) { $pop_per = $max_width; }
	else {	
		//$pop_per = $case_pop * $max_width / $pop_max; // lineal scale
		$pop_per = log($case_pop,$base); // log scale
	}

	// pop/ha graph: building units and markers output
	// opening divs
	$pop_units_out = "
		<div class='case-metric-line' style='top: 10px; position: relative;'>
			<div class='case-metric-unit' style='width: 0; border: none;'>" .$pop_min_label. "</div>
	";
	$pop_segments_out = "
		<div class='case-metric-line'>
			<div class='case-metric-segment' style='width: 0; border: none;'></div>
	";
	// first segment
	$pop_px = log($pop_min,$base); // $pop_min width, in px
	$factor_scale = $max_width / ( $max_width - $pop_px ); // scale factor, to fit $max_width after remove $pop_min width
	// middle segments
	foreach ( $pop_segments as $segment ) {
		$pop_px_prev = $pop_px;
		$pop_px = log($segment['num'],$base);
		$pop_width = ( ( $pop_px - $pop_px_prev ) * $factor_scale ) - 1;
		$pop_units_out .= "<div class='case-metric-unit pop-" .$segment['num']. "' style='width: " .$pop_width. "px; text-align: right;'>" .$segment['label']. "</div>";
		//if ( $segment['num'] == 4500 ) {
		//	$pop_segments_out .= "<div class='case-metric-segment' style='width: " .$pop_width. "px;'>";
		//	if ( $case_pop > 4000 ) { $pop_segments_out .= "<i style='position: absolute; right: 0; bottom: 1px;' class='icon-plus'></i>"; }
		//	$pop_segments_out .= "</div>";
		//} else {
			$pop_segments_out .= "<div class='case-metric-segment' style='width: " .$pop_width. "px;'></div>";
		//}
	}
	// last segment
	$pop_px_prev = $pop_px;
	$pop_px = log($pop_max,$base);
	$pop_width = ( ( $pop_px - $pop_px_prev ) * $factor_scale ) - 2;
	$pop_units_out .= "<div class='case-metric-unit pop-" .$pop_max. "' style='width: " .$pop_width. "px; text-align: right;'>" .$pop_max_label. "</div>";
	$pop_segments_out .= "<div class='case-metric-segment' style='border-right: 1px solid #333; width: " .$pop_width. "px;'></div>";
	// closing divs
	$pop_units_out .= "</div><!-- .case-metric-line -->";
	$pop_segments_out .= "</div><!-- .case-metric-line -->";
	// END pop/ha graph

} // end if case post type

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
			<div class="span8">
				<h2>
					<?php echo $case_tit ?>&nbsp;&nbsp;
					<div id="case-info">
						<small><?php echo get_the_term_list( $post->ID, 'district', '', '', ', ' ) ?> <?php echo get_the_term_list( $post->ID, 'city', '', ', ', '' ) ?>. <?php echo get_the_term_list( $post->ID, 'country', '', ', ', '' ) ?>
						<?php //echo $case_country; // echo  $case_year; ?></small>
					</div>
				</h2>
			</div>
			<div class="span8">
				<ul class="nav nav-pills pull-right">
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
							$term_select_out = "<a class='" .$tax['slug']. " btn-" .$tax['slug']. " dropdown-toggle' data-toggle='dropdown' href='#'>" .$term->name. "</a>";
						} else {
							$term_list_out .= "<li><a href='" .$term_link. "'>" .$term->name. "</a></li>";
						}
					}
				?>
					<li class="dropdown">
						<h4><?php echo $tax_name; ?></h4>
						<?php if ( $term_select_out != '' ) {
							echo $term_select_out;
							unset($term_select_out);
						} else {
							echo "<a class='btn-list btn dropdown-toggle' data-toggle='dropdown' href='#'>Not aplicable</a>";
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
				<?php $extra_image = get_post_meta( $post->ID, '_da_extra_image', true );
				 if ($extra_image != '' ) {  
				 	echo "<img class='span8' height='380' src='" .$extra_image. "' >";
				} else {?>
					<iframe class="span8" height="380" scrolling="no" frameborder="no" 
					src="https://www.google.com/fusiontables/embedviz?q=select+col4+from+1uJv8cueGs0ibGwGmCcUjDha6-hRuFgDLu00PhNo&viz=MAP&h=false&lat=<?php echo $lat ?>&amp;lng=<?php echo $lon ?>&t=2&z=<?php echo $zoom ?>&l=col4&y=2&tmplt=1"></iframe>
				<?php } ?>
			<div class="span8" style="overflow: hidden;">
				
				<?php the_post_thumbnail('medium', array('class' => 'featured-image')); ?>
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
			<div class="span16" style="text-align: center; position: relative;">
			<div id="case-carousel">
					<?php $count = 0;
					foreach ( $img_medium as $img ) {
						$count++;
						//if ( $count == 1 ) { echo '<div class="active item">'; }
						echo "<div><a href='" .$img_attachment_link. "'>".$img."</a></div>";
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
			<div class="span18">
				<h4>Key Density Metrics</h4> 
			</div>
		</div>
		<style>#case-far .case-metric-unit, #case-far .case-metric-segment { width: <?php echo $far_segment ?>px;}</style>
		<div class="row">
		<?php if ( (has_term("block","scale") || has_term("neighborhood","scale")) && $case_far != '0') { 
		// if is a block or a neighborhood and FAR value is not 0 ?>
		<div id="case-far">
			<div class="span1"><h3>FAR</h3></div>
			<div class="span1"><h3><?php echo $case_far; ?></h3></div>
			<div class="span6">
				<div style="position:relative;top:0px">
					<div class="case-metric-line" style="position:absolute;top:0px">
						<div class="case-metric-unit"></div>
						<div class="case-metric-unit"><img src="<?php echo $genvars['blogtheme']; ?>/img/far1.png"></div>
						<div class="case-metric-unit"><img src="<?php echo $genvars['blogtheme']; ?>/img/far2.png"></div>
						<div class="case-metric-unit"><img src="<?php echo $genvars['blogtheme']; ?>/img/far3.png"></div>
						<div class="case-metric-unit"><img src="<?php echo $genvars['blogtheme']; ?>/img/far4.png"></div>
						<div class="case-metric-unit"><img src="<?php echo $genvars['blogtheme']; ?>/img/far5.png"></div>
						<div class="case-metric-unit"><img src="<?php echo $genvars['blogtheme']; ?>/img/far6.png"></div>
						<div class="case-metric-unit"><img src="<?php echo $genvars['blogtheme']; ?>/img/far7.png"></div>
						<div class="case-metric-unit"><img src="<?php echo $genvars['blogtheme']; ?>/img/far8.png"></div>
						<?php if ( $case_far > 8 ) { echo "<i style='position: absolute; right: -25px; bottom: 7px;' class='icon-plus'></i>"; }?>
					</div><!-- .case-metric-line -->
					<div class="case-metric-line" style="position:absolute;top:0px;margin-top: -35px;">
							<div style="width: <?php echo ($far_per+20) ?>px;text-align:right;"><h3><?php echo $case_far; ?></h3></div>
							<div class="case-metric-far" style="width: <?php echo $far_per ?>px;" title="<?php echo $case_far ?>"></div>
					</div><!-- .case-metric-line -->
				</div>
			</div>
		</div><!-- #case-far -->
		<?php } // if is a block or a neighborhood ?>
		<div id="case-pop" >
			<div class="span1"><h3>POP/Ha</h3></div>
			<div class="span1"><h3><?php echo number_format($case_pop); ?></h3></div>
			<div class="span6">
				<div style="position:relative;top:0px">		
					<div class="case-metric-line case-metric-bg case-metric-line-density" style="position:absolute;top:0px;margin-top:-15px;">
						<div style="width: <?php echo ($pop_per+10) ?>px;text-align:right;position:absolute;top: -45px;">
							<h3><?php echo number_format($case_pop); ?></h3><!-- FAR label on graphic -->
						</div>
						<div class="case-metric-far" style="width: <?php echo $pop_per-4; ?>px;float:left;" title="<?php echo $case_pop ?>"></div>
						<?php if ( $case_pop > $pop_max ) { echo "<i style='position: absolute; right: -21px; bottom: 7px;' class='icon-plus'></i>";} ?>
					</div><!-- .case-metric-line -->
					<?php echo $pop_segments_out.$pop_units_out; ?>
				</div>
			</div>
		</div><!-- #case-far -->
		</div>
	<?php } // end if case study post type
	else { // if story ( post type )
		if ( $sentence_tit != '' ) { // if sentence tit ?>
		<div class="row">
			<div class="span18">
				<div class="nav-header"><?php echo $sentence_tit ?></div> 
			</div>
		</div>
		<?php } // if sentence tit
		if ( $sentence != '' ) { // if sentence ?>
		<div class="row">
			<div class="span18">
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
		<div id="case-sidebar" class="span4">
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
									if ( $grossbuildingarea == '' || $grossbuildingarea == '0' || $grossbuildingarea == '0.00' ) {
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
						<td><?php echo 'Site coverage (%)' ?></td>
						<td class="textr"><?php $sitearea = get_post_meta( $post->ID, '_da_site-coverage', true ); 
									echo $sitearea;
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
									if ( $dwellingunits == '' || $dwellingunits == '0' || $dwellingunits == '0.00' ) {
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
									if ( $parkingspaces == '' || $parkingspaces == '0' || $parkingspaces == '0.00' ) {
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
						<td><?php echo 'Area (Ha)' ?></td>
						<td class="textr"><?php $area = get_post_meta( $post->ID, '_da_site-area', true ); 
										echo $area/10000; ?></td>
					</tr>
					<tr>
						<td><?php echo 'Population' ?></td>
						<td class="textr"><?php $population = get_post_meta( $post->ID, '_da_population', true ); 
									echo number_format($population); ?></td>
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
		<div id="case-study-content" class="offset1 span10 text-content">
			<h1><?php echo $case_tit ?></h1>
			<?php if ( get_post_type( $post->ID ) == 'case' ) {
				echo "<h3>" .get_the_term_list( $post->ID, 'scale', '', ', ', '' ). "</h3>";
			}
			the_content(); ?>
		</div>
	</div><!-- .row -->
	</div><!-- .container -->
</div><!-- #case-data -->
