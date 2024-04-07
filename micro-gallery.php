<?php 
/* Plugin Name: Gallery Slider
* Description: GallerySlider is a very nifty responsive gallery plugin that helps you put images and slideshows wherever you need. The plugin is highly customizable. You can adjust size, style, timing, transitions, controls, lightbox effects, vertical gallery and more as per your needs.
* Plugin URI: https://wordpress.org/plugins/microgallery-slider
* Author: Galaxy Weblinks
* Author URI: http://galaxyweblinks.com
* Version: 6.9
* Text Domain: microgallery-slider
* License:GPL2
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if(!defined('GTS_PLUGINURL')){
	define('GTS_PLUGINURL', plugin_dir_url(__FILE__));
}
if(!defined('GTS_PLUGINPATH')){
	define('GTS_PLUGINPATH', plugin_dir_path(__FILE__));
}

require_once(GTS_PLUGINPATH.'gallery-metabox.php');
require_once(GTS_PLUGINPATH.'gallery-slider.php');
require_once(GTS_PLUGINPATH.'gallery-shortcode.php');
require_once(GTS_PLUGINPATH.'gallery-function.php');
require_once(GTS_PLUGINPATH.'gallery-posttype.php');
require_once(GTS_PLUGINPATH.'gallery-slider-vertical.php');

/* admin notice when activate plugin */
register_activation_hook(__FILE__, 'mg_adminnotice_func');
function mg_adminnotice_func(){
	update_option('micro_gallery_notice','enabled');
}
function micro_gallery_admin_notice__success() {
	if(get_option('micro_gallery_notice') == 'enabled'){
    	?>
    <div class="notice notice-success is-dismissible">
        <p><?php esc_html_e( '查看 微相册 MicroGallery 配置项 请 ', 'microgallery-slider' ); ?><a href="<?php echo admin_url('edit.php?post_type=microgallery&page=gallery-options'); ?>"><?php esc_html_e( 'Click Here', 'microgallery-slider' ); ?></a></p>
    </div>
    <?php 
	delete_option('micro_gallery_notice');
	}
}
add_action( 'admin_notices', 'micro_gallery_admin_notice__success' );


/* Add setings link in the plugins page (beside the activate/deactivate links) */
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'mg_add_action_settings_link' );
function mg_add_action_settings_link ( $links ) {
	$mylinks = array('<a href="' . admin_url( 'edit.php?post_type=microgallery&page=gallery-settings' ) . '">设置</a>',);
	return array_merge( $links, $mylinks );
}

/* Create admin menu for gallery */
add_action('admin_menu','mg_adminmenu_func');
function mg_adminmenu_func(){
	add_menu_page(__( 'Micro Gallery', 'microgallery-slider' ),__( '相册', 'microgallery-slider' ), 'manage_options', 'edit.php?post_type=microgallery', NULL, 'dashicons-images-alt', 7);
	add_submenu_page('edit.php?post_type=microgallery', __( 'Enable Gallery', 'microgallery-slider' ),__( 'Gallery Options', 'microgallery-slider' ), 'manage_options', 'gallery-options','mg_slider_option_fuction');
	add_submenu_page('edit.php?post_type=microgallery',__( 'Slider Settings', 'microgallery-slider' ),__( 'Slider Settings', 'microgallery-slider' ), 'manage_options', 'gallery-settings','micro_gallery_option_fuction');
	add_action( 'admin_init', 'micro_gallery_plugin_settings' );
	add_action( 'admin_init', 'micro_reg_galleryoption_plugin_settings' );
}

