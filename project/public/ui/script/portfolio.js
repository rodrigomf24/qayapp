function flip_the_content() {
    var name;
    $('.front-image').hover(function(){
        name = $(this).attr('name');
        $('.front-image[name="'+name+'"]').hide();
        //$('.back-content[name="'+name+'"]').fadeIn();
    }, function(){
        $('.front-image[name="'+name+'"]').show();
        //$('.back-content[name="'+name+'"]').fadeOut();    
    });
}

$(document).ready(function(){
    
});

$(window).load(function(){
    $('.portfolio-gallery iframe').css({    
        width : $('.portfolio-gallery div.span3').width(),
        height : $('.portfolio-gallery div.span3').height()
    }); 
});

$(window).resize(function(){
    $('.portfolio-gallery iframe').css({    
        width : $('.portfolio-gallery div.span3').width(),
        height : $('.portfolio-gallery div.span3').height()
    });
});