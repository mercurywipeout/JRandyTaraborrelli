<?php

/* function for portfolio block*/
function pmc_portBlock($title,$number_post,$rowsB,$categories,$port_ajax){
	wp_enqueue_script('pmc_bxSlider');		
	global $pmc_data,$sitepress;
	if(isset($pmc_data['home_recent_number_post'])){
		$showpost = $pmc_data['home_recent_number_post'] ;}
	else{
		$showpost = 3;}
		
	if($number_post){
		$showpost = $number_post  ;}		

	if($title) {
		$title = $title;
	}
	else {
		$title = pmc_stripText($pmc_data['translation_port']);
	}
		
	if(isset($pmc_data['home_recent_number_display']))
		$rows = $pmc_data['home_recent_number_display'];
	else
		$rows = 3;
		
	if($rowsB){
		$rows = $rowsB;
	}	
	
	if($categories)
		$categories = $categories;
	else
		$categories='';
		


		$pc = new WP_Query(array('post_type' => $pmc_data['port_slug'],
                'tax_query' => array( 
                     array (
                      'taxonomy' => 'portfoliocategory',
                      'field' => 'id',
                      'terms' => $categories
                     ), 
                 ),
                'posts_per_page' => $number_post)
             );
?>

	<script type="text/javascript">


		jQuery(document).ready(function(){	  


		// Slider
		var $slider = jQuery('#sliderAdvertisePort').bxSlider({
			controls: true,
			displaySlideQty: 1,
			default: 1000,
			easing : 'easeInOutQuint',
			prevText : '',
			nextText : '',
			pager :false
			
		});



		 });
	</script>
	
<?php 	if ($pc->have_posts()) :
	wp_enqueue_script('pmc_any');
	wp_enqueue_script('pmc_any_fx');
	wp_enqueue_script('pmc_any_video');	?>
<div class="homerecent">
	<div class="homerecentInner">
	<div id = "showpost-<?php echo $pmc_data['port_slug'] ?>">
		<div class="showpostload"><div class="loading"></div></div>
		<div class = "closehomeshow-<?php echo $pmc_data['port_slug'] ?> port closeajax"><i class="icon-remove"></i></div>
		<div class="showpostpostcontent"></div>
	</div>	
	<div class="titlebordrtext"><h2 class="titleborderh2"><?php echo $title ?></h2></div>	
	<div class="titleborderOut"><div class="titleborder"></div></div>	
	<ul id="sliderAdvertisePort" class="sliderAdvertisePort">
		<?php
		$currentindex = '';
		$count = 1;
		$countitem = 1;
		$type = $pmc_data['port_slug'];
		?>
		<?php  while ($pc->have_posts()) : $pc->the_post();
		if($countitem == 1){
			echo '<li>';}			
		$full_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'homePort', false);	
		$catType= 'portfoliocategory';
		
		//category
		$categoryIn = get_the_term_list( get_the_ID(), $catType, '', ', ', '' );	
		$category = explode(',',$categoryIn);	
		//end category			
		if ( has_post_thumbnail() ){
			$image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'homePort', false);
			$image = $image[0];
			
			$imagefull = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full', false);
			$imagefull = $imagefull[0];			
			}
		else
			$image = get_template_directory_uri() .'/images/placeholder-portfolio-home.png'; 
	
		if($count != 3){
			echo '<div class="one_third" >';
		}
		else{
			echo '<div class="one_third last" >';
			$count = 0;
		}
		?>
				<?php if ($port_ajax == 'true'){ ?>
				<div class="click" id="<?php echo $type ?>_<?php echo get_the_id() ?>">
				<?php } ?>
					<?php if ($port_ajax != 'true'){ ?>
					<a href = "<?php echo $imagefull ?>" title="<?php echo esc_attr(  get_the_title(get_the_id()) ) ?>" rel="lightbox" >
					<?php } ?>	
					<div class="recentimage">
							<div class="overdefult">
								<div class="portIcon"></div>
							</div>			
						<div class="image">
							<div class="loading"></div>
							<img class="portfolio-home-image" src="<?php echo $image ?>" alt="<?php the_title(); ?>">
						</div>
					</div>
					<?php if ($port_ajax != 'true'){ ?>
						</a>
					<?php } ?>						
					<div class="recentdescription">
						<?php if ($port_ajax != 'true'){ ?>
							<a href="<?php echo get_permalink( get_the_id() ) ?>">
						<?php } ?>
						<h3><?php $title = the_title('','',FALSE);  echo substr($title, 0, 23);  if(strlen($title) > 23) echo '...'?></h3>
						<?php if ($port_ajax != 'true'){ ?>
							</a>
						<?php } ?>						
						<div class="recentdescription-text"><?php echo shortcontent("[", "]", "", get_the_content() ,90) ?></div>
						<?php if ($port_ajax != 'true'){ ?>
							<div class="recentdescription-text"><a href="<?php echo get_permalink( get_the_id() ) ?>"><?php echo pmc_translation('translation_morelinkblog', 'Read more about this...') ?></a></div>
						<?php } ?>
					</div>
				<?php if ($port_ajax == 'true'){ ?>	
				</div>
				<?php } ?>
			</div>
		<?php 
		$count++;
		
		 if($countitem == $rows){ 
			$countitem = 0; ?>
			</li>
		<?php } 
		$countitem++;
		endwhile; 
		wp_reset_query(); ?>
		</ul>
	</div>
</div>
<?php  endif; ?>

<div class="clear"></div>

<?php

}

/* function for advertise block */
function pmc_advertiseBlock($title){

	global $pmc_data,$sitepress; 
	wp_enqueue_script('pmc_bxSlider');		
	if($title) {
		$title = $title;
	}
	else {
		$title = '';
	}	
	?>
	<script type="text/javascript">


		jQuery(document).ready(function(){	  


		<?php if(count($pmc_data['advertiseimage'])> 5) { ?>
		// Slider
		var $slider = jQuery('.sliderAdvertise').bxSlider({
			maxSlides:5,
			minSlides:1,
			moveSlides:1,
			prevText : '',
			nextText : '',
			auto : true,
			easing : 'easeInOutQuint',
			pause : 4000,
			pager :false,
			controls: true,
		});

		<?php } ?> 

		 });
	</script>
	
	<div class="advertise">
		<div class="advertiseInner">
			<?php if($title != '') { ?>
			<div class="titlebordrtext"><h2 class="titleborderh2"><?php echo $title ?></h2></div>	
			<div class="titleborderOut"><div class="titleborder"></div></div>
			<?php } ?>
			<?php 
			if(isset($pmc_data['advertiseimage'])){
				$slides = $pmc_data['advertiseimage']; ?>
				<ul class="sliderAdvertise">
				<?php foreach ($slides as $slide) {  ?>
					<li>
					<?php
					  if($slide['url'] != '') :
							   
						 if($slide['link'] != '') : ?>
						   <a href="<?php echo $slide['link']; ?>"><img src="<?php echo $slide['url']; ?>" alt="<?php echo $slide['title'] ?>" /></a>
						<?php else: ?>
							<img src="<?php echo $slide['url']; ?>" alt="<?php echo $slide['title'] ?>"/>
						<?php endif; ?>
								
					<?php endif; ?>
					</li>
				<?php } ?>
				</ul>
			<?php } ?>	
		</div>
	</div>
	<?php
}

?>