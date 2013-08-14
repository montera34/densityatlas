<?php
// register js scripts to avoid conflicts
function da_scripts_method() {
	wp_enqueue_script('jquery');
	wp_enqueue_script(
		'bootstrap.min',
		get_template_directory_uri() . '/js/bootstrap.min.js',
		array( 'jquery' ),
		'2.1.2',
		TRUE
	);
	if ( is_front_page() ) {
	// if is home page, load masonry
		wp_enqueue_script(
			'masonry',
			get_template_directory_uri() . '/js/jquery.masonry.min.js',
			array( 'jquery' ),
			'2.1.08',
			TRUE
		);
		wp_enqueue_script(
			'masonry.options',
			get_template_directory_uri() . '/js/jquery.masonry.options.js',
			array( 'jquery','masonry' ),
			'1.0',
			TRUE
		);
	} // end if home page
	if ( is_single() && get_post_type() == 'post' ) {
	// if single post
		wp_enqueue_script(
			'jquery.core',
			get_template_directory_uri() . '/rcarousel/widget/lib/jquery.ui.core.min.js',
			array( 'jquery' ),
			'1.8',
			TRUE
		);
		wp_enqueue_script(
			'jquery.widget',
			get_template_directory_uri() . '/rcarousel/widget/lib/jquery.ui.widget.min.js',
			array( 'jquery' ),
			'1.8',
			TRUE
		);
		wp_enqueue_script(
			'rcarousel',
			get_template_directory_uri() . '/rcarousel/widget/lib/jquery.ui.rcarousel.min.js',
			array( 'jquery','jquery.core','jquery.widget' ),
			'1.0',
			TRUE
		);
		wp_enqueue_script(
			'rcarousel.options',
			get_template_directory_uri() . '/js/rcarousel.options.js',
			array( 'jquery','jquery.core','jquery.widget' ),
			'1.0',
			TRUE
		);
	} // end if single post
}

//add_action( 'wp_enqueue_scripts', 'da_scripts_method' );
add_action( 'wp_print_scripts', 'da_scripts_method' );

// custom menus
add_action( 'init', 'register_my_menu' );
function register_my_menu() {
        if ( function_exists( 'register_nav_menus' ) ) {
                register_nav_menus(
                array(
                        'header-menu' => 'Menú de cabecera',
                )
                );
        }
}

// Custom post types
add_action( 'init', 'create_post_type', 0 );

function create_post_type() {
	// Case Studies custom post type
	register_post_type( 'case', array(
		'labels' => array(
			'name' => __( 'Case Studies' ),
			'singular_name' => __( 'Case Study' ),
			'add_new_item' => __( 'Add Case Study' ),
			'edit' => __( 'Edit' ),
			'edit_item' => __( 'Edit this Case Study' ),
			'new_item' => __( 'New Case Studyt' ),
			'view' => __( 'View Case Study' ),
			'view_item' => __( 'View this Case Study' ),
			'search_items' => __( 'Search Case Studies' ),
			'not_found' => __( 'No Case Study was found' ),
			'not_found_in_trash' => __( 'No Case Study in the trash' ),
			'parent' => __( 'Parent' )
		),
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'menu_position' => 5,
		//'menu_icon' => get_template_directory_uri() . '/images/icon-post.type-integrantes.png',
		'hierarchical' => true, // if true this post type will be as pages
		'query_var' => true,
		'supports' => array('title', 'editor','excerpt','custom-fields','author','page-attributes','trackbacks','thumbnail','comments' ),
		'rewrite' => array('slug'=>'case','with_front'=>false),
		'can_export' => true,
		'_builtin' => false,
		'_edit_link' => 'post.php?post=%d',
	));
}

// Custom Taxonomies
add_action( 'init', 'build_taxonomies', 0 );

