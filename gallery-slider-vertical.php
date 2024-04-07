<?php
/**
 * Register meta box(es).
 */
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

/* Register metabox for vertical slider settings */
function micro_gallery_register_meta_boxes_verticalslide() {
	$getpostopt = get_option('mg_data_posttypes');
	$getpostid = get_the_ID();	
	$getpostyp = get_post_type($getpostid);
	if(!empty($getpostopt)){
		if (in_array($getpostyp, $getpostopt)){
			add_meta_box( 'micro-gallery-vslider-settng', __('相册设置', 'microgallery-slider' ), 'micro_gallery_display_callback_for_verticalslid', $getpostyp, 'side' );
		}		
	}
	add_meta_box( 'micro-gallery-vslider-settng', __('竖向设置', 'microgallery-slider'), 'micro_gallery_display_callback_for_verticalslid','microgallery', 'side' );
}
add_action( 'add_meta_boxes', 'micro_gallery_register_meta_boxes_verticalslide' );

function micro_gallery_display_callback_for_verticalslid($post){ 
	wp_enqueue_script( 'micro-gallery-veticlegal' );
	$meta_data = get_gallery_metadata(get_the_ID());
	if( null!== get_gallery_metavalue($meta_data, 'vertical_opt_key', true )){
	  $sliderRange = get_gallery_metavalue($meta_data, 'vertical_opt_key', true);
	}
	  $sliderWidth = !empty($sliderRange) ? $sliderRange[0] : '1100'; 
	  $sliderHeight = !empty($sliderRange) ? $sliderRange[1] : '450';
	  $thumbnlWidth = !empty($sliderRange) ? $sliderRange[2] : '100';
	  $maxThumbItm = !empty($sliderRange) ? $sliderRange[3] : '6';

	if( null!== get_gallery_metavalue($meta_data, 'vertical_breakpoints_key', true )){
	  $sliderBreakpoints = get_gallery_metavalue($meta_data, 'vertical_breakpoints_key', true);
	}
		$vheight480 = !empty($sliderBreakpoints) ? $sliderBreakpoints[0] : '200'; 
		$vthumb480 = !empty($sliderBreakpoints) ? $sliderBreakpoints[1] : '4';
		
		$vheight641 = !empty($sliderBreakpoints) ? $sliderBreakpoints[2] : '300';
		$vthumb641 = !empty($sliderBreakpoints) ? $sliderBreakpoints[3] : '6';

		$vheight800 = !empty($sliderBreakpoints) ? $sliderBreakpoints[4] : '370';
		$vthumb800 = !empty($sliderBreakpoints) ? $sliderBreakpoints[5] : '6';

		//BG Color
		if( null!== get_gallery_metavalue($meta_data, 'slider_bgcolor_key', true )){
			$sliderBgColor = get_gallery_metavalue($meta_data, 'slider_bgcolor_key', true);
		}
		$sliderBgColor = !empty($sliderBgColor) ? $sliderBgColor : '#ffffff'; 

		if( null!== get_gallery_metavalue($meta_data, 'slider_pleft_key', true )){
			$sliderPLeft = get_gallery_metavalue($meta_data, 'slider_pleft_key', true);
		}
		$sliderPLeft = !empty($sliderPLeft) ? $sliderPLeft : '0px';
		if( null!== get_gallery_metavalue($meta_data, 'slider_pright_key', true )){
			$sliderPRight = get_gallery_metavalue($meta_data, 'slider_pright_key', true);
		}	
		$sliderPRight = !empty($sliderPRight) ? $sliderPRight : '0px';
		if( null!== get_gallery_metavalue($meta_data, 'slider_ptop_key', true )){
			$sliderPTop = get_gallery_metavalue($meta_data, 'slider_ptop_key', true);
		}	
		$sliderPTop = !empty($sliderPTop) ? $sliderPTop : '0px';
		if( null!== get_gallery_metavalue($meta_data, 'slider_pbottom_key', true )){
			$sliderPBottom = get_gallery_metavalue($meta_data, 'slider_pbottom_key', true);
		}		
		$sliderPBottom = !empty($sliderPBottom) ? $sliderPBottom : '0px';
?>	
	<div class="gallery-vertcleslide-container">	
		<!-- Enable vertical gallery -->
		<p class="enble_ver_box"><label for="vertical_slider"><strong><?php esc_html_e('竖向滚动','microgallery-slider'); ?></strong></label>
				<input class="gallery-verti-checkbx" type="checkbox" id="enable_vrticle_gal" name="enable_vrticle_gal" value="1" <?php if(!empty(get_gallery_metavalue($meta_data, 'slider_vertical_key', true))){echo "checked"; } ?>>			
		</p>
		<p><small><?php esc_html_e('❗️为了更好的效果，尽量图片宽高一致.', 'microgallery-slider'); ?></small></p>
		<!-- Enable zoom image -->
		<p class="enble_ver_box"><label for="vertical_slider"><strong><?php esc_html_e('允许缩放','microgallery-slider'); ?></strong></label>
				<input class="gallery-verti-checkbx" type="checkbox" name="enable_image_zoom" value="1" <?php if(!empty(get_gallery_metavalue($meta_data, 'image_zoom_key', true))){echo "checked"; } ?>>			
		</p>
		
		<!-- Hide Title -->
		<p class="enble_ver_box"><label for="vertical_slider"><strong><?php esc_html_e('隐藏标题','microgallery-slider'); ?></strong></label>
				<input class="gallery-verti-checkbx" type="checkbox" name="enable_hide_title" value="1" <?php if(!empty(get_gallery_metavalue($meta_data, 'hide_title_key',true))){echo "checked"; } ?>>			
		</p>

		<!-- Hide Description -->
		<p class="enble_ver_box"><label for="vertical_slider"><strong><?php esc_html_e('隐藏描述','microgallery-slider'); ?></strong></label>
				<input class="gallery-verti-checkbx" type="checkbox" name="enable_hide_description" value="1" <?php if(!empty(get_gallery_metavalue($meta_data, 'hide_desc_key', true))){echo "checked"; } ?>>			
		</p>

		<!-- Enable Alignment -->
	  <p><strong><?php esc_html_e( '缩略图 对齐样式 : ', 'gallery-with-thumbnail-alignment' ); ?></strong>
			<select name="mg_data_alignment" id="micro-gallery-thumbnail-alignment">
			 	<option value="left" <?php if(get_gallery_metavalue($meta_data, 'slider_align_key', true) == "left"){echo "selected";} ?>>Left</option>
			 	<option value="right" <?php if(get_gallery_metavalue($meta_data, 'slider_align_key', true) == "right"){echo "selected";} ?>>Right</option>
			 	<option id="center_align" value="center" <?php if(get_gallery_metavalue($meta_data, 'slider_align_key', true) == "center"){echo "selected";} ?>>Center</option>
			</select>
		</p>
	<!-- Enable Background Color -->
	<p><strong><?php esc_html_e( '轮播视图 背景色 (Ex. #FFFFFF) : ', 'microgallery-slider' ); ?></strong>
		<input type="text" name="mg_data_bgclor" id="micro-gallery-bgcolor" value="<?php esc_html_e($sliderBgColor, 'microgallery-slider'); ?>">
	</p>
	<!-- Enable Slider Paddding (px) -->
	<p><strong><?php esc_html_e( '内边距 左 (Ex. 15px) : ', 'microgallery-slider' ); ?></strong>
		<input type="text" name="mg_data_pleft" id="micro-gallery-pleft" value="<?php esc_html_e($sliderPLeft, 'microgallery-slider'); ?>">
	</p>
	<p><strong><?php esc_html_e( '内边距 右 (Ex. 15px) : ', 'microgallery-slider' ); ?></strong>
		<input type="text" name="mg_data_pright" id="micro-gallery-pright" value="<?php esc_html_e($sliderPRight, 'microgallery-slider'); ?>">
	</p>
	<p><strong><?php esc_html_e( '内边距 上 (Ex. 15px) : ', 'microgallery-slider' ); ?></strong>
		<input type="text" name="mg_data_ptop" id="micro-gallery-ptop" value="<?php esc_html_e($sliderPTop, 'microgallery-slider'); ?>">
	</p>
	<p><strong><?php esc_html_e( '内边距 下 (Ex. 15px) : ', 'microgallery-slider' ); ?></strong>
		<input type="text" name="mg_data_pbottom" id="micro-gallery-pbottom" value="<?php esc_html_e($sliderPBottom, 'microgallery-slider'); ?>">
	</p>
    <!-- slider width -->
    <p><strong><?php esc_html_e('Slider Width: ', 'microgallery-slider');?></strong><span id="mg_displyVert_wdth"></span>px</p>
    <input type="range" name="vertical_opt_key[]" min="320" max="2200" value="<?php esc_html_e($sliderWidth, 'microgallery-slider'); ?>" class="mg-opt-vtcle" id="mg_vrt_width">

    <!-- slider height -->
    <p><strong><?php esc_html_e('Vertical Height: ', 'microgallery-slider');?></strong><span id="mg_Vslide_height"></span>px</p>
    <input type="range" name="vertical_opt_key[]" min="100" max="900" value="<?php esc_html_e($sliderHeight, 'microgallery-slider'); ?>" class="mg-opt-vtcle" id="mg_vrt_height">

    <!-- Thumb Width -->
    <p><strong><?php esc_html_e('Thumbnail Width: ', 'microgallery-slider');?></strong><span id="mg_thumbVWidt"></span>px</p>
    <input type="range" name="vertical_opt_key[]" min="50" max="200" value="<?php esc_html_e($thumbnlWidth, 'microgallery-slider'); ?>" class="mg-opt-vtcle" id="mg_thmb_width">

	  <!-- Thumb Item -->
    <p><strong><?php esc_html_e('Show Thumbnail: ', 'microgallery-slider');?></strong><span id="mg_show_maxthumb"></span></p>
      <input type="range" name="vertical_opt_key[]" min="2" max="20" value="<?php esc_html_e($maxThumbItm, 'microgallery-slider'); ?>" class="mg-opt-vtcle" id="mg_max_thumb">  

    <!-- Navigation -->
    <p class="enble_ver_box"><label for="vertical_slider"><?php esc_html_e('显示 翻页导航按钮','microgallery-slider'); ?></label>
		<input class="gallery-verti-checkbx" type="checkbox" name="vertical_navi_key" value="1" <?php if(!empty(get_gallery_metavalue($meta_data, 'vertical_navi_key', true))){echo "checked"; } ?>>
		</p>
		<hr/>
		<p class="enble_ver_box mg-rsponsivmode"><strong><label><?php esc_html_e('Set Different breakpoints for responsive Gallery', 'microgallery-slider');?></label></strong></p>
		<small><?php esc_html_e('Set gallery size in the different breakpoints.', 'microgallery-slider'); ?></small>

		<!-- Set breakpoints to 480px  -->
		<p><strong><?php esc_html_e('Breakpoint 480px', 'microgallery-slider'); ?></strong></p>
		<p><?php esc_html_e('Vertical Height: ', 'microgallery-slider');?><span id="mg_Vslide_brkheight"></span>px</p>
	    <input type="range" name="vertical_breakpoints_key[]" min="100" max="900" value="<?php esc_html_e($vheight480, 'microgallery-slider'); ?>" class="mg-opt-vtcle" id="mg_brekvrt_height">
	    
	    <p><?php esc_html_e('Thumb Items: ', 'microgallery-slider');?><span id="mg_show_brkmaxthumb"></span></p><input type="range" name="vertical_breakpoints_key[]" min="2" max="20" value="<?php esc_html_e($vthumb480, 'microgallery-slider'); ?>" class="mg-opt-vtcle" id="mg_max_brkthumb">  

	  <!-- Set breakpoints to 641px  -->  
		<p><strong><?php esc_html_e('Breakpoint 641px', 'microgallery-slider'); ?></strong></p>
		<p><?php esc_html_e('Vertical Height: ', 'microgallery-slider');?><span id="mg_Vslide_sixfouroneheight"></span>px</p>
    <input type="range" name="vertical_breakpoints_key[]" min="100" max="900" value="<?php esc_html_e($vheight641, 'microgallery-slider'); ?>" class="mg-opt-vtcle" id="mg_vrt_sixfoheight">
    
    <p><?php esc_html_e('Thumb Items: ', 'microgallery-slider');?><span id="mg_show_sixfomaxthumb"></span></p><input type="range" name="vertical_breakpoints_key[]" min="2" max="20" value="<?php esc_html_e($vthumb641, 'microgallery-slider'); ?>" class="mg-opt-vtcle" id="mg_max_sixforthumb">  

		<!-- Set breakpoints to 800px  -->
		<p><strong><?php esc_html_e('Breakpoint 800px', 'microgallery-slider'); ?></strong></p>
		<p><?php esc_html_e('Vertical Height: ', 'microgallery-slider');?><span id="mg_Vslide_eightheight"></span>px</p>
    <input type="range" name="vertical_breakpoints_key[]" min="100" max="900" value="<?php esc_html_e($vheight800, 'microgallery-slider'); ?>" class="mg-opt-vtcle" id="mg_vrt_eightheight">
    <p><?php esc_html_e('Thumb Items: ', 'microgallery-slider');?><span id="mg_show_eightmaxthumb"></span></p><input type="range" name="vertical_breakpoints_key[]" min="2" max="20" value="<?php esc_html_e($vthumb800, 'microgallery-slider'); ?>" class="mg-opt-vtcle" id="mg_max_eigthumb">  
	</div>

	<script>
		jQuery(function(){
	   	jQuery('#enable_vrticle_gal').change(function() {
	      jQuery("#center_align").toggleClass("show-hide");
	   	});
		});	
	</script>
	<style> 
		.show-hide{ display: none; }
	</style>

<?php 
}

