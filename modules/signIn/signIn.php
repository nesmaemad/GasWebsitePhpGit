            <div ng-include="'modules/navbar/navbar.php'" ng-app="myApp.navbar" ng-controller="navbarCtrl"></div>

<div class="container-fluid" style="background-color: #FFF8DC;">

    <form class="form-horizontal" id="contact_form">
<fieldset>

<!-- Form Name -->
<legend><center><h2><b>Sign In Form</b></h2></center></legend><br>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label">E-Mail</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
  <input name="email" placeholder="E-Mail Address" class="form-control"  type="email" ng-model="email" required="true">
    </div>
  </div>
</div>




<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" >Password</label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  <input name="user_password" placeholder="Password" class="form-control"  type="password" ng-model="password" required="true">
    </div>
  </div>
</div>

<div class="form-group">
    <label class="col-md-4 col-md-push-2 control-label" ><a>forgot your password?</a></label> 

</div>




<!-- Select Basic -->

<!-- Success message -->
<div class="alert alert-success" role="alert" id="success_message">Success <i class="glyphicon glyphicon-thumbs-up"></i> Success!.</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label"></label>
  <div class="col-md-4"><br>
    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<button type="submit" class="btn btn-warning">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspSIGN IN <span class="glyphicon glyphicon-send"></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</button>
  </div>
</div>

</fieldset>
</form>
</div>

<style>
    #success_message{ display: none;}
</style>    