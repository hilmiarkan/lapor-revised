<?php
include 'db.php';

if (!isset($_GET['id'])) {
  exit('No id provided');
}

if (isset($_SESSION['error'])) {
  echo "<script type='text/javascript'>
              window.onload = function() {
                var toast = document.getElementById('toast');
                toast.innerText = '{$_SESSION['error']}';
                toast.style.color = '#eeeeee'; // ubah warna font
              toast.style.fontWeight = '400'; // atur font weight
              toast.style.fontSize = '14px'; // atur font size
              toast.style.lineHeight = '22px'; // atur line height
                toast.style.background = '#d92d20';
                toast.classList.remove('hidden');
                setTimeout(function() {
                  toast.classList.add('hidden');
                }, 3000);
              }
            </script>";
  unset($_SESSION['error']);
}

if (isset($_SESSION['success'])) {
  echo "<script type='text/javascript'>
              window.onload = function() {
                var toast = document.getElementById('toast');
                toast.innerText = '{$_SESSION['success']}';
                toast.style.color = '#eeeeee'; // ubah warna font
              toast.style.fontWeight = '400'; // atur font weight
              toast.style.fontSize = '14px'; // atur font size
              toast.style.lineHeight = '22px'; // atur line height
                toast.style.background = '#039855';
                toast.classList.remove('hidden');
                setTimeout(function() {
                  toast.classList.add('hidden');
                }, 3000);
              }
            </script>";
  unset($_SESSION['success']);
}

$id = $_GET['id'];
$user_id = $_GET['user_id'];
$pelapor_id = $_GET['pelapor_id'];

$usertype = "SELECT users.usertype FROM users WHERE users.id = $user_id";
$hasiltype = mysqli_query($conn, $usertype);
$rowtype = mysqli_fetch_assoc($hasiltype);

$laporanstatus = "SELECT laporan.status FROM laporan WHERE laporan.id = $id";
$hasilstatus = mysqli_query($conn, $laporanstatus);
$rowstatus = mysqli_fetch_assoc($hasilstatus);

$komentar = "SELECT comments.*, users.name FROM comments LEFT JOIN users ON comments.user_id = users.id WHERE comments.laporan_id = $id";
$hasilkomentar = mysqli_query($conn, $komentar);


