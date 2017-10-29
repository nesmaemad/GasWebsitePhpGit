            <div ng-include="'modules/landingNavbar/landingNavbar.php'" ng-app="myApp.landingNavbar" ng-controller="landingNavbarCtrl"></div>

<div class="container-fluid" style="background-color: #FFF8DC;">

    <form class="form-horizontal" id="contact_form">
<fieldset>

<!-- Form Name -->
<legend><center><h2><b>Successful Confirmation</b></h2></center></legend><br>

<!-- Text input-->

<div class="form-group text-center">
  <div class="col-md-11">
      <input id="email" type="hidden" value = "<?php echo $_COOKIE['email'];?>"> 
      <h3>You have successfully confirmed your email <i class="fa fa-thumbs-up" aria-hidden="true"></i></h3>
     </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label"></label>
  <div class="col-md-4"><br>
    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<button 
        type="submit" class="btn btn-warning" ng-click="auto_signin()">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspCONTINUE <span class="glyphicon glyphicon-send"></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</button>
  </div>
</div>



</fieldset>
</form>
</div>
