<?php
session_start();
if(empty($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['otp'])) {
        $entered_otp = $_POST['otp'];
        $email = $_SESSION['email'];

        $stmt = $con->prepare("SELECT * FROM otp_requests WHERE email = ? AND otp = ? AND expires_at > NOW()");
        $stmt->bind_param("ss", $email, $entered_otp);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // OTP is valid
            $_SESSION['user'] = $email;

            // Check if "Remember Me" is selected
            if (isset($_POST['remember_me'])) {
                // Set a cookie for 30 days
                setcookie('remember_me', $email, time() + (30 * 24 * 60 * 60), "/");

                // Clean up all OTPs for the email
                $stmt = $con->prepare("DELETE FROM otp_requests WHERE email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();

                // Save the recent OTP only
                $stmt = $con->prepare("INSERT INTO otp_requests (email, otp, expires_at) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $email, $entered_otp, date("Y-m-d H:i:s", strtotime("+5 minutes")));
                $stmt->execute();
            } else {
                // Clean up only the previous OTPs, keep the recent one
                $stmt = $con->prepare("DELETE FROM otp_requests WHERE email = ? AND otp != ?");
                $stmt->bind_param("ss", $email, $entered_otp);
                $stmt->execute();
            }

            header("Location: dashboard.php");
            exit();
        } else {
            $msg = "Invalid or expired OTP. Please try again.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verify</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
</head>
<style>
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
    <h3 align="center">OTP Verification</h3><br/>
    <div class="box">
     <form method="POST">
       <div class="form-group">
       <label for="otp">Enter OTP</label>
       <input type="text" name="otp" id="otp" placeholder="One Time Password" required class="form-control"/>
      </div>
      <div class="form-group">
        <label>
            <input type="checkbox" name="remember_me" id="remember_me"> Remember Me for 30 Days
        </label>
      </div>
      <div class="form-group">
       <input type="submit" id="submit" name="verify_otp" value="Submit" class="btn btn-success" />
      </div>
      <p class="error"><?php if(!empty($msg)){ echo $msg; } ?></p>
     </form>
     </div>
   </div>
  </div>
 </body>
</html>