$().ready(function(){
    $(".near").click(function(){
        var num = $(this).attr('data-position');
        var input = $("<input>");
        input.attr({'type': 'hidden', 'name': 'selected', 'value': num});
        $("form").append(input);
        
        var index_selected = $(this).index();
        var index_void = $(".void").index();
        var time = 150;
        switch (index_void){
            case (index_selected+1):
                $(this).animate({left: $(this).css("width")}, time);
                break;
            case (index_selected-1):
                $(this).animate({right: $(this).css("width")}, time);
                break;
            case (index_selected+4):
                $(this).animate({top: $(this).css("width")}, time);
                break;
            case (index_selected-4):
                $(this).animate({bottom: $(this).css("width")}, time);
                break;
        }
        setTimeout(function(){
            $("form").submit();
        }, time);
    });
});