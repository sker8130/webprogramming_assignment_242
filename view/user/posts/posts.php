<!-- trang danh sách bài đăng -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="posts.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="header">header</div>

        <div class="content">
            <div class="banner">
                <div class="blog-title">
                    <h3>BLOG ẨM THỰC</h3>
                    <p style="margin-top: -2px">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Suscipit,
                        quae? Fugiat temporibus
                        minima neque aspernatur? A!</p>
                </div>
            </div>

            <div class="search-bar">
                <form>
                    <div class="search-input"><input type="text" placeholder="   Tìm kiếm bài đăng" name="search"></div>
                    <button type="submit" class="search-button">Đi</button>
                </form>
            </div>

            <div class="posts" id="posts"></div>
            <script>
            let posts = "";
            for (let i = 0; i < 6; i++) {
                posts += `<div class="card">
                    <img src="images/food.png" alt=""
                        style="width: 100%; border-top-left-radius: 20px; border-top-right-radius: 20px">
                    <h2 style="text-align: center; margin: 10px 20px">Mỳ tươi trường thọ làm bằng tay</h2>
                    <p style="text-align:justify; margin: 0 15px">Lorem ipsum dolor sit amet, consectetur adipisicing
                        elit. Qui, Lorem Lorem ipsum dolor sit amet consectetur adipisicing.
                        ipsum dolor, sit amet consectetur adipisicing elit. Aliquam, natus?
                        maiores? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Autem, illo!</p>
                    <button class="view-more-button">
                        Xem chi tiết
                    </button>
                </div>`
            }

            document.getElementById("posts").innerHTML = posts;
            </script>

            <div class="pagination">
                <p>&laquo;</p>
                <p class="active">1</p>
                <p>2</p>
                <p>3</p>
                <p>4</p>
                <p>5</p>
                <p>6</p>
                <p>7</p>
                <p>8</p>
                <p>&raquo;</p>
            </div>
        </div>

        <div class="footer">footer</div>
    </div>
</body>



</html>