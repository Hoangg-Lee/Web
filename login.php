<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in & Register</title>
    <link rel="stylesheet" href="globle.css">
    <link rel="stylesheet" href="signup.css">
    <link rel="stylesheet" href="about.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="/code/img/Mot_Chut_Fact_logo_chen_vid.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <video autoplay muted loop id="background-video">
            <source src="img/vid.mp4" type="video/mp4" class="container flex">
        </video>
        <div class="logo">
            <h1>
                <a href="index.html">Game<span>1</span></a>
            </h1>
        </div>  
        <div class="login">
            <h1>Sign In</h1>
            <form method="POST" action="">
                <label>Email</label>
                <input type="email" name="email" placeholder="Email" required>
                <label>PassWord</label>
                <input type="password" name="password" placeholder="Mật khẩu" required>
                <input type="submit" value="Đăng nhập">
                <label >
                    <?php
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "forum";
                    $conn = new mysqli('localhost', 'root', '', 'forum');

                    session_start();
                    
                    if ($conn->connect_error) {
                        die("Kết nối thất bại: " . $conn->connect_error);
                    }
                    
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $email = $_POST['email'];
                        $password = $_POST['password'];
                    
                        // Chuẩn bị và thực thi truy vấn kiểm tra xem email có tồn tại không
                        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
                        $stmt->bind_param("s", $email);
                        $stmt->execute();
                        $result = $stmt->get_result();
                    
                        if ($result->num_rows > 0) {
                            $user = $result->fetch_assoc();

                            // Kiểm tra mật khẩu
                            if (password_verify($password, $user['password'])) {

                                $_SESSION['user_id'] = $user['id'];
                                $_SESSION['username'] = $user['username'];

                                header("Location: forum.php");
                                exit();
                            } else {
                                echo"Không đúng mật khẩu hoặc mật khẩu";
                            }
                        } else {
                            echo"Không tìm thấy email";
                        }
                        $stmt->close();
                    }
                    $conn->close();
                    ?>
                    
            </form>

            <p>Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
        </div> 
    </header>
    <footer>
        <div class="row">
            <div class="col">
                <img src="img/Mot_Chut_Fact_logo_chen_vid.png" class="logo">
                <p>Gioi thieu va mo ta Gioi thieu va mo ta Gioi thieu va mo ta Gioi thieu va mo ta Gioi thieu va mo ta</p>
            </div>
            <div class="col">
                <h3>Dia chi:</h3>
                <p>Nha thg Hoang</p>
                <p>Ha Noi</p>
                <p class="email-id">Thitcho@web.com</p>
                <h4>0123124451</h4>
            </div>
            <div class="col">
                <h3>Links</h3>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="">Blogs</a></li>
                </ul>
                
            </div>
            <div class="col">
                <h3>Socials</h3>
                <div class="nav2 flex">
                    <div class="icons flex">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <i class="fa-brands fa-facebook"></i>
                    <i class="fa-brands fa-youtube"></i>
                    <i class="fa-brands fa-instagram"></i>
                    <i class="fa-brands fa-twitch"></i>
                    </div>
                </div>

            </div>
        </div>
    </footer>
</body>
</html>