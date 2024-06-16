<!-- Modal -->
<div class="modal fade" id="form_profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="update_profile_form" onsubmit="return false">
          
          <div class="form-group">
            <label for="update_username">Full Name</label>
            <input type="hidden" name="uid" id="uid" value=""/>
            <input type="text" class="form-control" name="update_username" id="update_username" value="<?php echo $_SESSION["username"]; ?>" placeholder="Enter Full Name">
            <small id="update_u_error" class="form-text text-muted"></small>
          </div>
          
          <div class="form-group">
            <label for="update_email">Email Address</label>
            <input type="email" class="form-control" name="update_email" id="update_email" aria-describedby="emailHelp" value="<?php echo $_SESSION["email"]; ?>" placeholder="Enter Email Address">
            <small id="update_e_error" class="form-text text-muted">We'll never share your email with anyone else.</small>
          </div>

          <div class="form-group">
            <label for="update_usertype">Select User Type</label>
            <select class="form-control" id="update_usertype" name="update_usertype">
              <?php 
                if ($_SESSION["usertype"] == "Admin") {
              ?>
                  <option value="Admin" selected>Admin</option>
                  <option value="Other">Other</option>
              <?php
                }else if ($_SESSION["usertype"] == "Other") {
              ?>
                  <option value="Admin">Admin</option>
                  <option value="Other" selected>Other</option>
              <?php
                }
              ?>
            </select>
            <small id="update_t_error" class="form-text text-muted"></small>
          </div>
         
          <button type="submit" class="btn btn-success"><i class="fa fa-edit">&nbsp;</i>Update Profile</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close">&nbsp;</i>Close</button>
      </div>
    </div>
  </div>
</div>