/*imgLiquid*/
$(".imgLiquidFill").imgLiquid();

/*tab accordion*/
$(".tab_content").hide();
$(".tab_content:first").show();

$("ul.page_tabs li").click(function() {

    $(".tab_content").hide();
    var activeTab = $(this).attr("rel");
    $("#" + activeTab).fadeIn();

    $("ul.page_tabs li").removeClass("active");
    $(this).addClass("active");
});
$('ul.page_tabs li').last().addClass("tab_last");

/*qa*/
$(".qa_box > a").on("click", function() {
    if ($(this).hasClass('active')) {
        $(this).removeClass("active");
        $(this).siblings('.qa_content').slideUp(200);
    } else {
        $(".qa_box > a").removeClass("active");
        $(this).addClass("active");
        $('.qa_content').slideUp(200);
        $(this).siblings('.qa_content').slideDown(200);
    }
});
/*login dialog*/
$(".login").fancybox({
    wrapCSS: 'fancybox-login',
    padding: 40,
    width: 490,
    maxWidth: '100%',
    helpers: {
        overlay : {
            css : {
                'background' : 'rgba(0,0,0,.8)'
            }
        }
    },
});

$(function(){
    $('.selectpicker').selectpicker();
});