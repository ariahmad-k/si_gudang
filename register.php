<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register - Inventory App</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      height: 100vh;
      margin: 0;
    }
    .register-left {
      background-color: #fff;
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .register-right {
      background: url('assets/images/taman.png') no-repeat center center;
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
  </style>
</head>
<body>
  <div class="container-fluid h-100">
    <div class="row h-100">
      <div class="col-lg-6 register-left">
        <div class="text-start mb-4">
          <h4 class="fw-bold"><i class="bi bi-box-seam me-1 text-success"></i> Spica</h4>
          <p class="text-muted mb-1">New here?</p>
          <p>Join us today! It takes only few steps</p>
        </div>

        <?php
        session_start();
        if (isset($_SESSION['reg_error'])) {
          echo "<div class='alert alert-danger'>" . $_SESSION['reg_error'] . "</div>";
          unset($_SESSION['reg_error']);
        }
        if (isset($_SESSION['reg_success'])) {
          echo "<div class='alert alert-success'>" . $_SESSION['reg_success'] . "</div>";
          unset($_SESSION['reg_success']);
        }
        ?>

        <form action="proses_reg.php" method="POST">
          <div class="mb-3">
            <label>Username</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" name="username" class="form-control" required>
            </div>
          </div>

          <div class="mb-3">
            <label>Email</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-envelope"></i></span>
              <input type="email" name="email" class="form-control" required>
            </div>
          </div>

          <div class="mb-3">
            <label>Tipe User</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
              <select name="tipe_user" class="form-select" required>
                <option value="">-- Pilih --</option>
                <option value="admin">Admin</option>
                <option value="customer">Customer</option>
                <option value="suplier">Suplier</option>
              </select>
            </div>
          </div>

          <div class="mb-3">
            <label>Password</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock"></i></span>
              <input type="password" name="password" class="form-control" required>
            </div>
          </div>

          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="terms" required>
            <label class="form-check-label" for="terms">
              I agree to all <a href="#" class="text-primary">Terms & Conditions</a>
            </label>
          </div>

          <button type="submit" class="btn btn-primary w-100">SIGN UP</button>

          <p class="mt-3 text-center">
            Already have an account? <a href="login.php" class="text-decoration-none text-primary">Login</a>
          </p>
        </form>
      </div>

      <div class="col-lg-6 d-none d-lg-block register-right">
        <!-- Background image here -->
      </div>
    </div>
  </div>
</body>
</html>
