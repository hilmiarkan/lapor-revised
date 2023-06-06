<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $is_anonymous = isset($_POST['checkboxName']) ? 1 : 0;
    $user_id = $_SESSION['login_user'];  // Mengganti 'user_id' menjadi 'login_user'.

    $sql = "INSERT INTO laporan (title, content, is_anonymous, user_id, created_at, updated_at, status) 
            VALUES ('$title', '$content', '$is_anonymous', '$user_id', NOW(), NOW(), 'diverifikasi')";
    if (!$conn->query($sql)) {
        die('Error: ' . $conn->error);
    } else {
        header("Location: dashboard_masyarakat.php");  // Redirect user ke halaman dashboard setelah submit.
    }
}

$sql = "SELECT laporan.*, users.name
        FROM laporan 
        LEFT JOIN users ON laporan.user_id = users.id
        ORDER BY laporan.created_at DESC";
$result = $conn->query($sql);
?>
