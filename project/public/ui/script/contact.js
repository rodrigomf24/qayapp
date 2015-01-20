var old_input_focused = null;

$(document).ready(function(){
    $('input').focus(function(){
        var input_name = $(this).attr('name');
        if (old_input_focused != null) {
            $('label[for="'+old_input_focused+'"]').css({
                color:  '#333333'  
            });  
        }
        old_input_focused = input_name;
        $('label[for="'+input_name+'"]').css({
            color:  '#46b98a'  
        });
    });
    
    $('textarea').focus(function(){
        var input_name = $(this).attr('name');
        if (old_input_focused != null) {
            $('label[for="'+old_input_focused+'"]').css({
                color:  '#333333'  
            });  
        }
        old_input_focused = input_name;
        $('label[for="'+input_name+'"]').css({
            color:  '#46b98a'  
        }); 
    });
    
});