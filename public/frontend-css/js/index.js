$("#billing_address").hide();

$(document).ready(function () {
    // Trigger the aos animation
    AOS.init();

    // title view animation
    $(".page-title").removeClass("onload");

    // get billing address form
    $("#billing_form").on("click", function (e) {
        let checkbox = $("#billing_form")[0];

        if (checkbox.checked) {
            $("#billing_address").hide('slow');
        } else {
            $("#billing_address").show('slow');

        }
    })

    $("scroll-up-anim").on("click", function () {
        let animate = $("animate-to-scroll")

        animate.removeClass("scroll-up-anim");
        void animate[0].offsetWidth;
        animate.addClass("scroll-up-anim");
    })
    
    $('#img_previewer').hide();
});


// set preview image with scroll-up animation
function setPreviewImg(get, type) {
    let preview = $(".indi-img-preview");
    let src = $(get).attr("src");

    switch (type) {
        case 'img':
            $('#video_previewer').hide();
            $('#img_previewer').show();
            break;

        case 'video':
            $('#img_previewer').hide();
            $('#video_previewer').show();
            break;

        default:
            $('#video_previewer').hide();
            $('#img_previewer').show();
            break;
    }

    $(".indi-img-gallery div div div").removeClass("active");
    $(get).parent().addClass("active");

    preview.attr("src", src);
    preview.removeClass("scroll-up-anim");
    void preview[0].offsetWidth;
    preview.addClass("scroll-up-anim");
}
