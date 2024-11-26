<?php
session_start();
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['token']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
        $token = $_POST['token'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if ($new_password === $confirm_password) {
            // Validate token
            $stmt = $con->prepare("SELECT email FROM password_resets WHERE token = ? AND expires_at > NOW()");
            $stmt->bind_param("s", $token);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $email = $row['email'];

                // Update password in the register table for the specific email
                $stmt = $con->prepare("UPDATE register SET pass = ? WHERE email = ?");
                $stmt->bind_param("ss", $new_password, $email);  // Bind both the new password and the email
                $stmt->execute();

                // Clean up password reset request
                $stmt = $con->prepare("DELETE FROM password_resets WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();

                echo "<script type='text/javascript'>alert('Password updated successfully. You can now log in with your new password.'); window.location.href='login.php';</script>";
                exit();
            } else {
                $msg = "Invalid or expired token.";
            }
        } else {
            $msg = "Passwords do not match.";
        }
    } else {
        $msg = "All fields are required.";
    }
} elseif (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
</head>
<style>
 body {
  background-color: #56a3ff;
 }
 .box {
  width: 100%;
  max-width: 600px;
  background-color: #f9f9f9;
  border: 1px solid #ccc;
  border-radius: 5px;
  padding: 16px;
  margin: 0 auto;
 }
 .error {
  color: red;
  font-weight: 700;
} 
</style>
<body>
    <div class="container">
    <div class="table-responsive">
    <h3 align="center">Reset Password</h3><br/>
    <div class="box">
     <form method="POST">
       <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
       <div class="form-group">
       <label for="new_password">New Password</label>
       <input type="password" name="new_password" id="new_password" placeholder="New Password" class="form-control" required/>
      </div>
      <div class="form-group">
       <label for="confirm_password">Confirm Password</label>
       <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" class="form-control" required/>
      </div>
      <div class="form-group">
       <input type="submit" value="Reset Password" class="btn btn-success" />
      </div>
      <p class="error"><?php if(!empty($msg)){ echo $msg; } ?></p>
     </form>
     </div>
   </div>
  </div>
 </body>
</html>