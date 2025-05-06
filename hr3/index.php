<?php
session_start();
require_once 'database_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    $errors = [];

    if (empty($username)) {
        $errors['username'] = 'Username is required';
    }

    if (empty($password)) {
        $errors['password'] = 'Password is required';
    }

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("SELECT id, username, name, password FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                // Successful login
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['name'] = $user['name'];
                header('Location: ./admin/dashboard.php');
                exit;
            } else {
                $error_message = 'Invalid username or password';
            }
        } catch (PDOException $e) {
            error_log("Login DB error: " . $e->getMessage());
            $error_message = 'An error occurred. Please try again later.';
        }
    } else {
        $error_message = 'Validation failed';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paradise Hotel | Tomas Morato</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Nunito', sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }
        
        .login-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            position: relative;
            z-index: 1;
        }
        
        h1 {
            color: #28a745;
            margin-bottom: 16px;
            font-weight: 800;
            font-size: 24px;
            text-transform: uppercase;
        }
        
        .subtitle {
            color: #666;
            margin-bottom: 32px;
            font-size: 14px;
            font-weight: 600;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-size: 14px;
            font-weight: 600;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        input {
            width: 100%;
            padding: 12px 12px 12px 40px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        input:focus {
            outline: none;
            border-color: #28a745;
            box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.2);
        }
        
        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }
        
        .forgot-password {
            text-align: right;
            margin-bottom: 24px;
        }
        
        .forgot-password a {
            color: #28a745;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }
        
        .forgot-password a:hover {
            text-decoration: underline;
        }
        
        .login-button {
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
            border: none;
            border-radius: 4px;
            padding: 12px;
            width: 100%;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-transform: uppercase;
            box-shadow: 0 10px 20px -10px rgba(40, 167, 69, 0.44);
        }
        
        .login-button:hover {
            background: linear-gradient(135deg, #218838, #1e7e34);
            transform: translateY(-2px);
        }
        
        .login-button i {
            margin-right: 8px;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
            display: none;
        }
        
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        
        .modal-content {
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
            animation: modalFadeIn 0.3s ease-out;
        }
        
        .modal-icon {
            font-size: 50px;
            color: #dc3545;
            margin-bottom: 15px;
        }
        
        .modal-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #dc3545;
        }
        
        .modal-message {
            margin-bottom: 20px;
            color: #555;
        }
        
        .modal-button {
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .modal-button:hover {
            background-color: #c82333;
        }
        
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Sign in</h1>
        <p class="subtitle">Enter your username and password to login</p>
        
        <form id="loginForm" method="POST" action="">
            <div class="form-group">
                <label for="username">Username</label>
                <div class="input-wrapper">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" id="username" name="username" placeholder="Enter Username" required>
                </div>
                <div id="username-error" class="error-message"></div>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" id="password" name="password" placeholder="Enter Password" required>
                </div>
                <div id="password-error" class="error-message"></div>
            </div>
            
            <div class="forgot-password">
                <a href="forgot-password.php">Forgot Password?</a>
            </div>
            
            <button type="submit" class="login-button">
                <i class="fas fa-sign-in-alt"></i> Sign in
            </button>
        </form>
    </div>

    <!-- Error Modal -->
    <div id="errorModal" class="modal">
        <div class="modal-content">
            <div class="modal-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <h3 class="modal-title">Login Failed</h3>
            <p class="modal-message" id="modalMessage"></p>
            <button class="modal-button" id="modalCloseButton">OK</button>
        </div>
    </div>

    <script>
        // Client-side validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            let valid = true;
            
            // Reset error messages
            document.querySelectorAll('.error-message').forEach(el => {
                el.style.display = 'none';
            });
            
            if (!username) {
                document.getElementById('username-error').textContent = 'Username is required';
                document.getElementById('username-error').style.display = 'block';
                valid = false;
            }
            
            if (!password) {
                document.getElementById('password-error').textContent = 'Password is required';
                document.getElementById('password-error').style.display = 'block';
                valid = false;
            }
            
            if (!valid) {
                e.preventDefault();
            }
        });

        // Modal functionality
        const errorModal = document.getElementById('errorModal');
        const modalMessage = document.getElementById('modalMessage');
        const modalCloseButton = document.getElementById('modalCloseButton');
        
        function showErrorModal(message) {
            modalMessage.textContent = message;
            errorModal.style.display = 'flex';
        }
        
        function closeModal() {
            errorModal.style.display = 'none';
        }
        
        modalCloseButton.addEventListener('click', closeModal);
        
        // Close modal when clicking outside
        errorModal.addEventListener('click', function(e) {
            if (e.target === errorModal) {
                closeModal();
            }
        });
        
        // Check for PHP error message and show modal if exists
        <?php if (isset($error_message)): ?>
            document.addEventListener('DOMContentLoaded', function() {
                showErrorModal('<?php echo addslashes($error_message); ?>');
            });
        <?php endif; ?>
    </script>
</body>
</html>