<?php 
session_start(); 
ob_start(); 
include "models/pdo.php"; 
include "models/user.php"; 

$error = '';

if(isset($_POST['dangnhap'])) { 
    $username = $_POST['username']; 
    $password = $_POST['password']; 
    
    $userInfo = checkuser($username, $password); 
    
    if ($userInfo) { 
        // Đăng nhập thành công
        $_SESSION['user'] = [
            'id' => $userInfo['id'],
            'username' => $userInfo['username'],
            'full_name' => $userInfo['full_name'],
            'role' => $userInfo['role']
        ];        
        
        // Regenerate session ID để tăng cường bảo mật
        session_regenerate_id(true);
        
        if ($userInfo['role'] == 'teacher') { 
            header('Location: index.php'); 
        } elseif ($userInfo['role'] == 'student') {
            header('Location: login.php'); 
        } else {
            header('Location: login.php');
        }
        exit;
    } else { 
        $error = 'Tên đăng nhập hoặc mật khẩu không đúng!';
    } 
} 

?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="../css/login.css" rel="stylesheet">
    <style>
        .login-container {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin-top: 5rem;
        }
        .form-label {
            font-weight: 500;
        }
        .form-control {
            height: 45px;
        }
        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="login-container p-4 p-md-5">
                    <h1 class="text-center mb-4">Log in</h1>
                    
                    <?php if(!empty($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <div class="mb-4">
                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        <div class="mb-3">
                            <button type="submit" name="dangnhap" class="btn btn-secondary w-100 py-2">Log in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>