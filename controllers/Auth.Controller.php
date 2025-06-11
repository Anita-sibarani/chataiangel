<!-- controllers/AuthController.php -->
<?php

if (!class_exists('AuthController')) {
    class AuthController {
        private $conn;

        public function __construct($dbConnection) {
            $this->conn = $dbConnection;
        }

        public function login($email, $password) {
            $stmt = $this->conn->prepare("SELECT id, fullname, email, password, role_id FROM tb_users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['fullname'] = $user['fullname'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role_id'] = $user['role_id'];
                    if ($user['role_id'] == 1) {
                        
                        header("Location: index.php?page=user_dashboard");
                    } else {
                        header("Location: index.php?page=home");
                    }
                    exit();
                } else {
                    $error = "Invalid password!";
                }
            } else {
                $error = "Email not found!";
            }
            $stmt->close();
            if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                  <?php echo $error; ?>
                </div>
              <?php endif; ?>
        
        
          <?php }
        public function getCurrentUser() {
            if (!isset($_SESSION['user_id'])) {
                return null;
            }

            $user_id = $_SESSION['user_id'];
            $stmt = $this->conn->prepare("SELECT fullname, email, image FROM tb_users WHERE id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                $stmt->close();
                return $user;
            }
            $stmt->close();
            return null;
        }
    }
}
?>