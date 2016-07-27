
    
function selectPolicy(val) {
  window.location = val;
}

    function footer_push(){
        jQuery(".push").height(0);
        var wh = jQuery(window).height();
        var headerh = jQuery("#masthead").outerHeight(true)
        var dh = jQuery("body").outerHeight(true);
        var fh = jQuery("#colophon").outerHeight();
        
       if(dh<=wh){
        jQuery(".push").height(wh-dh);
       }else{        
        jQuery(".push").height(0);
       }
        var hedaerheight = jQuery("#masthead").outerHeight();
        jQuery("#main").css("padding-top",hedaerheight);
    }
    jQuery(document).ready(function($){
        footer_push();
        jQuery( document ).on( 'click', '.login', function() {
            jQuery('.login_form').slideToggle();
            jQuery('.login').toggleClass("open");
        })
        
        jQuery( document ).on( 'click', '.logout_link', function() {
            jQuery(this).next().slideToggle();
            jQuery('.user_link').toggleClass("open_drop");
        })
        
        jQuery(".mob_menu").click(function(){
            
             if(jQuery(this).hasClass("active")){
        			jQuery(this).removeClass("active");
        			jQuery("#page").animate({"right":"0"},500);
        		  }else{
        			jQuery(this).addClass("active");	
        			jQuery("#page").animate({"right":"230px"},500);
        		  }
        })
        jQuery(".mob_close").click(function(){
             if(jQuery(".mob_menu").hasClass("active")){
        			jQuery(".mob_menu").removeClass("active");
        			jQuery("#page").animate({"right":"0"},500);
       		  }
        })
    jQuery(document).scroll(function(e) {
        var mheight = jQuery(".mob_wrap").outerHeight();
        if(jQuery(this).scrollTop() > mheight) {
              if(jQuery(".mob_menu").hasClass("active")){
            jQuery(".mob_menu").removeClass("active");
            jQuery("#page").animate({"right":"0"},500);
            }
        } 
        
        
  });
  

   

  

$(".primary_nav .nav-menu li.menu-item-has-children" ).prepend( "<span class='p_arrow'><i class='fa fa-angle-down'></i></span>" );
$(".primary_nav .nav-menu li.menu-item-has-children ul.sub-menu li.menu-item-has-children span" ).addClass('sub_arrow');
$(".primary_nav .nav-menu li ul.sub-menu li.menu-item-has-children span" ).removeClass('p_arrow');



$('.primary_nav .nav-menu span.p_arrow').click(function (e){
if($(this).hasClass('active')==true){
    $(this).next().next().slideUp(300);
    $(this).parent('li').removeClass('changebg');
    $(this).removeClass("active");
    }
    else{   
        $('.primary_nav .nav-menu li.menu-item-has-children').find('ul.sub-menu').slideUp(300);
        $('.primary_nav .nav-menu li').removeClass('changebg');
        $('.primary_nav .nav-menu li.menu-item-has-children span').removeClass("active");

        $(this).next().next().slideDown(300);
        $(this).parent('li').addClass('changebg');
        $(this).addClass("active");
    }
    return false;
});

$('.primary_nav .nav-menu span.sub_arrow').click(function (e) { 
    $(this).next().next().slideToggle(300);
    $(this).parent('li').toggleClass('changebg');
    $(this).toggleClass('active');
    return false;
});

        
    })
    
    jQuery(window).load(function(){
        footer_push();
    })
    jQuery(window).resize(function(){
        footer_push();
    })
 
            jQuery(document).ready(function($){
                
                jQuery(".mob_au_height > li").each(function(){
                    if(jQuery(this).hasClass("widget_subpages_current_page")){
                            jQuery(this).children(".mob_click_slide").trigger("click");
                    }
                    
                })
                jQuery(".mob_au_height > li.widget_subpages_current_page .mon_sub_open > li").each(function(){
                    if(jQuery(this).hasClass("widget_subpages_current_page")){
                            jQuery(this).children(".mob_down_slide").trigger("click");
                    }
                    
                })
                
                jQuery(".main_policies > ul > li > a.click_slide").click(function() {
                	$(".main_policies").animate({"left":"-100%"}, 120);
                    jQuery(this).next(".slide_policies").slideDown(120).height();
                    var current = jQuery(this);
                    var top_minus= jQuery(this).offset().top - $('.au_height').offset().top + 35;
                    jQuery(this).next(".slide_policies").css('top',-top_minus);
                });
                
                 jQuery(".back_policies").click(function() {
                	$(".main_policies").animate({"left":"0%"}, 120);
                    jQuery(".slide_policies").slideUp(120);
                    $('.au_height').removeClass("slide");
                });
               
                
                $('.down_slide').click(function(){
                    if(jQuery(this).hasClass("active")){
                        jQuery(this).removeClass("active");
                        $(".toggle_policies").slideUp(300);
                         
                    }else{
                        $('.down_slide').removeClass("active");
                        $(".toggle_policies").slideUp(300);
                        jQuery(this).addClass("active");
                        $(this).next(".toggle_policies").slideDown(300);
                       }
                })
                
                
                /** mobile **/
                
                 
                jQuery(".mob_main_policies > ul > li > a.mob_click_slide").click(function() {
                	$(".mob_main_policies").animate({"left":"-100%"}, 100);
                    jQuery(this).next(".mob_slide_policies").slideDown(100).height();
                    jQuery(this).parent().addClass("show");
                    jQuery(".mob_main_policies").addClass("slides")
                    var top_minus= jQuery(this).offset().top - $('.mob_au_height').offset().top + 35;
                    jQuery(this).next(".mob_slide_policies").css({'top':-top_minus});
                    
                });
                
                 jQuery(".mob_back_policies").click(function() {
                	$(".mob_main_policies").animate({"left":"0%"}, 100);
                    jQuery(".mob_slide_policies").slideUp(100);
                    $('.mob_au_height').removeClass("slide");
                     jQuery(".mob_au_height > li").removeClass("show");
                    jQuery(".mob_main_policies").removeClass("slides")
                });
               
                
                
                $('.mob_down_slide').click(function(){
                    if(jQuery(this).hasClass("active")){
                        jQuery(this).removeClass("active");
                        $(".mob_toggle_policies").slideUp(500);
                         
                    }else{
                        $('.mob_down_slide').removeClass("active");
                        $(".mob_toggle_policies").slideUp(500);
                        jQuery(this).addClass("active");
                        $(this).next(".mob_toggle_policies").slideDown(500);
                       }
                })
                
                 
                
                /** mobile **/
                
                jQuery(".mobile_search_policy").click(function(){
                     if(jQuery(this).hasClass("active")){
                        jQuery(this).removeClass("active");
                       jQuery(this).next().slideUp();
                         
                    }else{
                        jQuery(this).addClass("active");
                        jQuery(this).next().slideDown();
                   
                        jQuery(".mobile_menu_policy").removeClass("active");
                       jQuery(".mobile_menu_policy").next().slideUp();
                         
                                       }
                    
                    
                   
                })
                
                 jQuery(".mobile_menu_policy").click(function(){
                     if(jQuery(this).hasClass("active")){
                        jQuery(this).removeClass("active");
                       jQuery(this).next().slideUp();
                         
                    }else{
                        jQuery(this).addClass("active");
                        jQuery(this).next().slideDown();
                       
                        jQuery(".mobile_search_policy").removeClass("active");
                       jQuery(".mobile_search_policy").next().slideUp();
                         
                   
                    }
                    
                   
                })
                
                jQuery(".au_height > li").each(function(){
                    if(jQuery(this).hasClass("widget_subpages_current_page")){
                            jQuery(this).children(".click_slide").trigger("click");
                    }
                    
                })
                jQuery(".au_height > li.widget_subpages_current_page .sub_open > li").each(function(){
                    if(jQuery(this).hasClass("widget_subpages_current_page")){
                            jQuery(this).children(".down_slide").trigger("click");
                    }
                    
                })
                
                
                
                
            })
    