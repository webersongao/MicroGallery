<?php
if ( ! defined( 'ABSPATH' ) ) {
   exit; // Exit if accessed directly
}

add_filter( 'the_content', 'gallery_filter_the_content_in_the_main_loop' );
function gallery_filter_the_content_in_the_main_loop( $content ) {
	$getpostopt = get_option('mg_data_posttypes');
	if(empty($getpostopt)){
		$getpostopt = array();
	}
	array_push($getpostopt,'microgallery');
	$postid = get_the_ID();	
	$getpostyp = get_post_type($postid);
	$outputgal = '';
	
	$slider_switcher = get_post_meta($postid, 'mg_gallery_hide', true);

	if($slider_switcher != 'true'){

		$meta_data = get_gallery_metadata($postid);
		$sliderPLeft = get_gallery_metavalue($meta_data, 'slider_pleft_key', true);
		$sliderPRight = get_gallery_metavalue($meta_data, 'slider_pright_key', true);
		$sliderbgcolor = get_gallery_metavalue($meta_data, 'slider_bgcolor_key', true);
		$sliderPTop = get_gallery_metavalue($meta_data, 'slider_ptop_key', true);
		$sliderPBottom = get_gallery_metavalue($meta_data, 'slider_pbottom_key', true);
		$sliderPadding = $sliderPTop.' '.$sliderPRight.' '.$sliderPBottom.' '.$sliderPLeft;
	
		$lboxdownload 	= get_option('mg_data_lightbx_download');
		if(empty($lboxdownload)){ $lboxdownload = false; }

		if(!empty($getpostopt)){
			if(in_array($getpostyp, $getpostopt)){

			 	$getttl = get_post_meta($postid, 'mg_gallery_title', true);
				$getimag = get_post_meta($postid, 'mg_gallery_imgids', true);
			 	$getdescription = get_post_meta($postid, 'mg_gallery_desc', true);

				if(!empty($getimag)){ 
					ob_start(); 
					if(!empty($getttl) || !empty($getdescription)) {?>
					<div class="micro-gallery-prev-gallery">
						<?php if(!empty($getttl)) { ?>				
						<p class="micro-gallery-prev-title"><strong><?php echo esc_html($getttl);?></strong></p> <?php } ?>
						<?php if(!empty($getdescription)) { ?>
						<p class="micro-gallery-prev-desc"><?php echo esc_html($getdescription);?></p> <?php } ?>
					</div>
					<?php } 
					if(null !== get_gallery_metavalue($meta_data, 'slider_vertical_key', true) && !empty(get_gallery_metavalue($meta_data, 'slider_vertical_key', true))){
						if( null!== get_gallery_metavalue($meta_data, 'vertical_opt_key', true )){
						   $VssliderRange = get_gallery_metavalue($meta_data, 'vertical_opt_key', true);
						   $smaxwidth = $VssliderRange[0];
						}
					}
					else{
						$smaxwidth = get_option('mg_data_sliderwidth');
					}
					/* Fetch Thumbnail image size */
					$thumbsize = get_option('mg_data_slider_thumb_size');
					if (!empty($thumbsize)) {
						$thumbsize = get_option('mg_data_slider_thumb_size');
					}else{
						$thumbsize = 'thumbnail';
					}
					?>
				 	<div class="item micro-gallery-prev-gallery-items" style="<?php if(!empty($sliderbgcolor)){ ?>background-color:<?php esc_html_e($sliderbgcolor, 'microgallery-slider'); ?>;<?php } ?>padding: <?php echo $sliderPadding; ?>;">
			        	<div class="clearfix" <?php if(!empty($smaxwidth)){ ?> style="max-width:<?php esc_html_e($smaxwidth, 'microgallery-slider') ?>px;" <?php } ?>>
				 			
				 		<?php $lboxswitchr = get_option('mg_data_lightbx_switcher'); ?>
			        <ul id="micro-gallery-img-gallery" class="micro-gallery-slidergal list-unstyled cS-hidden" data-litebx="<?php if(!empty($lboxswitchr)){echo $lboxswitchr;}else{echo "false";}?>">
						   	
						   	<?php
							 	foreach ($getimag as $imgvalue) {
							 		$attchimg = wp_get_attachment_image_src($imgvalue,'full');
							 		$thumbnailimg = wp_get_attachment_image_src($imgvalue, $thumbsize);
							 		$image_alt = get_post_meta($imgvalue, '_wp_attachment_image_alt', true);
								?>
							 		<li data-thumb="<?php echo esc_url($thumbnailimg[0]); ?>" data-responsive="<?php echo esc_url($thumbnailimg[0]); ?>" data-src="<?php echo esc_url($attchimg[0]); ?>"> 
				            <img src="<?php echo esc_attr($attchimg[0]); ?>" alt="<?php echo esc_attr($image_alt);?>"/>
				          </li>
							 	<?php } ?>
							</ul>
						</div>
					</div>				
					<?php 
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
						
						if(null !== get_gallery_metavalue($meta_data, 'slider_vertical_key', true) && !empty(get_gallery_metavalue($meta_data, 'slider_vertical_key', true))){
							if( null!== get_gallery_metavalue($meta_data, 'vertical_opt_key', true )){
							    $sliderRange = get_gallery_metavalue($meta_data, 'vertical_opt_key', true);
							}

							$sliderWidth = !empty($sliderRange) ? $sliderRange[0] : '1100'; 
							$sliderHeight = !empty($sliderRange) ? $sliderRange[1] : '450';
							$thumbnlWidth = !empty($sliderRange) ? $sliderRange[2] : '100';
							$maxThumbItm = !empty($sliderRange) ? $sliderRange[3] : '6';

							if(!empty(get_gallery_metavalue($meta_data, 'vertical_navi_key', true))){
							  	$contrlNav = 'true';
							}
							else{
							  	$contrlNav = 'false';
							}
							  
							if( null!== get_gallery_metavalue($meta_data, 'vertical_breakpoints_key', true )){
							   $sliderBreakpoints = get_gallery_metavalue($meta_data, 'vertical_breakpoints_key', true);
							} 
							$vheight480 = !empty($sliderBreakpoints) ? $sliderBreakpoints[0] : '200'; 
							$vthumb480 = !empty($sliderBreakpoints) ? $sliderBreakpoints[1] : '4';
							
							$vheight641 = !empty($sliderBreakpoints) ? $sliderBreakpoints[2] : '300';
							$vthumb641 = !empty($sliderBreakpoints) ? $sliderBreakpoints[3] : '6';

							$vheight800 = !empty($sliderBreakpoints) ? $sliderBreakpoints[4] : '370';
							$vthumb800 = !empty($sliderBreakpoints) ? $sliderBreakpoints[5] : '6';
							?>
							<script>
							jQuery(document).ready(function() {
								var setting_download = '<?php echo $lboxdownload; ?>';
                var count  = 0
                  if (count === 1) return;
                  jQuery('#micro-gallery-img-gallery').addClass('cS-hidden');
                  jQuery('#micro-gallery-img-gallery').lightSlider({	
                    gallery:true,	                        
                    speed:<?php esc_html_e($sliderspd, 'microgallery-slider');?>,
                    pause:<?php esc_html_e($spause, 'microgallery-slider');?>,
                    auto:<?php esc_html_e('fade', 'microgallery-slider');?>,
                    item: 1,
									  loop: <?php esc_html_e($sloop, 'microgallery-slider');?>,
									  thumbItem: <?php esc_html_e($maxThumbItm, 'microgallery-slider'); ?>,
									  vertical: true,
									  verticalHeight:<?php esc_html_e($sliderHeight, 'microgallery-slider'); ?>,
									  vThumbWidth:<?php esc_html_e($thumbnlWidth, 'microgallery-slider'); ?>,
									  thumbMargin:4,
									  controls:<?php esc_html_e($contrlNav, 'microgallery-slider'); ?>,
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
                      jQuery('#micro-gallery-img-gallery').removeClass('cS-hidden');
                      var lithbox = jQuery('#micro-gallery-img-gallery').attr("data-litebx");
											
											if(lithbox=='true'){
												obj.lightGallery({
													download: setting_download,
			                		selector: '#micro-gallery-img-gallery .lslide'
			            			});
											}            
                  	} 
                  });
			            
			            count++;
				        });
				      </script>
						<?php } else { ?>

						<script>
				    	jQuery(document).ready(function() {	
							var setting_download = '<?php echo $lboxdownload; ?>';		    	 	
	            	jQuery('#micro-gallery-img-gallery').lightSlider({		                
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
                	controls:<?php esc_html_e($s_nav,'microgallery-slider');?>,
      						useCSS: true,
      						cssEasing: 'ease',
	        				easing: 'linear',
	        				keyPress: false,
	        				slideEndAnimation: true,
	        				swipeThreshold: 40,
	                onSliderLoad: function(el) {
                    jQuery('#micro-gallery-img-gallery').removeClass('cS-hidden');
                    jQuery('#micro-gallery-img-gallery').addClass('mg-loaded');

										var maxHeight = 0,
										container = jQuery(el),
										children = container.children();
										children.each(function () {
											var childHeight = jQuery(this).height();
											
											if (childHeight > maxHeight) {
												maxHeight = childHeight;
											}
										});
									container.height(maxHeight);
									var lithbox = jQuery('#micro-gallery-img-gallery').attr("data-litebx");
						
									if(lithbox=='true'){
										el.lightGallery({
											download: setting_download,
				              selector: '.micro-gallery-slidergal .lslide'
				            });
									}
	              }, 
	            });
						});
				  </script>			    	
				 	<?php }
				 $outputgal = ob_get_clean();			 
				}
			}
		}
	}
	return $content.$outputgal;
}
