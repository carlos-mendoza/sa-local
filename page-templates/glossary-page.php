<?php
/**
 * Template Name: Glossary Page Template
 */
 
get_header(); 

$custom_privacy ;
if($user_role == "administrator"){
    $custom_privacy = array();
}else{
    
    $custom_privacy = array('meta_query'=> array(array('key'=> 'user_type','value'=> $user_role,'compare' => 'LIKE',)));
} 
$user_type = get_post_meta(get_the_ID(), 'user_type', true);
$page_title = get_post_meta(get_the_ID(), 'page_title', true);
 if(!$user_type){
    $user_type = array();
}
?>
<script src="<?php echo get_template_directory_uri(); ?>/js/isotope.pkgd.min.js"></script>

<script>


function setminHeight(column) {
    var maxHeight = 0;
    //Get all the element with class = col
    column = jQuery(column);
    column.css('height', 'auto');
    //Loop all the column
    column.each(function() {       
        //Store the highest value
        if(jQuery(this).is(':visible')){
        if(jQuery(this).height() > maxHeight) {
            maxHeight = jQuery(this).height();
        }
        }
    });
    //Set the height
    column.height(maxHeight);
}

function onAnimationFinished(){
     console.log("yes");    
}

jQuery(document).ready(function($){
     $container = $('.masonary').isotope({
  itemSelector: '.g_box',
  percentPosition: true,
  masonry: {
    columnWidth: '.g_box'
  },
 layoutMode: 'fitRows',
})
//setminHeight(".masonary .g_box");
var oftop = jQuery(".top_app").offset().top;
    jQuery(window).scroll(function(){
        if (jQuery(window).scrollTop() >= oftop){
            
            jQuery("#main-content").addClass("sticky");
            if(jQuery('.mob_menu').hasClass("active")){
                jQuery("#main-content").addClass("right");
            }else{
                jQuery("#main-content").removeClass("right");
            }
            
        }
        else
        {
         jQuery("#main-content").removeClass("sticky");   
        }
    });
        
})

jQuery(window).load(function($){
     $container = jQuery('.masonary').isotope({
  itemSelector: '.g_box',
  percentPosition: true,
  masonry: {
    columnWidth: '.g_box'
  },
  layoutMode: 'fitRows',
})
//setminHeight(".masonary .g_box");

jQuery('.filter_nav').on('click','a',function(){
  var filterValue = jQuery(this).attr('data-filter');
  $container.isotope({ filter: filterValue  });
  jQuery('.filter_nav a').removeClass('selected');
  jQuery(this).addClass('selected');
  var cs = jQuery(this).text();  
  jQuery(".sel_character").text(cs);
  jQuery('.current_filter').text(cs)
  footer_push();
  
  if (!$container.data('isotope').filteredItems.length ){
    var $csval= filterValue.replace(".", "")
    var $newItems = jQuery('<div class="g_box '+ $csval +' no_data" >No items for the letter '+cs+'.</div>');
    $container.append( $newItems ).isotope( 'addItems', $newItems );
   
    }
     if(filterValue == "*"){
        var $firstTwoElems = jQuery(".masonary .no_data");
        $container.isotope( 'remove', $firstTwoElems, function() {});
    }
     
});


jQuery('.mobile_fill').on('click','a',function(){
    
    jQuery(".current_filter").removeClass("active");
    jQuery(".mobile_fill").slideUp();
  var filterValue = jQuery(this).attr('data-filter');
  $container.isotope({ filter: filterValue  });
  jQuery('.mobile_fill a').removeClass('selected');
  jQuery(this).addClass('selected');
  var cs = jQuery(this).text();  
  jQuery(".sel_character").text(cs);
  jQuery('.current_filter').text(cs)
  footer_push();
  
  
  if (!$container.data('isotope').filteredItems.length ){
    var $csval= filterValue.replace(".", "")
    var $newItems = jQuery('<div class="g_box '+ $csval +' no_data" >No items for the letter '+cs+'.</div>');
    $container.append( $newItems ).isotope( 'addItems', $newItems );
   
    }
     if(filterValue == "*"){
        var $firstTwoElems = jQuery(".masonary .no_data");
        $container.isotope( 'remove', $firstTwoElems, function() {});
    }
     
});

 

jQuery('.mob_maz').change( function() {
  var filterValue = jQuery(this).val();
  $container.isotope({ filter: filterValue });
  footer_push();
 
 
    });    
    
    jQuery(".current_filter").click(function(){
        
        
         if(jQuery(this).hasClass("active")){
        			jQuery(this).removeClass("active");
        		 jQuery(".mobile_fill").slideUp();
        		  }else{
        			jQuery(this).addClass("active");	
        			 jQuery(".mobile_fill").slideDown();
        		  }
                  
       
    })
})
</script>


<div id="main-content" class="main-content">
<div class="cf top_app">
<div class="wrapper cf">
<h1 class="page_title"><?php  if($page_title){ echo $page_title; }else{ the_title(); }?></h1>

