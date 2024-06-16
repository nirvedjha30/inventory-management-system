<!-- Modal -->
<div class="modal fade" id="form_change_profile_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="change_profile_password_form" onsubmit="return false">
          
          <div class="form-group">
            <input type="hidden" class="form-control" name="change_password_email" id="change_password_email" aria-describedby="emailHelp" value="<?php echo $_SESSION["email"]; ?>">
             <label for="current_password">Current Password</label>
              <input type="password" class="form-control" name="current_password" id="current_password" placeholder="Enter Current Password">
              <small id="currentp_error" class="form-text text-muted"></small>
          </div>
          
          <div class="form-group">
            <label for="update_password1">New Password</label>
            <input type="password" class="form-control" name="update_password1" id="update_password1" placeholder="Enter New Password">
            <small id="update_p1_error" class="form-text text-muted"></small>
          </div>

          <div class="form-group">
            <label for="update_password2">Re-Enter New Password</label>
            <input type="password" class="form-control" name="update_password2" id="update_password2" placeholder="Re-Enter New Password">
            <small id="update_p2_error" class="form-text text-muted"></small>
          </div>
         
          <button type="submit" class="btn btn-success"><i class="fa fa-edit">&nbsp;</i>Change Password</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close">&nbsp;</i>Close</button>
      </div>
    </div>
  </div>
</div>