function slider_vertical_keylery_callback($post_id){
	
	$savedata = get_gallery_metadata($post_id);
	/* show vertical gallery */
	if(isset($_POST['enable_vrticle_gal'])){
		$savedata['slider_vertical_key'] = sanitize_text_field($_POST['enable_vrticle_gal']);	
	}
	else{
		$savedata['slider_vertical_key'] = '';
	}

	if(isset($_POST['enable_image_zoom'])){
		$savedata['image_zoom_key'] = sanitize_text_field($_POST['enable_image_zoom']);		
	}
	else{
		$savedata['image_zoom_key'] = '';
	}

	if(isset($_POST['enable_hide_title'])){
		$savedata['hide_title_key'] = sanitize_text_field($_POST['enable_hide_title']);	
	}
	else{
		$savedata['hide_title_key'] = '';
	}

	if(isset($_POST['enable_hide_description'])){
		$savedata['hide_desc_key'] = sanitize_text_field($_POST['enable_hide_description']);		
	}
	else{
		$savedata['hide_desc_key'] = '';
	}

	if(isset($_POST['mg_data_alignment'])){
		$savedata['slider_align_key'] = sanitize_text_field($_POST['mg_data_alignment']);	
	}
	else{
		$savedata['slider_align_key'] = '';
	}

	if(isset($_POST['mg_data_bgclor'])){
		$savedata['slider_bgcolor_key'] = sanitize_text_field($_POST['mg_data_bgclor']);	
	}
	else{
		$savedata['slider_bgcolor_key'] = '';
	}

	// Slider Paddings
	if(isset($_POST['mg_data_pleft'])){
		$savedata['slider_pleft_key'] = sanitize_text_field($_POST['mg_data_pleft']);
	}
	else{
		$savedata['slider_pleft_key'] = '';
	}
	if(isset($_POST['mg_data_pright'])){
		$savedata['slider_pright_key'] = sanitize_text_field($_POST['mg_data_pright']);		
	}
	else{
		$savedata['slider_pright_key'] = '';
	}
	if(isset($_POST['mg_data_ptop'])){
		$savedata['slider_ptop_key'] = sanitize_text_field($_POST['mg_data_ptop']);	
	}
	else{
		$savedata['slider_ptop_key'] = '';
	}
	if(isset($_POST['mg_data_pbottom'])){
		$savedata['slider_pbottom_key'] = sanitize_text_field($_POST['mg_data_pbottom']);	
	}
	else{
		$savedata['slider_pbottom_key'] = '';
	}

	/*show navigation*/
	if(isset($_POST['vertical_navi_key'])){
		$savedata['vertical_navi_key'] = rest_sanitize_array($_POST['vertical_navi_key']);	
	}
	else{
		$savedata['vertical_navi_key'] = '';
	}

	/*update settings*/
	if(isset($_POST['vertical_opt_key'])){
		$savedata['vertical_opt_key'] = rest_sanitize_array($_POST['vertical_opt_key']);
	}

	/*update breakpoints*/
	if(isset($_POST['vertical_breakpoints_key'])){
		$savedata['vertical_breakpoints_key'] = rest_sanitize_array($_POST['vertical_breakpoints_key']);
	}

	update_gallery_metadata($post_id,$savedata);
}
add_action('save_post','slider_vertical_keylery_callback');