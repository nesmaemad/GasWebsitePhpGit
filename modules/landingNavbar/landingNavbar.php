


    <!-- Second navbar for sign in -->
    <nav class="navbar navbar-inverse">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-2">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            <a  href="#">
                <img class="navbar-brand" src="images/logo.png" alt="logo">

            </a>
        </div>
    
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-collapse-2">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Home</a></li>
            <li><a ui-sref="advertiseWithUs">Advertise With Us</a></li>
            <li><a ui-sref="contactUs">Contact</a></li>
            <li ng-if="is_signed_in != 'true'">
<!--              <a class="btn btn-default btn-outline btn-circle collapsed"  data-toggle="collapse" href="#nav-collapse2" aria-expanded="false" aria-controls="nav-collapse2">Sign in</a>-->
              <a class="btn btn-default btn-outline btn-circle"  ui-sref="signIn">Sign in</a>

            </li>
            <li ng-if="is_signed_in != 'true'">
              <a class="btn btn-default btn-outline btn-circle collapsed" ui-sref="signUp" >Sign Up</a>
            </li>
            
            <li ng-if="is_signed_in == 'true'">
<!--              <a class="btn btn-default btn-outline btn-circle collapsed"  data-toggle="collapse" href="#nav-collapse2" aria-expanded="false" aria-controls="nav-collapse2">Sign in</a>-->
              <a class="btn btn-default btn-outline btn-circle" ui-sref="userSettings" >{{user_name}}</a>

            </li>
            <li ng-if="is_signed_in == 'true'">
              <a class="btn btn-default btn-outline btn-circle collapsed" ng-click="signOut()" >Sign Out</a>
            </li>
            
          </ul>
<!--          <div class="collapse nav navbar-nav nav-collapse slide-down" id="nav-collapse2">
              <form class="navbar-form navbar-right form-inline" id="signin_form" role="form" onsubmit="signIn()">
              <div class="form-group">
                <label class="sr-only" for="Email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" autofocus required />
              </div>
              <div class="form-group">
                <label class="sr-only" for="Password">Password</label>
                <input type="password" class="form-control" id="Password" name="password" placeholder="Password" required />
              </div>
              <button type="submit" class="btn btn-success">Sign in</button>
            </form>
          </div>-->
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container -->
    </nav><!-- /.navbar -->
       	