function micro_reg_galleryoption_plugin_settings()
{
	register_setting( 'micro-gallery-data-options-group', 'mg_data_posttypes' );
}
function mg_slider_option_fuction(){
	if( isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true'):
   		echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><strong>Settings saved.</strong></p></div>';
	endif;
	?>
	<h3><?php esc_html_e( 'Enable The Image Gallery Slider For Post Types', 'microgallery-slider' ); ?></h3>
 	
	<?php
	$getarg = array(
		'public'	=> true,
		// '_builtin'	=>	true
	);
	$getptyp = get_post_types($getarg, 'names', 'or');
	$getopt = get_option('mg_data_posttypes');
	$searcharry = array('attachment', 'revision', 'nav_menu_item', 'custom_css', 'customize_changeset', 'microgallery', 'oembed_cache', 'user_request', 'wp_block');

	echo '<form method="post" action="options.php">';
	settings_fields( 'micro-gallery-data-options-group' ); 
   	do_settings_sections( 'micro-gallery-data-options-group' );  
	if(!empty($getptyp)){
		$counterid = 1;
		foreach ($getptyp as $gttype) {
			if(!in_array($gttype, $searcharry)){ ?>
				<div class="postype-sec"><span class="postype-ttl"><?php esc_html_e($gttype, 'microgallery-slider'); ?></span>
					<label class="switch">
						<input type="checkbox" id="togBtn-<?php esc_html_e($counterid, 'microgallery-slider'); ?>" name="mg_data_posttypes[]" value="<?php esc_html_e($gttype, 'microgallery-slider'); ?>" <?php if(!empty($getopt)){ 
					if(in_array($gttype, get_option('mg_data_posttypes'))){ echo "checked"; }} ?> ><div class="mg-setopt slider round"></div>
					</label>
				</div>
			<?php $counterid++; }
		}		
	}
	submit_button();
	wp_nonce_field( basename(__FILE__), 'mg_data_enable_post_type_nonce' );
	echo '</form>';	
	echo '<hr>';
	?>
	<h3>
		<?php esc_html_e('Use the shortcode to display galleries listing. [micro_gallery_list no_of_items=12]', 'microgallery-slider'); ?>
	</h3>

	<p><?php esc_html_e('Change the "no_of_items" value in the shortcode above to display items in the gallery.', 'microgallery-slider'); ?></p>

	<?php
}
function micro_gallery_plugin_settings() {

	$args = array(
		'type' => 'string', 
		'sanitize_callback' => 'sanitize_text_field',
		'default' => NULL,
	);
	$numargs = array(
		'type' => 'integer', 
		'sanitize_callback' => 'sanitize_text_field',
		'default' => NULL,
	);
    /*register our settings*/
    register_setting( 'micro-gallery-data-settings-group', 'mg_data_itemcount' );
    register_setting( 'micro-gallery-data-settings-group', 'mg_data_slidemargin' );
    register_setting( 'micro-gallery-data-settings-group', 'mg_data_classtoslider', $args );
    register_setting( 'micro-gallery-data-settings-group', 'mg_data_speedslider' );
    register_setting( 'micro-gallery-data-settings-group', 'mg_data_slideinterval', $numargs );
    register_setting( 'micro-gallery-data-settings-group', 'mg_data_slidermode' );
    register_setting( 'micro-gallery-data-settings-group', 'mg_data_allow_looping' );
    register_setting( 'micro-gallery-data-settings-group', 'mg_data_slider_navigation' );
    register_setting( 'micro-gallery-data-settings-group', 'mg_data_slider_menuoption' );
    register_setting( 'micro-gallery-data-settings-group', 'mg_data_numberof_thumbitems', $numargs );
    register_setting( 'micro-gallery-data-settings-group', 'mg_data_sliderwidth', $numargs );
    register_setting( 'micro-gallery-data-settings-group', 'mg_data_slider_pagination' );
    register_setting( 'micro-gallery-data-settings-group', 'mg_data_lightbx_switcher' );
    register_setting( 'micro-gallery-data-settings-group', 'mg_data_slider_effect' );
    register_setting( 'micro-gallery-data-settings-group', 'mg_data_slider_thumb_size' );
    register_setting( 'micro-gallery-data-settings-group', 'mg_data_enable_caption' );
	register_setting( 'micro-gallery-data-settings-group', 'mg_data_enable_alt_txt' );
	register_setting( 'micro-gallery-data-settings-group', 'mg_data_lightbx_download' );
}

/* Sub Menu Setting Callback function */
function micro_gallery_option_fuction(){ 
	if( isset($_GET['settings-updated']) && $_GET['settings-updated'] == 'true'):
   		echo '<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible"> 
		<p><strong>Settings saved.</strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
	endif;

 	$getmargin = get_option('mg_data_slidemargin');
	$smode = get_option('mg_data_slidermode');
	$sloop = get_option('mg_data_allow_looping');
	$snav = get_option('mg_data_slider_navigation');
	$spager = get_option('mg_data_slider_pagination');	
	$sgallery = get_option('mg_data_slider_menuoption');
	$sthumbitem = get_option('mg_data_numberof_thumbitems');
	$seffect = get_option('mg_data_slider_effect');
	$thumbsize = get_option('mg_data_slider_thumb_size');
	$lboxswitchr = get_option('mg_data_lightbx_switcher');
	$scaption = get_option('mg_data_enable_caption');
	$img_enable_alt_txt = get_option('mg_data_enable_alt_txt');
	
	$lboxdownload = get_option('mg_data_lightbx_download');
?>
<h3><?php esc_html_e( 'Slider Global Settings', 'microgallery-slider' ); ?></h3>

<form method="POST" action="options.php">
	<?php settings_fields( 'micro-gallery-data-settings-group' ); ?>
    <?php do_settings_sections( 'micro-gallery-data-settings-group' ); ?>
<div class="mainopt">

 	<div id="micro-gallery-sec1" class="micro-gallery-sec1">
	<p id="micro-gallery-selslid" class="mg-settings-opts"><label for="mg_data_itemcount"><?php esc_html_e( 'Display slide(s) :', 'microgallery-slider' ); ?> </label>
		 <select name="mg_data_itemcount" id="micro-gallery-galleryitems">
		 <?php $gallitms = get_option('mg_data_itemcount');?>
		 	<option value="1" <?php if($gallitms ==1){echo "selected";} ?>>1</option>
		 	<option value="2" <?php if($gallitms ==2){echo "selected";} ?>>2</option>
		 	<option value="3" <?php if($gallitms ==3){echo "selected";} ?>>3</option>
		 	<option value="4" <?php if($gallitms ==4){echo "selected";} ?>>4</option>
		 	<option value="5" <?php if($gallitms ==5){echo "selected";} ?>>5</option>
		 	<option value="6" <?php if($gallitms ==6){echo "selected";} ?>>6</option>
		 </select>
	</p>
	<p class="mg-settings-opts" id="micro-gallery-slidergap" <?php if($gallitms == "1" || $gallitms == ""){ ?>style="display: none;" <?php } ?>><label for="mg_data_slidemargin"><?php esc_html_e( 'Margin Between slides : ', 'microgallery-slider' ); ?></label><input type="number" min="1" max="200" id="micro-gallery-marginslide" name="mg_data_slidemargin" placeholder="Default 10px" value="<?php if(!empty($getmargin)){echo $getmargin;} ?>"></p>
	</div>

 	<p class="mg-settings-opts"><label for="mg_data_classtoslider"><?php esc_html_e( 'Add class in slider : ', 'microgallery-slider' ); ?></label><input type="text" placeholder="Add custom class" name="mg_data_classtoslider" value="<?php echo get_option('mg_data_classtoslider'); ?>"></p>

 	<p class="mg-settings-opts"><label for="mg_data_sliderwidth"><?php esc_html_e( 'Slider Max width ( px ) : ', 'microgallery-slider' ); ?></label><input type="number" min="200" max="2000" placeholder="Default full width" name="mg_data_sliderwidth" value="<?php echo get_option('mg_data_sliderwidth'); ?>"></p>
 
 	<hr>
 	<p class="mg-settings-opts"><label for="mg_data_speedslider"><?php esc_html_e( 'Slider Speed ( ms ) : ', 'microgallery-slider' ); ?></label><input type="number" min="200" max="1500" placeholder="Default speed 500" name="mg_data_speedslider" value="<?php if(!empty(get_option('mg_data_speedslider'))){ echo get_option('mg_data_speedslider'); } ?>"></p>
 
 	<p class="mg-settings-opts"><label for="mg_data_slideinterval"><?php esc_html_e( 'Slide Interval/Pause ( seconds ) : ', 'microgallery-slider' ); ?></label><input type="number" min="2" max="300" placeholder="Default 2 sec." name="mg_data_slideinterval" value="<?php if(!empty(get_option('mg_data_slideinterval'))){ echo get_option('mg_data_slideinterval'); } ?>"></p>
 
	<!-- Slider Navigation -->
	<p class="mg-settings-opts"><label for="mg_data_slider_navigation"><?php esc_html_e( 'Slider Navigation : ', 'microgallery-slider' ); ?></label>
		<select name="mg_data_slider_navigation" id="micro-gallery-slidernav">
		 	<option value="true" <?php if($snav == "true"){echo "selected";} ?>>True</option>
		 	<option value="false" <?php if($snav == "false"){echo "selected";} ?>>False</option>
		 </select>
	</p>

 	<!-- Slider pagination -->
 	<p class="mg-settings-opts"><label for="mg_data_slider_pagination"><?php esc_html_e( 'Slider pagination : ', 'microgallery-slider' ); ?></label>
		<select name="mg_data_slider_pagination" id="micro-gallery-sliderpager">
		 	<option value="true" <?php if($spager == "true"){echo "selected";} ?>>True</option>
		 	<option value="false" <?php if($spager == "false"){echo "selected";} ?>>False</option>
		</select>
 	</p>

	<div class="micro-gallery-pageroption" id="micro-gallery-pageroption" <?php if($spager == "false") {?> style="display:none" <?php }?>>

 		<p class="mg-settings-opts"><label for="mg_data_slider_menuoption"><?php esc_html_e( 'Select Menu Options : ', 'microgallery-slider' ); ?></label>
			<select name="mg_data_slider_menuoption" id="micro-gallery-showgallery-menu">
			 	<option value="true" <?php if($sgallery == "true"){echo "selected";} ?>>Show Thumbnail</option>
			 	<option value="false" <?php if($sgallery == "false"){echo "selected";} ?>>Show Dot pagination</option>
			 </select>
		</p>
	 	<p class="mg-settings-opts"><label for="mg_data_slider_effect"><?php esc_html_e( 'Select Slider Effect : ', 'microgallery-slider' ); ?></label>
			<select name="mg_data_slider_effect" id="micro-gallery-slider-effect">
			 	<option value="slide" <?php if($seffect == "slide"){echo "selected";} ?>>Slide</option>
			 	<option value="fade" <?php if($seffect == "fade"){echo "selected";} ?>>Fade</option>
			 </select>
		</p>
		<p class="mg-settings-opts"><label for="mg_data_slider_thumb_size"><?php esc_html_e( 'Select Thumbnails Size : ', 'microgallery-slider' ); ?></label>
			<select name="mg_data_slider_thumb_size" id="micro-gallery-slider-thumb-size">
			 	<option value="thumbnail" <?php if($thumbsize == "thumbnail"){echo "selected";} ?>>Thumbnail</option>
			 	<option value="medium" <?php if($thumbsize == "medium"){echo "selected";} ?>>Medium</option>
			 	<option value="medium_large" <?php if($thumbsize == "medium_large"){echo "selected";} ?>>Medium Large</option>
			 	<option value="large" <?php if($thumbsize == "large"){echo "selected";} ?>>Large</option>
			 	<option value="full" <?php if($thumbsize == "full"){echo "selected";} ?>>Full</option>
			 </select>
		</p>
 		<p class="mg-settings-opts" id="micro-gallery-slider-thumbitems" <?php if($sgallery == "false") {?> style="display:none" <?php }?>><label for="mg_data_numberof_thumbitems"><?php esc_html_e( 'Number of thumbnails : ', 'microgallery-slider' ); ?></label><input id="micro-gallery-thumbnailitems" type="number" min="2" max="15" name="mg_data_numberof_thumbitems" placeholder="Default 9" value="<?php if(!empty($sthumbitem)){echo $sthumbitem;} ?>">
 		</p>
	</div>
	
	<hr>
	<!-- Enable Caption -->
	<div class="mg-settings-opts">
	<label for="mg_data_enable_caption"><?php esc_html_e( 'Enable Caption: ', 'microgallery-slider' ); ?></label>
	 <label class="switch">
		<input type="checkbox" id="mg_data_enable_caption" name="mg_data_enable_caption" value="true"<?php if(!empty($scaption)){ echo "checked"; } ?>>
		<div class="mg-setopt slider round"></div>
	</label>
	</div>

	<!-- Enable Caption -->
	<div class="mg-settings-opts">
	<label for="mg_data_enable_alt_txt"><?php esc_html_e( 'Enable Alt Text: ', 'microgallery-slider' ); ?></label>
	 <label class="switch">
		<input type="checkbox" id="mg_data_enable_alt_txt" name="mg_data_enable_alt_txt" value="true"<?php if(!empty($img_enable_alt_txt)){ echo "checked"; } ?>>
		<div class="mg-setopt slider round"></div>
	</label>
	</div>

	<!-- Enable autometic slide -->
	<div class="mg-settings-opts">
	<label for="mg_data_slidermode"><?php esc_html_e( 'Enable Auto Slide: ', 'microgallery-slider' ); ?></label>
	 <label class="switch">
		<input type="checkbox" id="togBtn-ltbox" name="mg_data_slidermode" value="true"<?php if(!empty($smode)){ echo "checked"; } ?>>
		<div class="mg-setopt slider round"></div>
	</label>
	</div>

	<!-- Enable loop slider -->
	<div class="mg-settings-opts">
	<label for="mg_data_allow_looping"><?php esc_html_e( 'Enable Loop Slide: ', 'microgallery-slider' ); ?></label>
	 <label class="switch">
		<input type="checkbox" id="mg_data_allow_looping" name="mg_data_allow_looping" value="true"<?php if(!empty($sloop)){ echo "checked"; } ?>>
		<div class="mg-setopt slider round"></div>
	</label>
	</div>

	<!-- Enable Lightbox slider -->
	<div class="mg-settings-opts">
	<label for="mg_data_lightbx_switcher"><?php esc_html_e( 'Enable Lightbox Slider : ', 'microgallery-slider' ); ?></label>
	 <label class="switch">
		<input type="checkbox" id="togBtn-ltbox" name="mg_data_lightbx_switcher" value="true"<?php if(!empty($lboxswitchr)){ echo "checked"; } ?>>
		<div class="mg-setopt slider round"></div>
	</label>
	</div>

	<!-- Lightbox download option disable -->
	<?php if(!empty($lboxswitchr)){ ?>
		<div class="mg-settings-opts">
			<label for="mg_data_lightbx_download"><?php esc_html_e( 'Enable Lightbox Download Option : ', 'microgallery-slider' ); ?></label>
			<label class="switch">
				<input type="checkbox" id="togBtn-ltbox-download" name="mg_data_lightbx_download" value="true"<?php if(!empty($lboxdownload)){ echo "checked"; } ?>>
				<div class="mg-setopt slider round"></div>
			</label>
		</div>
	<?php } ?>

 	<?php submit_button(__("Save Settings","microgallery-slider"), 'primary', 'slidersettings'); ?>
</div>

	<?php wp_nonce_field( basename(__FILE__), 'mg_data_enable_slider_setting_nonce' ); ?>
</form>

<script>
jQuery(document).ready(function(){
	jQuery("#micro-gallery-galleryitems").change(function(){
		var thisval = jQuery(this).val();
		if(thisval == 1){
			jQuery("#micro-gallery-slidergap").css('display', 'none');
		}
		else{
			jQuery("#micro-gallery-slidergap").css('display', 'block');
		}
	});

	/* show thumnail option */
	jQuery("#micro-gallery-showgallery-menu").change(function(){
		var showgal = jQuery(this).val();
		if(showgal == "false"){
			jQuery("#micro-gallery-slider-thumbitems").css('display', 'none');
		}
		else{
			jQuery("#micro-gallery-slider-thumbitems").css('display', 'block');
		}
	});	

	/* pager setting */
	jQuery("#micro-gallery-sliderpager").change(function(){
		var sliderpager = jQuery(this).val();
		if(sliderpager == "false"){
			jQuery("#micro-gallery-pageroption").css('display', 'none');
		}
		else{
			jQuery("#micro-gallery-pageroption").css('display', 'block');
		}
	});
});
</script>

<?php }

/* Register jquery for sorting items in gallery */
function micro_gallery_enqueue_script(){
	wp_enqueue_media();
	wp_enqueue_script('micro-gallery-galleryjs', GTS_PLUGINURL.'includes/js/micrgallery-core.js', array('jquery'));
	wp_enqueue_script( 'jquery-ui-sortable' );
	wp_enqueue_style('micro-gallery-style-css', GTS_PLUGINURL.'includes/css/gallery-admin.css');	
	/* register vertical script */
	wp_register_script( 'micro-gallery-veticlegal', GTS_PLUGINURL.'includes/js/gallery-slider-vertical.js', array('jquery') );
}
add_action('admin_enqueue_scripts','micro_gallery_enqueue_script');


/* enqueue script for front end */
function mg_frontend_enqueue_script(){	
	wp_enqueue_style('micro-gallery-lightslider-css', GTS_PLUGINURL.'includes/css/lightslider.css');
	wp_enqueue_style('micro-gallery-style-css', GTS_PLUGINURL.'includes/css/gallery-style.css');
	wp_enqueue_style('micro-gallery-lightgal-css', GTS_PLUGINURL.'includes/css/lightgallery.css');

	wp_enqueue_script('micro-gallery-lightslider', GTS_PLUGINURL.'includes/js/lightslider.js', array('jquery'));
	wp_enqueue_script('micro-gallery-cdngal', GTS_PLUGINURL.'includes/js/picturefill.min.js', array('jquery'));
	wp_enqueue_script('micro-gallery-lightgallry', GTS_PLUGINURL.'includes/js/lightgallery-all.min.js', array('jquery'));
	wp_enqueue_script('micro-gallery-mousewheel', GTS_PLUGINURL.'includes/js/jquery.mousewheel.min.js', array('jquery'));
	wp_enqueue_script( 'micro-gallery-zoom.min', GTS_PLUGINURL.'includes/js/gallery-zoom.min.js', array('jquery') );
}
add_action('wp_enqueue_scripts','mg_frontend_enqueue_script');