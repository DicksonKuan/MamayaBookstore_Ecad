<?php
//Detect the current session
session_start();
// Include the page layout header
include("header.php");
?>

<!-- Create a cenrally located container-->
<div style="width:80%; margin:auto;">
    <form action="checkLogin.php" method="post">
        <!--1st Row header row-->
        <div class="form-group row">
            <div class="col-sm-9 offset-sm-3">
                <span class="page-title">Member Login</span>
            </div>
        </div>
        <!--2nd Row entry of email address-->
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for="email">
                Email Address:
            </label>
            <div class="col-sm-9">
                <input type="form-control" type="email" name="email" id="email" class="form-control" required>
            </div>
        </div>
        <!-- 3rd row- entry of password-->
        <div class="form-group row">
            <label class="col-sm-3 col-form-label" for="password">
                Password:
            </label>
            <div class="col-sm-9">
                <input type="form-control" type="password" name="password" id="password" class="form-control" required>
            </div>
        </div>
        <!-- 4th row- Login button-->
        <div class="form-group row">
            <div class="col-sm-9 offset-sm-3">
                <button type="submit" class="btn btn-primary">Login</button>
                <p>Please sign up if you do not have an account.</p>
                <p><a href="forgetpassword.php">Forget Password</a></p>
            </div>
        </div>
    </form>
</div>
<?php include("footer.php");?>