$("#billing_address").hide();

$(document).ready(function () {
    // Trigger the aos animation
    AOS.init();

    // title view animation
    $(".page-title").removeClass("onload");

    // get billing address form
    $("#billing_form").on("click", function(e) {
        let checkbox = $("#billing_form")[0];

        if (checkbox.checked) {
            $("#billing_address").hide('slow');
        } else {
            $("#billing_address").show('slow');
            
        }
    })
});


// set preview image with scroll-up animation
function setPreviewImg(get) {
    let preview = $("#indi-img-preview");
    let src = $(get).attr("src");

    preview.attr("src", src);
    preview.removeClass("scroll-up-anim");
    void preview[0].offsetWidth;
    preview.addClass("scroll-up-anim");
}
