<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details-tab-pane" type="button" role="tab" aria-controls="details-tab-pane" aria-selected="true">Details</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="review-tab" data-bs-toggle="tab" data-bs-target="#review-tab-pane" type="button" role="tab" aria-controls="review-tab-pane" aria-selected="false">Review</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="review_create-tab" data-bs-toggle="tab" data-bs-target="#review_create-tab-pane" type="button" role="tab" aria-controls="review_create-tab-pane" aria-selected="false">Add Review</button>
                </li>

            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="details-tab-pane" role="tabpanel" aria-labelledby="details-tab" tabindex="0">
                   <div id="p_details">

                   </div>
                </div>
                <div class="tab-pane fade" id="review-tab-pane" role="tabpanel" aria-labelledby="review-tab" tabindex="0">
                    <ul id="reviewList" class="list-group list-group-flush">

                    </ul>
                </div>


                <div class="tab-pane fade" id="review_create-tab-pane" role="tabpanel" aria-labelledby="review_create-tab" tabindex="0">
                    <label class="form-label">Write Your Review</label>
                    <textarea class="form-control form-control-sm" id="reviewTextID" rows="5" placeholder="Your Review"></textarea>
                    <label class="form-label mt-2">Rating Score</label>
                    <input min="1" value="0" max="10" id="reviewScore" type="number" class="form-control-sm form-control">
                    <button onclick="AddReview()" class="btn btn-danger mt-3 btn-sm">Submit</button>
                </div>


            </div>
        </div>
    </div>
</div>


