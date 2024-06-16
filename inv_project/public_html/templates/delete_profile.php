<!-- Modal -->
<div class="modal fade" id="form_delete_profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Your Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="delete_profile_form" onsubmit="return false">
          <div class="form-group">
            <input type="hidden" class="form-control" name="dlog_email" id="dlog_email" value="<?php echo $_SESSION["email"] ?>">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" name="dlog_password" id="dlog_password" placeholder="Enter password">
            <small id="delp_error" class="form-text text-muted">Enter password</small>
          </div>
          <?php
              if (isset($_SESSION["userid"]) AND $_SESSION['email']) {
            ?>
          <button type="submit" class="btn btn-danger"><i class="fa fa-trash">&nbsp;</i>Delete Your ID</button>
          <?php
              }
          ?>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close">&nbsp;</i>Close</button>
      </div>
    </div>
  </div>
</div>