<!DOCTYPE html>
<?php
session_start();       /* starting the session */
?>

<html>
   <head>
      <meta charset = "utf-8">
      <meta http-equiv = "X-UA-Compatible" content = "IE = edge">
      <meta name = "viewport" content = "width = device-width, initial-scale = 1">
      
      <title>Gas Info</title>
      
      <!-- Bootstrap -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      
      
      <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      

      <!--[endif]-->
      <link rel="stylesheet" type="text/css" href="css/navStyle.css">
      <link rel="stylesheet" type="text/css" href="css/searchStyle.css">
      <link rel="stylesheet" type="text/css" href="css/tableStyle.css">
      <link rel="stylesheet" type="text/css" href="css/footerStyle.css">
      <link rel="stylesheet" type="text/css" href="css/companyReviews.css">
      <link href="https://fortawesome.github.io/Font-Awesome/assets/font-awesome/css/font-awesome.css" rel="stylesheet">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-dropdown/2.0.3/jquery.dropdown.min.css" rel="stylesheet">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"  rel="stylesheet">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" rel="stylesheet">
      
      <!-- CSS file -->
      <link rel="stylesheet" href="css/easy-autocomplete.min.css"> 
      <!-- Additional CSS Themes file - not required-->
      <link rel="stylesheet" href="css/easy-autocomplete.themes.min.css"> 
      <style>
          .my-container{
             position: relative;
             overflow: hidden;
          }
          
          .my-container img {
            position: absolute;
            opacity: 0.4;
          }
      </style>

   </head>

      <body ng-app="myApp">

<!--        <div class="container-fluid my-container">-->
            <div ng-include="'modules/navbar/navbar.html'"></div>
            <div ui-view></div>           
            <div ng-include="'footer.html'"></div> 
<!--        </div>           -->



<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>




<!--[if lt IE 9] -->
<script src = "https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src = "https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<script src = "https://cdnjs.cloudflare.com/ajax/libs/jquery-dropdown/2.0.3/jquery.dropdown.min.js"></script>
<script src = "https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.3.2/angular-ui-router.min.js"></script>
<script src = "https://ajax.googleapis.com/ajax/libs/angularjs/1.2.0rc1/angular-route.min.js"></script>
<script src = "https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src = "https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>

<script src = "js/stars.js"></script>
<script src = "js/jquery.easy-autocomplete.min.js"></script> 
<script src = "js/search_autocomplete.js"></script> 
<script src = "js/signup_form_validation.js"></script>

<script src = "app.js"></script> 
<script src = "modules/signUp/signUp.js"></script> 
<script src = "modules/reviews/reviews.js"></script> 
<script src = "modules/navbar/navbar.js"></script>



</body>
</html>