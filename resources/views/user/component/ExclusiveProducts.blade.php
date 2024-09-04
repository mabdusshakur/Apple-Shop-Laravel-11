<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="heading_s1 text-center">
                <h2>Exclusive Products</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="tab-style1">
                <ul class="nav nav-tabs justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="arrival-tab" data-bs-toggle="tab" href="#Popular" role="tab" aria-controls="arrival" aria-selected="true">Popular</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="sellers-tab" data-bs-toggle="tab" href="#New" role="tab" aria-controls="sellers" aria-selected="false">New</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="featured-tab" data-bs-toggle="tab" href="#Top" role="tab" aria-controls="featured" aria-selected="false">Top</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="special-tab" data-bs-toggle="tab" href="#Special" role="tab" aria-controls="special" aria-selected="false">Special</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="special-tab" data-bs-toggle="tab" href="#Trending" role="tab" aria-controls="special" aria-selected="false">Trending</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="Popular" role="tabpanel" aria-labelledby="arrival-tab">
                    <div class="row shop_container" id="PopularItem">

                    </div>
                </div>
                <div class="tab-pane fade" id="New" role="tabpanel" aria-labelledby="sellers-tab">
                    <div class="row shop_container" id="NewItem">

                    </div>
                </div>
                <div class="tab-pane fade" id="Top" role="tabpanel" aria-labelledby="featured-tab">
                    <div class="row shop_container" id="TopItem">

                    </div>
                </div>
                <div class="tab-pane fade" id="Special" role="tabpanel" aria-labelledby="special-tab">
                    <div class="row shop_container" id="SpecialItem">

                    </div>
                </div>
                <div class="tab-pane fade" id="Trending" role="tabpanel" aria-labelledby="special-tab">
                    <div class="row shop_container" id="TrendingItem">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function Popular() {
        let res = await axios.get('/api/products/?remark=popular');
        res = res.data[0];

        $("#PopularItem").empty();

        res.forEach((item, i) => {
            let EachItem = `<div class="col-lg-3 col-md-4 col-6">
                                <div class="product">
                                    <div class="product_img">
                                        <a href="#">
                                            <img src="${item['image']}" alt="product_img9">
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                <li><a href="/details?id=${item['id']}" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a  href="/details?id=${item['id']}">${item['title']}</a></h6>
                                        <div class="product_price">
                                            <span class="price">$ ${item['price']}</span>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:${item['star']}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`
            $("#PopularItem").append(EachItem);
        })

    }


    async function New() {
        let res = await axios.get('/api/products/?remark=new');
        res = res.data[0];

        $("#NewItem").empty();

        res.forEach((item, i) => {
            let EachItem = `<div class="col-lg-3 col-md-4 col-6">
                                <div class="product">
                                    <div class="product_img">
                                        <a href="#">
                                            <img src="${item['image']}" alt="product_img9">
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">

                                                <li><a href="/details?id=${item['id']}" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>

                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="/details?id=${item['id']}">${item['title']}</a></h6>
                                        <div class="product_price">
                                            <span class="price">$ ${item['price']}</span>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:${item['star']}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`
            $("#NewItem").append(EachItem);
        })
    }


    async function Top() {
        let res = await axios.get('/api/products/?remark=top');
        res = res.data[0];

        $("#TopItem").empty();

        res.forEach((item, i) => {
            let EachItem = `<div class="col-lg-3 col-md-4 col-6">
                                <div class="product">
                                    <div class="product_img">
                                        <a href="#">
                                            <img src="${item['image']}" alt="product_img9">
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">

                                                <li><a href="/details?id=${item['id']}" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>

                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="/details?id=${item['id']}">${item['title']}</a></h6>
                                        <div class="product_price">
                                            <span class="price">$ ${item['price']}</span>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:${item['star']}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`
            $("#TopItem").append(EachItem);

        })
    }



    async function Special() {
        let res = await axios.get('/api/products/?remark=special');
        res = res.data[0];

        $("#SpecialItem").empty();

        res.forEach((item, i) => {
            let EachItem = `<div class="col-lg-3 col-md-4 col-6">
                                <div class="product">
                                    <div class="product_img">
                                        <a href="#">
                                            <img src="${item['image']}" alt="product_img9">
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">

                                                <li><a href="/details?id=${item['id']}" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>

                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="/details?id=${item['id']}">${item['title']}</a></h6>
                                        <div class="product_price">
                                            <span class="price">$ ${item['price']}</span>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:${item['star']}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`
            $("#SpecialItem").append(EachItem);

        })
    }



    async function Trending() {
        let res = await axios.get('/api/products/?remark=trending');
        res = res.data[0];

        $("#TrendingItem").empty();

        res.forEach((item, i) => {
            let EachItem = `<div class="col-lg-3 col-md-4 col-6">
                                <div class="product">
                                    <div class="product_img">
                                        <a href="#">
                                            <img src="${item['image']}" alt="product_img9">
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">

                                                <li><a href="/details?id=${item['id']}" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>

                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="/details?id=${item['id']}">${item['title']}</a></h6>
                                        <div class="product_price">
                                            <span class="price">$ ${item['price']}</span>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:${item['star']}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`
            $("#TrendingItem").append(EachItem);

        })
    }
</script>