function build_taxonomies() {
register_taxonomy( 'scale', 'case', array( //each type of case study goes in each of the 4 scales: Block, Neigh, District, City
	'hierarchical' => true,
	'label' => 'Scales',
	'name' => 'Scales',
	'query_var' => true,
	'rewrite' => array( 'slug' => 'scale', 'with_front' => false ),) );
register_taxonomy( 'country', 'case', array( //Country taxonomy
	'hierarchical' => true,
	'label' => 'Countries',
	'name' => 'Countries',
	'query_var' => true,
	'rewrite' => array( 'slug' => 'country', 'with_front' => false ),) );
register_taxonomy( 'city', 'case', array( //City taxonomy
	'hierarchical' => true,
	'label' => 'Cities',
	'name' => 'Cities',
	'query_var' => true,
	'rewrite' => array( 'slug' => 'city', 'with_front' => false ),) );
register_taxonomy( 'district', 'case', array( //Distric taxonomy
	'hierarchical' => true,
	'label' => 'Districts',
	'name' => 'Districts',
	'query_var' => true,
	'rewrite' => array( 'slug' => 'district', 'with_front' => false ),) );
register_taxonomy( 'neighborhood', 'case', array( //Neighborhood taxonomy
	'hierarchical' => true,
	'label' => 'Neighborhoods',
	'name' => 'Neighborhoods',
	'query_var' => true,
	'rewrite' => array( 'slug' => 'neighborhood', 'with_front' => false ),) );
}

