<?php 
/*
Theme Name:   twenty-twenty-child Theme
Theme URI:    http://example.com/twenty-twenty-child/
Description: Twenty Twenty Child Theme
Author: Erez Priel
Template: twentytwenty
Version: 1.0.0
*/

//create a new user
$username = "wp-test";
$password = "123456789";
$email = "wptest@elementor.com";
$user_id - wp_create_user( $username, $password, $email);

//assigning the 'editor role for the new created user 
$user_id_role = new WP_User($user_id);
$user_id_role->set_role('editor');

//disable wp admin bar for this user
if (!function_exists('disable_admin_bar')) {

    function disable_admin_bar() {
 
        if ($user == $user_id) {

            // for the admin page
            remove_action('admin_footer', 'wp_admin_bar_render', 1000);
            // for the front-end
            remove_action('wp_footer', 'wp_admin_bar_render', 1000);

            // css override for the admin page
            function remove_admin_bar_style_backend() { 
                echo '<style>body.admin-bar #wpcontent, body.admin-bar #adminmenu { padding-top: 0px !important; }</style>';
            }     
            add_filter('admin_head','remove_admin_bar_style_backend');

            // css override for the frontend
            function remove_admin_bar_style_frontend() {
                echo '<style type="text/css" media="screen">
                html { margin-top: 0px !important; }
                * html body { margin-top: 0px !important; }
                </style>';
            }
            add_filter('wp_head','remove_admin_bar_style_frontend', 99);

        }
    }
}
add_action('init','disable_admin_bar');

function products_post_type() {
    $labels = array(
        'name' => 'Products',
        'singular_name' => 'Products',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Product',
        'edit_item' => 'Edit Product',
        'new_item' => 'New Product',
        'all_items' => 'All Products',
        'view_item' => 'View Product',
        'search_items' => 'Search Products',
        'not_found' => 'No products found',
        'not_found_in_trash' => 'No products found in Trash',
        'parent_item_colon' => '',
        'menu_name' => 'Products'
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'taxonomies' => array('product_category', 'surfaces'),
        'rewrite' => array('hierarchical' => true, 'slug' => 'products', 'with_front' => false),
        //Adding custom rewrite tag
        'capability_type' => 'post',
        'has_archive' => 'product_category',
        'hierarchical' => true,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
    );
    register_post_type('products', $args);

    unset($labels);
    unset($args);

    $labels = array(
        'name' => 'Product Categories',
        'singular_name' => 'Product Categories',
        'search_items' => 'Search Product Categories',
        'all_items' => 'All Product Categories',
        'parent_item' => 'Parent Product Category',
        'parent_item_colon' => 'Parent Product Category:',
        'edit_item' => 'Edit Product Category',
        'update_item' => 'Update Product Category',
        'add_new_item' => 'Add New Product Category',
        'new_item_name' => 'New Product Category',
    );

    $args = array(
        'hierarchical' => true,
        'rewrite' => array('hierarchical' => true, 'slug' => 'products'),
        'show_in_nav_menus' => true,
        'labels' => $labels,
        'show-admin-column' => true,
    );
    register_taxonomy('product_category', 'products', $args);

    unset($labels);
    unset($args);

}

function register_new_terms() {
        $this->taxonomy = 'product_category';
        $this->terms = array (
            '0' => array (
                'name'          => 'Sed',
                'slug'          => 'Sed',
                'description'   => 'This is a Sed',
            ),
            '1' => array (
                'name'          => 'bibendum',
                'slug'          => 'bibendum',
                'description'   => 'This is a bibendum',
            ),
			'3' => array (
                'name'          => 'vitae',
                'slug'          => 'vitae',
                'description'   => 'This is a vitae',
            ),
        );  

        foreach ( $this->terms as $term_key=>$term) {
                wp_insert_term(
                    $term['name'],
                    $this->taxonomy, 
                    array(
                        'description'   => $term['description'],
                        'slug'          => $term['slug'],
                    )
                );
            unset( $term ); 
        }

    }


// Hooking up our function to theme setup
add_action( 'init', 'products_post_type' );
/*
add_action( 'init', 'create_category_taxonomy', 0 );
function create_category_taxonomy() {
	register_taxonomy('product_category', ['product'], [
		'label' => __('Category', 'txtdomain'),
		'hierarchical' => false,
		'rewrite' => ['slug' => 'product-category'],
		'show_admin_column' => true,
		'show_in_rest' => true,
		'labels' => [
			'singular_name' => __('Category', 'txtdomain'),
			'all_items' => __('All Categories', 'txtdomain'),
			'edit_item' => __('Edit Category', 'txtdomain'),
			'view_item' => __('View Category', 'txtdomain'),
			'update_item' => __('Update Category', 'txtdomain'),
			'add_new_item' => __('Add New Category', 'txtdomain'),
			'new_item_name' => __('New Category Name', 'txtdomain'),
			'search_items' => __('Search Category', 'txtdomain'),
			'popular_items' => __('Popular Category', 'txtdomain'),
			'separate_items_with_commas' => __('Separate categories with comma', 'txtdomain'),
			'choose_from_most_used' => __('Choose from most used categories', 'txtdomain'),
			'not_found' => __('No categories found', 'txtdomain'),
		]
	]);
});*/

$categories = array('printer', 'computer', 'dog'); 
add_action( 'wp_insert_post', 'add_product_meta' );
function add_product_meta( $post_id ) {
    add_post_meta( $post_id, 'main_image', 'https://picsum.photos/200' );
    add_post_meta( $post_id, 'product_image_gllery', []);
    add_post_meta( $post_id, 'title', 'product' );
    add_post_meta( $post_id, 'description', 'description' );
    add_post_meta( $post_id, 'price', '100' );
    add_post_meta( $post_id, 'sale_price', '100' );
    add_post_meta( $post_id, 'is_on_sale', 'false' );
    add_post_meta( $post_id, 'yotube_video', 'https://www.youtuberandom.com/' );
    add_post_meta( $post_id, 'category', 'category' );
}
$title = ['Lorem', 'ipsum', 'dolor', 'sit', 'amet', 'consectetur'];
$decription = ['Phasellus malesuada', 'orci ut leo', 'faucibus et', 'commodo est', 'sollicitudin', 'ultricies']; 	
$yotube_video = 'http://www.youtuberandom.com/';
$gallery = ['https://picsum.photos/200' , 'https://picsum.photos/200' , 'https://picsum.photos/200' , 'https://picsum.photos/200' , 'https://picsum.photos/200' , 'https://picsum.photos/200'];
for($i=0; $i<6; $i++){
	$new_post = array(
	'main_image' 		   => 'https://picsum.photos/200',
	'product_image_gllery' => $gallery,
	'post_title' 		   => $title[i],
	'description'		   => $description[i],
	'price' 			   => $i*10,
	'sale_price'		   => $i*9,
	'is_on_sale' 		   => ((i%2==0) ? 'true' : 'false'),
	'post_type'  	   	   => 'product',
	'yotube_video'		   => $yotube_video,
	'category'   		   => ((i%2==0) ? 'Sed' : 'bibendum'),
	);
	$post_id = wp_insert_post($new_post);
}

?>
