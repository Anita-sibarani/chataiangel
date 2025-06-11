<?php
include 'config/db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?page=login");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT id, fullname, email, no_telp, alamat, image, jenis_kelamin FROM tb_users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_profile'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $no_telp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
    
    $image = $user['image']; 
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        $target_file = $target_dir . $filename;
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $target_file;
            if ($user['image'] && $user['image'] != './img/Foto Profil Default.jpg') {
                unlink($user['image']);
            }
        }
    }
    
    if ($password) {
        $query = "UPDATE tb_users SET fullname=?, email=?, no_telp=?, alamat=?, image=?, jenis_kelamin=?, password=?, update_at=NOW() WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssssi", $fullname, $email, $no_telp, $alamat, $image, $jenis_kelamin, $password, $user_id);
    } else {
        $query = "UPDATE tb_users SET fullname=?, email=?, no_telp=?, alamat=?, image=?, jenis_kelamin=?, update_at=NOW() WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssssi", $fullname, $email, $no_telp, $alamat, $image, $jenis_kelamin, $user_id);
    }
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Profile updated successfully!";
        $_SESSION['fullname'] = $fullname;
        $_SESSION['email'] = $email;
       header("Location: ?page=manage_users");
        exit();
    } else {
        $_SESSION['error_message'] = "Error updating profile: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
  <style>
        .profile-img-lg {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .profile-card {
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        }
        .info-item {
            margin-bottom: 1.5rem;
        }
        .info-icon {
            width: 30px;
            text-align: center;
            color: #6c757d;
        }
        .preview-image {
            max-width: 100px;
            max-height: 100px;
            display: block;
            margin: 10px 0;
        }
    </style>
</head>
    <body style="background-color: beige;">
        <div class="container py-5">
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card profile-card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">My Profile</h3>
                    </div>
                    <div class="card-body">
                        
                        <div class="text-center mb-4">
                            <img src="<?php echo !empty($user['image']) ? htmlspecialchars($user['image']) : './img/Foto Profil Default.jpg'; ?>" 
                                 alt="Profile" 
                                 class="profile-img-lg mb-3">
                            <h3><?php echo htmlspecialchars($user['fullname']); ?></h3>
                            <p class="text-muted"><?php echo $user['jenis_kelamin'] == 1 ? 'Male' : 'Female'; ?></p>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex info-item">
                                    <div class="info-icon">
                                        <i class="bi bi-envelope-fill"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Email</h6>
                                        <p class="text-muted mb-0"><?php echo htmlspecialchars($user['email']); ?></p>
                                    </div>
                                </div>
                                
                                <div class="d-flex info-item">
                                    <div class="info-icon">
                                        <i class="bi bi-telephone-fill"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Phone Number</h6>
                                        <p class="text-muted mb-0"><?php echo !empty($user['no_telp']) ? htmlspecialchars($user['no_telp']) : '-'; ?></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="d-flex info-item">
                                    <div class="info-icon">
                                        <i class="bi bi-house-fill"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Address</h6>
                                        <p class="text-muted mb-0"><?php echo !empty($user['alamat']) ? htmlspecialchars($user['alamat']) : '-'; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <button type="button" class="btn bg-primary px-4 text-white" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                                <i class="bi bi-pencil-square"></i> Edit Profile
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-header bg-primary  text-white">
                        <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fullname" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="fullname" name="fullname" 
                                           value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="no_telp" class="form-label">Handphone</label>
                                    <input type="tel" class="form-control" id="no_telp" name="no_telp" 
                                           value="<?php echo htmlspecialchars($user['no_telp']); ?>">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">Gender</label>
                                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="1" <?php echo $user['jenis_kelamin'] == 1 ? 'selected' : ''; ?>>Male</option>
                                        <option value="0" <?php echo $user['jenis_kelamin'] == 0 ? 'selected' : ''; ?>>Female</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3"><?php echo htmlspecialchars($user['alamat']); ?></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Foto Profile</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                    <small class="text-muted">Max 2MB (JPG, PNG, GIF)</small>
                                    <?php if (!empty($user['image'])): ?>
                                        <div class="mt-2">
                                            <p>Current Image:</p>
                                            <img src="<?php echo htmlspecialchars($user['image']); ?>" class="preview-image">
                                        </div>
                                    <?php endif; ?>
                                    <div id="imagePreview" class="mt-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" name="update_profile" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <script>
        
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('imagePreview');
                    preview.innerHTML = '<p>New Image Preview:</p><img src="' + e.target.result + '" class="preview-image">';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>