<div class="modal fade" id="partPayment" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit_catrgory">Part Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
                    @csrf
                    <!--- Hidden Category Type ---------->
                    <input type="hidden" name="id" id="cat_id">
                    <div class="col-md-12">
                        <input type="text" class="form-control" name="cat_name" id="edit_cat_name" placeholder="Enter Amount" aria-label="Owner Name">
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
