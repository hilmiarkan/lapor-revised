<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users (name, email, password, usertype) VALUES (?, ?, ?, 'masyarakat')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password);
    
    if ($stmt->execute()) {
        echo "<script type='text/javascript'>
                window.onload = function() {
                  var toast = document.getElementById('toast');
                  toast.style.backgroundColor = '#039855';
                  toast.innerHTML = 'Akun anda sukses dibuat. Silahkan login';
                  toast.classList.remove('hidden');
                  setTimeout(function() {
                    toast.classList.add('hidden');
                  }, 3000);
                }
              </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
