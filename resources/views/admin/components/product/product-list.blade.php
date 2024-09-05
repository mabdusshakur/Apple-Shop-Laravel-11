<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between">
                    <div class="align-items-center col">
                        <h4>Product</h4>
                    </div>
                    <div class="align-items-center col">
                        <button class="float-end btn bg-gradient-primary m-0" data-bs-toggle="modal" data-bs-target="#create-modal">Create</button>
                    </div>
                </div>
                <hr class="bg-dark" />
                <table class="table" id="tableData">
                    <thead>
                        <tr class="bg-light">
                            <th>Image</th>
                            <th>Title</th>
                            <th>Discount ? Price</th>
                            <th>Normal Price</th>
                            <th>Stock</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Remark</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tableList">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    getList();


    async function getList() {


        showLoader();
        let res = await axios.get("/api/admin/products");
        res = res.data[0];
        hideLoader();

        let tableList = $("#tableList");
        let tableData = $("#tableData");

        tableData.DataTable().destroy();
        tableList.empty();

        res.forEach(function(item, index) {
            let row = `<tr>
                    <td><img class="w-15 h-auto" alt="" src="{{ config('app.url') }}/${item['image']}"></td>
                    <td>${item['title']}</td>
                    <td>${item['is_discount'] == 1 ? 'Yes - $' + item['discount_price'] : 'No'}</td>
                    <td>${item['price']}</td>
                    <td>${item['stock']}</td>
                    <td>${item['brand']['name']}</td>
                    <td>${item['category']['name']}</td>
                    <td>${item['remark']}</td>
                    <td>
                        <button data-detail="${item['product_detail'] != null ? item['product_detail']['id'] : item['product_detail']}" data-id="${item['id']}"  class="btn editBtn btn-sm btn-outline-success">Edit</button>
                        <button data-detail="${item['product_detail'] != null ? item['product_detail']['id'] : item['product_detail']}" data-id="${item['id']}" class="btn deleteBtn btn-sm btn-outline-danger">Delete</button>
                    </td>
                 </tr>`
            tableList.append(row)
        })

        $('.editBtn').on('click', async function() {
            let id = $(this).data('id');
            let detail = $(this).data('detail');
            await FillUpUpdateForm(id, detail);
            $("#update-modal").modal('show');
        })

        $('.deleteBtn').on('click', function() {
            let id = $(this).data('id');
            let detail = $(this).data('detail');
            $("#delete-modal").modal('show');
            $("#deleteProductId").val(id);
            $("#deleteDetailId").val(detail);
        })

        new DataTable('#tableData', {
            order: [
                [0, 'desc']
            ],
            lengthMenu: [5, 10, 15, 20, 30]
        });

    }
</script>
