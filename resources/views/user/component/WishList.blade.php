<div class="breadcrumb_section bg_gray page-title-mini">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="page-title">
                    <h1>Wish List</h1>
                </div>
            </div>
            <div class="col-md-6">
                <ol class="breadcrumb justify-content-md-end">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">This Page</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="mt-5">
    <div class="container my-5">
        <div class="row" id="byList">
        </div>
    </div>
</div>

<script>
    async function WishList() {
        let res = await axios.get(`/api/wishlists`);
        res = res.data[0];

        $("#byList").empty();

        res.forEach((item, i) => {
            let EachItem = `<div class="col-lg-3 col-md-4 col-6">
                                <div class="product">
                                    <div class="product_img">
                                        <a href="#">
                                            <img src="${item['product']['image']}" alt="product_img9">
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                <li><a href="/details?id=${item['product']['id']}" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="/details?id=${item['product']['id']}">${item['product']['title']}</a></h6>
                                        <div class="product_price">
                                            <span class="price">$ ${item['product']['price']}</span>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:${item['product']['star']}%"></div>
                                            </div>
                                        </div>
                                        <button class="btn remove btn-sm my-2 btn-danger" data-id="${item['product']['id']}">Remove</button>

                                    </div>
                                </div>
                            </div>`
            $("#byList").append(EachItem);
        })


        $(".remove").on('click', function() {
            let id = $(this).data('id');
            RemoveWishList(id);
        })
    }

    async function RemoveWishList(id) {
        $(".preloader").delay(90).fadeIn(100).removeClass('loaded');

        let res = await axios.delete("/api/wishlists/" + id);

        $(".preloader").delay(90).fadeOut(100).addClass('loaded');

        if (res.status === 200) {
            await WishList();
        } else {
            alert("Request Fail")
        }
    }
</script>