//Add metaboxes to Case Study Custom post type
function be_sample_metaboxes( $meta_boxes ) {//metaboxes common variables to all scales
	$prefix = '_da_'; // Prefix for all fields
	$meta_boxes[] = array(
		'id' => 'common',
		'title' => 'Common variables to all the scales',
		'pages' => array('case'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'POP/Ha',
				'desc' => 'field description (optional)',
				'id' => $prefix . 'pop-ha',
				'type' => 'text_small'
			),
			array(
				'name' => 'Population',
				'desc' => 'field description (optional)',
				'id' => $prefix . 'population',
				'type' => 'text_small'
			),
			array(
				'name' => 'References',
				'desc' => 'field description (optional)',
				'id' => $prefix . 'references',
				'type' => 'wysiwyg',
					'options' => array(
						    'wpautop' => true, // use wpautop?
						    'textarea_rows' => get_option('default_post_edit_rows', 2), // rows="..."
						    'teeny' => false, // output the minimal editor config used in Press This
						    'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
						),
			),
			array(
				'name' => 'Year of case study',
				'desc' => 'Year when the case study was made',
				'id' => $prefix . 'year',
				'type' => 'text_small'
			),
			array(
				'name' => 'Author of case study',
				'desc' => 'If filled, it will override the Wordpress Author.',
				'id' => $prefix . 'author',
				'type' => 'text_small'
			),
			array(
				'name' => 'URL of image that substitutes map',
				'desc' => 'If filled, it will override the map and will show this image.',
				'id' => $prefix . 'extra_image',
				'type' => 'text',
			),
		),
	);
	$meta_boxes[] = array(
		'id' => 'block-nh',
		'title' => 'Block and Neighborood Scales',
		'pages' => array('case'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'FAR',
				'desc' => 'field description (optional)',
				'id' => $prefix . 'far',
				'type' => 'text_small'
			),
			array(
				'name' => 'DUs/Ha',
				'desc' => 'field description (optional)',
				'id' => $prefix . 'dus-ha',
				'type' => 'text_small'
			),
			array(
				'name' => 'm2/Ha',
				'desc' => 'field description (optional)',
				'id' => $prefix . 'm2-ha',
				'type' => 'text_small'
			),
			array(
				'name' => 'Gross Building Area',
				'desc' => 'm2',
				'id' => $prefix . 'gross-building-area',
				'type' => 'text_small'
			),
			array(
				'name' => 'Site Area',
				'desc' => 'm2',
				'id' => $prefix . 'site-area',
				'type' => 'text_small'
			),
			array(
				'name' => 'Range of Heights',
				'desc' => 'select',
				'id' => $prefix . 'range-of-heights',
				'type' => 'text_small'				
			),
			array(
				'name' => 'Dwelling Units',
				'desc' => 'field description (optional)',
				'id' => $prefix . 'dwelling-units',
				'type' => 'text_small'
			),
			array(
				'name' => 'Parking Spaces',
				'desc' => 'field description (optional)',
				'id' => $prefix . 'parking-spaces',
				'type' => 'text_small'
			),
			array(
				'name' => 'Location',
				'desc' => 'Lat,Long. Exact location of the place. Separated by commas.<br> Example Paris: 48.8588,2.347',
				'id' => $prefix . 'location',
				'type' => 'text_small'
			),
			array(
				'name' => 'Zoom',
				'desc' => 'Zoom of the map',
				'id' => $prefix . 'zoom',
				'type' => 'select',
					'options' => array(
						array('name' => '1', 'value' => '1'),
						array('name' => '2', 'value' => '2'),
						array('name' => '3', 'value' => '3'),
						array('name' => '4', 'value' => '4'),
						array('name' => '5', 'value' => '5'),
						array('name' => '6', 'value' => '6'),
						array('name' => '7', 'value' => '7'),
						array('name' => '8', 'value' => '8'),
						array('name' => '9', 'value' => '9'),
						array('name' => '10', 'value' => '10'),
						array('name' => '11', 'value' => '11'),
						array('name' => '12', 'value' => '12'),
						array('name' => '13', 'value' => '13'),
						array('name' => '14', 'value' => '14'),
						array('name' => '15', 'value' => '15'),
						array('name' => '16', 'value' => '16'),
						array('name' => '17', 'value' => '17'),
						array('name' => '18', 'value' => '18'),
						array('name' => '19', 'value' => '19'),
						array('name' => '20', 'value' => '20'),
						array('name' => '21', 'value' => '21'),
					) 
			),
			array(
				'name' => 'Income',		//Is it a common variable for all the case studies
				'desc' => '',
				'id' => $prefix . 'income',
				'type' => 'select',
					'options' => array(
						array('name' => 'Low', 'value' => 'Low'),
						array('name' => 'Medium', 'value' => 'Medium'),
						array('name' => 'High', 'value' => 'High'),
						array('name' => 'Mixed', 'value' => 'Mixed')						
					) 
			),
			array(
				'name' => 'Demographic group',
				'desc' => '',
				'id' => $prefix . 'demographic-group',
				//'type' => 'select',
				'type' => 'multicheck',
					'options' => array(
						//array('name' => 'Senior', 'value' => 'senior'), 
						//array('name' => 'Families', 'value' => 'families'),
						//array('name' => 'Single', 'value' => 'single'),
						//array('name' => 'Couples', 'value' => 'couples'),	
						//array('name' => 'Mixed', 'value' => 'mixed')					
						'senior' => 'Senior',
						'family' => 'Families with children',
						'single' => 'Single couples',
						'other' => 'Other',
					) 
			) 
		) 
	);
	$meta_boxes[] = array(
		'id' => 'story',
		'title' => 'Related case studies',
		'pages' => array('post'), // post type
		'context' => 'side',
		'priority' => 'high',
		'show_names' => false, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Related case study 1',
				'desc' => 'the slug of the case study',
				'id' => $prefix . 'story_rel1',
				'type' => 'text_small'
			),
			array(
				'name' => 'Related case study 2',
				'desc' => 'the slug of the case study',
				'id' => $prefix . 'story_rel2',
				'type' => 'text_small'
			),
			array(
				'name' => 'Related case study 3',
				'desc' => 'the slug of the case study',
				'id' => $prefix . 'story_rel3',
				'type' => 'text_small'
			),
			array(
				'name' => 'Related case study 4',
				'desc' => 'the slug of the case study',
				'id' => $prefix . 'story_rel4',
				'type' => 'text_small'
			),
			array(
				'name' => 'Related case study 5',
				'desc' => 'the slug of the case study',
				'id' => $prefix . 'story_rel5',
				'type' => 'text_small'
			)
		)
	);
	$meta_boxes[] = array(
		'id' => 'sentence',
		'title' => 'Featured content',
		'pages' => array('post'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => false, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Sentence title',
				'desc' => 'title',
				'id' => $prefix . 'sentence_tit',
				'type' => 'text'
			),
			array(
				'name' => 'Sentence',
				'desc' => 'sentence',
				'id' => $prefix . 'sentence',
				'type' => 'textarea'
			),
		)
	);
	$meta_boxes[] = array(
		'id' => 'story-ref',
		'title' => 'References',
		'pages' => array('post'), // post type
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => false, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'References',
				'desc' => 'field description (optional)',
				'id' => $prefix . 'story_references',
				'type' => 'wysiwyg',
					'options' => array(
						    'wpautop' => true, // use wpautop?
						    'textarea_rows' => get_option('default_post_edit_rows', 2), // rows="..."
						    'teeny' => false, // output the minimal editor config used in Press This
						    'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
						),
			),
		),
	);
	$meta_boxes[] = array(
		'id' => 'story-featured',
		'title' => 'Feature this story in home page',
		'pages' => array('post'), // post type
		'context' => 'side',
		'priority' => 'low',
		'show_names' => false, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Story featured',
				'desc' => 'check to feature this story',
				'id' => $prefix . 'story_featured',
				'type' => 'checkbox',
			),
			array(
				'name' => 'Order',
				'desc' => 'set priority of this story: 1 is highest.',
				'id' => $prefix . 'story_order',
				'type' => 'text_small',
			),
			array(
				'name' => 'Width',
				'desc' => 'width of this story, in columns.',
				'id' => $prefix . 'story_cols',
				'type' => 'radio_inline',
				'options' => array(
					array('name' => '1', 'value' => 'span1'), 
					array('name' => '2', 'value' => 'span2'),
					array('name' => '3', 'value' => 'span3'),
					array('name' => '4', 'value' => 'span4'),
					array('name' => '6', 'value' => 'span6'),	
					array('name' => '8', 'value' => 'span8'),
					array('name' => '12', 'value' => 'span12'),
					array('name' => '16', 'value' => 'span16')
				) 
			),
		),
	);
	$meta_boxes[] = array(
		'id' => 'home',
		'title' => 'Featured content for home page',
		'pages' => array('page'), // post type
		'show_on' => array( 'key' => 'page-template', 'value' => 'page-home.php' ),
		'context' => 'normal',
		'priority' => 'high',
		'show_names' => true, // Show field names on the left
		'fields' => array(
			array(
				'name' => 'Featured sentence 1',
				'desc' => '',
				'id' => $prefix . 'home_featured_1',
				'type' => 'textarea',
			),
			array(
				'name' => 'Featured sentence 2',
				'desc' => '',
				'id' => $prefix . 'home_featured_2',
				'type' => 'textarea',
			),
		),
	);
	return $meta_boxes;
}
add_filter( 'cmb_meta_boxes', 'be_sample_metaboxes' );
// Initialize the metabox class
add_action( 'init', 'be_initialize_cmb_meta_boxes', 9999 );
function be_initialize_cmb_meta_boxes() {
	if ( !class_exists( 'cmb_Meta_Box' ) ) {
		require_once( 'lib/metabox/init.php' );
	}
}

