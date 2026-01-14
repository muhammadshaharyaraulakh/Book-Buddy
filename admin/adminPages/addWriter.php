<?php 
require __DIR__."/../../config/config.php";
require __DIR__."/../../includes/dashboardHeader.php";
?>

<div id="content">
    
    <div class="top-navbar">
        <div class="nav-left">
            <button type="button" id="sidebarCollapse" class="menu-btn">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <div class="nav-right">
            <div class="profile-preview">
                <img src="/userImages/<?= $_SESSION['image'] ?>" alt="Admin">
                <span><?= $_SESSION['name'] ?></span>
            </div>
        </div>
    </div>

   <div class="form-container">
    <form action="/admin/handlers/registerWriter.php" method="POST" enctype="multipart/form-data">

            <div class="form-group">
                <label for="name">Name</label>
                <div class="input-wrapper">
                <input type="text" name="name" id="name" placeholder="Enter Name">
                </div>
                <div class="error name"></div>
            </div>

            <div class="form-group">
                <label>User Name</label>
                <div class="input-wrapper">
                    <input type="text" name="username" id="name" placeholder="Enter Unique User Name">
                </div>
                <div class="error username"></div>
            </div>




            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <input type="email" name="gmail" id="email" placeholder="Enter Email">
                </div>
                <div class="error email"></div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" name="password" id="password" placeholder="Password">
                </div>
                <div class="error password"></div>
            </div>

            <div class="form-group">
                <label for="cpassword">Confirm Password </label>
                <div class="input-wrapper">
                   
                <input type="password" name="cpassword" id="cpassword" placeholder="Confirm Password">
                </div>
                <div class="error publisher"></div>
            </div>




        <!-- Upload Cover -->
        <div class="form-group">
            <label>Upload Cover</label>
            <div class="file-upload-wrapper">
                <input type="file" class="cover_image" name="cover_image">
                <div class="file-custom-label">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span>Click to upload image</span>
                </div>
            </div>
            <div class="error cover_image"></div>

            <div class="image-preview-box" id="previewBox" style="display: none;">
                <img id="imagePreview" src="" alt="Cover Preview">
                <button type="button" id="removeImage">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn-submit">
            Register
        </button>
    </form>
</div>

</div>

</div> <script src="/assests/js/admin.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const coverInput = document.querySelector('.cover_image');
    const previewBox = document.getElementById('previewBox');
    const imagePreview = document.getElementById('imagePreview');
    const removeBtn = document.getElementById('removeImage');

    // When a file is selected
    coverInput.addEventListener('change', () => {
        const file = coverInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result; // Set preview image src
                previewBox.style.display = 'block';  // Show preview box
            }
            reader.readAsDataURL(file); // Read file as data URL
        } else {
            previewBox.style.display = 'none';
            imagePreview.src = '';
        }
    });

    // Remove the selected image
    removeBtn.addEventListener('click', () => {
        coverInput.value = '';            // Clear input
        imagePreview.src = '';            // Remove preview
        previewBox.style.display = 'none'; // Hide preview box
    });
});
</script>

</body>
</html>

