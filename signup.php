<?php
if(isset($_POST['signup'])) {
  // Get form data
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];
  $role = $_POST['role'];

  // Check if passwords match
  if($password !== $confirm_password) {
    echo "Passwords do not match.";
    exit();
  }

  // Hash the password
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Connect to database
  $conn = mysqli_connect("localhost", "username", "password", "database_name");

  // Check if connection succeeded
  if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Prepare SQL statement
  $stmt = mysqli_prepare($conn, "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");

  // Bind parameters to statement
  mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashed_password, $role);

  // Execute statement
  mysqli_stmt_execute($stmt);

  // Check if user was inserted successfully
  if(mysqli_affected_rows($conn) > 0) {
    echo "User created successfully.";
  } else {
    echo "Error creating user: " . mysqli_error($conn);
  }

  // Close statement and connection
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Amatic+SC">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <title>Document</title>
</head>
<body>
<form method="POST">
  <label>Username</label>
  <input type="text" name="username" required>

  <label>Email</label>
  <input type="email" name="email" required>

  <label>Password</label>
  <input type="password" name="password" required>

  <label>Confirm Password</label>
  <input type="password" name="confirm_password" required>

  <label>Role</label>
  <select name="role" required>
    <option value="">Select Role</option>
    <option value="admin">Admin</option>
    <option value="local">Local User</option>
  </select>

  <input type="submit" name="signup" value="Signup">
</form>

  

</body>
</html>