<div class="modal animated zoomIn" id="update-modal" aria-labelledby="exampleModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Update Category</h6>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Category Name *</label>
                                <input class="form-control" id="categoryNameUpdate" type="text">

                                <br />
                                <img class="w-15" id="oldImg" src="{{ asset('admin/images/default.jpg') }}" />
                                <br />

                                <label class="form-label">Image</label>
                                <input class="form-control" id="categoryImgUpdate" type="file" oninput="oldImg.src=window.URL.createObjectURL(this.files[0])">
                                <input class="d-none" id="updateID" type="text">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn bg-gradient-primary" id="modal-close" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button class="btn bg-gradient-success" id="save-btn" onclick="update()">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    async function FillUpUpdateForm(id) {
        document.getElementById('updateID').value = id;
        showLoader();
        let res = await axios.get(`/api/admin/categories/${id}`);
        res = res.data[0];
        hideLoader();
        document.getElementById('categoryNameUpdate').value = res['name'];
        document.getElementById('oldImg').src = ' {{ config('app.url') }}/' + res['image'];
    }

    async function update() {
        let categoryName = document.getElementById('categoryNameUpdate').value;
        let categoryImg = document.getElementById('categoryImgUpdate').files[0];
        let id = document.getElementById('updateID').value;

        if (categoryName.length === 0) {
            errorToast("Category Required !")
        } else {

            let formData = new FormData();
            formData.append('name', categoryName)
            if (categoryImg) {
                formData.append('image', categoryImg)
            }

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader();
            let res = await axios.post(`/api/admin/categories/${id}`, formData, config)
            console.log(res);
            hideLoader();

            if (res.status === 200 && res.data['success'] === true) {
                successToast(res.data['message']);
                $("#update-modal").modal('hide');
                document.getElementById("update-form").reset();
                await getList();
            } else {
                errorToast(res.data['message'])
            }
        }
    }
</script>
