<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Inventory App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      height: 100vh;
      background-color: #f8f9fa;
    }
    .login-left {
      background-color: #ffffff;
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .login-right {
      background: url('assets/images/gudang.png') no-repeat center center;
      background-size: cover;
    }
    .form-control:focus {
      box-shadow: none;
      border-color: #6a11cb;
    }
    .btn-primary {
      background-color: #6a11cb;
      border: none;
    }
    .btn-primary:hover {
      background-color: #5a0db4;
    }
    .input-group-text {
      background-color: transparent;
      border-right: none;
    }
    .form-control {
      border-left: none;
    }
    .input-group .form-control:focus {
      border-left: none;
      box-shadow: none;
    }
  </style>
</head>
<body>
  <div class="container-fluid h-100">
    <div class="row h-100">
      <div class="col-lg-6 login-left">
        <h4 class="mb-2 fw-bold">Sistem Informasi Inventory Gudang Barang</h4>
        <h6 class="text-muted mb-4">Login User</h6>

        <form method="post" action="proses_login.php">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" class="form-control" name="username" id="username" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock"></i></span>
              <input type="password" class="form-control" name="password" id="password" required>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="keepSignedIn">
              <label class="form-check-label" for="keepSignedIn">Keep me signed in</label>
            </div>
            <a href="#" class="text-decoration-none text-primary">Forgot password?</a>
          </div>

          <div class="d-flex gap-2 mb-3">
            <button type="submit" class="btn btn-primary w-50">LOGIN</button>
            <button type="reset" class="btn btn-outline-secondary w-50">RESET</button>
          </div>

          <div class="text-center">
            Don't have an account? <a href="register.php" class="text-decoration-none text-primary">Create Account</a><br>
            <a href="index.php" class="text-decoration-none text-secondary">Go Back</a>
          </div>
        </form>
      </div>

      <div class="col-lg-6 d-none d-lg-block login-right">
        <!-- Background image here -->
      </div>
    </div>
  </div>
</body>
</html>
