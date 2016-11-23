var $j = jQuery.noConflict();

// Simple hide no animation
function jhide(id){  if (document.getElementById){  obj = document.getElementById(id);  obj.style.display = "none";  } }
// Simple show no animation
function jshow(id){  if (document.getElementById){  obj = document.getElementById(id);  obj.style.display = "inline-block"; } }

// Jquery hide, show and toggle
function ajaxshow(id){	$j(id).fadeIn("fast");	}
function cartshow(id){	$j(id).fadeIn("fast");	}
function ajaxhide(id){	$j(id).fadeOut("fast");	}
function toggle(id)  {	$j(id).slideToggle("fast");  }

// Jquery  Scripts
(function($) {

    $(document).ready(function(){

   	      RESPONSIVEUI.responsiveTabs();

          // External links open in new windows
          $("a[rel='external']").bind("click.external", function(){  window.open(this.href);  return false;  });

		  // Addon Checkbox active state
		  $('.add-on :checkbox').click(function() {  if ($(this).attr('checked')) {  $(this).parents('.add-on').addClass('active'); } else {  $(this).parents('.add-on').removeClass('active');	}  });

        	$('.accordionButton').click(function() {
        		$('.accordionButton').removeClass('on');
        	 	$('.accordionContent').slideUp('fast');

        		if($(this).next().is(':hidden') == true) {
        			$(this).addClass('on');
        			$(this).next().slideDown('fasts');
        		 }
        	 });

        	$('.accordionButton').mouseover(function() {
        		$(this).addClass('over');
           	}).mouseout(function() {
        		$(this).removeClass('over');
        	});
          	$('.accordionContent').hide();

          
    });

$(document).ready(function() {
//On Hover Over
function megaHoverOver(){
   $(this).find(".sub-menu").stop().fadeTo('fast', 1).show(); //Find sub and fade it in
   (function($) {
       //Function to calculate total width of all ul's
       jQuery.fn.calcSubWidth = function() {
           rowWidth = 0;
           //Calculate row
           $(this).find("ul").each(function() { //for each ul...
               rowWidth += $(this).width(); //Add each ul's width together
           });
       };
   })(jQuery);

   if ( $(this).find(".row").length > 0 ) { //If row exists...

       var biggestRow = 0;

       $(this).find(".row").each(function() {	//for each row...
           $(this).calcSubWidth(); //Call function to calculate width of all ul's
           //Find biggest row
           if(rowWidth > biggestRow) {
               biggestRow = rowWidth;
           }
       });

       $(this).find(".sub-menu").css({'width' :biggestRow}); //Set width
       $(this).find(".row:last").css({'margin':'0'});  //Kill last row's margin

   } else { //If row does not exist...

       $(this).calcSubWidth();  //Call function to calculate width of all ul's
       $(this).find(".sub-menu").css({'width' : rowWidth}); //Set Width

   }
}
//On Hover Out
function megaHoverOut(){
 $(this).find(".sub-menu").stop().fadeTo('fast', 0, function() { //Fade to 0 opactiy
     $(this).hide();  //after fading, hide it
 });
}
//Set custom configurations
var config = {
    sensitivity: 2, // number = sensitivity threshold (must be 1 or higher)
    interval: 10, // number = milliseconds for onMouseOver polling interval
    over: megaHoverOver, // function = onMouseOver callback (REQUIRED)
    timeout: 150, // number = milliseconds delay before onMouseOut
    out: megaHoverOut // function = onMouseOut callback (REQUIRED)
};
$("ul#main-menu li .sub-menu").css({'opacity':'0'}); //Fade sub nav to 0 opacity on default
$("ul#main-menu li").hoverIntent(config); //Trigger Hover intent with custom configurations
$("ul#main-menu-second li .sub-menu").css({'opacity':'0'}); //Fade sub nav to 0 opacity on default
$("ul#main-menu-second li").hoverIntent(config); //Trigger Hover intent with custom configurations
});

})(jQuery);











