<?php
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
				'type' => 'select',
					'options' => array(
						array('name' => 'Option One', 'value' => 'standard'), //ToDo fill with real values
						array('name' => 'Option Two', 'value' => 'custom'),
						array('name' => 'Option Three', 'value' => 'none')				
					)
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
				'name' => 'Income',		//Is it a commons variable for all the case studies
				'desc' => '',
				'id' => $prefix . 'income',
				'type' => 'select',
					'options' => array(
						array('name' => 'Option One', 'value' => 'standard'), //ToDo fill with real values
						array('name' => 'Option Two', 'value' => 'custom'),
						array('name' => 'Option Three', 'value' => 'none')					
					) 
			),
			array(
				'name' => 'Demographic group',
				'desc' => 'Select',
				'id' => $prefix . 'demographic-group',
				'type' => 'select',
					'options' => array(
						array('name' => 'Senior', 'value' => 'senior'), 
						array('name' => 'Families', 'value' => 'families'),
						array('name' => 'Single', 'value' => 'single'),
						array('name' => 'Couples', 'value' => 'couples'),	
						array('name' => 'Mixes', 'value' => 'mixes')					
					) 
			),
		),
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
			),
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
				'type' => 'text_medium'
			),
			array(
				'name' => 'Sentence',
				'desc' => 'sentence',
				'id' => $prefix . 'sentence',
				'type' => 'text_medium'
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
					array('name' => '6', 'value' => 'span6'),	
					array('name' => '12', 'value' => 'span12')
				) 
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
			if ( $prev_meta_key == '' ) { update_post_meta($post_id, $post_meta_key, $post_meta_value, $prev_meta_key ); }
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
?>
