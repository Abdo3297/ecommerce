<!-- Button trigger modal -->
<div class="container">
    <button type="button" class="btn btn-primary py-3 my-3 w-100 text-capitalize" data-mdb-toggle="modal" data-mdb-target="#exampleModal">
        add product
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-capitalize" id="exampleModalLabel">add product</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form>
                <div class="modal-body">
                    <!-- name input -->
                    <div class="form-outline mb-4">
                        <input type="text" id="name" class="form-control" />
                        <label class="form-label" for="name">Name</label>
                    </div>
                    <!-- Price input -->
                    <div class="form-outline mb-4">
                        <input type="number" id="number" class="form-control" min="1" max="<?= PHP_INT_MAX ?>" />
                        <label class="form-label" for="number">Price</label>
                    </div>

                    <!-- photo -->
                    <p>choose a photo to product</p>
                    <div class="form-outline mb-4">
                        <input type="file" id="photo" class="form-control" accept="image/*" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-mdb-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>