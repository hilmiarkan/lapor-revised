<?php
session_start();

if (!isset($_SESSION['login_user'])) {
    header("Location: index.php");
    exit();
}

include 'db.php';

$user_id = $_SESSION['login_user'];
$sql = "SELECT `laporan`.*, `users`.`name`
FROM `laporan` 
	LEFT JOIN `users` ON `laporan`.`user_id` = `users`.`id` 
	LEFT JOIN `instansi` ON `laporan`.`instansi_id` = `instansi`.`id`
    WHERE instansi.user_id = $user_id";

$result = $conn->query($sql);
?>


<!DOCTYPE html>
<html>

<head>
    <title>My Blog</title>
    <link href="./style.css" rel="stylesheet">
</head>


<div id="toast" class="toast hidden">
    <span class="heading"></span>
</div>




<body>
    <div id="toast" class="toast hidden">
        <span class="heading">Username dan atau password yang anda masukkan salah</span>
    </div>

    <div class="wrapper">

        <div class="left">
            <div class="left-container">
                <img src="/lapor-revised/assets/home-active.svg" alt="home icon" class="icon-home">
                <a href="" style="text-decoration: none; color: inherit; cursor: pointer;" class="haptic">
                    <svg class="icon-notif" width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.35419 20C8.05933 20.6224 8.98557 21 10 21C11.0145 21 11.9407 20.6224 12.6458 20M16 7C16 5.4087 15.3679 3.88258 14.2427 2.75736C13.1174 1.63214 11.5913 1 10 1C8.40872 1 6.8826 1.63214 5.75738 2.75736C4.63216 3.88258 4.00002 5.4087 4.00002 7C4.00002 10.0902 3.22049 12.206 2.34968 13.6054C1.61515 14.7859 1.24788 15.3761 1.26134 15.5408C1.27626 15.7231 1.31488 15.7926 1.46179 15.9016C1.59448 16 2.19261 16 3.38887 16H16.6112C17.8074 16 18.4056 16 18.5382 15.9016C18.6852 15.7926 18.7238 15.7231 18.7387 15.5408C18.7522 15.3761 18.3849 14.7859 17.6504 13.6054C16.7795 12.206 16 10.0902 16 7Z" stroke="#EEEEEE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>

            </div>
        </div>

        <div class="middle middle-border">
            <div class="content middle-border">

                <div class="switch">
                    <span class="switch-active"> 📁 Laporan yang anda tangani 📁 </span>
                </div>
                <div class="post-list height-index">
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <?php
                        $pelapor = "SELECT laporan.*, users.id FROM laporan LEFT JOIN users ON laporan.user_id = users.id WHERE laporan.id = " . $row['id'] . "";
                        $hasil = $conn->query($pelapor);
                        $wow = $hasil->fetch_assoc()
                        ?> 
                        <a href="detail_laporan.php?id=<?php echo $row['id']; ?>&user_id=<?php echo $user_id; ?>&pelapor_id=<?php echo $wow['id']; ?>" style="text-decoration: none; color: inherit;">

                            <div class="post post-row pointer">

                                <img src="/lapor-revised/assets/anonim.png" alt="my face" class="myphoto">

                                <div class="full-body">
                                    <div class="head-wrapper">

                                        <div class="name-status-wrapper">
                                            <span class="post-list-title">
                                                <?php
                                                if ($row['is_anonymous']) {
                                                    echo 'Anonim';
                                                } else {
                                                    echo $row['name'];
                                                }
                                                ?>
                                            </span>

                                            <?php
                                            switch ($row['status']) {
                                                case 'diverifikasi':
                                                    echo '<div class="status-pending-wrapper"><span class="status-pending-font">Menunggu diverifikasi</span></div>';
                                                    break;

                                                case 'ditindaklanjuti':
                                                    echo '<div class="status-ditindaklanjuti-wrapper"><span class="status-ditindaklanjuti-font">Ditindaklanjuti instansi terkait</span></div>';
                                                    break;

                                                case 'selesai':
                                                    echo '<div class="status-success-wrapper"><span class="status-success-font">Selesai</span></div>';
                                                    break;
                                            }
                                            ?>
                                        </div>

                                        <span class="post-list-desc"><?php echo date("F j, Y", strtotime($row['created_at'])); ?></span>

                                    </div>
                                    <div class="title-content-wrapper">
                                        <span class="aduan-title"><?php echo $row['title']; ?></span>
                                        <span class="aduan-content"><?php echo $row['content']; ?></span>
                                        <?php if (!empty($row['imagepath'])) : ?>
                                            <img class="imagepost" src="<?php echo $row['imagepath']; ?>" alt="<?php echo $row['title']; ?>" />
                                        <?php endif; ?>
                                    </div>


                                </div>


                            </div>
                        </a>
                    <?php endwhile; ?>
                </div>


        </div>
    </div>

    <div class="right">
        <div class="content right-container">
            <div class="right-box">
                <span class="above-button">Hai Instansi!</span>
                <form method="post" action="logout.php">
                    <button type="submit" name="logout" class="login-button">
                        <span id="loginBtn">Log Out</span>
                    </button>
                </form>
                <span class="below-button">Layanan Aspirasi Online dari<br />pemerintah Indonesia</span>
            </div>
        </div>
    </div>

    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // Get the modal
        var addModal = document.getElementById("add-modal");
        // Get the buttons that open the modals
        var addButtons = document.getElementsByClassName("addButton");
        // Get the cancel buttons
        var cancelButtons = document.getElementsByClassName("login-modal-button-cancel");

        // When the user clicks an add button, open the add modal
        for (let addButton of addButtons) {
            addButton.onclick = function(event) {
                var postId = event.target.getAttribute('data-id');
                document.getElementById('postId').value = postId;
                // Set the postContent value here, if available.
                // document.getElementById('postContent').value = ...
                openModal(addModal);
            }
        }

        // When the user clicks a cancel button, close the modal
        for (let cancelButton of cancelButtons) {
            cancelButton.onclick = function(event) {
                event.preventDefault();
                event.stopPropagation();
                closeModal(event.target.closest(".modal"));
            }
        }

        // Open a modal
        function openModal(modal) {
            modal.style.display = "flex";
            setTimeout(function() {
                modal.classList.add('show');
            }, 10);
        }

        // Close a modal
        function closeModal(modal) {
            modal.classList.remove('show');
            setTimeout(function() {
                modal.style.display = "none";
            }, 250);
        }
    </script>

</body>

</html>