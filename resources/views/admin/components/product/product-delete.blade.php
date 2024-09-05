<div class="modal animated zoomIn" id="delete-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <h3 class="text-warning mt-3">Delete !</h3>
                <p class="mb-3">Once delete, you can't get it back.</p>
                <input class="d-none" id="deleteProductId" />
                <input class="d-none" id="deleteDetailId" />
            </div>
            <div class="modal-footer justify-content-end">
                <div>
                    <button class="btn bg-gradient-success mx-2" id="delete-modal-close" data-bs-dismiss="modal" type="button">Cancel</button>
                    <button class="btn bg-gradient-danger" id="confirmDelete" type="button" onclick="itemDelete()">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    async function itemDelete() {
        let productId = document.getElementById('deleteProductId').value;
        let detailId = document.getElementById('deleteDetailId').value;
        document.getElementById('delete-modal-close').click();
        showLoader();

        if (detailId) {
            await axios.delete(`/api/admin/product-details/${detailId}`)
        }

        let res = await axios.delete(`/api/admin/products/${productId}`).catch(err => {
            hideLoader();
            errorToast("Invoice exist for this product!")
        })

        hideLoader();
        if (res.data['success'] === true) {
            successToast("Request completed")
            await getList();
        } else {
            errorToast("Request fail!")
        }
    }
</script>
