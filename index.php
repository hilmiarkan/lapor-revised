<?php
include 'db.php';
session_start();

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

$sql = "SELECT laporan.*, users.name
        FROM laporan 
        LEFT JOIN users ON laporan.user_id = users.id
        ORDER BY laporan.created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
  <title>My Blog</title>
  <link href="./style.css" rel="stylesheet">
</head>



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
        <button class="add-button" id="AddButton">
                    <img src="/myblog/assets/add.svg" alt="add icon" class="add-edit">
                </button>
      </div>
    </div>

    <div class="middle middle-border">
      <div class="content middle-border">

        <div class="switch">
          <span class="switch-active">Selamat datang, pengunjung 👋</span>
        </div>

        <div class="switch" style="padding: 16px;">
          <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.584 2.41605C13.4529 1.28492 12.0173 0.507037 10.452 0.177119C8.88666 -0.152799 7.2592 -0.0205243 5.76773 0.557839C4.27625 1.1362 2.98509 2.13571 2.05143 3.43467C1.11778 4.73363 0.581903 6.27601 0.50905 7.87404C0.436198 9.47207 0.829509 11.0568 1.6411 12.4353C2.45269 13.8139 3.64755 14.9267 5.08022 15.6384C6.51289 16.35 8.12156 16.6299 9.71038 16.4437C11.2992 16.2576 12.7997 15.6136 14.029 14.5901L17.44 18.0001C17.5087 18.0737 17.5915 18.1328 17.6835 18.1738C17.7755 18.2148 17.8748 18.2369 17.9755 18.2386C18.0762 18.2404 18.1763 18.2219 18.2696 18.1842C18.363 18.1465 18.4479 18.0903 18.5191 18.0191C18.5903 17.9479 18.6464 17.863 18.6842 17.7697C18.7219 17.6763 18.7404 17.5762 18.7386 17.4755C18.7369 17.3748 18.7148 17.2755 18.6738 17.1835C18.6328 17.0915 18.5737 17.0087 18.5 16.9401L15.091 13.5301C16.4085 11.9483 17.087 9.93128 16.9933 7.87493C16.8997 5.81857 16.0397 3.87151 14.584 2.41605ZM3.97705 3.47705C5.24293 2.21118 6.95983 1.50001 8.75005 1.50001C10.5403 1.50001 12.2572 2.21118 13.523 3.47705C14.7889 4.74293 15.5001 6.45983 15.5001 8.25005C15.5001 10.0403 14.7889 11.7572 13.523 13.0231C12.2572 14.2889 10.5403 15.0001 8.75005 15.0001C6.95983 15.0001 5.24293 14.2889 3.97705 13.0231C2.71117 11.7572 2.00001 10.0403 2.00001 8.25005C2.00001 6.45983 2.71117 4.74293 3.97705 3.47705Z" fill="#BBBBBB" />
          </svg>
          <input style="background: #222222;font-weight: 400;font-size: 16px;line-height: 26px;" type="search" name="search" placeholder="Cari aduan..." required>
          <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.584 2.41605C13.4529 1.28492 12.0173 0.507037 10.452 0.177119C8.88666 -0.152799 7.2592 -0.0205243 5.76773 0.557839C4.27625 1.1362 2.98509 2.13571 2.05143 3.43467C1.11778 4.73363 0.581903 6.27601 0.50905 7.87404C0.436198 9.47207 0.829509 11.0568 1.6411 12.4353C2.45269 13.8139 3.64755 14.9267 5.08022 15.6384C6.51289 16.35 8.12156 16.6299 9.71038 16.4437C11.2992 16.2576 12.7997 15.6136 14.029 14.5901L17.44 18.0001C17.5087 18.0737 17.5915 18.1328 17.6835 18.1738C17.7755 18.2148 17.8748 18.2369 17.9755 18.2386C18.0762 18.2404 18.1763 18.2219 18.2696 18.1842C18.363 18.1465 18.4479 18.0903 18.5191 18.0191C18.5903 17.9479 18.6464 17.863 18.6842 17.7697C18.7219 17.6763 18.7404 17.5762 18.7386 17.4755C18.7369 17.3748 18.7148 17.2755 18.6738 17.1835C18.6328 17.0915 18.5737 17.0087 18.5 16.9401L15.091 13.5301C16.4085 11.9483 17.087 9.93128 16.9933 7.87493C16.8997 5.81857 16.0397 3.87151 14.584 2.41605ZM3.97705 3.47705C5.24293 2.21118 6.95983 1.50001 8.75005 1.50001C10.5403 1.50001 12.2572 2.21118 13.523 3.47705C14.7889 4.74293 15.5001 6.45983 15.5001 8.25005C15.5001 10.0403 14.7889 11.7572 13.523 13.0231C12.2572 14.2889 10.5403 15.0001 8.75005 15.0001C6.95983 15.0001 5.24293 14.2889 3.97705 13.0231C2.71117 11.7572 2.00001 10.0403 2.00001 8.25005C2.00001 6.45983 2.71117 4.74293 3.97705 3.47705Z" fill="#222222" />
          </svg>
        </div>

        <div class="post-list height-index">
          <?php while ($row = $result->fetch_assoc()) : ?>
            <a style="text-decoration: none; color: inherit; cursor: default;">

              <div class="post post-row">

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
                  <span class="aduan-content"><?php echo $row['content']; ?></span>

                  <?php if (!empty($row['imagepath'])) : ?>
                                            <img class="imagepost" src="<?php echo $row['imagepath']; ?>" alt="<?php echo $row['title']; ?>" />
                                        <?php endif; ?>
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
          <span class="above-button">Lapor</span>
          <button class="login-button">
            <span id="loginBtn">Log in / Sign Up</span>
          </button>
          <span class="below-button">Layanan Aspirasi Online dari<br />pemerintah Indonesia</span>

        </div>
      </div>
    </div>

    <div id="login-modal">
      <div class="mau-form">
        <form id="login-form" method="post" action="login.php">
          <div class="login-modal-title-desc">
            <span class="login-modal-title">Silahkan login ke akun-mu</span>
          </div>

          <input type="email" name="email" placeholder="Email Address" required>
          <input type="password" name="password" placeholder="Password" required>
          <span class="login-modal-desc">belum punya akun?&nbsp;<a id="showRegister">Buat baru</a></span>
          <div class="login-modal-two-button">
            <button class="login-modal-button-cancel">Cancel</button>
            <button type="submit" class="login-button">
              <span id="loginBtn">Login</span>
            </button>
          </div>
        </form>
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
    var addbutton = document.getElementById("AddButton");
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

    // Show login modal when user clicks login button
    addbutton.onclick = function(event) {
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