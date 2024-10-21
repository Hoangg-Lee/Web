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
                <a href="">Game<span>1</span></a>
            </h1>
        </div>  
        <div class="signup ">
                <h1>Sign Up</h1>
                <form method="POST" enctype="multipart/form-data" >
                    <label>Tên</label>
                    <input type="text" name="username" placeholder="Username" required>
                    <label>email</label>
                    <input type="email" name="email" placeholder="Email" required>
                    <label>PassWord</label>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="submit" value="Register">
                    <label> 
                        <?php
                            include("dbconnect.php");
                            if ($_SERVER["REQUEST_METHOD"] == "POST"){
                                $username = $_POST['username'];
                                $email = $_POST['email'];
                                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                                $checkUser = $conn ->prepare("SELECT * FROM users WHERE  email = ?");
                                $checkUser->bind_param("s", $email);
                                $checkUser -> execute();
                                $result = $checkUser -> get_result();

                                if($result->num_rows > 0){
                                    echo "email đã được sử dụng";
                                }
                                else{
                                    $stmt = $conn -> prepare("INSERT INTO users (username, email, password) VALUES(?, ?, ?)");
                                    $stmt -> bind_param("sss",  $username, $email, $password);
                                    if ( $stmt -> execute() ){
                                        echo "Đăng ký thành công";
                                    }
                                    else{
                                        echo "error!!!" . $stmt->error;
                                    }
                                    $stmt->close();
                                }     
                                $checkUser->close();
                            }
                            $conn -> close();
                        ?>
                    </label>
                </form>

            <p>Chấp nhận điều khoản: <br>
            <a href="">Terms and Condition</a> and <a href="#">Policy Privacy</a>
            </p>
            <p>Đã có tài khoản <a href="login.php">Đăng nhập</a></p>
        </div>    
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
                    <li><a href="index.php">Home</a></li>
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