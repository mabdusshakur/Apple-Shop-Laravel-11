<div class="modal animated zoomIn" id="create-modal" aria-labelledby="exampleModalLabel" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Create Brand</h6>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Brand Name *</label>
                                <input class="form-control" id="brandName" type="text">

                                <br />
                                <img class="w-15" id="newImg" src="{{ asset('admin/images/default.jpg') }}" />
                                <br />

                                <label class="form-label">Image</label>
                                <input class="form-control" id="brandImg" type="file" oninput="newImg.src=window.URL.createObjectURL(this.files[0])">

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn bg-gradient-primary" id="modal-close" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button class="btn bg-gradient-success" id="save-btn" onclick="Save()">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    async function Save() {
        let brandName = document.getElementById('brandName').value;
        let brandImg = document.getElementById('brandImg').files[0];

        if (brandName.length === 0) {
            errorToast("brand Required !")
        } else {

            let formData = new FormData();
            formData.append('name', brandName)
            formData.append('image', brandImg)

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader();
            let res = await axios.post("/api/admin/brands", formData, config)
            console.log(res);
            hideLoader();

            if (res.status === 201) {
                successToast(res.data['message']);
                $("#create-modal").modal('hide');
                document.getElementById("save-form").reset();
                await getList();
            } else {
                errorToast(res.data['message'])
            }
        }
    }
</script>
