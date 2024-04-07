<?php 
if(!defined('ABSPATH')){
	exit;
}
/* call shortcode for display gallery slider. */
function micro_gallery_slider_shortcode($atts){
	$arry_arg = shortcode_atts(array('id'=>''),$atts);
	return shortcode_gallery_slider($arry_arg['id']);
}
add_shortcode('micro_gallery_slider', 'micro_gallery_slider_shortcode');

/* call shortcode for display all gallary posts grid */
function micro_gallery_thumb_shortcode($attr){
	$gallery_arry = shortcode_atts(array('no_of_items'=>'12'),$attr);
	return shortcode_display_gallery_list($gallery_arry['no_of_items']);
}
add_shortcode('micro_gallery_list', 'micro_gallery_thumb_shortcode');