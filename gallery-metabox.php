<?php
/**
 * Register meta box(es).
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/* Register metabox for gallery */
function micro_gallery_register_meta_boxes() {
	$getpostopt = get_option('mg_data_posttypes');
	$getpostid = get_the_ID();	
	$getpostyp = get_post_type($getpostid);

	if(!empty($getpostopt)){
	    add_meta_box( 'micro-gallery-metabox-id', __( 'Micro Gallery', 'microgallery-slider' ), 'micro_gallery_display_callback',$getpostopt );
	}
	if($getpostyp == 'microgallery'){
		add_meta_box( 'micro-gallery-metabox-id', __( 'Micro Gallery', 'microgallery-slider' ), 'micro_gallery_display_callback','microgallery' );
	}
}
add_action( 'add_meta_boxes', 'micro_gallery_register_meta_boxes' );
 
/* Meta box display callback. */
function micro_gallery_display_callback( $post ) {
	$gallerytitle = sanitize_text_field(get_post_meta($post->ID,'mg_gallery_title',true));

	$gallerydesc = sanitize_textarea_field(get_post_meta($post->ID,'mg_gallery_desc',true));
	$getpostid = get_the_ID();	
	$getpostyp = get_post_type($getpostid);	
	$slider_hide = get_post_meta($post->ID,'mg_gallery_hide',true);
?>

    <!--gallery Title-->
    <p class="micro-gallery-box"><label for="mg_gallery_title"><?php esc_html_e('Title', 'microgallery-slider'); ?></label> <input type="text" name="mg_gallery_title" class="regular-text" id="micro-gallery-box-title" value="<?php if(!empty($gallerytitle)){echo esc_html($gallerytitle);}?>" ></p>

    <!--Gallery Discription-->
    <p class="micro-gallery-box"><label for="mg_gallery_desc"><?php esc_html_e('Description', 'microgallery-slider'); ?></label> <textarea name="mg_gallery_desc" class="regular-text" id="micro-gallery-box-desc"><?php if(!empty($gallerydesc)){ echo esc_html($gallerydesc); } ?></textarea></p>
    
    <!--image uploader-->
    <p class="micro-gallery-box">
		<label for="mg_fields[image]"><?php esc_html_e('Upload Images', 'microgallery-slider'); ?></label>
		<input type="button" class="button micro-gallery-imgupload" value="Select Images">
	</p>

	<div id ="micro-gallery-sortableitem" class="image-preview">
	<?php 
	 $getimag = get_post_meta($post->ID,'mg_gallery_imgids',true);
	 if(!empty($getimag)){
	 	foreach ($getimag as $imgvalue) {
	 		$attchimg = wp_get_attachment_image_src($imgvalue,'full'); ?>
	 			<div class="micro-gallery-boximg">
	 				<img src="<?php echo esc_url($attchimg[0]); ?>" title="img<?php echo esc_attr($imgvalue); ?>">
           	<input id="micro-gallery-image-input<?php echo esc_attr($imgvalue); ?>" type="hidden" name="mg_gallery_imgids[]"  value="<?php echo esc_attr($imgvalue); ?>">
           	<input class="micro-gallery-image-delete" type="button" name="mg_data_delete_img_item"  data-dlt="<?php echo esc_attr($imgvalue); ?>" value="Delete this">
      	</div>
	<?php } } ?>
	</div>
	<hr>
	<?php if($getpostyp != 'microgallery'){ ?>
		<div class="switchslider">
			<h4>
				<span class="micro-slideroff"><?php esc_html_e('禁用 相册轮播图', 'microgallery-slider'); ?></span>
				<input type="checkbox" name="mg_gallery_hide" value="true" <?php if(!empty($slider_hide) && $slider_hide == "true"){ echo "checked"; } ?> >
			</h4>
		</div>
	<?php } ?>
	<div class="showshrotcode"><h4><?php esc_html_e('使用此短代码可以显示 相册轮播图.', 'microgallery-slider'); ?></h4>[micro_gallery_slider id="<?php echo $post->ID; ?>"]</div>
  	<script>
	    jQuery( function() {
		    jQuery( "#micro-gallery-sortableitem" ).sortable();
		  });
	    jQuery(document).on("click",'.micro-gallery-image-delete',function (e) {
		    var tst = jQuery(this).parent().remove();
		  });

  	</script>  	
	<?php wp_nonce_field( 'micro_gallery_nounce', 'micro_gallery_nounce_field' ); ?>

<?php }
 
/* Save meta box content. */
function micro_gallery_save_meta_box( $post_id ) {
  if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
  /* if our current user can't edit this post */
  if( !current_user_can( 'edit_posts' ) ) return;
  /* if our nonce isn't there, or we can't verify it */
  	
if(!isset($_REQUEST['micro_gallery_nounce_field']) || ! wp_verify_nonce( $_REQUEST['micro_gallery_nounce_field'], 'micro_gallery_nounce')){
  	return;
} 

if(isset($_REQUEST['mg_gallery_title'])){
  	update_post_meta($post_id,'mg_gallery_title', sanitize_text_field($_REQUEST['mg_gallery_title']));
}
if(isset($_REQUEST['mg_gallery_desc'])){
    update_post_meta($post_id,'mg_gallery_desc', sanitize_textarea_field($_REQUEST['mg_gallery_desc']));
}
if(isset($_REQUEST['mg_gallery_imgids'])){
    if(!empty($_REQUEST['mg_gallery_imgids'])){
    	update_post_meta($post_id, 'mg_gallery_imgids', rest_sanitize_array($_REQUEST['mg_gallery_imgids']));	    	
	}
}else{
  	update_post_meta($post_id, 'mg_gallery_imgids', '');
}
update_post_meta($post_id,'mg_gallery_hide', sanitize_text_field($_REQUEST['mg_gallery_hide']));

}
add_action( 'save_post', 'micro_gallery_save_meta_box' );