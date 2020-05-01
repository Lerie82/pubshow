<?php
/**
 * Plugin Name:       Pubshow
 * Plugin URI:        https://www.lerietaylor.com/pubshow/
 * Description:       Create new posts for software releases
 * Version:           1.0
 * Author:            Lerie Taylor
 * Author URI:        https://www.lerietaylor.com/
 * License:           GPL v3
 * License URI:       https://www.gnu.org/licenses/gpl-3.0.en.html
 * Domain Path:       /languages
 */
 
/* custom post type */
function create_pub_posttype()
{
    $posttype_args = [
        'labels' => [
            'name' => 'Releases',
            'singular_name' => 'Release',
            'add_new_item' => 'Add New Release'
        ],
        'description' => 'A public release',
        'rewrite' => ['slug' => 'release'],
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'capability_type' => 'post',
        'show_in_rest' => true,
        'publicly_queryable' => true,
        'has_archive' => true,
        'hierarchical' => true
    ];
    
    register_post_type('releases', $posttype_args);
 }
 add_action('init', 'create_pub_posttype');
 
/* meta boxes */
function release_mb($post)
{
    global $post;
    
    echo  '<p>URL <input type="hidden" name="banner-buttonmeta_noncename" id="banner-buttonmeta_noncename" value="'.wp_create_nonce(plugin_basename(__FILE__)).'" />';
    $release_url = get_post_meta($post->ID, 'release_url', true);
    echo '<input type="text" name="_release_url" value="'.$release_url.'" class="widefat" /></p>';
    
    //
    echo  '<p>Author <input type="hidden" name="banner-buttonmeta_noncename" id="banner-buttonmeta_noncename" value="'.wp_create_nonce(plugin_basename(__FILE__)).'" />';
    $release_author = get_post_meta($post->ID, 'release_author', true);
    echo '<input type="text" name="_release_author" value="'.$release_author.'" class="widefat" /></p>';
}
 
function create_meta_box()
{
    add_meta_box('l_release_mb', __('Software Details'), 'release_mb', 'releases', 'side', 'low');
}
add_action('admin_init', 'create_meta_box');
 
 
 
/* cpt single-page */
function release_single_page($template)
{
	if(is_singular('releases'))
	{
		$template = plugin_dir_path(__FILE__).'single-release.php';
	}
	
	return $template;
}
add_filter('single_template', 'release_single_page');

/* save custom post type data */
function save_release_data($post_id)
{
	if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
	{
		return;
	}

    update_post_meta($post_id, 'release_url', strip_tags($_POST['_release_url']));
    update_post_meta($post_id, 'release_author', strip_tags($_POST['_release_author']));
}
add_action('save_post', 'save_release_data');

/* include css */
function release_css()
{
    wp_enqueue_style('release', plugins_url("templates/css/release.css", __FILE__));
}
add_action('wp_enqueue_scripts', 'release_css');