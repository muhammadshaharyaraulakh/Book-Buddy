<?php
require __DIR__ . "/../../config/config.php";
require __DIR__ . "/../../includes/header.php";
?>
<section class="registration">
    <h3>Registration</h3>
    <div class="registration-form"  >
        <h4>Create New Account</h4>
        <p>If you don't have an account with us, Please Create new account.</p>
       <form action="/auth/registration/handler.php" method="post" enctype="multipart/form-data">
        <div class="input-form">
            <div class="input-field">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Your Name">
            </div>
            <div class="input-field">
                <label for="name">Username</label>
                <input type="text" name="username" id="name" placeholder="Enter Unique User Name">
            </div>
            <div class="input-field">
                <label for="email">Email</label>
                <input type="email" name="gmail" id="email" placeholder="Your Email">
            </div>
            <div class="input-field">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password">
            </div>
            <div class="input-field">
                <label for="cpassword">Confirm Password </label>
                <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password">
            </div>
            <div class="input-field">
                <label for="picture" class="upload-label">
                    Profile Pic
                </label>
                <input type="file" name="profile" id="picture" hidden>
                <span id="file-chosen">No file selected</span>
            </div>

            <button>Create Account</button>
            <p>Already Have an Account ? <a href="/auth/login/login.php">Login Now</a></p>
        </div>

       </form>
    </div>
</section>
<?php 
require __DIR__."/../../includes/footer.php";
?>