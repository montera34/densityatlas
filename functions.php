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
	'hierarchical' => false,
	'label' => 'Scales',
	'name' => 'Scales',
	'query_var' => true,
	'rewrite' => array( 'slug' => 'scale', 'with_front' => false ),) );
register_taxonomy( 'cities', 'case', array( //City taxonomy
	'hierarchical' => true,
	'label' => 'Cities',
	'name' => 'Cities',
	'query_var' => true,
	'rewrite' => array( 'slug' => 'city', 'with_front' => false ),) );
register_taxonomy( 'districts', 'case', array( //Distric taxonomy
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
?>
