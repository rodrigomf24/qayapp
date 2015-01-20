


$(document).ready(function(){
    
    $('#menu_small').hide();
    
    if ($(window).width() < 632) {
        $('#menu').hide();
        $('#menu_small').show();
    }else if($(window).width() > 632){
        $('#menu').show();
        $('#menu_small').hide();
    }
    
    $(window).resize(function(){
        if ($(window).width() < 632) {
            $('#menu').hide();
            $('#menu_small').show();
        }else if($(window).width() > 632){
            $('#menu').show();
            $('#menu_small').hide();
        }   
    });
    
    $(window).scroll(function(){
        if($(window).scrollTop() > 213){
            $('#menu_small').attr('class', 'fixed_small_menu');
        }else{
             $('#menu_small').attr('class', '');
        }
    });
    
    $('#show_menu_list').click(function(){
        if ($('#menu_small').css('overflow') == 'hidden') {
            $('#menu_small').css({
                overflow:'visible'    
            });    
        }else{
            $('#menu_small').css({
                overflow:'hidden'    
            });    
        }
    });
    
    
});