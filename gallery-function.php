<?php 
if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly
}

function shortcode_gallery_slider($postid){
	$outputgal = '';
	if(!empty($postid)){
		$meta_data = get_gallery_metadata($postid);

	 	$getimag 				= get_post_meta($postid,'mg_gallery_imgids', true);
	 	$getttl 				= get_post_meta($postid,'mg_gallery_title', true);
	 	$getdescription = get_post_meta($postid,'mg_gallery_desc', true);

		$hidetitle = get_gallery_metavalue($meta_data, 'hide_title_key',true);
		
	 	$hidedescription 	= get_gallery_metavalue($meta_data, 'hide_desc_key', true); 

		$simagezoom 	= get_gallery_metavalue($meta_data, 'image_zoom_key', true);

		$getverticalgal = get_gallery_metavalue($meta_data, 'slider_vertical_key', true);
		$getvertical_opt = get_gallery_metavalue($meta_data, 'vertical_opt_key', true);
		$getverticalcontrl = get_gallery_metavalue($meta_data, 'vertical_navi_key', true);
		$getverticalBreakpoints = get_gallery_metavalue($meta_data, 'vertical_breakpoints_key', true );
		$sthumbalign = get_gallery_metavalue($meta_data, 'slider_align_key', true);

		$sliderbgcolor = get_gallery_metavalue($meta_data, 'slider_bgcolor_key', true);

		$sliderPLeft = get_gallery_metavalue($meta_data, 'slider_pleft_key', true);
		$sliderPRight = get_gallery_metavalue($meta_data, 'slider_pright_key', true);
		$sliderPTop = get_gallery_metavalue($meta_data, 'slider_ptop_key', true);
		$sliderPBottom = get_gallery_metavalue($meta_data, 'slider_pbottom_key', true);
		
		$sliderPadding = $sliderPTop.' '.$sliderPRight.' '.$sliderPBottom.' '.$sliderPLeft;
		
		$lboxswitchr 	= get_option('mg_data_lightbx_switcher');
		$lboxdownload 	= get_option('mg_data_lightbx_download');
		if(empty($lboxdownload)){
			$lboxdownload = false;
		}
	 
		if(!empty($getimag)){ 
			ob_start();
				
			if((null == $hidetitle && empty($hidetitle) && !empty($getttl)) || ((null == $hidedescription) && empty($hidedescription) && !empty($getdescription))) { ?>
			<div class="micro-gallery-prev-gallery">
				<?php if(null == $hidetitle && empty($hidetitle) && !empty($getttl)) { ?>				
					<p class="micro-gallery-prev-title"><strong><?php echo esc_html($getttl);?></strong></p> 
				<?php } ?>
				<?php if(null == $hidedescription && empty($hidedescription) && !empty($getdescription)) { ?>
					<p class="micro-gallery-prev-desc"><?php echo esc_html($getdescription);?></p> 
				<?php } ?>
			</div>
			<?php } 
				if(null !== $getverticalgal && !empty($getverticalgal)){
					if( null!== $getvertical_opt){
				    $VssliderRange = $getvertical_opt;
				    $smaxwidth = $VssliderRange;
					}
				}
				else{
					$smaxwidth = get_option('mg_data_sliderwidth');
				}
				$thumbsize = get_option('mg_data_slider_thumb_size');
				if (!empty($thumbsize)) {
					$thumbsize = get_option('mg_data_slider_thumb_size');
				}else{
					$thumbsize = 'thumbnail';
				}
			?>

		 	<div class="item" style="<?php if(!empty($sliderbgcolor)){ ?>background-color:<?php esc_html_e($sliderbgcolor, 'microgallery-slider'); ?>;<?php } ?>padding: <?php echo $sliderPadding; ?>;">            
	      <div class="clearfix" <?php if(!empty($smaxwidth)){ ?>style="max-width:<?php esc_html_e($smaxwidth, 'microgallery-slider'); ?>px;"<?php } ?>>

	        <ul id="micro-gallery-img-gallery<?php esc_html_e($postid, 'microgallery-slider'); ?>" class="micro-gallery-slidergal list-unstyled cS-hidden" data-litebx="<?php if(!empty($lboxswitchr)){ echo esc_attr($lboxswitchr); }else{ echo "false"; }?>">
				    <?php
					$scaption = get_option('mg_data_enable_caption');
						foreach ($getimag as $imgvalue) {

					 		$attchimg = wp_get_attachment_image_src($imgvalue,'full');
					 		$thumbnailimg = wp_get_attachment_image_src($imgvalue, $thumbsize);
					 		$image_alt = get_post_meta($imgvalue, '_wp_attachment_image_alt', true);
					 		$image_cap = get_post($imgvalue)->post_excerpt;
					 	?>

					 		<li data-thumb="<?php echo esc_url($thumbnailimg[0]); ?>" data-responsive="<?php echo esc_url($thumbnailimg[0]); ?>" data-src="<?php echo esc_url($attchimg[0]); ?>" class="<?php if(!empty($simagezoom)){ esc_html_e('zoom', 'microgallery-slider'); }?>"> 
              	<img src="<?php echo esc_url($attchimg[0]); ?>" alt="<?php echo esc_attr($image_alt);?>" />
              		<?php if($scaption == 'true' && !empty($image_cap)): ?>
              			<p><?php echo esc_html($image_cap);?></p>
              		<?php endif; ?>
              </li>
					 	<?php } ?>
					</ul>
				</div>
			</div>

			<?php if(!get_option('mg_data_enable_alt_txt')){ ?>
			<style type="text/css">
				.lg .lg-sub-html{
					display: none !important;
				}
			</style>
			<?php } ?>

			<style type="text/css">
				.lSSlideOuter .lSSlideWrapper ul li img{
				  width: 100%;
				}
			</style>

			<?php if(null !== $simagezoom && !empty($simagezoom)){ ?>

			<script>
				jQuery(function() {
				  jQuery('.zoom').zoom();
				});
			</script>

			<?php	} 

				$gallitms = get_option('mg_data_itemcount');
				if(!empty($gallitms)){
					$gallitms = $gallitms;
				}
				else{
					$gallitms = 1;
				}
				$getmargin = get_option('mg_data_slidemargin');
				if(!empty($getmargin)){
					$getmargin = $getmargin;
				}
				else{
					$getmargin = 10;
				}
				$addclss = get_option('mg_data_classtoslider');
				$sliderspd = get_option('mg_data_speedslider');
				if(!empty($sliderspd)){
					$sliderspd = $sliderspd;
				}
				else{
					$sliderspd = 500;
				}
				$spause = get_option('mg_data_slideinterval');
				if(!empty($spause)){
					$spause = $spause*1000;
				}
				else{
					$spause = 2000;
				}
				$smode = get_option('mg_data_slidermode');
				if(!empty($smode)){
					$smode = $smode;
				}
				else{
					$smode = "false";
				}
				$sloop = get_option('mg_data_allow_looping');
				if(!empty($sloop)){
					$sloop = $sloop;
				}
				else{
					$sloop = "false";
				}
				$spager = get_option('mg_data_slider_pagination');
				if(!empty($spager)){
					$spager = $spager;
				}
				else{
					$spager = "true";
				}
				$sgallery = get_option('mg_data_slider_menuoption');
				if(!empty($sgallery)){
					$sgallery = $sgallery;
				}
				else{
					$sgallery = "true";
				}
				$sthumbitem = get_option('mg_data_numberof_thumbitems');
				if(!empty($sthumbitem)){
					$sthumbitem = $sthumbitem;
				}
				else{
					$sthumbitem = 9;
				}
				$s_nav = get_option('mg_data_slider_navigation');
				if(!empty($s_nav)){
					$s_nav = $s_nav;
				}
				else{
					$s_nav = "true";
				}				
				$seffect = get_option('mg_data_slider_effect');

				if(null !== $getverticalgal && !empty($getverticalgal)){
					if( null!== $getvertical_opt){
					    $sliderRange = $getvertical_opt;
					}
					  $sliderWidth = !empty($sliderRange) ? $sliderRange[0] : '1100'; 
					  $sliderHeight = !empty($sliderRange) ? $sliderRange[1] : '450';
					  $thumbnlWidth = !empty($sliderRange) ? $sliderRange[2] : '100';
					  $maxThumbItm = !empty($sliderRange) ? $sliderRange[3] : '6';

					  if(!empty($getverticalcontrl)){
					  	$contrlNav = 'true';
					  }
					  else{
					  	$contrlNav = 'false';
					  }
					  
					if( null!== $getverticalBreakpoints){
					    $sliderBreakpoints = $getverticalBreakpoints;
					}  
					$vheight480 = !empty($sliderBreakpoints) ? $sliderBreakpoints[0] : '200'; 
					$vthumb480 = !empty($sliderBreakpoints) ? $sliderBreakpoints[1] : '4';
					
					$vheight641 = !empty($sliderBreakpoints) ? $sliderBreakpoints[2] : '300';
					$vthumb641 = !empty($sliderBreakpoints) ? $sliderBreakpoints[3] : '6';

					$vheight800 = !empty($sliderBreakpoints) ? $sliderBreakpoints[4] : '370';
					$vthumb800 = !empty($sliderBreakpoints) ? $sliderBreakpoints[5] : '6';
					
					if($sthumbalign == 'left'){
					?>
					<style>
						.lSSlideOuter.vertical{
							padding-left: 105px;
							padding-right: 0px!important;
						}
						.lSSlideOuter.vertical .lSGallery {
						    left: 0;
						    margin-left: 0px!important;
						}
					</style>
					<?php 
					}
					?>
				<script>
					jQuery(document).ready(function() {
						var setting_download = '<?php echo $lboxdownload; ?>';
            var count  = 0
              if (count === 1) return;
              jQuery('#micro-gallery-img-gallery<?php esc_html_e($postid, 'microgallery-slider'); ?>').addClass('cS-hidden');
                jQuery('#micro-gallery-img-gallery<?php esc_html_e($postid, 'microgallery-slider'); ?>').lightSlider({
                  gallery:true,
				  <?php if($seffect == 'fade'): ?>
					mode: '<?php esc_html_e($seffect, 'microgallery-slider'); ?>',
				   <?php endif; ?>	                        
	              speed:<?php esc_html_e($sliderspd, 'microgallery-slider');?>,
                  auto:<?php esc_html_e($smode, 'microgallery-slider');?>,
                  item: 1,
							    loop: <?php esc_html_e($sloop, 'microgallery-slider');?>,
							    thumbItem: <?php esc_html_e($maxThumbItm, 'microgallery-slider'); ?>,
							    vertical: true,
							    verticalHeight:<?php esc_html_e($sliderHeight, 'microgallery-slider'); ?>,
							    vThumbWidth:<?php esc_html_e($thumbnlWidth, 'microgallery-slider'); ?>,
							    thumbMargin:4,
							    controls:<?php esc_html_e($contrlNav, 'microgallery-slider'); ?>,//navigation
							    responsive : [
			            {
		                breakpoint:800,
		                settings: {
	                    item:1,
	                    slideMove:1,
	                    verticalHeight:<?php esc_html_e($vheight800, 'microgallery-slider'); ?>,
	                    thumbItem:<?php esc_html_e($vthumb800, 'microgallery-slider'); ?>,
	                  }
			            },
			            {
		                breakpoint:641,
		                settings: {
	                    item:1,
	                    slideMove:1,
	                    verticalHeight:<?php esc_html_e($vheight641, 'microgallery-slider'); ?>,
	                    thumbItem:<?php esc_html_e($vthumb641, 'microgallery-slider'); ?>,
	                  }
			            },
			            {
		                breakpoint:480,
		                settings: {
	                    item:1,
	                    slideMove:1,
	                    verticalHeight:<?php esc_html_e($vheight480, 'microgallery-slider'); ?>,
	                    thumbItem:<?php esc_html_e($vthumb480, 'microgallery-slider'); ?>,
	                  }
			            },						           
			        	],

                onSliderLoad: function(obj) {
                	jQuery('#micro-gallery-img-gallery<?php esc_html_e($postid, 'microgallery-slider'); ?>').removeClass('cS-hidden');
	                var lithbox = jQuery('#micro-gallery-img-gallery<?php esc_html_e($postid, 'microgallery-slider'); ?>').attr("data-litebx");
					if(lithbox=='true'){
						obj.lightGallery({
							download: setting_download,
							selector: '#micro-gallery-img-gallery<?php esc_html_e($postid, 'microgallery-slider'); ?> .lslide'
						});
					}            
                } 
              });
            count++;
          });
	      </script>
				<?php } else {
				$sthumbalign = get_gallery_metavalue($meta_data, 'slider_align_key', true);
				if($sthumbalign == 'center'){
				?>
				<style>
					.lSSlideOuter .lSPager.lSGallery {
						margin-left: auto;
						margin-right: auto;
					}
				</style>
				<?php 
				}
				else if($sthumbalign == 'right'){
				?>
				<style>
					.lSSlideOuter .lSPager.lSGallery {
						margin-left: auto;
					}
				</style>
				<?php 
				}
				?>
				<script>
		    	jQuery(document).ready(function() {
					var setting_download = '<?php echo $lboxdownload; ?>';
		        jQuery('#micro-gallery-img-gallery<?php esc_html_e($postid, 'microgallery-slider'); ?>').lightSlider({
              item:<?php esc_html_e($gallitms, 'microgallery-slider');?>,		                
              slideMargin:<?php esc_html_e($getmargin, 'microgallery-slider');?>,
              addClass:'<?php esc_html_e($addclss, 'microgallery-slider');?>',
              speed:<?php esc_html_e($sliderspd, 'microgallery-slider');?>,
              pause:<?php esc_html_e($spause, 'microgallery-slider');?>,
              auto:<?php esc_html_e($smode, 'microgallery-slider');?>,
              loop:<?php esc_html_e($sloop, 'microgallery-slider');?>,
              pager:<?php esc_html_e($spager, 'microgallery-slider');?>,
              gallery:<?php esc_html_e($sgallery, 'microgallery-slider');?>,
              thumbItem:<?php esc_html_e($sthumbitem, 'microgallery-slider');?>,
	    	  controls:<?php esc_html_e($s_nav, 'microgallery-slider');?>,
	    	   <?php if($seffect == 'fade'): ?>
								mode: '<?php esc_html_e($seffect, 'microgallery-slider'); ?>',
							<?php endif; ?>
							
	    				responsive : [
		            {
	                breakpoint:800,
	                settings: {
                    item:1,
                    slideMove:1,
                  }
		            },
		            {
	                breakpoint:641,
	                settings: {
                    item:1,
                    slideMove:1,
                  }
		            },
		            {
	                breakpoint:480,
	                settings: {
                    item:1,
                    slideMove:1,
                  }
		            },						           
						  ],
	    					useCSS: true,
	        			cssEasing: 'ease',
	        			easing: 'linear',
	        			keyPress: false,
	        			slideEndAnimation: true,
	        			swipeThreshold: 40,        			
		              	onSliderLoad: function(el) {
							jQuery('#micro-gallery-img-gallery<?php esc_html_e($postid, 'microgallery-slider'); ?>').removeClass('cS-hidden');
							jQuery('#micro-gallery-img-gallery<?php esc_html_e($postid, 'microgallery-slider'); ?>').addClass('mg-loaded');
							
							var lithbox = jQuery('#micro-gallery-img-gallery<?php esc_html_e($postid, 'microgallery-slider'); ?>').attr("data-litebx");
							if(lithbox=='true'){
								el.lightGallery({
									download: setting_download,
									selector: '#micro-gallery-img-gallery<?php esc_html_e($postid, 'microgallery-slider'); ?> .lslide'
								});
							}	
		              	}  
			        });
					});
		    	<?php if($smode != 'false'){ ?>
						var interval = setTimeout(function() {
						document.querySelector('.lSSlideOuter > ul > li:nth-child(2)').click();
						}, 3000);
					<?php } ?>
			</script>
		 <?php }
		 $outputgal = ob_get_clean();			 
		}		
	}
	return $outputgal;
}

