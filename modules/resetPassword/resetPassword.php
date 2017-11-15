<div ng-include="'modules/navbar/navbar.php'" ng-app="myApp.navbar" ng-controller="navbarCtrl"></div>

<div class="container-fluid" style="background-color: #FFF8DC;">

<form class="form-horizontal" id="contact_form">
<fieldset>

<!-- Form Name -->
<legend><center><h2><b>Reset Password</b></h2></center></legend><br>
<!-- Text input-->

<input id="email" type="hidden" value = "<?php echo $_COOKIE['email'];?>"> 

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" >New Password</label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  <input name="user_password" placeholder="Password" class="form-control"  pattern=".{8,}" title="8 characters minimum"   type="password" ng-model="password" required="true">
    </div>
  </div>
</div>

<!-- Text input-->

<div class="form-group">
  <label class="col-md-4 control-label" >Confirm New Password</label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  <input name="confirm_password" placeholder="Confirm Password" class="form-control"  pattern=".{8,}" title="8 characters minimum"   type="password" ng-model="confirm_password" required="true" >
    </div>
  </div>
</div>


<!-- Select Basic -->

<!-- Success message -->
<div class="alert alert-success" role="alert" id="success_message">Success <i class="glyphicon glyphicon-thumbs-up"></i> Success!.</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label"></label>
  <div class="col-md-4"><br>
    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<button id="btnSubmit" type="submit" class="btn btn-warning">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspSUBMIT <span class="glyphicon glyphicon-send"></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</button>
  </div>
</div>

</fieldset>
</form>
</div>


<style>
    #success_message{ display: none;}
</style>
<script>
    $('#characterLeft').text('140 characters left');
    $('#message').keydown(function () {
        var max = 140;
        var len = $(this).val().length;
        if (len >= max) {
            $('#characterLeft').text('You have reached the limit');
            $('#characterLeft').addClass('red');
            $('#btnSubmit').addClass('disabled');            
        } 
        else {
            var ch = max - len;
            $('#characterLeft').text(ch + ' characters left');
            $('#btnSubmit').removeClass('disabled');
            $('#characterLeft').removeClass('red');            
        }
    }); 
</script>