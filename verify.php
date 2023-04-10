<?php
// Connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'database');

// Get the verification code from the URL
$verification_code = mysqli_real_escape_string($conn, $_GET['code']);

// Check if the verification code exists in the database
$sql = "SELECT * FROM users WHERE verification_code='$verification_code'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
  // The verification code is valid
  $user = mysqli_fetch_assoc($result);

  // Update the user's verified status in the database
  $sql = "UPDATE users SET verified=1 WHERE id=" . $user['id'];
  mysqli_query($conn, $sql);

  echo 'Your email address has been verified!';
} else {
  // The verification code is invalid
  echo 'Invalid verification code!';
}
?>