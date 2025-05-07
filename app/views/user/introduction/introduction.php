<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>

    <link rel="stylesheet" href="app/views/user/introduction/introduction.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <div class="custom-container">
        <h1>OUR STORY</h1>
        <div id="customCarousel" class="carousel slide custom-carousel" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php if (!empty($branches)): ?>
                <?php $firstBranch = true; ?>
                <?php foreach ($branches as $branch): ?>
                <div class="carousel-item <?php if ($firstBranch) echo 'active'; ?>">
                    <div class="carousel-card">
                        <div class="carousel-description">
                            <h3><?php echo htmlspecialchars($branch['location']); ?></h3>
                            <p><?php echo htmlspecialchars($branch['description']); ?></p>
                        </div>
                        <div class="carousel-image">
                            <img src="<?php echo htmlspecialchars($branch['image']); ?>"
                                alt="<?php echo htmlspecialchars($branch['location']); ?>">
                        </div>
                    </div>
                </div>
                <?php $firstBranch = false; ?>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="carousel-item active">
                    <div class="carousel-card">
                        <div class="carousel-description">
                            <h3>Chưa có thông tin</h3>
                            <p>Hiện tại chưa có thông tin về các chi nhánh.</p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#customCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#customCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <div class="service-container">
        <h1>SPECIAL SERVICE</h1>
        <p>What Special services we are offering now</p>

        <div id="serviceCarousel" class="carousel slide custom-carousel" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php if (!empty($specialServices)): ?>
                <?php $firstService = true; ?>
                <?php foreach ($specialServices as $service): ?>
                <div class="carousel-item <?php if ($firstService) echo 'active'; ?>">
                    <div class="carousel-card">
                        <div class="carousel-description">
                            <h3><?php echo htmlspecialchars($service['title']); ?></h3>
                            <p><?php echo htmlspecialchars($service['description']); ?></p>
                        </div>
                    </div>
                </div>
                <?php $firstService = false; ?>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="carousel-item active">
                    <div class="carousel-card">
                        <div class="carousel-description">
                            <h3>Chưa có dịch vụ đặc biệt</h3>
                            <p>Hiện tại chưa có dịch vụ đặc biệt nào.</p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#serviceCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#serviceCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <div class="team-container">
        <h1>OUR TEAM</h1>
        <P>The Hardworking Team behind the restaurant</P>

        <div id="teamCarousel" class="carousel slide custom-carousel" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php if (!empty($members)): ?>
                <?php $firstMemberSlide = true; ?>
                <?php $memberCount = 0; ?>
                <?php $totalMembers = count($members); // Lấy tổng số thành viên 
                    ?>
                <?php foreach ($members as $index => $member): ?> <?php if ($memberCount % 3 == 0): ?>
                <div class="carousel-item <?php if ($firstMemberSlide) echo 'active'; ?>">
                    <div class="d-flex justify-content-center gap-3">
                        <?php endif; ?>
                        <div class="card">
                            <div class="card-content">
                                <h3 class="card-title"><?php echo htmlspecialchars($member['name']); ?></h3>
                                <p class="card-text"><?php echo htmlspecialchars($member['position']); ?></p>
                                <p class="card-text"><?php echo htmlspecialchars($member['description']); ?></p>
                                <?php if (isset($_SESSION['mySession']) && ($_SESSION['mySession'] == 'admin' || $_SESSION['mySession'] == 'admin@gmail.com')): ?>
                                <div class="button-container">
                                    <a href="/admin/members/edit/<?php echo htmlspecialchars($member['ID']); ?>"
                                        class="btn btn-primary" style="margin-right: 7.5px;">Sửa</a>
                                    <a href="/admin/members/delete/<?php echo htmlspecialchars($member['ID']); ?>"
                                        class="btn btn-danger" style="margin-right: 7.5px;">Xóa</a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php $memberCount++; ?>
                        <?php // Thay thế $loop->last bằng việc kiểm tra chỉ số
                                if ($memberCount % 3 == 0 || ($index + 1) == $totalMembers): ?>
                    </div>
                </div>
                <?php $firstMemberSlide = false; ?>
                <?php endif; ?>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="carousel-item active">
                    <div class="d-flex justify-content-center">
                        <div class="card">
                            <div class="card-content">
                                <h3 class="card-title">Chưa có thành viên</h3>
                                <p class="card-text">Hiện tại chưa có thành viên nào được thêm vào.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#teamCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#teamCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html> 