$stmt = $conn->prepare("SELECT laporan.*, users.name FROM laporan LEFT JOIN users ON laporan.user_id = users.id WHERE laporan.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) exit('No rows');
$row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html>

<head>
  <title><?php echo $row['title']; ?></title>
  <link href="style.css" rel="stylesheet">
</head>

<body>
  <div id="toast" class="toast hidden">
    <span class="heading">Username dan atau password yang anda masukkan salah</span>
  </div>
  <div class="wrapper">
    <?php if ($rowtype['usertype'] == 'masyarakat') {
      echo '<div class="left">
<div class="left-container">
        <a href="javascript:history.back()" style="text-decoration: none; color: inherit; cursor: pointer;" class="haptic">
          <svg class="icon-home" xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
            <path d="M10.9823 1.49715C10.631 1.2239 10.4553 1.08727 10.2613 1.03476C10.0902 0.988415 9.9098 0.988415 9.73865 1.03476C9.54468 1.08727 9.36902 1.2239 9.0177 1.49715L2.23539 6.77228C1.78202 7.1249 1.55534 7.30121 1.39203 7.52201C1.24737 7.7176 1.1396 7.93794 1.07403 8.17221C1 8.43667 1 8.72385 1 9.29821V16.5331C1 17.6532 1 18.2133 1.21799 18.6411C1.40973 19.0174 1.71569 19.3234 2.09202 19.5152C2.51984 19.7331 3.0799 19.7331 4.2 19.7331H6.2C6.48003 19.7331 6.62004 19.7331 6.727 19.6786C6.82108 19.6307 6.89757 19.5542 6.9455 19.4601C7 19.3532 7 19.2132 7 18.9331V12.3331C7 11.7731 7 11.4931 7.10899 11.2791C7.20487 11.091 7.35785 10.938 7.54601 10.8421C7.75992 10.7331 8.03995 10.7331 8.6 10.7331H11.4C11.9601 10.7331 12.2401 10.7331 12.454 10.8421C12.6422 10.938 12.7951 11.091 12.891 11.2791C13 11.4931 13 11.7731 13 12.3331V18.9331C13 19.2132 13 19.3532 13.0545 19.4601C13.1024 19.5542 13.1789 19.6307 13.273 19.6786C13.38 19.7331 13.52 19.7331 13.8 19.7331H15.8C16.9201 19.7331 17.4802 19.7331 17.908 19.5152C18.2843 19.3234 18.5903 19.0174 18.782 18.6411C19 18.2133 19 17.6532 19 16.5331V9.29821C19 8.72385 19 8.43667 18.926 8.17221C18.8604 7.93794 18.7526 7.7176 18.608 7.52201C18.4447 7.30121 18.218 7.1249 17.7646 6.77228L10.9823 1.49715Z" stroke="#EEEEEE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </a>
        <a href="" style="text-decoration: none; color: inherit; cursor: pointer;" class="haptic margin-icon">
                    <svg class="icon-notif" width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.35419 20C8.05933 20.6224 8.98557 21 10 21C11.0145 21 11.9407 20.6224 12.6458 20M16 7C16 5.4087 15.3679 3.88258 14.2427 2.75736C13.1174 1.63214 11.5913 1 10 1C8.40872 1 6.8826 1.63214 5.75738 2.75736C4.63216 3.88258 4.00002 5.4087 4.00002 7C4.00002 10.0902 3.22049 12.206 2.34968 13.6054C1.61515 14.7859 1.24788 15.3761 1.26134 15.5408C1.27626 15.7231 1.31488 15.7926 1.46179 15.9016C1.59448 16 2.19261 16 3.38887 16H16.6112C17.8074 16 18.4056 16 18.5382 15.9016C18.6852 15.7926 18.7238 15.7231 18.7387 15.5408C18.7522 15.3761 18.3849 14.7859 17.6504 13.6054C16.7795 12.206 16 10.0902 16 7Z" stroke="#EEEEEE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
    <img src="/lapor-revised/assets/avatar.png" alt="my face" class="myphoto-nav">
    <button class="add-button" id="AddButton">
        <img src="/myblog/assets/add.svg" alt="add icon" class="add-edit">
    </button>

</div>
</div>';
    } else if ($rowtype['usertype'] == 'instansi') {
      echo '<div class="left">
  <div class="left-container">
    <a href="javascript:history.back()" style="text-decoration: none; color: inherit; cursor: pointer;" class="haptic">
      <svg class="icon-home" xmlns="http://www.w3.org/2000/svg" width="20" height="21" viewBox="0 0 20 21" fill="none">
        <path d="M10.9823 1.49715C10.631 1.2239 10.4553 1.08727 10.2613 1.03476C10.0902 0.988415 9.9098 0.988415 9.73865 1.03476C9.54468 1.08727 9.36902 1.2239 9.0177 1.49715L2.23539 6.77228C1.78202 7.1249 1.55534 7.30121 1.39203 7.52201C1.24737 7.7176 1.1396 7.93794 1.07403 8.17221C1 8.43667 1 8.72385 1 9.29821V16.5331C1 17.6532 1 18.2133 1.21799 18.6411C1.40973 19.0174 1.71569 19.3234 2.09202 19.5152C2.51984 19.7331 3.0799 19.7331 4.2 19.7331H6.2C6.48003 19.7331 6.62004 19.7331 6.727 19.6786C6.82108 19.6307 6.89757 19.5542 6.9455 19.4601C7 19.3532 7 19.2132 7 18.9331V12.3331C7 11.7731 7 11.4931 7.10899 11.2791C7.20487 11.091 7.35785 10.938 7.54601 10.8421C7.75992 10.7331 8.03995 10.7331 8.6 10.7331H11.4C11.9601 10.7331 12.2401 10.7331 12.454 10.8421C12.6422 10.938 12.7951 11.091 12.891 11.2791C13 11.4931 13 11.7731 13 12.3331V18.9331C13 19.2132 13 19.3532 13.0545 19.4601C13.1024 19.5542 13.1789 19.6307 13.273 19.6786C13.38 19.7331 13.52 19.7331 13.8 19.7331H15.8C16.9201 19.7331 17.4802 19.7331 17.908 19.5152C18.2843 19.3234 18.5903 19.0174 18.782 18.6411C19 18.2133 19 17.6532 19 16.5331V9.29821C19 8.72385 19 8.43667 18.926 8.17221C18.8604 7.93794 18.7526 7.7176 18.608 7.52201C18.4447 7.30121 18.218 7.1249 17.7646 6.77228L10.9823 1.49715Z" stroke="#EEEEEE" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
    </a>

  </div>
</div>';
    } ?>


    <div class="middle middle-border">
      <div class="content middle-border">

        <div class="tulisan-my-blog">
          <span class="heading-bold">Detail Aduan</span>
          <?php
          if ($user_id == $pelapor_id  && $row['status'] == 'ditindaklanjuti') {
            echo '<form action="tandaiselesai.php" method="POST"><input type="hidden" name="id" value="' . $row['id'] . '"><button type="submit" class="tandai-telah-selesai"><img src="/lapor-revised/assets/check.svg" alt="check" class="icon-check"><span class="button-selesai">Tandai telah selesai</span></button></form>';} else {}?>
        </div>

        <div class="post-list height-detail">

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
              <span class="aduan-title"><?php echo $row['title']; ?></span>
              <span class="aduan-content"><?php echo nl2br(htmlspecialchars($row['content'], ENT_QUOTES, 'UTF-8')); ?></span>
              <?php if (!empty($row['imagepath'])) : ?>
                                            <img class="imagepost" src="<?php echo $row['imagepath']; ?>" alt="<?php echo $row['title']; ?>" />
                                        <?php endif; ?>
              <div class="divide-et-impera"></div>
              <div class="counter-all">

                <div class="counter-wrapper">
                  <svg width="19" height="17" viewBox="0 0 19 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.4997 8.30306C17.4997 12.2151 14.3284 15.3864 10.4164 15.3864C9.51908 15.3864 8.66073 15.2195 7.87069 14.9152C7.72625 14.8595 7.65402 14.8317 7.59659 14.8185C7.5401 14.8054 7.49921 14.8 7.44128 14.7978C7.38238 14.7955 7.31777 14.8022 7.18853 14.8156L2.92101 15.2567C2.51414 15.2988 2.31071 15.3198 2.19071 15.2466C2.08618 15.1828 2.01499 15.0763 1.99604 14.9554C1.97429 14.8165 2.0715 14.6366 2.26593 14.2767L3.62897 11.7537C3.74122 11.546 3.79735 11.4421 3.82277 11.3422C3.84788 11.2435 3.85395 11.1724 3.84592 11.0709C3.83779 10.9682 3.7927 10.8344 3.70254 10.5669C3.46293 9.85605 3.33306 9.09472 3.33306 8.30306C3.33306 4.39104 6.50438 1.21973 10.4164 1.21973C14.3284 1.21973 17.4997 4.39104 17.4997 8.30306Z" stroke="#888888" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  <span class="counter">12</span>
                </div>

                <div class="counter-wrapper">
                  <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M9.99425 2.99957C8.32813 1.05173 5.54975 0.527762 3.46221 2.3114C1.37466 4.09505 1.08077 7.07721 2.72012 9.18673C4.08314 10.9407 8.2081 14.6398 9.56004 15.8371C9.7113 15.971 9.78692 16.038 9.87514 16.0643C9.95213 16.0873 10.0364 16.0873 10.1134 16.0643C10.2016 16.038 10.2772 15.971 10.4285 15.8371C11.7804 14.6398 15.9054 10.9407 17.2684 9.18673C18.9077 7.07721 18.6497 4.07628 16.5263 2.3114C14.4029 0.546524 11.6604 1.05173 9.99425 2.99957Z" stroke="#888888" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  <span class="counter">9</span>
                </div>

              </div>

            </div>


          </div>
          <?php
          if ($row['status'] == 'diverifikasi') {
            echo '<div class="menunggu-diverifikasi">
            <span class="menunggu-diverifikasi-font">Laporan ini menunggu tindak lanjut instansi terkait</span>
          </div>';
          } else {
          }
          ?>

<?php while ($rowkomentar = mysqli_fetch_assoc($hasilkomentar)) : ?>
  <div class="post post-row">

            <img src="/lapor-revised/assets/anonim.png" alt="my face" class="myphoto">

            <div class="full-body">
              <div class="head-wrapper">

                <div class="name-status-wrapper">
                  <span class="post-list-title">
                  <?php echo $rowkomentar['name'] ?>
                  </span>
                </div>

                <span class="post-list-desc"><?php echo date("F j, Y", strtotime($rowkomentar['created_at'])); ?></span>
              </div>
              <span class="aduan-content"><?php echo $rowkomentar['content']; ?></span>
            </div>
          </div>
  <?php endwhile; ?>
          

          <div class="tulisan-my-blog-yooi" style="background-color: #222222">
            <form method="post" action="reply.php" class="reply-input">
              <img src="/lapor-revised/assets/anonim.png" alt="my face" class="myphoto">
              <input type="hidden" name="id_laporan" value="<?php echo $_GET['id']; ?>" />
              <input type="hidden" name="user_id" value="<?php echo $_GET['user_id']; ?>" />
              <input type="text" name="reply" placeholder="Tinggalkan balasan..." />

              <button type="submit" name="submit-reply">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M2.5 10H17.5" stroke="#888888" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M10 2.5L17.5 10L10 17.5" stroke="#888888" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </button>
            </form>
          </div>

        </div>

      </div>
    </div>

    <div class="right">
      <div class="content right-container">
        <div class="right-box">
          <span class="above-button">Lapor</span>
          <form method="post" action="logout.php">
            <button type="submit" name="logout" class="login-button">
              <span id="logoutt">Log Out</span>
            </button>
          </form>

          <span class="below-button">Layanan Aspirasi Online dari<br />pemerintah Indonesia</span>

        </div>
      </div>
    </div>

    <div id="register-modal" style="display: none;">
      <div class="mau-form">
        <form id="register-form" method="post">
          <div class="login-modal-title-desc">
            <span class="login-modal-title">👋 Silahkan buat akun baru</span>
          </div>
          <input type="email" name="email" placeholder="Email address" required>
          <input type="name" name="name" placeholder="Nama Lengkap" required>
          <input type="password" name="password" placeholder="Password" required>
          <span class="login-modal-desc">sudah punya akun?&nbsp;<a id="showLogin">Masuk disini</a></span>
          <div class="login-modal-two-button">
            <button class="login-modal-button-cancel">Cancel</button>
            <button type="submit" class="login-button">
              <span id="loginBtn">Register</span>
            </button>
          </div>
        </form>
      </div>
    </div>

  </div>




  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    // Get the modals
    var loginModal = document.getElementById("login-modal");
    var registerModal = document.getElementById("register-modal");

    // Get the buttons that open the modals
    var loginBtn = document.getElementById("loginBtn");
    var showRegisterBtn = document.getElementById("showRegister");
    var showLoginBtn = document.getElementById("showLogin");

    // Get the cancel buttons
    var loginCancelButton = loginModal.querySelector(".login-modal-button-cancel");
    var registerCancelButton = registerModal.querySelector(".login-modal-button-cancel");

    // Show login modal when user clicks login button
    loginBtn.onclick = function(event) {
      event.stopPropagation();
      showModal(loginModal);
    }

    // Show register modal when user clicks "buat baru"
    showRegisterBtn.onclick = function(event) {
      event.preventDefault();
      event.stopPropagation();
      hideModal(loginModal);
      showModal(registerModal);
    }

    // Show login modal when user clicks "Masuk disini"
    showLoginBtn.onclick = function(event) {
      event.preventDefault();
      event.stopPropagation();
      hideModal(registerModal);
      showModal(loginModal);
    }

    // Hide modals when user clicks cancel buttons
    loginCancelButton.onclick = function(event) {
      event.preventDefault();
      event.stopPropagation();
      hideModal(loginModal);
    }

    registerCancelButton.onclick = function(event) {
      event.preventDefault();
      event.stopPropagation();
      hideModal(registerModal);
    }

    // Hide modals when user clicks anywhere outside of them
    window.onclick = function(event) {
      if (!loginModal.contains(event.target)) {
        hideModal(loginModal);
      }
      if (!registerModal.contains(event.target)) {
        hideModal(registerModal);
      }
    }

    // Helper functions to show and hide modals
    function showModal(modal) {
      modal.style.display = "flex";
      setTimeout(function() {
        modal.classList.add('show');
      }, 10);
    }

    function hideModal(modal) {
      modal.classList.remove('show');
      setTimeout(function() {
        modal.style.display = "none";
      }, 250);
    }

    $(document).ready(function() {
      $("#register-form").on("submit", function(e) {
        e.preventDefault();

        $.ajax({
          type: "POST",
          url: "register.php",
          data: $(this).serialize(),
          success: function(response) {
            var toast = document.getElementById('toast');
            toast.style.backgroundColor = '#039855';
            toast.style.color = '#eeeeee'; // ubah warna font
            toast.style.fontWeight = '400'; // atur font weight
            toast.style.fontSize = '14px'; // atur font size
            toast.style.lineHeight = '22px'; // atur line height
            toast.innerHTML = 'Akun anda sukses dibuat. Silahkan login';
            toast.classList.remove('hidden');
            setTimeout(function() {
              toast.classList.add('hidden');
            }, 3000);

            // Menutup modal
            var modal = document.getElementById('register-modal');
            modal.style.display = 'none';
          },
          error: function(err) {
            // Handle error here
            console.log(err);
          }
        });
      });
    });
  </script>

</body>

</html>