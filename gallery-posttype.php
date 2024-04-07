<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
/* Register Custom post type gallery*/
function micro_gallery_posttype(){
	$argsments = array('labels'	=> 	array(
		'name'	=>	__('相册','microgallery-slider'),
		'singular_name'	=>	__('相册','microgallery-slider'),
		'add_new'	=> __('新建相册','microgallery-slider'),
		'add_new_item'	=> __('新建相册','microgallery-slider'),
		'edit_item'	=>	__('编辑相册','microgallery-slider'),
		'new_item'	=>	__('新建相册','microgallery-slider'),
		'view_item'	=>	__('查看相册','microgallery-slider'),
		'items_archive'	=>	__('相册归档','microgallery-slider'),
		'search_items'	=>	__('搜索相册','microgallery-slider'),
		'not_found'	=>	__('未找到指定相册','microgallery-slider'),
		'not_found_in_trash'	=>	__('未找到指定相册 in trash','microgallery-slider')),
		'description'        => __( 'Description.', 'microgallery-slider' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'microgallery' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'show_in_rest' => use_block_editor_for_post_type('post'),
		'show_in_menu'=>'edit.php?post_type=microgallery',		
		'supports'	=> array('title','thumbnail','editor'));
 register_post_type('microgallery', $argsments);
}
add_action('init', 'micro_gallery_posttype');


/* add column shortcode to custom post type gallery. */
add_filter('manage_microgallery_posts_columns' , 'mg_add_gallery_columns');
function mg_add_gallery_columns($columns) {
    $columns['shortcode'] = __('简码/短代码', 'microgallery-slider');
    return $columns;
}

/* implement the shortcode to post type gallery */
add_action( 'manage_microgallery_posts_custom_column' , 'mg_custom_gallery_column', 10, 2 );
function mg_custom_gallery_column($column, $post_id){
	if($column == 'shortcode'){
		// 使用实体码，防止被转译
		// echo "[micro_gallery_slider id=".$post_id."]";
		echo "&#91;micro_gallery_slider id=" . $post_id . "&#93;";
	}
}