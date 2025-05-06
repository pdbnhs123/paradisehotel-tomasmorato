<?php
session_start();
require 'database_config.php'; // Ensure PDO $pdo is available

// Optional: Log the logout activity
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Optional logging (assumes session_logs table exists)
    $stmt = $pdo->prepare("INSERT INTO session_logs (username, action, timestamp) VALUES (:username, 'logout', NOW())");
    $stmt->execute([':username' => $username]);
}

// Destroy the session securely
$_SESSION = [];
if (ini_get("session.use_cookies")) {
    setcookie(session_name(), '', time() - 42000, '/');
}
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Paradise Hotel | Tomas Morato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Auto-redirect after 2 seconds
        setTimeout(() => {
            window.location.href = 'index.php'; // Update this path if needed
        }, 3000);
    </script>
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="modal-dialog text-center">
        <div class="modal-content p-4 shadow-sm border-0">
            <div class="modal-body">
                <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h5 class="mb-0">Logging out...</h5>
                <small class="text-muted">You will be redirected shortly.</small>
            </div>
        </div>
    </div>
</body>
</html>