// Adding featured image to the custom post types
add_theme_support( 'post-thumbnails', array( 'case','post') ); 



// Adds terms from a custom taxonomy to post_class

add_filter( 'post_class', 'theme_t_wp_taxonomy_post_class', 10, 3 );
 
function theme_t_wp_taxonomy_post_class( $classes, $class, $ID ) {
    $taxonomy = 'scale';
    $terms = get_the_terms( (int) $ID, $taxonomy );
    if( !empty( $terms ) ) {
        foreach( (array) $terms as $order => $term ) {
            if( !in_array( $term->slug, $classes ) ) {
                $classes[] = $term->slug;
            }
        }
    }
    return $classes;
} 

// add "0" value to FAR custom field if is empty, in case study post type
$cfields = array("far","pop-ha","dus-ha");
function update_empty_cfields( $post_id ) {
	global $cfields;
	foreach ( $cfields as $cfield ) {
		//verify post is not a revision
		if ( !wp_is_post_revision( $post_id ) ) {
			$post_meta_key = "_da_" .$cfield;
			$post_meta_value = "0";
			add_post_meta($post_id, $post_meta_key, $post_meta_value,true);
		}
	}
}
add_action( 'wp_insert_post', 'update_empty_cfields' );

// add tax term as value to _da_tax_$taxo custom field if is empty, in case study post type
$taxos = array("country","city","scale");
function update_empty_taxs_custom_field( $post_id ) {
	global $taxos;
	foreach ( $taxos as $taxo) {
		//verify post is not a revision
		if ( !wp_is_post_revision( $post_id ) ) {
			$post_meta_key = "_da_tax_" .$taxo;
			$terms = get_the_terms( $post_id, $taxo );
			$post_meta_value = $terms[0]->name;
			$prev_meta_key = get_post_meta( $post_id, $post_meta_key, true);
			if ( $prev_meta_key == '' || $prev_meta_key != $post_meta_value ) { update_post_meta($post_id, $post_meta_key, $post_meta_value, $prev_meta_key ); }
			else { add_post_meta($post_id, $post_meta_key, $post_meta_value,true); }
		}
	}
}
add_action( 'wp_insert_post', 'update_empty_taxs_custom_field' );

