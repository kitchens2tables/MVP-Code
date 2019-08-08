jQuery(document).ready(function(){
    jQuery(".pum-content.popmake-content p:empty").remove();


jQuery('a.accordion-toggle').click(function(e){

    e.preventDefault();

    var $div = jQuery(this).parents().next('.collapse');
    jQuery(".collapse").not($div).stop(true, true).slideUp(); 
    if ($div.is(":visible")) {
        $div.stop(true, true).slideUp(200);
    }  else {
       $div.stop(true, true).delay(50).slideDown(100);  
    }

});  
});




jQuery( window ).load(function() {
 jQuery(".page-loader-css").hide();
});

jQuery('.um-notice').fadeIn().delay(3000).fadeOut();
jQuery('.alert-dismissible').fadeIn().delay(3000).fadeOut();



