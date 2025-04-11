
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
                    
                    <form method="POST" action="index.php?act=login">
                        <div class="mb-4">
                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        
                        <div class="mb-3">
                            <input type="submit" name="login" class="btn btn-secondary w-100 py-2" value="Login">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>