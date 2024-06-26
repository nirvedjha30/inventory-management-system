<!-- Modal -->
<div class="modal fade" id="form_brand" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Brand</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="brand_form" onsubmit="return false">
          <div class="form-group">
            <input type="hidden" class="form-control" name="user_id" id="user_id" value="<?php echo $_SESSION["userid"] ?>">
            <label>Brand Name</label>
            <input type="text" class="form-control" name="brand_name" id="brand_name" placeholder="Enter Brand Name">
            <small id="brand_error" class="form-text text-muted">Enter new Brand Name</small>
          </div>
          <button type="submit" class="btn btn-success"><i class="fa fa-plus">&nbsp;</i>Add Brand</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close">&nbsp;</i>Close</button>
      </div>
    </div>
  </div>
</div>