<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - PS Rental</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/4dfd690ec1.js" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="login.css">

</head>

<body>

  <form action="auth.php" method="POST" class="auth-container">

    <h3>Login</h3>

    <div class="avatar-container">
      <i class="fa-solid fa-circle-user"></i>
    </div>

    <div class="input-group custom-group">
      <span class="input-group-text">
        <i class="fa-solid fa-user"></i>
      </span>

      <input
        name="username" class="form-control" placeholder="Username" required>
    </div>

    <div class="input-group custom-group password-group">
      <span class="input-group-text">
        <i class="fa-solid fa-lock"></i>
      </span>

      <input
        id="password" name="password" type="password" class="form-control password-input" placeholder="Password" required>

      <span class="show-pass" id="togglePassword">
        <i class="fa-solid fa-eye"></i>
      </span>
    </div>

    <button class="btn btn-login w-100 mt-2">
      Login
    </button>

  </form>

  <script>
    const password = document.getElementById("password");
    const toggle = document.getElementById("togglePassword");

    toggle.addEventListener("click", () => {
      if (password.type === "password") {
        password.type = "text";
        toggle.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
      } else {
        password.type = "password";
        toggle.innerHTML = '<i class="fa-solid fa-eye"></i>';
      }
    });
  </script>

</body>

</html>