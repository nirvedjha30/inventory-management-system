<!-- Modal -->
<div class="modal fade" id="form_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="category_form" onsubmit="return false">
          <div class="form-group">
            <input type="hidden" class="form-control" name="user_id" id="user_id" value="<?php echo $_SESSION["userid"] ?>">
            <label>Category Name</label>
            <input type="text" class="form-control" name="category_name" id="category_name" aria-describedby="emailHelp" placeholder="Enter Category Name">
            <small id="cat_error" class="form-text text-muted">Enter new Category Name</small>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Parent Category</label>
            <select class="form-control" id="parent_cat" name="parent_cat">
              

              
            </select>
            <small id="#" class="form-text text-muted">Choose Parent Category Or Root</small>
          </div>
          <button type="submit" class="btn btn-success"><i class="fa fa-plus">&nbsp;</i>Add Category</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close">&nbsp;</i>Close</button>
      </div>
    </div>
  </div>
</div>