// add post title as value to _da_tit custom field, in case study post type
function update_tit_custom_field( $post_id ) {
	//verify post is not a revision
	if ( !wp_is_post_revision( $post_id ) ) {
		$post_meta_key = "_da_tit";
		$post_meta_value = get_the_title($post_id);
		$prev_meta_key = get_post_meta( $post_id, $post_meta_key, true );
		if ( $prev_meta_key != '' && $prev_meta_key != $post_meta_value ) { update_post_meta($post_id, $post_meta_key, $post_meta_value, $prev_meta_key ); }
		else { add_post_meta($post_id, $post_meta_key, $post_meta_value,true); }
	}
}
add_action( 'wp_insert_post', 'update_tit_custom_field' );

// modify caption output
// justin tadlock howto: http://justintadlock.com/archives/2011/07/01/captions-in-wordpress
add_filter( 'img_caption_shortcode', 'da_caption_bootstrap', 10, 3 );

function da_caption_bootstrap( $output, $attr, $content ) {

	/* We're not worried abut captions in feeds, so just return the output here. */
	if ( is_feed() )
		return $output;

	/* Set up the default arguments. */
	$defaults = array(
		'id' => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => ''
	);

	/* Merge the defaults with user input. */
	$attr = shortcode_atts( $defaults, $attr );

	/* If the width is less than 1 or there is no caption, return the content wrapped between the [caption]< tags. */
	if ( 1 > $attr['width'] || empty( $attr['caption'] ) )
		return $content;

	/* Set up the attributes for the caption <div>. */
	$attributes = ( !empty( $attr['id'] ) ? ' id="' . esc_attr( $attr['id'] ) . '"' : '' );
	$attributes .= ' class="wp-caption ' . esc_attr( $attr['align'] ) . '"';
	//$attributes .= ' style="width: ' . esc_attr( $attr['width'] ) . 'px"';

	/* Open the caption <div>. */
	$output = '<div' . $attributes .'><div class="row">';

	/* Allow shortcodes for the content the caption was created for. */
	$output .= '<div class="span8">' .do_shortcode( $content ). '</div>';

	/* Append the caption text. */
	$output .= '<p class="wp-caption-text span2"><small>' . $attr['caption'] . '</small></p>';

	/* Close the caption </div>. */
	$output .= '</div></div>';

	/* Return the formatted, clean caption. */
	return $output;
}

?>
