<?php
  session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../../view/style/login.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="/harrow/controller/login_main.js"></script>
    <script src="../../view/style/password.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.15.1/css/all.css" type="text/css">

    <title>Harrow</title>
  </head>

  <body>
    <div class="background"></div>
    <div class="log"></div>

    <!-- <button type="button" class="toggle-btn" id="main_login">Sign in</button> -->

    <!--Registration Form-->

    <div class="registration">
      <form
        action="../../model/login_form.php"
        id="registration"
        name="registration"
        method="post"
      >
        <!-- form user will be the class to handle the forms  -->
        <div class="form-user">
          <!-- <img src="../../view/images/avatar.png" class="avatar" /> -->
          <span id="register-title">New account</span> 

          <!-- Firstname bracker -->
          <div id="first-name-title"><i class="fas fa-signature"></i> firstname</div>
          <input
            type="text"
            class="form-control"
            id="firstname"
            placeholder="John"
            name="firstname"
            required=""
          /><br>
          <span class="error_form" id="firstname_error_message" hidden></span>
            
          <!-- Lastname bracket -->
          <div id="last-name-title"><i class="fas fa-signature"></i> lastname</div>
          <input
            type="text"
            class="form-control"
            id="lastname"
            placeholder="Doe"
            name="lastname"
            required=""
          /><br>
          <span class="error_form" id="lastname_error_message"hidden></span >
            
          <!-- Username bracket -->
          <div id="user-name-title"><i class="fas fa-user"></i> username</div>
          <input
            type="text"
            class="form-control"
            id="username"
            placeholder="JohnDoe123"
            name="username"
            required=""
          />
          <br>
          <span class="error_form" id="username_error_message" hidden></span>
            
          <!-- email bracket -->
          <div id="email-title"><i class="fas fa-at"></i> email</div>
          <input
            type="email"
            class="form-control"
            id="email_reg"
            placeholder="john_doe@example.com"
            name="email"
            required=""
          />
          <br>
          <span class="error_form" id="email_error_message"hidden></span>

          <!-- password bracket -->
          <div id="password-title"><i class="fas fa-key"></i> passoword</div>
          <input
            type="password"
            class="form-control"
            id="password_reg"
            placeholder="Password"
            name="password"
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
            required=""
          />
            <br>
          <span class="error_form" id="password_error_message"hidden></span>
          
          <!-- An element to toggle between password visibility -->
          <button class="show-pass-btn" type="button"><i class="fas fa-eye-slash"></i></button>
          <span id="show-pass-msg">Show password</span>
          <!-- <input type="checkbox" id="check_reg">Show password -->
          <br />
          <br />
          <div id="register_error"></div>

          <input
            type="button"
            name="register"
            class="btn_reg"
            value="Sign up"
            id="register_btn"
          />
          or <a id="login-redirect" href="login.html">Log In</a>
        </div>
      </form>
    </div>

    <!--Login Form-->

    <div class="login">
      <form
        action="../../model/login_form.php"
        id="login"
        name="login"
        method="post"
      >
        

        <div class="form-user">
          <!-- <img src="../../view/images/avatar.png" class="avatar" /> -->
          <div class="login-msg">Log In</div>

          <!-- E-mail bracket -->
          <div class="email">
              <div class="email-msg"><i class="far fa-at"></i> e-mail</div>
            <div class="email-input"><input
                class="form-control"
                id="email_log"
                placeholder="Email"
                name="email"
                required=""
                ></input>
            </div>
        </div>
          
          
          <!-- Password bracket -->
          <div class="password-msg"><i class="fas fa-key"></i> password</div>
          <input
            type="password"
            class="form-control"
            id="password_log"
            placeholder="Password"
            name="password"
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
            title="Password must be at least 8 characters. Requirements: at least one lowercase letter, one uppercase letter, one number and one special character."
            required=""
          />
          <br />
          <!-- An element to toggle between password visibility -->
          <button class="show-pass-btn" type="button"><i class="fas fa-eye-slash"></i></button>
          
          <span id="show-pass-msg">Show password</span>
          <!-- <input type="checkbox" id="check_log">Show Password -->
          <br />

          <a id='forgot-pass' href="../../controller/email_password.php">Forgot Password?</a>

          <br />
          
          <br />
          <div id="login_error"></div>
          <input
            type='button'
            name="login"
            class="btn btn-primary"
            value="Sign in"
            id="login_btn"
          />

          <br />
          <br />

          <p id="forReg">You still do not have an account? Create one!</p>
          <button type="button" class="toggle-btn" id="main_register">
            Create Acount
          </button>
        </div>
      </form>
    </div>

    <div id="password_reg_info" hidden>
      <h4>Password must meet the following requirements:</h4>
      <ul>
        <li id="letter" class="invalid">
            <span id="pass-icon-lower"></span> At least <strong>one lowercase letter.</strong>
        </li>
        <li id="capital" class="invalid">
            <span id="pass-icon-upper"></span> At least <strong>one uppercase letter.</strong>
        </li>
        <li id="number" class="invalid">
            <span id="pass-icon-number"></span> At least <strong>one number.</strong>
        </li>
        <li id="symbol" class="invalid">
            <span id="pass-icon-special"></span> At least
          <strong>one spesial character e.g. (!@#$%^&*).</strong>
        </li>
        <li id="length" class="invalid">
            <span id="pass-icon-eight"></span> Be at least <strong>8 characters.</strong>
        </li>
      </ul>
    </div>
  </body>
</html>
