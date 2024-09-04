<div class="banner_section slide_medium shop_banner_slider staggered-animation-wrap">
    <div class="carousel slide carousel-fade light_arrow" id="carouselExampleControls" data-bs-ride="carousel">
        <div class="carousel-inner" id="carouselSection">

        </div>
        <a class="carousel-control-prev" data-bs-slide="prev" href="#carouselExampleControls" role="button"><i class="ion-chevron-left"></i></a>
        <a class="carousel-control-next" data-bs-slide="next" href="#carouselExampleControls" role="button"><i class="ion-chevron-right"></i></a>
    </div>
</div>
<script>
    async function Hero() {
        let res = await axios.get('/api/product-sliders');
        res = res.data[0];

        $("#carouselSection").empty();

        res.forEach((item, i) => {
            let activeClass = ''
            if (i === 0) {
                activeClass = ' active '
            }
            let SliderItem = `<div class="carousel-item  background_bg ${activeClass}" style="background-image: url('${item['image']}')">
                <div class="banner_slide_content">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-7 col-9">
                                <div class="banner_content overflow-hidden">
                                    <h5 class="mb-3 staggered-animation font-weight-light" data-animation="slideInLeft" data-animation-delay="0.5s">${item['price']}</h5>
                                    <h2 class="staggered-animation" data-animation="slideInLeft" data-animation-delay="1s">${item['title']}</h2>
                                    <a class="btn btn-fill-out rounded-0 staggered-animation text-uppercase" href="/product-details?id=${item['product_id']}" data-animation="slideInLeft" data-animation-delay="1.5s">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`
            $("#carouselSection").append(SliderItem)
        })
    }
</script>