/* Gallery thumbnail grid shortcode */
function shortcode_display_gallery_list($no_of_items){
	$outputgallery = '';
	$argary = array(
		'posts_per_page' => $no_of_items,
		'post_type'	=>	'microgallery',
		'post_status'	=> 'publish',
		);
	$getgallery = new WP_Query($argary);	
	if($getgallery->have_posts()){
		ob_start();
		echo '<div class="micro-gallery-gallery-listings"><ul id="micro-gallery-thumbrig">';		
		while ($getgallery->have_posts()) {
			$getgallery->the_post();
			if( has_post_thumbnail()) { ?>
				<li>
    			<a class="micro-gallery-thumbrig-cell" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" target="_blank">
    				<?php the_post_thumbnail('thumbnail', array( 'class' => 'micro-gallery-thumbrig-img' )); ?>
            	<span class="micro-gallery-thumbrig-overlay"></span>
            	<span class="micro-gallery-thumbrig-text"><?php the_title_attribute(); ?></span>
            </a>
        </li>				  			
    	<?php   			
			}
			else { ?>
				<li>
    			<a class="micro-gallery-thumbrig-cell" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" target="_blank">
    				<img class="micro-gallery-thumbrig-img" src="<?php echo GTS_PLUGINURL; ?>includes/images/thumbnail.png" alt="img"/>
            	<span class="micro-gallery-thumbrig-overlay"></span>
            	<span class="micro-gallery-thumbrig-text"><?php the_title_attribute(); ?></span>
            </a>
        </li>
			<?php
			}
		}
		echo '<div class="clear clearfix"></div>';
		echo '</div></ul>';
		
		$outputgallery = ob_get_clean();
	}	
	return $outputgallery;
}

function get_gallery_metadata( $post_id = 0) {
    $post_id = (int) $post_id;

    if ( ! $post_id ) {
        return null;
    }

    $data = get_post_meta( $post_id, 'mg_gallery_options', true );

    if ( ! $data ) {
        return null;
    }

    return $data;
}

function get_gallery_metavalue( $meta_data, $key = '', $single = false ) {
    // 如果 $meta_data 不是数组或者 $key 为空，则返回 null
    if ( ! is_array( $meta_data ) || empty( $key ) ) {
        return null;
    }

    // 如果 $meta_data 中存在 $key，则返回对应的值
    if ( array_key_exists( $key, $meta_data ) ) {
        return $meta_data[ $key ];
    }

    // 如果 $single 为 true，则返回空字符串；否则返回空数组
    return $single ? '' : array();
}

function update_gallery_metadata( $post_id, $data ) {
    $post_id = (int) $post_id;
    
    if ( $data ) {
        return update_post_meta( $post_id, 'mg_gallery_options', $data );
    } else {
        return delete_post_meta( $post_id, 'mg_gallery_options' );
    }
}
