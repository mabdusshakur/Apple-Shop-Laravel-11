<div class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="heading_s4 text-center">
                    <h2>Top Categories</h2>
                </div>
                <p class="leads text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim Nullam nunc varius.</p>
            </div>
        </div>
        <div class="row align-items-center" id="TopCategoryItem">

        </div>
    </div>
</div>

<script>
    async function TopCategory() {
        let res = await axios.get('/api/categories');
        res = res.data[0];

        $("#TopCategoryItem").empty()

        res.forEach((item, i) => {
            let EachItem = `<div class="p-2 col-2">
                <div class="item">
                    <div class="categories_box">
                        <a href="/product-by-category?id=${item['id']}">
                            <img src="${item['image']}" alt="cat_img1"/>
                            <span>${item['name']}</span>
                        </a>
                    </div>
                </div>
            </div>`
            $("#TopCategoryItem").append(EachItem);
        })
    }
</script>
