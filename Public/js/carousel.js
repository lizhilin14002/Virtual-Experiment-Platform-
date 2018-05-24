$(function(){
    var cus_timer= setInterval(autoplay,20);
    var leftnow = parseFloat($(".carousel-wrap ul").css("left"));
    var limleft = parseFloat($('.carousel-wrap>ul>li').css('margin-left'));
    // var leftnow = 0;
    var size = $(".carousel-wrap>ul").children().length;
    var step = parseFloat($(".carousel-wrap>ul>li").width()+limleft);
    var leftul = size*step; 

    for(var i=0;i<6;i++){
        $(".carousel-wrap>ul").append($(".carousel-wrap>ul>li").eq(i).clone());
    }
    function autoplay(){
        var leftnow = parseFloat($(".carousel-wrap ul").css("left"));
        leftnow--;
        $(".carousel-wrap ul").css({"left":leftnow+"px"});
        if(leftnow < -leftul){
            $(".carousel-wrap ul").css({"left":"0px"});
        };
    }
     $(".carousel-content").mouseenter(function(){
        clearInterval(cus_timer);
    });
     $(".carousel-content").mouseleave(function(){
        cus_timer=setInterval(autoplay,20);
    });
});