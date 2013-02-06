<div id="case-tit" class="row">
	<div class="container">
		<div class="row">
			<div class="span6">
				<h2><?php the_title();?></h2>
			</div>
			<div class="span6">
	<?php 
 	echo 'Year: ' .get_post_meta( $post->ID, 'year', true );
	echo get_the_term_list( $post->ID, 'city', 'City: ', ', ', '' );
	echo get_the_term_list( $post->ID, 'district', 'District: ', ', ', '' );
	echo get_the_term_list( $post->ID, 'neighborhood', 'NH: ', ', ', '' ); ?>
			</div>
		</div>
	</div>
</div><!-- #case-tit -->
<div id="case-img" class="row">
	<div class="container">
		<div class="row">
			<div class="span6">
	<?php the_post_thumbnail('medium'); ?>	
			</div>
			<div class="span6">
	<?php the_post_thumbnail('medium'); ?>	
			</div>
		</div>
	</div>
</div>
<div id="case-metrics" class="row">	
	<div class="container">
		<div class="row">
			<div class="span12">
				<div class="nav-header">Key Density Metrics</div> 
	<?php 
	//for Block and Neighborood Scales
	echo 'FAR ' .get_post_meta( $post->ID, 'far', true ); 
	echo '<br>';
	//common to all scales
	echo 'POP/Ha ' .get_post_meta( $post->ID, 'pop-ha', true );
	?>
			</div>
		</div>
	</div>
</div><!-- #case-metrics -->
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span3">
			<table class="table table-condensed">
				<thead>
					<tr><th>Other Density Measures</th></tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo 'DUs/Ha' ?></td>
						<td><?php echo get_post_meta( $post->ID, 'dus-ha', true ); ?></td>
					</tr>
					<tr>
						<td><?php echo 'm2/Ha' ?></td>
						<td><?php echo get_post_meta( $post->ID, 'm2-ha', true ); ?></td>
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
						<td><?php echo get_post_meta( $post->ID, 'gross-building-area', true ); ?></td>
					</tr>
					<tr>
						<td><?php echo 'Site Area' ?></td>
						<td><?php echo get_post_meta( $post->ID, 'site-area', true ); ?></td>
					</tr>
					<tr>
						<td><?php echo 'Range of Heights' ?></td>
						<td><?php echo get_post_meta( $post->ID, 'range-of-heights', true ); ?></td>
					</tr>
					<tr>
						<td><?php echo 'Dwelling Units' ?></td>
						<td><?php echo get_post_meta( $post->ID, 'dwelling-units', true ); ?></td>
					</tr>
					<tr>
						<td><?php echo 'Parking Spaces' ?></td>
						<td><?php echo get_post_meta( $post->ID, 'parking-spaces', true ); ?></td>
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
						<td><?php echo get_post_meta( $post->ID, 'population', true ); ?></td>
					</tr>
					<tr>
						<td><?php echo 'Income' ?></td>
						<td><?php echo get_post_meta( $post->ID, 'income', true ); ?></td>
					</tr>
					<tr>
						<td><?php echo 'Demographic group' ?></td>
						<td><?php echo get_post_meta( $post->ID, 'demographic-group', true ); ?></td>
					</tr>
				</tbody>
			</table>
			<table class="table table-condensed">
				<thead>
					<tr><th>References</th></tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo get_post_meta( $post->ID, 'references', true ); ?></td>
					</tr>
				</tbody>
			</table>
		<?php //echo 'Location ' .get_post_meta( $post->ID, 'location', true ); ?>
		</div>
		<div class="span9">
			<h2><?php the_title();?></h2>
			<h3><?php echo get_the_term_list( $post->ID, 'scale', '<br>Scale: ', ', ', '' );?></h3>
			<?php echo '<br>Content<br>';?>
			<?php the_content(); ?>
		</div>
	</div>
</div>












           
