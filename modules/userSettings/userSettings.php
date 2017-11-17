            <div ng-include="'modules/navbar/navbar.php'" ng-app="myApp.navbar" ng-controller="navbarCtrl"></div>

<div class="container-fluid" style="background-color: #FFF8DC;">

    <form class="form-horizontal" id="contact_form">
<fieldset>

<!-- Form Name -->
<legend><center><h2><b>User Settings</b></h2></center></legend><br>

<!-- Text input-->

<div class="form-group">
  <label class="col-md-4 control-label">First Name</label>  
  <div class="col-md-4 inputGroupContainer">
  <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  <input  name="first_name" placeholder="First Name" class="form-control"  type="text" ng-model="first_name" required="true">
    </div>
  </div>
</div>

<!-- Text input-->

<div class="form-group">
  <label class="col-md-4 control-label" >Last Name</label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  <input name="last_name" placeholder="Last Name" class="form-control"  type="text" ng-model="last_name" required="true">
    </div>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label" >Username</label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  <span>
  <input name="user_name" placeholder="Username" class="form-control"  type="text" ng-model="user_name" required="true">
  <span style="color:red;display: none;" id="username_exists">User Name Already Exists</span>
  </span>
    </div>
  </div>
</div>

  <div class="form-group"> 
  <label class="col-md-4 control-label">Country</label>
    <div class="col-md-4 selectContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
    <select name="department" class="form-control selectpicker" ng-model="country"
            ng-change="changeProvincy()" required="true">
      <option value="2">America</option>
      <option value="1">Canada</option>

    </select>
  </div>
</div>
</div>

<div  class="form-group"> 
  <label class="col-md-4 control-label" ng-if = "country == '1'">Province / Territory</label>
  <label class="col-md-4 control-label" ng-if = "country == '2'">State</label>
    <div class="col-md-4 selectContainer">
    <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
    <select name="department" class="form-control selectpicker" ng-change="changeCity()"
            ng-options="province.name for province in provinces" ng-model="selected_province" required="true">
    </select>   
  </div>
</div>
</div>

<div  class="form-group"> 
  <label class="col-md-4 control-label" >City / Town</label>
    <div class="col-md-4 selectContainer">
    <div class="input-group">
    <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
    <select name="department" class="form-control selectpicker"
            ng-options="city.name for city in cities" ng-model="selected_city" required="true">
    </select>   
  </div>
</div>
</div>


<!-- Text input-->
       
<div class="form-group">
  <label class="col-md-4 control-label">Address</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-address-card-o"></i></span>
  <input name="address" placeholder="Address" class="form-control" type="text" ng-model="address" required="true">
    </div>
  </div>
</div>
  
<!-- Text input-->

<div  class="form-group">
  <label class="col-md-4 control-label" ng-if = "country == '1'">postal Code</label> 
  <label class="col-md-4 control-label" ng-if = "country == '2'">Zip Code</label> 
  <div class="col-md-4 inputGroupContainer">
  <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  <input  name="code" ng-show = "country == '1'" placeholder="Postal Code" class="form-control"  type="text" ng-model="code" required="true">
    <input  name="code" ng-show = "country == '2'" placeholder="Zip Code" class="form-control"  type="text" ng-model="code" required="true">

    </div>
  </div>
</div>


<!-- Text input-->

<div class="form-group">
  <label class="col-md-4 control-label" >Password</label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  <input name="user_password" placeholder="Password" class="form-control"  pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" title="8 characters minimum, at least 1 letter and 1 number"   type="password" ng-model="password" required="true">
    </div>
  </div>
</div>

<!-- Text input-->

<div class="form-group">
  <label class="col-md-4 control-label" >Confirm Password</label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  <input name="confirm_password" placeholder="Confirm Password" class="form-control"  pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" title="8 characters minimum, at least 1 letter and 1 number"  type="password" ng-model="confirm_password" required="true" >
    </div>
  </div>
</div>



<!-- Text input-->
       
<div class="form-group">
  <label class="col-md-4 control-label">Contact No.</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
  <input name="contact_no" placeholder="(639)" class="form-control" type="number" ng-model="number">
    </div>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label">E-Mail</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
        <span>
          <input name="email" placeholder="E-Mail Address" class="form-control"  type="email" ng-model="email" required="true">
          <span style="color:red;display: none;" id="email_exists">Email Already Exists</span>

        </span> 
  </div>
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label">Delete Account</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-remove"></i></span>
        <span>
            <button class="form-control btn btn-danger"  type="button" ng-click="deleteAccount()">
                Delete Account
            </button>
        </span> 
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
    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<button type="submit" class="btn btn-warning">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspSUBMIT <span class="glyphicon glyphicon-send"></span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</button>
  </div>
</div>

</fieldset>
</form>
</div>

<style>
    #success_message{ display: none;}
</style>    