<?php
include 'db.php';

session_start();

function escape($string) {
  global $conn;
  return $conn->real_escape_string($string);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  print_r($_POST);
  $laporan_id = escape($_POST['id_laporan']);
  $user_id = escape($_POST['user_id']);
  $isi_komentar = escape($_POST['reply']);
  
  $sql = "INSERT INTO comments (content, created_at, user_id, laporan_id) VALUES ('$isi_komentar', NOW(), '$user_id', '$laporan_id')";

  $conn->query($sql) or die($conn->error);

  header('Location: ' . $_SERVER['HTTP_REFERER']);
  $stmt->close();
  $conn->close();
}

?>

