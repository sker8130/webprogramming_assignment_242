<!-- trang danh sách bài đăng -->

<?php
$currentPage = $_GET['page'] ?? 1;
$totalPages = $totalPages ?? 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blogs</title>
    <meta name="description"
        content="Discover the latest articles about food, behind-the-scene stories and more from Tasty Bites' restaurant's food blog">

    <link rel="stylesheet" href="app/views/user/blogs/blogs.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>


<body>
    <div class="blogs-container">
        <div class="banner">
            <div class="blog-title">
                <h3>FOOD BLOGS</h3>
            </div>
        </div>
        <div class="search-bar">
            <form method="get">
                <div class="search-input"><input type="text" placeholder="   Search for blogs" name="searchForBlogs"
                        value="<?php echo isset($oldInput["searchForBlogs"]) ? htmlspecialchars($oldInput["searchForBlogs"]) : ""; ?>">
                </div>
                <button type="submit" class="search-button">Go</button>
            </form>
        </div>
        <div class="blogs" id="blogs">
            <?php echo $htmlDisplayed; ?>
        </div>
        <div class="pagination">
            <?php if ($currentPage > 1): ?>
            <a
                href="?page=<?php echo $currentPage - 1; ?>&searchForBlogs=<?php echo urlencode($oldInput["searchForBlogs"] ?? ''); ?>">&laquo;</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?php echo $i; ?>&searchForBlogs=<?php echo urlencode($oldInput["searchForBlogs"] ?? ''); ?>"
                class="<?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
            <a
                href="?page=<?php echo $currentPage + 1; ?>&searchForBlogs=<?php echo urlencode($oldInput["searchForBlogs"] ?? ''); ?>">&raquo;</a>
            <?php endif; ?>
        </div>

    </div>
</body>



</html>