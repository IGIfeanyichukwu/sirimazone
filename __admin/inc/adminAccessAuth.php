<?php
if (isset($_POST['signup-btn'])) {

    require_once('handleSignup.php');

} else if(isset($_POST['signin-btn'])) {

    echo 'Love of God';
    require_once('handleSignin.php');

}

?>

<!-- FOR LOGIN AND SIGN IN -->

<div class="admin-access-auth-container">


<div class="admin-access-auth-wrap">
     
     <h1>Admin Panel</h1>
     

     <!-- SIGN IN FORM -->
    <div class="signin-form">   
     <h3>Sign in</h3>

     <form action="" method="post" autocomplete="off">

     	<div class="input-fc">
         <!-- <label>Username</label> -->
         <input type="text" name="signin-username" value=""  required autocomplete="off" placeholder="Username">
	    </div>

     <div class="input-fc">
         <!-- <label>Password</label> -->
         <input type="password" name="signin-password" value="" required autocomplete="new-password" placeholder="password">
     </div>
     <div class="other-opt">
     	<span class="open-signup"><small>Sign Up</small></span> <span><small>Forgot your password?</small></span>
     </div>

     <div class="submit-fc">
         <input type="submit" value="Sign In" name="signin-btn">
     </div>
     </form>
 </div>



 <!-- SIGN UP FORM -->
    <div class="signup-form display-none">   

     <h3>Sign up</h3>

     <form action="" method="post" autocomplete="off">

     	<div class="input-fc">
         <!-- <label>Username</label> -->
         <input type="text" name="signup-username" value=""  required autocomplete="off" placeholder="Username">
     </div>

     <div class="input-fc">
         <!-- <label>Email</label> -->
         <input type="text" name="signup-email" value="" required autocomplete="off" placeholder="Email">
     </div>
     
     <div class="input-fc">
         <!-- <label>Password</label> -->
         <input type="password" name="signup-password1" value="" required autocomplete="new-password" placeholder="Password">
     </div>

     <div class="input-fc">
         <!-- <label>Password</label> -->
         <input type="password" name="signup-password2" value="" required autocomplete="new-password" placeholder="Retype Password">
     </div>

     <div class="input-fc">
         <!-- <label>Access ID</label> -->
         <input type="text" name="signup-accessname" value="" required autocomplete="off" placeholder="Access Name">
     </div>

     <div class="input-fc">
         <!-- <label>Access ID</label> -->
         <input type="text" name="signup-accesskey" value="" required autocomplete="off" placeholder="Access Key">
     </div>

     <div class="other-opt">
     	<span class="open-signin"><small>Already signed up?</small></span>
     </div>

     <div class="submit-fc">
         <input type="submit" value="Sign Up" name="signup-btn">
     </div>

     </form>
 </div>


</div>

 </div>