<div class="filter_nav character_filter cf">
    <a data-filter="*" href="javascript:;" class="all selected">All</a>
    <a data-filter=".a" href="javascript:;">A</a>
    <a data-filter=".b" href="javascript:;">B</a>
    <a data-filter=".c" href="javascript:;">C</a>
    <a data-filter=".d" href="javascript:;">D</a>
    <a data-filter=".e" href="javascript:;">E</a>
    <a data-filter=".f" href="javascript:;">F</a>
    <a data-filter=".g" href="javascript:;">G</a>
    <a data-filter=".h" href="javascript:;">H</a>
    <a data-filter=".i" href="javascript:;">I</a>
    <a data-filter=".j" href="javascript:;">J</a>
    <a data-filter=".k" href="javascript:;">K</a>
    <a data-filter=".l" href="javascript:;">L</a>
    <a data-filter=".m" href="javascript:;">M</a>
    <a data-filter=".n" href="javascript:;">N</a>
    <a data-filter=".o" href="javascript:;">O</a>
    <a data-filter=".p" href="javascript:;">P</a>
    <a data-filter=".q" href="javascript:;">Q</a>
    <a data-filter=".r" href="javascript:;">R</a>
    <a data-filter=".s" href="javascript:;">S</a>
    <a data-filter=".t" href="javascript:;">T</a>
    <a data-filter=".y" href="javascript:;">U</a>
    <a data-filter=".v" href="javascript:;">V</a>
    <a data-filter=".w" href="javascript:;">W</a>
    <a data-filter=".x" href="javascript:;">X</a>
    <a data-filter=".y" href="javascript:;">Y</a>
    <a data-filter=".z" href="javascript:;">Z</a>
    
</div>

        <div class="mobile_filter">
            <a href="javascript:;" class="current_filter">All</a>
            
            <div class="mobile_fill cf">
                <a data-filter="*" href="javascript:;" class="all selected">All</a>
                <a data-filter=".a" href="javascript:;" class="brown">A</a>
                <a data-filter=".b" href="javascript:;">B</a>
                <a data-filter=".c" href="javascript:;" class="brown">C</a>
                <a data-filter=".d" href="javascript:;">D</a>
                <a data-filter=".e" href="javascript:;" class="brown">E</a>
                <a data-filter=".f" href="javascript:;" class="brown">F</a>
                <a data-filter=".g" href="javascript:;">G</a>
                <a data-filter=".h" href="javascript:;" class="brown">H</a>
                <a data-filter=".i" href="javascript:;">I</a>
                <a data-filter=".j" href="javascript:;" class="brown">J</a>
                <a data-filter=".k" href="javascript:;">K</a>
                <a data-filter=".l" href="javascript:;">L</a>
                <a data-filter=".m" href="javascript:;" class="brown">M</a>
                <a data-filter=".n" href="javascript:;">N</a>
                <a data-filter=".o" href="javascript:;" class="brown">O</a>
                <a data-filter=".p" href="javascript:;">P</a>
                <a data-filter=".q" href="javascript:;" class="brown">Q</a>
                <a data-filter=".r" href="javascript:;" class="brown">R</a>
                <a data-filter=".s" href="javascript:;">S</a>
                <a data-filter=".t" href="javascript:;" class="brown">T</a>
                <a data-filter=".y" href="javascript:;">U</a>
                <a data-filter=".v" href="javascript:;" class="brown">V</a>
                <a data-filter=".w" href="javascript:;">W</a>
                <a data-filter=".x" href="javascript:;">X</a>
                <a data-filter=".y" href="javascript:;" class="brown">Y</a>
                <a data-filter=".z" href="javascript:;">Z</a>
                
            </div>
        </div>
</div>
    
    


</div>
	<div id="primary" class="content-area">
		<div id="content" class="site-content application_wrapper" role="main">
        
            <div class="wrapper cf ">
                <div class="left_glossy">
                    <div class="sel_character">All</div>
                </div>
                <div class="right_glossy">
                    <div class="masonary cf">
                	<?php   $args = array('post_type'=> array( 'glossaries'),'posts_per_page'=>-1,'orderby'=> 'title','order'=>'ASC');
                            query_posts( array_merge($args,$custom_privacy) );
                            //query_posts( $args );
        				    while ( have_posts() ) : the_post();
                            $app_gl_desctiption = get_post_meta(get_the_ID(), 'app_gl_desctiption', true);
                             ?>
                            <div class="g_box <?php $string = substr(get_the_title(),0,1); echo strtolower($string); ?>" >
                                
                                <div class="cont_box ">
                                    <h3 class="box_title"><?php the_title();?></h3> 
                                    <p class="box_desc"><?php echo $app_gl_desctiption; ?></p>
                                </div>
                               
                             </div>
                      <?php endwhile; ?>
                      </div>
                  </div>
              </div>
              
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
				//	get_template_part( 'content', 'page' );

				endwhile;
			?>
		</div><!-- #content -->
         <div class="push"></div>
	</div><!-- #primary -->
    
</div><!-- #main-content -->

<?php

get_footer();
