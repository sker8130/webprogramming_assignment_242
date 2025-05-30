<?php
// session_start();

if (isset($_SESSION['scrollToComment'])) {
    $scrollCommentID = $_SESSION['scrollToComment'];
    $parentID = $_SESSION["openResponds"];
    echo "<script>
        window.addEventListener('load', function() {
            var target = document.getElementById('comment-{$scrollCommentID}');
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            viewRespondsToggle({$parentID});
         });
    </script>";
    unset($_SESSION['scrollToComment']);
    unset($_SESSION['openResponds']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($row["Title"]); ?></title>

    <meta name="description" content="<?php echo htmlspecialchars(substr(strip_tags($row['Content']), 0, 160)); ?>">
    <meta name="author" content="<?php echo htmlspecialchars($row['WriterName']); ?>">

    <link rel="stylesheet" href="app/views/user/blogdetail/blogdetail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="content">
            <div class="top">
                <div class="main-content">
                    <div class="title"><?php echo htmlspecialchars($row["Title"]); ?></div>
                    <div class="blog-info">
                        <div class="writer-name">
                            <i class='far fa-user-circle'></i>
                            <div><?php echo htmlspecialchars($row["WriterName"]) ?></div>
                        </div>
                        <div class="created-at">
                            <i class='far fa-calendar-plus'></i>
                            <div><?php echo substr($row["CreatedAt"], 0, 10) ?></div>
                        </div>
                    </div>
                    <hr style="color: grey">
                    <div class="blog-content">
                        <?php echo $row["Content"]; ?>
                    </div>
                    <div class="share">
                        <i class='fab fa-facebook'></i>
                        <i class='fab fa-instagram'></i>
                        <i class='fas fa-link'></i>
                        <i class='fas fa-share-alt'></i>


                    </div>
                </div>
                <div class="other-blogs">
                    <div class="other-blogs-title">Other blogs
                    </div>
                    <div class="other-blogs-list">
                        <?php
                        $count = 0;
                        while ($otherBlog = $otherBlogs->fetch_assoc()) {
                            if ($otherBlog["BlogID"] != $row["BlogID"] && $otherBlog["IsPublic"] === "yes") {
                                $title = htmlspecialchars($otherBlog["Title"]);
                                $writerName = htmlspecialchars($otherBlog["WriterName"]);
                                $titleParam = str_replace(' ', '-', urldecode($title));
                                echo "<a href='/webprogramming_assignment_242/blog?id={$otherBlog["BlogID"]}&title={$titleParam}'>
                                    <div class='other-blog-element'>
                                        <img src='{$otherBlog["Image"]}' alt='idk' class='other-blog-image'>
                                        <div class='other-blog'>
                                            <div class='other-blog-title'>{$title}</div>
                                            <div class='other-blog-info'>{$writerName} | " . substr($otherBlog["CreatedAt"], 0, 10) . "</div>
                                        </div>
                                    </div>
                                </a>";
                                $count++;
                                if ($count >= 4) break;
                            }
                        }

                        ?>

                    </div>
                </div>
            </div>


            <?php
            //nếu session hết hạn nhưng cookie còn -> đặt lại session
            //nếu k có session or có mà session là admin -> header tới login
            require_once "app/models/UserModel.php";
            require_once "app/models/TokenModel.php";

            $userModel = new UserModel();
            $tokenModel = new TokenModel();
            if (!isset($_SESSION["mySession"]) && isset($_COOKIE["usernameEmail"])) {
                $token = $_COOKIE["usernameEmail"];
                if ($tokenModel->checkTokenExists($token)) {
                    $user = $userModel->getUserByToken($token);
                    if ($user) {
                        $_SESSION["mySession"] = $user["Username"];
                    }
                }
            }

            //kiểm tra chưa đăng nhập
            $notLoginCond = !isset($_SESSION["mySession"]) || (isset($_SESSION["mySession"]) && ($_SESSION["mySession"] == "admin" || $_SESSION["mySession"] == "admin@gmail.com"));
            if ($notLoginCond):
            ?>

            <div class="comment-section">
                <a href="login" style="font-size: 30px; margin: 10px 0">
                    Please login as a member first to leave a comment!
                </a>
            </div>
            <?php else: ?>
            <div class="comment-section" id="comment-section">
                <div style="font-size: 30px">
                    Leave a comment!
                </div>
                <?php endif; ?>

                <?php if (!$notLoginCond): ?>
                <div class="comment-frame">
                    <div class="comment-avatar"><img src="<?php echo $userModel->getUserById($userID)["Avatar"]; ?>"
                            alt="avatar"></div>

                    <form method="post" onsubmit="return confirmSend()" style="width: 100%">
                        <textarea name="comment" placeholder="Add a comment" required></textarea>
                        <hr>
                        <input type="submit" value="Send" class="send-button">
                    </form>


                </div>
                <?php else: ?>
                <?php endif; ?>

                <?php
                while ($comment = $comments->fetch_assoc()) {
                    $date = substr($comment["CreatedAt"], 0, 10);
                    $subComments = $this->commentModel->getAllByParentID($comment["CommentID"]);
                    $subCommentsTotal = $subComments->num_rows; ?>
                <!-- hiển thị comment cha
                    khi ấn vào icon reply thì comments con và khung trả lời comment được hiện ra
                    ấn vào icon reply 1 lần nữa thì ẩn đi -->
                <div class='comment-frame' id='comment-<?php echo $comment["CommentID"] ?>'>
                    <div class='displayed-comment-avatar'><img src='<?php echo $comment["Avatar"] ?>' alt=''></div>
                    <div class='displayed-comment'>
                        <div class='comment-info'>
                            <div class='account-name'><?php echo $comment["Username"] ?></div>
                            <div class='comment-date'><?php echo $date ?></div>
                        </div>
                        <div class='comment-content'><?php echo htmlspecialchars($comment["Content"]) ?></div>
                        <?php if (!$notLoginCond) { ?>
                        <div class='comment-action'>
                            <div onclick='viewRespondsToggle(<?php echo $comment["CommentID"] ?>)'
                                style='cursor: pointer' class='viewRespondsButton'><i class='far fa-comment-alt'></i>
                                <span><?php echo $subCommentsTotal ?></span>
                            </div>
                            <?php if ($comment["UserID"] == $userID) { ?>
                            <i class='far fa-trash-alt deleteComment' style='cursor: pointer'
                                onclick='confirmDelete(<?php echo $comment["CommentID"] ?>)'></i>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>

                <?php
                    if (!$notLoginCond) {
                    ?>
                <div class='responds-for <?php echo $comment["CommentID"] ?>'>
                    <?php
                    }
                        ?>

                    <!-- hiển thị CÁC comments con -->
                    <?php while ($subComment = $subComments->fetch_assoc()) {
                            $subCommentDate = substr($subComment["CreatedAt"], 0, 10); ?>
                    <div class='comment-frame'
                        style='margin-left: 60px; <?php echo $notLoginCond ? "margin-top: 3px" : "" ?>'
                        id='comment-<?php echo $subComment["CommentID"] ?>'>
                        <div class='displayed-comment-avatar'><img src='<?php echo $comment["Avatar"] ?>' alt=''></div>
                        <div class='displayed-comment'>
                            <div class='comment-info'>
                                <div class='account-name'><?php echo $subComment["Username"] ?></div>
                                <div class='comment-date'><?php echo $subCommentDate ?></div>
                            </div>
                            <div class='comment-content'>
                                <?php echo htmlspecialchars($subComment["Content"]) ?>
                            </div>
                            <?php if (!$notLoginCond && $subComment["UserID"] == $userID) { ?>
                            <div class='comment-action'>
                                <i class='far fa-trash-alt deleteComment' style='cursor: pointer'
                                    onclick='confirmDelete(<?php echo $subComment["CommentID"] ?>, <?php echo $comment["CommentID"] ?>)'></i>
                            </div>
                            <?php } ?>

                        </div>
                    </div>
                    <?php } ?>

                    <?php if (!$notLoginCond) { ?>
                    <div class="comment-frame">
                        <form method="post" onsubmit="return confirmSend()" style="width: 100%; margin-left: 64px">
                            <textarea name="comment" placeholder="Add a respond" required></textarea>
                            <input type='hidden' name='parentID' value='<?php echo $comment["CommentID"] ?>'>
                            <hr>
                            <input type="submit" value="Send" class="send-button">
                        </form>
                    </div>
                    <?php } ?>
                    <?php
                        if (!$notLoginCond) {
                        ?>
                </div>
                <?php
                        }
                    ?>

                <?php } ?>

            </div>
        </div>
    </div>
</body>

</html>

<script>
function confirmSend() {
    return confirm("Send this comment?");
}

function confirmDelete(commentID, parentID) {
    if (confirm("Delete this comment?")) {
        params = `&deletingCommentID=${commentID}`;
        if (parentID != undefined) {
            params += `&parentID=${parentID}`;
        }
        window.location.href += params;
    }
}
</script>

<script>
function viewRespondsToggle(commentID) {
    var elem = document.getElementsByClassName(`responds-for ${commentID}`)[0];
    if (!elem) return;

    if (elem.classList.contains("show")) {
        // Đang mở, thì đóng lại
        elem.style.maxHeight = "0";
        elem.classList.remove("show");
    } else {
        // Đang đóng, thì mở ra
        elem.style.maxHeight = elem.scrollHeight + "px";
        elem.classList.add("show");
    }
}
</script>