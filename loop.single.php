<div class="span12">
	<h2><?php the_title();?></h2> 
	<?php 
 	echo 'Year: ' .get_post_meta( $post->ID, 'year', true );
	echo get_the_term_list( $post->ID, 'city', 'City: ', ', ', '' );
	echo get_the_term_list( $post->ID, 'district', 'District: ', ', ', '' );
	echo get_the_term_list( $post->ID, 'neighborhood', 'NH: ', ', ', '' ); ?>
</div>
<div class="span12">
	<?php the_post_thumbnail('medium'); the_post_thumbnail('medium');?>	
</div>
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
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span3">
			<div class="well sidebar-nav">
				<ul class="nav nav-list">
					<li class="nav-header">Other Density Measures</li>
					<li><?php echo 'DUs/Ha ' .get_post_meta( $post->ID, 'dus-ha', true ); ?></li>
					<li><?php echo 'm2/Ha ' .get_post_meta( $post->ID, 'm2-ha', true ); ?></li>
					<li class="nav-header">Project data</li>
					<li><?php echo 'Gross Building Area ' .get_post_meta( $post->ID, 'gross-building-area', true ); ?></li>
					<li><?php echo 'Site Area ' .get_post_meta( $post->ID, 'site-area', true ); ?></li>
					<li><?php echo 'Range of Heights ' .get_post_meta( $post->ID, 'range-of-heights', true ); ?></li>
					<li><?php echo 'Dwelling Units ' .get_post_meta( $post->ID, 'dwelling-units', true ); ?></li>
					<li><?php echo 'Parking Spaces ' .get_post_meta( $post->ID, 'parking-spaces', true ); ?></li>
					<li class="nav-header">People</li>
					<li><?php echo 'Population ' .get_post_meta( $post->ID, 'population', true ); ?></li>
					<li><?php echo 'Income ' .get_post_meta( $post->ID, 'income', true ); ?></li>
					<li><?php echo 'Demographic group ' .get_post_meta( $post->ID, 'demographic-group', true ); ?>
					<li class="nav-header">References</li>
					<li><?php echo 'References ' .get_post_meta( $post->ID, 'references', true );?></li>

		<?php echo 'Location ' .get_post_meta( $post->ID, 'location', true ); ?>
			</div>
		</div>
		<div class="span9">
			<h2><?php the_title();?></h2>
			<h3><?php echo get_the_term_list( $post->ID, 'scale', '<br>Scale: ', ', ', '' );?></h3>
			<?php echo '<br>Content<br>';?>
			<?php the_content(); ?>
		</div>
	</div>
</div>












           
