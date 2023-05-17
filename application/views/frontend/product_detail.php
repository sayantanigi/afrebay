<?php
if(!empty($get_banner->image) && file_exists('uploads/banner/'.$get_banner->image)){
    $banner_img=base_url("uploads/banner/".$get_banner->image);
} else{
    $banner_img=base_url("assets/images/resource/mslider1.jpg");
} ?>
<section class="overlape">
    <div class="block no-padding">
        <div data-velocity="-.1" style="background: url('<?= $banner_img ?>') repeat scroll 50% 422.28px transparent;" class="parallax scrolly-invisible no-parallax"></div>
        <!-- PARALLAX BACKGROUND IMAGE -->
        <div class="container fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner-header">
                        <h3>Product Details</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container Product-Details-Page">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 column">
                <div class="row Product-Block">
                    <div class="col-lg-4 col-md-12 col-sm-12 column Product-Img">
                        <div class="Product-Img-Container">
                            <div class="imgSlides">
                                <img src="https://cdn.shopify.com/s/files/1/0070/7032/files/trending-products_c8d0d15c-9afc-47e3-9ba2-f7bad0505b9b.png?format=jpg&quality=90&v=1614559651" style="width:100%">
                            </div>
                            <div class="imgSlides">
                                <img src="https://static.doofinder.com/main-files/uploads/2018/01/Top6Sales.png" style="width:100%">
                            </div>
                            <div class="imgSlides">
                                <img src="https://queue-it.com/media/ppcp1twv/product-drop.jpg" style="width:100%">
                            </div>
                            <div class="imgSlides">
                                <img src="https://cdn.shopify.com/s/files/1/0070/7032/files/trending-products_c8d0d15c-9afc-47e3-9ba2-f7bad0505b9b.png?format=jpg&quality=90&v=1614559651" style="width:100%">
                            </div>
                            <div class="imgSlides">
                                <img src="https://static.doofinder.com/main-files/uploads/2018/01/Top6Sales.png" style="width:100%">
                            </div>
                            <div class="imgSlides">
                                <img src="https://queue-it.com/media/ppcp1twv/product-drop.jpg" style="width:100%">
                            </div>
                            <a class="prev" onclick="plusSlides(-1)">❮</a>
                            <a class="next" onclick="plusSlides(1)">❯</a>
                            <div class="row Slider-All-Img">
                                <div class="column">
                                    <img class="demo cursor" src="https://cdn.shopify.com/s/files/1/0070/7032/files/trending-products_c8d0d15c-9afc-47e3-9ba2-f7bad0505b9b.png?format=jpg&quality=90&v=1614559651" style="width:100%" onclick="currentSlide(1)" alt="The Woods">
                                </div>
                                <div class="column">
                                    <img class="demo cursor" src="https://static.doofinder.com/main-files/uploads/2018/01/Top6Sales.png" style="width:100%" onclick="currentSlide(2)" alt="Cinque Terre">
                                </div>
                                <div class="column">
                                    <img class="demo cursor" src="https://queue-it.com/media/ppcp1twv/product-drop.jpg" style="width:100%" onclick="currentSlide(3)" alt="Mountains and fjords">
                                </div>
                                <div class="column">
                                    <img class="demo cursor" src="https://cdn.shopify.com/s/files/1/0070/7032/files/trending-products_c8d0d15c-9afc-47e3-9ba2-f7bad0505b9b.png?format=jpg&quality=90&v=1614559651" style="width:100%" onclick="currentSlide(4)" alt="The Woods">
                                </div>
                                <div class="column">
                                    <img class="demo cursor" src="https://static.doofinder.com/main-files/uploads/2018/01/Top6Sales.png" style="width:100%"
                                        onclick="currentSlide(5)" alt="Cinque Terre">
                                </div>
                                <div class="column">
                                    <img class="demo cursor" src="https://queue-it.com/media/ppcp1twv/product-drop.jpg" style="width:100%" onclick="currentSlide(6)" alt="Mountains and fjords">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12 column Product-Data">
                        <p><span>Test Product</span></p>
                        <p><span>Vendor:</span><span>Jeff's test vendor</span></p>
                        <p><span>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate.</span></p>
                    </div>
                    <div class="col-lg-4 column Product-Contact">
                        <form>
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="" class="form-label">Name</label>
                                    <input type="text" class="form-control" placeholder="Type your name ...">
                                </div>
                                <div class="col-lg-12">
                                    <label for="" class="form-label">Email</label>
                                    <input type="text" class="form-control" placeholder="Type your email ...">
                                </div>
                                <div class="col-lg-12">
                                    <label for="" class="form-label">Details</label>
                                    <textarea placeholder="Type comments ..." rows="4" cols="50"></textarea>
                                </div>
                                <div class="col-lg-12 text-center ContactBtn">
                                    <a type="button" class="btn btn-info">Contact</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>
    let slideIndex = 1;
    showSlides(slideIndex);
    function plusSlides(n) {
        showSlides(slideIndex += n);
    }

    function currentSlide(n) {
        showSlides(slideIndex = n);
    }

    function showSlides(n) {
        let i;
        let slides = document.getElementsByClassName("imgSlides");
        let dots = document.getElementsByClassName("demo");
        let captionText = document.getElementById("caption");
        if (n > slides.length) {
            slideIndex = 1
        }
        if (n < 1) {
            slideIndex = slides.length
        }
        for (i = 0; i < slides.length; i++) {
            slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
            dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
        captionText.innerHTML = dots[slideIndex - 1].alt;
    }
</script>
