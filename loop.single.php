<?php
$case_tit = get_the_title();
$countries = get_the_terms( $post->ID, "country" );
if ( $countries != '' ) {
	foreach ( $countries as $country ) {
		$case_country = $country->name;
	}
}
$case_year = get_post_meta( $post->ID, '_da_year', true );
$case_far = get_post_meta( $post->ID, '_da_far', true );
$far_max = 8;
$far_per = $case_far * 700 / $far_max;
$case_pop = get_post_meta( $post->ID, '_da_pop-ha', true );
$pop_max = 4000;
$pop_per = $case_pop * 700 / $pop_max;
?>
<div id="case-tit" class="row">
	<div class="container">
		<div class="row">
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

	<?php 
// 	echo 'Year: ' .get_post_meta( $post->ID, 'year', true );
//	echo get_the_term_list( $post->ID, 'city', 'City: ', ', ', '' );
//	echo get_the_term_list( $post->ID, 'district', 'District: ', ', ', '' );
//	echo get_the_term_list( $post->ID, 'neighborhood', 'NH: ', ', ', '' ); ?>
			</div>
		</div>
	</div>
</div><!-- #case-tit -->
<div id="case-img" class="row">
	<div class="container">
		<div class="row">
			<iframe class="span6" height="300" scrolling="no" frameborder="no" src="https://www.google.com/fusiontables/embedviz?viz=MAP&amp;q=select+col4+from+1uJv8cueGs0ibGwGmCcUjDha6-hRuFgDLu00PhNo&amp;h=false&amp;lat=35.70219412474616&amp;lng=139.70619167330935&amp;z=16&amp;t=3&amp;l=col4"></iframe>
			<div class="span6">
				<?php the_post_thumbnail(array(450,400)); ?>	
			</div>
		</div>
	</div>
</div>
<div id="case-metrics" class="row">	
	<div class="container">
		<div class="row">
			<div class="span12">
				<div class="nav-header">Key Density Metrics</div> 
			</div>
		</div>
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
					<div class="case-metric-segment" style="border-right: 1px solid #ddd;"></div>
				</div><!-- .case-metric-line -->
				<div class="case-metric-line case-metric-bg">
					<div class="case-metric-far" style="width: <?php echo $far_per ?>px;"></div>
				</div><!-- .case-metric-line -->
			</div>
		</div><!-- #case-far -->
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
					<div class="case-metric-segment" style="border-right: 1px solid #ddd;"></div>
				</div><!-- .case-metric-line -->
				<div class="case-metric-line case-metric-bg">
					<div class="case-metric-far" style="width: <?php echo $pop_per ?>px;"></div>
				</div><!-- .case-metric-line -->
			</div>
		</div><!-- #case-far -->
	
	<?php 
	//for Block and Neighborood Scales
	//echo 'FAR ' .get_post_meta( $post->ID, 'far', true ); 
	//echo '<br>';
	//common to all scales
	//echo 'POP/Ha ' .get_post_meta( $post->ID, 'pop-ha', true );
	?>
	</div><!-- .container -->
</div><!-- #case-metrics -->
<div id="case-data" class="row">
	<div class="container">
	<div class="row">
		<div id="case-sidebar" class="span3">
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
		<?php //echo 'Location ' .get_post_meta( $post->ID, 'location', true ); ?>
		</div>
		<div class="span8 offset1">
			<h2><?php the_title();?></h2>
			<h3><?php echo get_the_term_list( $post->ID, 'scale', '<br>Scale: ', ', ', '' );?></h3>
			<?php echo '<br>Content<br>';?>
			<?php the_content(); ?>
		</div>
	</div>
	</div>
</div><!-- #case-data -->












           
