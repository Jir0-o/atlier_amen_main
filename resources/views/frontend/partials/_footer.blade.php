<footer>
    <div class="dark p-4 p-lg-5 mt-5">
        <h1 class="playfair mb-4 mb-lg-5 text-center">{{$footer->footer_text}}</h1>
        <div class="d-flex justify-content-between align-items-center gap-4 flex-wrap">
            <div class="social-link d-flex gap-2 cormorant">
                <i class="ri-facebook-line"></i>
                <a href="#">{{$footer->facebook_url}}</a>
            </div>
            <div class="social-link d-flex gap-2 cormorant">
                <i class="ri-instagram-line"></i>
                <a href="#">{{$footer->instagram_url}}</a>
            </div>
            <div class="social-link d-flex gap-2 cormorant">
                <i class="ri-dribbble-line"></i>
                <a href="#">{{$footer->website_url}}</a>
            </div>
        </div>
        <hr class="my-4 my-lg-5">
        <div class="d-flex justify-content-between">
            <div class="social-link d-flex gap-2 cormorant">
                <i class="ri-map-2-line"></i>
                <a href="#">{{$footer->address}}</a>
            </div>
            <div class="social-link d-flex gap-2 cormorant">
                <i class="ri-mail-line"></i>
                <a href="#">{{$footer->email}}</a>
            </div>
        </div>
        <center class="d-flex gap-2 justify-content-center cormorant pt-4">
            <i class="ri-copyright-line"></i> 
            <span>All right reserve to <a href="#">{{$footer->footer_text}}</a> & <a href="https://www.ussbd.com/" target="_blank">Unicorn software and solutions limited</a></span>
        </center>
    </div>
</footer>