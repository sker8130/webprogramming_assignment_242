<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ</title>
    
    <link rel="stylesheet" href="app/views/user/faq/faq.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="team-container">
        <h1>FAQ</h1>
        <P>Questions you may find helpful</P>

        <div id="teamCarousel" class="carousel slide custom-carousel" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php if (!empty($faq)): ?>
                    <?php $firstQuestion = true; ?>
                    <?php $questionCount = 0; ?>
                    <?php $totalQuestions = count($faq); // Lấy tổng số câu hỏi
                         ?>
                    <?php foreach ($faq as $index => $member): ?> <?php if ($questionCount % 3 == 0): ?>
                            <div class="carousel-item <?php if ($firstQuestion) echo 'active'; ?>">
                                <div class="d-flex justify-content-center gap-3">
                                    <?php endif; ?>
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="card-image-container">
                                                <?php if (($questionCount % 3) == 0): ?>
                                                    <img src="app/views/user/faq/images/1.svg" alt="Question Icon">
                                                <?php elseif (($questionCount % 3) == 1): ?>
                                                    <img src="app/views/user/faq/images/2.svg" alt="Question Icon">
                                                <?php elseif (($questionCount % 3) == 2): ?>
                                                    <img src="app/views/user/faq/images/3.svg" alt="Question Icon">
                                                <?php endif; ?>
                                            </div>
                                            <h3 class="card-title"><?php echo htmlspecialchars($member['ID']); ?></h3>
                                            <p class="card-text" style="color: #cc3333; font-weight: bold;"><?php echo htmlspecialchars($member['question']); ?></p>
                                            <p class="card-text" style="text-align: left"><?php echo htmlspecialchars($member['answer']); ?></p>
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
                                    <?php $questionCount++; ?>
                                    <?php // Thay thế $loop->last bằng việc kiểm tra chỉ số
                                          if ($questionCount % 3 == 0 || ($index + 1) == $totalQuestions): ?>
                                </div>
                            </div>
                            <?php $firstQuestion = false; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <div class="carousel-item active">
                        <div class="d-flex justify-content-center">
                            <div class="card">
                                <div class="card-content">
                                    <h3 class="card-title">No FAQs available</h3>
                                    <p class="card-text">There are currently no frequently asked questions.</p>
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