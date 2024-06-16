<!-- Modal -->
<div class="modal fade" id="form_products" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="update_product_form" onsubmit="return false">
          <div class="form-row">
            <div class="form-group col-md-6">
              <input type="hidden" name="pid" id="pid" value=""/>
              <label>Date</label>
              <input type="text" class="form-control" name="added_date" id="added_date" value="<?php date_default_timezone_set('Asia/Kolkata'); echo date("Y-m-d"); ?>" readonly/>
            </div>
            <div class="form-group col-md-6">
              <label>Product Name</label>
              <input type="text" class="form-control" name="update_product" id="update_product" placeholder="Enter Product Name" required>
              <small id="product_name_error" class="form-text text-muted">Enter Product Name</small>
            </div>
          </div>
          <div class="form-group">
            <label>Category</label>
            <select class="form-control" id="select_cat" name="select_cat" required/>
              

              
            </select>
            <small id="select_cat_error" class="form-text text-muted">Choose Category</small>
          </div>
          <div class="form-group">
            <label>Brand</label>
            <select class="form-control" id="select_brand" name="select_brand" required/>
              

              
            </select>
            <small id="select_brand_error" class="form-text text-muted">Choose Brand</small>
          </div>
          <div class="form-group">
            <label>Product Price</label>
            <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Enter Price of Product" required/>
            <small id="product_price_error" class="form-text text-muted">Enter Price of Product</small>
          </div>
          <div class="form-group">
            <label>Product Quantity</label>
            <input type="text" class="form-control" id="product_qty" name="product_qty" placeholder="Enter Product Quantity" required/>
            <small id="product_qty_error" class="form-text text-muted">Enter Product Quantity</small>
          </div>
          <button type="submit" class="btn btn-success"><i class="fa fa-edit">&nbsp;</i>Update Product</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close">&nbsp;</i>Close</button>
      </div>
    </div>
  </div>
</div>