<?php
include 'db.php';

session_start();

function escape($string) {
  global $conn;
  return $conn->real_escape_string($string);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  print_r($_POST);
  $laporan = escape($_POST['id']);

  $sql = "UPDATE laporan SET status = 'selesai' WHERE id = $laporan";

  $conn->query($sql) or die($conn->error);

  header('Location: dashboard_masyarakat.php');
  $stmt->close();
  $conn->close();
}
?>
