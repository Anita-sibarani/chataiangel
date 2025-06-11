<?php
include 'config/db.php';
if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $fullname = htmlspecialchars($_POST['fullname']);
    $jenis_kelamin = isset($_POST['jenis_kelamin']) ? ($_POST['jenis_kelamin'] === 'male' ? 1 : 0) : null;
    $no_telp = isset($_POST['no_telp']) ? preg_replace('/[^0-9]/', '', $_POST['no_telp']) : '';
    $alamat = htmlspecialchars($_POST['alamat']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role_id = 1; 
    $created_at = date('Y-m-d H:i:s');
    $update_at = date('Y-m-d H:i:s');
    $image = '';

   
    $upload_success = false;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

        
        if (in_array($ext, $allowed_types)) {
            
            if ($_FILES["image"]["size"] <= 5000000) {
                $filename = uniqid('profile_', true) . '.' . $ext;
                $target_path = 'uploads/' . $filename;

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_path)) {
                    $image = $target_path; 
                    $upload_success = true;
                } else {
                    echo "<script>alert('Gagal menyimpan file upload');</script>";
                }
            } else {
                echo "<script>alert('Ukuran file terlalu besar (maksimal 5MB)');</script>";
            }
        } else {
            echo "<script>alert('Format file tidak didukung. Gunakan JPG, PNG, atau GIF');</script>";
        }
    } else {
        echo "<script>alert('Silakan upload foto profil');</script>";
    }

 
    if ($upload_success) {
        $query_check = "SELECT id FROM tb_users WHERE email = ?";
        $stmt_check = $conn->prepare($query_check);
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            echo "<script>alert('Maaf, email sudah terdaftar');</script>";
            echo '<meta http-equiv="refresh" content="1; url=?page=login">'; 
            exit();
        }
        $stmt_check->close();

       
        $query_insert = "INSERT INTO tb_users (fullname, email, password, jenis_kelamin, no_telp, alamat, image, role_id, created_at, update_at)
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($query_insert);
        $stmt_insert->bind_param("sssisssiss", $fullname, $email, $password, $jenis_kelamin, $no_telp, $alamat, $image, $role_id, $created_at, $update_at);

        if ($stmt_insert->execute()) {
            echo "<script>alert('Pendaftaran berhasil! Silakan login');</script>";
            echo '<meta http-equiv="refresh" content="1; url=?page=login">'; 
        } else {
            error_log("Database error: " . $stmt_insert->error); 
            echo "<script>alert('Terjadi kesalahan saat mendaftar. Silakan coba lagi.');</script>";
        }

        $stmt_insert->close();
        $conn->close(); 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Chat AI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-pink: #FF69B4; 
            --light-pink: #FFE8F2;   
            --form-border-color: rgba(255, 255, 255, 0.7); 
            --button-background: #687078; 
            --button-text:#F2F2F2; 
            --link-color: #007bff;   
            --text-dark: #333333;    
            --page-background: #FFFFFF; 
        }

       
        body {
            background-color: var(--page-background) !important; 
            font-family: 'Times New Roman', Times, serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        
        .form-container-wrapper {
            flex-grow: 1; 
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem 1rem;
            background-color: var(--page-background); 
        }

        .form-signin {
            background-color: var(--light-pink) !important; 
            border-radius: 15px !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
            padding: 2.5rem !important;
            max-width: 450px;
            width: 100%;
            color: var(--text-dark);
            margin: auto;
        }

        .form-signin h1.h3 {
            color: var(--primary-pink) !important; 
            font-size: 2.5rem !important;
            font-weight: normal !important;
            margin-bottom: 1.5rem !important;
        }

        .form-floating .form-control {
            border: 1px solid var(--form-border-color) !important;
            background-color: rgba(255, 255, 255, 0.9) !important;
            color: var(--text-dark) !important;
        }

        .form-floating .form-control:focus {
            border-color: var(--primary-pink) !important;
            box-shadow: 0 0 0 0.25rem rgba(255, 105, 180, 0.25) !important;
        }

        .form-floating label {
            color: var(--text-dark) !important;
        }

        .form-floating > .form-control:not(:placeholder-shown) ~ label,
        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-select ~ label,
        .form-floating > textarea:not(:placeholder-shown) ~ label,
        .form-floating > textarea:focus ~ label {
            transform: scale(.85) translateY(-.5rem) translateX(.15rem);
            opacity: .65;
        }

        .form-floating > .form-select,
        .form-floating > textarea {
            min-height: calc(3.5rem + 2px);
            padding-top: 1.625rem;
            padding-bottom: 0.625rem;
        }
        .form-floating > textarea {
            height: 100px;
        }

        .form-signin .btn.btn-primary {
            background-color: var(--button-background) !important; 
            border-color: var(--button-background) !important;
            color: var(--button-text) !important;
        }

        .form-signin .btn.btn-primary:hover {
            background-color: #212529 !important;
            border-color: #212529 !important;
        }

        .form-signin .text-center.mt-3 a {
            color: var(--link-color) !important;
            text-decoration: none !important;
        }

        .form-signin .text-center.mt-3 a:hover {
            text-decoration: underline !important;
        }

    
        @media (max-width: 767.98px) { 
            .form-container-wrapper {
                padding: 1rem; 
            }
            .form-signin {
                padding: 1.5rem !important;
            }
        }
    </style>
</head>
<body>

    <div class="form-container-wrapper">
    <main class="form-signin">
        <form method="POST" enctype="multipart/form-data">
            <h3 class="text-center" style="color: rgb(255, 105, 180);"><b>Register</b></h3>
            <h1 class="h3 mb-3 fw-normal text-center" style="color: black !important;">Register Now</h1>
            
            <div class="form-floating">
                <input type="email" name="email" class="form-control" id="floatingInputEmail" placeholder="name@example.com" required>
                <label for="floatingInputEmail">Email</label>
            </div>
            
            <div class="form-floating mt-1">
                <input type="text" name="fullname" class="form-control" id="floatingInputUsername" placeholder="Username" required>
                <label for="floatingInputUsername">Username</label>
            </div>
            
            <div class="form-floating mt-1">
                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                <label for="floatingPassword">Password</label>
            </div>
            
            <div class="form-floating mt-1">
                <select name="jenis_kelamin" class="form-control" id="floatingGender" required>
                    <option value="" disabled selected>Select Gender</option>
                    <option value="male">Laki-laki</option>
                    <option value="female">Perempuan</option>
                </select>
                <label for="floatingGender">Jenis Kelamin</label>
            </div>
            
            <div class="form-floating mt-1">
                <input type="tel" name="no_telp" class="form-control" id="floatingPhone" placeholder="No Telepon" required>
                <label for="floatingPhone">No Telepon</label>
            </div>
            
            <div class="form-floating mt-1">
                <textarea name="alamat" class="form-control" id="floatingAddress" placeholder="Alamat" style="height: 100px;" required></textarea>
                <label for="floatingAddress">Alamat</label>
            </div>
            
            <div class="form-floating mt-1">
                <input type="file" name="image" class="form-control" id="floatingImage" accept="image/*" required>
                <label for="floatingImage">Upload Foto Profil</label>
            </div>

            <button class="btn btn-primary w-100 py-2 mt-3" type="submit" name="register">Register</button>

            <div class="text-center mt-3">
                Sudah memiliki akun? <a href="?page=login">Login</a>
            </div>
        </form>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
