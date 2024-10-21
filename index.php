<?php
// Kết nối cơ sở dữ liệu
include 'dbconnect.php';

// Khởi tạo session
session_start();

// Lấy ID chủ đề từ URL, đảm bảo ID là số nguyên
$topic_id = intval($_GET['id'] ?? 0);

// Lấy chi tiết chủ đề và bài viết từ cơ sở dữ liệu
$stmt = $conn->prepare("SELECT topics.title, users.username, topics.created_at,
                         posts.content, posts.created_at AS post_created_at
                         FROM topics
                         JOIN users ON topics.user_id = users.id
                         LEFT JOIN posts ON posts.topic_id = topics.id
                         WHERE topics.id = ?");
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$result = $stmt->get_result();
$topic = $result->fetch_assoc();
$posts = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game1</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="globle.css">
    <link rel="shortcut icon" href="/code/img/Mot_Chut_Fact_logo_chen_vid.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <nav class = container>
            <div class="logo">
                <h1>
                    <a href="">Game<span>1</span></a>
                </h1>
            </div>  

            <div class="navlist">
                <ul class = "flex">
                    <li> <a href="index.php">Home</a></li>
                    <li> <a href="about.html">About</a></li>
                    <li> <a href="login.php">Forums</a></li>
                </ul>
            </div>

            <div class="icons flex">
                <i class="fa-solid fa-magnifying-glass"></i>
                <i class="fa-brands fa-facebook"></i>
                <i class="fa-brands fa-youtube"></i>
                <i class="fa-brands fa-instagram"></i>
                <i class="fa-brands fa-twitch"></i>
            </div>
        </nav>

        <div class="headercont container flex">
            <div class="labels flex">
                <div class="flex">
                    <i class="fa-solid fa-tv"></i>
                    <h3>
                    <a href="/">PS5</a>
                    <span>,</span>
                    <a href="/">STEAM</a>
                    </h3>
                </div>
                <div class="flex">
                    <i class="fa-solid fa-tags"></i>
                    <h3>
                    <a href="/">ACTION</a>
                    <span>,</span>
                    <a href="/">ADVENTURE</a>
                    </h3>
                </div>
            </div>
            <h1 id="header_title">I'm BetMan</h1>
            <p>Gioi thieu, mo ta?</p>
            <div class="headbtn flex">
                <a href="/" id="d_btn1"><button class="button type1"></button></a>
                <a href="/" id="d_btn1"><button class="button type2"></button></a>
            </div>
        </div>
        <div class="dots flex">
            <div class="dot flex"></div>
            <div class="dot flex"></div>
            <div class="dot flex"></div>
        </div>
    </header>

    <main>
        <div class="gamecards container flex">
            <div class="card">
                <div class="carding">
                    <a href="/">
                        <img src="img/tdz.jpg" alt="" >
                    </a>
                    <div class="tags">
                        <a href="/">alo</a>
                        <i class="fa-solid fa-tag"></i>
                    </div>
                </div>
                <div class="cardinfo">
                    <h2>Game1</h2>
                    <div class="playtag">
                        <i class="fa-solid fa-tv"></i>
                        <h3 class="flex">
                            <a href="/">Ps1</a>
                            <span>,</span>
                            <a href="">ps2</a>
                        </h3>
                    </div>
                    <p>Gioi thieu va mo ta  </p>
                </div>
            </div>

            <div class="card">
                <div class="carding">
                    <a href="/">
                        <img src="img/tdz.jpg" alt="" >
                    </a>
                    <div class="tags">
                        <a href="/">alo</a>
                        <i class="fa-solid fa-tag"></i>
                    </div>
                </div>
                <div class="cardinfo">
                    <h2>Game1</h2>
                    <div class="playtag">
                        <i class="fa-solid fa-tv"></i>
                        <h3 class="flex">
                            <a href="/">Ps1</a>
                            <span>,</span>
                            <a href="">ps2</a>
                        </h3>
                    </div>
                    <p>Gioi thieu va mo ta  </p>
                </div>
            </div>

            <div class="card">
                <div class="carding">
                    <a href="/">
                        <img src="img/tdz.jpg" alt="" >
                    </a>
                    <div class="tags">
                        <a href="/">alo</a>
                        <i class="fa-solid fa-tag"></i>
                    </div>
                </div>
                <div class="cardinfo">
                    <h2>Game1</h2>
                    <div class="playtag">
                        <i class="fa-solid fa-tv"></i>
                        <h3 class="flex">
                            <a href="/">Ps1</a>
                            <span>,</span>
                            <a href="">ps2</a>
                        </h3>
                    </div>
                    <p>Gioi thieu va mo ta  </p>
                </div>
            </div>
            
            
        </div>

        <div class="news flex">
            <div class="container">
                <h2>blog&nbsp;<span>& news</span></h2>
                <div class="threecards flex">
                    <?php
                        // Truy vấn 3 topic mới nhất từ cơ sở dữ liệu và lấy tên người dùng từ bảng users
                        $query = "
                            SELECT topics.title, topics.created_at, users.username, topics.id 
                            FROM topics 
                            JOIN users ON topics.user_id = users.id 
                            ORDER BY topics.created_at DESC 
                            LIMIT 1";
                        $result = mysqli_query($conn, $query);

                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $id = $row['id'];
                                $title = $row['title'];
                                $username = $row['username'];
                                $created_at = $row['created_at'];

                                // Giới hạn tiêu đề trong 20 ký tự
                                $short_title = (strlen($title) > 50) ? substr($title, 0, 50) . '...' : $title;
                            }
                        }        
                    ?>   
                    <div class="tcards">
                        <img src="img/sherk.jpg" alt="">
                        <div class="tcarddetails">
                            <h3><a href="topic.php?id=<?php echo $id; ?>">Cập nhật 1</a></h3>
                            <p><?php echo $short_title; ?></p>
                            <div class="postby">
                                <div class="flex">
                                    <i class="fa-solid fa-poo"></i>
                                    <h5><?php echo $username; ?></h5>
                                </div>
                                <div class="flex">
                                    <i class="fa-solid fa-clapperboard"></i>
                                    <h5><?php echo date("d/m/Y", strtotime($created_at)); ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        // Truy vấn 3 topic mới nhất từ cơ sở dữ liệu và lấy tên người dùng từ bảng users
                        $query_previous = "
                            SELECT topics.title, topics.created_at, users.username, topics.id 
                            FROM topics 
                            JOIN users ON topics.user_id = users.id 
                            ORDER BY topics.created_at DESC 
                            LIMIT 1 OFFSET 1";
                        $result_previous = mysqli_query($conn, $query_previous);

                        if ($result_previous && mysqli_num_rows($result_previous) > 0) {
                            while ($row = mysqli_fetch_assoc($result_previous)) {
                                $id = $row['id'];
                                $title = $row['title'];
                                $username = $row['username'];
                                $created_at = $row['created_at'];

                                // Giới hạn tiêu đề trong 20 ký tự
                                $short_title = (strlen($title) > 50) ? substr($title, 0, 50) . '...' : $title;
                            }
                        }        
                    ?>
                    <div class="tcards">
                        <img src="img/sherk.jpg" alt="">
                        <div class="tcarddetails">
                            <h3><a href="topic.php?id=<?php echo $id; ?>">Cập nhật 2</a></h3>
                            <p><?php echo $short_title; ?></p>
                            <div class="postby">
                                <div class="flex">
                                    <i class="fa-solid fa-poo"></i>
                                    <h5><?php echo $username; ?></h5>
                                </div>
                                <div class="flex">
                                    <i class="fa-solid fa-clapperboard"></i>
                                    <h5><?php echo date("d/m/Y", strtotime($created_at)); ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        // Truy vấn 3 topic mới nhất từ cơ sở dữ liệu và lấy tên người dùng từ bảng users
                        $query_previous1 = "
                            SELECT topics.title, topics.created_at, users.username, topics.id  
                            FROM topics 
                            JOIN users ON topics.user_id = users.id 
                            ORDER BY topics.created_at DESC 
                            LIMIT 1 OFFSET 2";
                        $result_previous1 = mysqli_query($conn, $query_previous1);

                        if ($result_previous1 && mysqli_num_rows($result_previous1) > 0) {
                            while ($row = mysqli_fetch_assoc($result_previous1)) {
                                $id = $row['id'];
                                $title = $row['title'];
                                $username = $row['username'];
                                $created_at = $row['created_at'];

                                // Giới hạn tiêu đề trong 20 ký tự
                                $short_title = (strlen($title) > 50) ? substr($title, 0, 50) . '...' : $title;
                            }
                        }        
                    ?>
                    <div class="tcards">
                        <img src="img/sherk.jpg" alt="">
                        <div class="tcarddetails">
                            <h3><a href="topic.php?id=<?php echo $id; ?>">Cập nhật 3</a></h3>
                            <p><?php echo $short_title; ?></p>
                            <div class="postby">
                                <div class="flex">
                                    <i class="fa-solid fa-poo"></i>
                                    <h5><?php echo $username; ?></h5>
                                </div>
                                <div class="flex">
                                    <i class="fa-solid fa-clapperboard"></i>
                                    <h5><?php echo date("d/m/Y", strtotime($created_at)); ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

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
                    <li><a href="">Home</a></li>
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
           
    <script src="script.js"></script>

</body>
</html>