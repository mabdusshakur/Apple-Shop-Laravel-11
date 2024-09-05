<div class="modal animated zoomIn" id="create-modal" aria-labelledby="exampleModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">

                                <label class="form-label">Category</label>
                                <select class="form-control form-select" id="productCategory" type="text">
                                    <option value="">Select Category</option>
                                </select>

                                <label class="form-label">Brand</label>
                                <select class="form-control form-select" id="productBrand" type="text">
                                    <option value="">Select Brand</option>
                                </select>

                                <label class="form-label">Remark</label>
                                <select class="form-control form-select" id="productRemark" type="text">
                                    <option value="">Select Remark</option>
                                    <option value="popular">Popular</option>
                                    <option value="new">New</option>
                                    <option value="top">Top</option>
                                    <option value="special">Special</option>
                                    <option value="trending">Trending</option>
                                    <option value="regular">Regular</option>
                                </select>

                                <label class="form-label mt-2">Title</label>
                                <input class="form-control" id="productTitle" type="text">

                                <label class="form-label mt-2">Price</label>
                                <input class="form-control" id="productPrice" type="text">

                                <br />
                                <label class="form-label">is Discount ?</label>
                                <input id="isDiscountCb" type="checkbox" style="background-color: rgb(0, 110, 255);" onclick="toggleDiscountPriceTab()">
                                <br />

                                <div class="d-none" id="discountPriceTab">
                                    <label class="form-label mt-2">Discount Price</label>
                                    <input class="form-control" id="productDiscountPrice" type="text">
                                </div>

                                <label class="form-label mt-2">Stock</label>
                                <input class="form-control" id="productStock" type="text">

                                <label class="form-label mt-2">Short Description</label>
                                <textarea class="form-control" id="productShortDescription" name="" rows="3"></textarea>

                                <br />
                                <img class="w-15" id="newImg" src="{{ asset('admin/images/default.jpg') }}" />
                                <br />

                                <label class="form-label">Image</label>
                                <input class="form-control" id="productImg" type="file" oninput="newImg.src=window.URL.createObjectURL(this.files[0])">

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn bg-gradient-primary mx-2" id="modal-close" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button class="btn bg-gradient-success" id="save-btn" onclick="Save()">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    FillCategoryDropDown();
    FillBrandDropDown();

    toggleDiscountPriceTab = () => {
        let isDiscountCb = document.getElementById('isDiscountCb');
        let discountPriceTab = document.getElementById('discountPriceTab');
        if (isDiscountCb.checked) {
            discountPriceTab.classList.remove('d-none');;
        } else {
            discountPriceTab.classList.add('d-none');
        }
    }
    async function FillCategoryDropDown() {
        let res = await axios.get("/api/admin/categories")
        res = res.data[0];
        res.forEach(function(item, i) {
            let option = `<option value="${item['id']}">${item['name']}</option>`
            $("#productCategory").append(option);
        })
    }

    async function FillBrandDropDown() {
        let res = await axios.get("/api/admin/brands")
        res = res.data[0];
        res.forEach(function(item, i) {
            let option = `<option value="${item['id']}">${item['name']}</option>`
            $("#productBrand").append(option);
        })
    }


    async function Save() {

        let category_id = document.getElementById('productCategory').value;
        let brand_id = document.getElementById('productBrand').value;
        let remark = document.getElementById('productRemark').value;
        let title = document.getElementById('productTitle').value;
        let is_discount = document.getElementById('isDiscountCb');
        let discount_price = document.getElementById('productDiscountPrice').value;
        let price = document.getElementById('productPrice').value;
        let stock = document.getElementById('productStock').value;
        let short_des = document.getElementById('productShortDescription').value;
        let image = document.getElementById('productImg').files[0];

        if (category_id.length === 0) {
            errorToast("Product Category Required !");
        } else if (brand_id.length === 0) {
            errorToast("Product Brand Required !");
        } else if (remark.length === 0) {
            errorToast("Product Remark Required !");
        } else if (title.length === 0) {
            errorToast("Product Title Required !");
        } else if (price.length === 0) {
            errorToast("Product Price Required !");
        } else if (short_des.length === 0) {
            errorToast("Product Short Description Required !");
        } else if (is_discount.checked && discount_price.length === 0) {
            errorToast("Discount Price Required !");
        } else if (!image) {
            errorToast("Product Image Required !");
        } else {

            document.getElementById('modal-close').click();

            let formData = new FormData();
            formData.append('image', image);
            formData.append('title', title);
            formData.append('price', price);
            formData.append('stock', stock);
            formData.append('category_id', category_id);
            formData.append('brand_id', brand_id);
            formData.append('remark', remark);
            formData.append('short_des', short_des);
            formData.append('is_discount', is_discount.checked ? 1 : 0);
            formData.append('in_stock', 1);
            formData.append('star', 0);
            if (is_discount.checked) {
                formData.append('discount_price', discount_price);
            }

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader();
            let res = await axios.post("/api/admin/products", formData, config)
            hideLoader();

            if (res.status === 201) {
                successToast(res.data['message']);
                $('create-modal').modal('hide');
                document.getElementById("save-form").reset();
                await getList();
            } else {
                errorToast(res.data['message'])
            }
        }
    }
</script>
