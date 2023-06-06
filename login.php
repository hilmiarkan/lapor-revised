<?php
include 'db.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT id, usertype FROM users WHERE email = ? and password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
      $_SESSION['login_user'] = $user['id'];
      if ($user['usertype'] == 'admin') {
        header('Location: dashboard_admin.php');
      } else if ($user['usertype'] == 'instansi') {
        header('Location: dashboard_instansi.php');
      } else if ($user['usertype'] == 'masyarakat') {
        header('Location: dashboard_masyarakat.php');
      }
    } else{
      // Kirim pesan kesalahan ke index.php
      $_SESSION['error'] = 'Username atau password salah';
      header('Location: index.php');
    }
    
    
}
?>