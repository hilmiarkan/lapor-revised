<?php
include 'db.php';

session_start();

function escape($string) {
  global $conn;
  return $conn->real_escape_string($string);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  print_r($_POST);
  $laporan = escape($_POST['laporan_id']);
  $instansi = escape($_POST['instansi_id']);

  $sql = "UPDATE laporan SET instansi_id = $instansi, status = 'ditindaklanjuti' WHERE id = $laporan";

  $conn->query($sql) or die($conn->error);

  header('Location: dashboard_admin.php');
  $stmt->close();
  $conn->close();
}
?>
