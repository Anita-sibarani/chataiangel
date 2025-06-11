
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="././css/style.css"> <!-- Sesuaikan dengan file CSS Anda -->
</head>
<body>
    <div class="container">
        <h1>Selamat Datang, Admin! <?php echo $_SESSION['fullname']; ?> !</h1>
        <p>Ini adalah halaman admin dashboard.</p>
    </div>
</body>
</html>

<!-- file_/admin_dashboard.php -->
 <?php

include 'config/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header("Location: index.php?page=login");
    exit();
}
// Ambil data user termasuk foto profil dari database
$user_id = $_SESSION['user_id'];
$query = "SELECT fullname, email, image FROM tb_users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$stmt->close();
?>
<head>
  <link rel="stylesheet" href="./css/style.css">
  <style>
        .profile-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .profile-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="profile-card text-center">
                    <!-- Tampilkan foto profil -->
                    <?php if (!empty($user_data['image'])): ?>
                        <img src="<?php echo htmlspecialchars($user_data['image']); ?>" alt="Foto Profil" class="profile-img mb-3">
                    <?php else: ?>
                        <img src="./img/Foto Profil Default.jpg" alt="Foto Profil Default" class="profile-img mb-3">
                    <?php endif; ?>

                    <h3> <a href="?page=manage_users" class="btn btn-outline-primary bi bi-person-circle">
                             <?php echo htmlspecialchars($user_data['fullname']); ?>
                            </a></h3>
                   
                    <p>Email: <?php echo htmlspecialchars($user_data['email']); ?></p>
                     
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h2>Robotors Chatbot</h2>
                    </div>
                    <div class="card-body">
                        <h3>Welcome, <?php echo htmlspecialchars($user_data['fullname']); ?>!</h3>
                        
                        <p>Tekan tombol untuk memulai chat dengan ROBOTORS!</p>
                       <div class="mt-4">
                            <div class="d-flex flex-wrap gap-3">
                            <a href="file_/chatbot.php" class="btn btn-outline-primary bi bi-chat-left-dots ms-2">
                                New Chat 
                            </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    
</body>