<?php
session_start();

//nếu session hết hạn nhưng cookie còn -> đặt lại session
//nếu k có session or có mà session khác admin -> header tới login
require_once "app/models/UserModel.php";
require_once "app/models/TokenModel.php";
require_once "app/models/ContactModel.php"; 

$userModel = new UserModel();
$tokenModel = new TokenModel();
$contactModel = new ContactModel(); 

if (!isset($_SESSION["mySession"]) && isset($_COOKIE["usernameEmail"])) {
    $token = $_COOKIE["usernameEmail"];
    if ($tokenModel->checkTokenExists($token)) {
        $user = $userModel->getUserByToken($token);
        if ($user) {
            $_SESSION["mySession"] = $user["Username"];
        }
    }
}
if (!isset($_SESSION["mySession"]) || (isset($_SESSION["mySession"]) && ($_SESSION["mySession"] != "admin" && $_SESSION["mySession"] != "admin@gmail.com"))) {
    header("Location: /webprogramming_assignment_242/");
}


if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $contactId = isset($_GET['id']) ? intval($_GET['id']) : 0;
    
    if ($action === 'delete' && $contactId > 0) {
      
        $contactModel->deleteContact($contactId);
        $_SESSION["success_message"] = "Contact deleted successfully!";
        header("Location: /webprogramming_assignment_242/admin/contact.php");
        exit;
    } else if ($action === 'mark' && $contactId > 0 && isset($_GET['status'])) {
    
        $status = $_GET['status'];
        $contactModel->updateContactStatus($contactId, $status);
        $_SESSION["success_message"] = "Contact marked as " . $status . "!";
        header("Location: /webprogramming_assignment_242/admin/contact.php");
        exit;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reply_submit'])) {
    $contactId = isset($_POST['contact_id']) ? intval($_POST['contact_id']) : 0;
    $reply = isset($_POST['reply_message']) ? trim($_POST['reply_message']) : '';
    
    if ($contactId > 0 && !empty($reply)) {
       
        $contactModel->replyToContact($contactId, $reply);
        $contactModel->updateContactStatus($contactId, 'Responded');
        $_SESSION["success_message"] = "Reply sent successfully!";
        header("Location: /webprogramming_assignment_242/admin/contact.php");
        exit;
    }
}


$statusFilter = isset($_GET['filter_status']) ? $_GET['filter_status'] : '';
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';


$contacts = $contactModel->getContacts($statusFilter, $searchTerm);

if (isset($_SESSION["success_message"])) {
    echo '<script>alert("' . $_SESSION['success_message'] . '");</script>';
    unset($_SESSION['success_message']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Management - Mazer Admin Dashboard</title>

    <base href="/webprogramming_assignment_242/">
    <!-- bắt buộc phải có dòng này -->

    <link rel="shortcut icon" href="assets/compiled/svg/favicon.svg" type="image/x-icon" />

    <link rel="stylesheet" href="assets/extensions/simple-datatables/style.css" />
    <link rel="stylesheet" href="assets/compiled/css/table-datatable.css" />
    <link rel="stylesheet" href="assets/compiled/css/app.css" />
    <link rel="stylesheet" href="assets/compiled/css/app-dark.css" />
   
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
        <?php
            require_once "assets/components/admin/sidebar.php"
        ?>

        <div id="main">
            <?php
                require_once "assets/components/admin/header.php"
            ?>

            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Contact Management</h3>
                            <p class="text-subtitle text-muted">Manage customer inquiries and messages</p>
                        </div>
                    </div>
                </div>

                <section class="section">
                   
                    <div class="card">
                        <div class="card-header">
                            <h4>Filter Options</h4>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="/webprogramming_assignment_242/admin/contact.php" class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="filter_status">Status:</label>
                                    <select name="filter_status" id="filter_status" class="form-select">
                                        <option value="">All</option>
                                        <option value="Unread" <?php echo $statusFilter === 'Unread' ? 'selected' : ''; ?>>Unread</option>
                                        <option value="Read" <?php echo $statusFilter === 'Read' ? 'selected' : ''; ?>>Read</option>
                                        <option value="Responded" <?php echo $statusFilter === 'Responded' ? 'selected' : ''; ?>>Responded</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="search">Search:</label>
                                    <input type="text" name="search" id="search" class="form-control" placeholder="Search by name or email" value="<?php echo htmlspecialchars($searchTerm); ?>">
                                </div>
                                <div class="col-md-2 mb-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                                </div>
                            </form>
                        </div>
                    </div>

                   
                    <div class="card">
                        <div class="card-header">
                            <h4>Contact Messages</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered" id="contactsTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Message</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($contacts)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No contacts found</td>
                                    </tr>
                                    <?php else: ?>
                                        <?php foreach ($contacts as $contact): ?>
                                        <tr class="<?php echo $contact['Status'] === 'Unread' ? 'table-primary' : ''; ?>">
                                            <td><?php echo htmlspecialchars($contact['ContactID']); ?></td>
                                            <td><?php echo htmlspecialchars($contact['Name']); ?></td>
                                            <td><?php echo htmlspecialchars($contact['Email']); ?></td>
                                            <td><?php echo nl2br(htmlspecialchars(substr($contact['Message'], 0, 100) . (strlen($contact['Message']) > 100 ? '...' : ''))); ?></td>
                                            <td>
                                                <span class="badge bg-<?php
                                                    switch($contact['Status']) {
                                                        case 'Unread': echo 'primary'; break;
                                                        case 'Read': echo 'info'; break;
                                                        case 'Responded': echo 'success'; break;
                                                        default: echo 'secondary';
                                                    }
                                                ?>">
                                                    <?php echo htmlspecialchars($contact['Status'] ?: 'Unread'); ?>
                                                </span>
                                            </td>
                                            <td><?php echo htmlspecialchars($contact['CreatedAt']); ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $contact['ContactID']; ?>">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#replyModal<?php echo $contact['ContactID']; ?>">
                                                        <i class="bi bi-reply"></i>
                                                    </button>
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-sm btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-tag"></i>
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="/webprogramming_assignment_242/admin/contact.php?action=mark&id=<?php echo $contact['ContactID']; ?>&status=Unread">Mark as Unread</a></li>
                                                            <li><a class="dropdown-item" href="/webprogramming_assignment_242/admin/contact.php?action=mark&id=<?php echo $contact['ContactID']; ?>&status=Read">Mark as Read</a></li>
                                                            <li><a class="dropdown-item" href="/webprogramming_assignment_242/admin/contact.php?action=mark&id=<?php echo $contact['ContactID']; ?>&status=Responded">Mark as Responded</a></li>
                                                        </ul>
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteConfirm(<?php echo $contact['ContactID']; ?>)">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                       
                                        <div class="modal fade" id="viewModal<?php echo $contact['ContactID']; ?>" tabindex="-1" aria-labelledby="viewModalLabel<?php echo $contact['ContactID']; ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="viewModalLabel<?php echo $contact['ContactID']; ?>">View Contact #<?php echo $contact['ContactID']; ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <strong>Name:</strong> <?php echo htmlspecialchars($contact['Name']); ?>
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>Email:</strong> <?php echo htmlspecialchars($contact['Email']); ?>
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>Status:</strong> <?php echo htmlspecialchars($contact['Status'] ?: 'Unread'); ?>
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>Created At:</strong> <?php echo htmlspecialchars($contact['CreatedAt']); ?>
                                                        </div>
                                                        <div class="mb-3">
                                                            <strong>Message:</strong>
                                                            <p class="mt-2 p-2 bg-light"><?php echo nl2br(htmlspecialchars($contact['Message'])); ?></p>
                                                        </div>
                                                        <?php if (isset($contact['Reply']) && !empty($contact['Reply'])): ?>
                                                        <div class="mb-3">
                                                            <strong>Your Reply:</strong>
                                                            <p class="mt-2 p-2 bg-light"><?php echo nl2br(htmlspecialchars($contact['Reply'])); ?></p>
                                                        </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <?php if ($contact['Status'] !== 'Read'): ?>
                                                        <a href="/webprogramming_assignment_242/admin/contact.php?action=mark&id=<?php echo $contact['ContactID']; ?>&status=Read" class="btn btn-info">Mark as Read</a>
                                                        <?php endif; ?>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                     
                                        <div class="modal fade" id="replyModal<?php echo $contact['ContactID']; ?>" tabindex="-1" aria-labelledby="replyModalLabel<?php echo $contact['ContactID']; ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="replyModalLabel<?php echo $contact['ContactID']; ?>">Reply to <?php echo htmlspecialchars($contact['Name']); ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form method="POST" action="/webprogramming_assignment_242/admin/contact.php">
                                                        <div class="modal-body">
                                                            <input type="hidden" name="contact_id" value="<?php echo $contact['ContactID']; ?>">
                                                            <div class="mb-3">
                                                                <label for="original_message<?php echo $contact['ContactID']; ?>">Original Message:</label>
                                                                <div class="p-2 bg-light"><?php echo nl2br(htmlspecialchars($contact['Message'])); ?></div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="reply_message<?php echo $contact['ContactID']; ?>" class="form-label">Your Reply:</label>
                                                                <textarea class="form-control" id="reply_message<?php echo $contact['ContactID']; ?>" name="reply_message" rows="5" required><?php echo isset($contact['Reply']) ? htmlspecialchars($contact['Reply']) : ''; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" name="reply_submit" class="btn btn-primary">Send Reply</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2023 &copy; Mazer</p>
                    </div>
                    <div class="float-end">
                        <p>
                            Crafted with
                            <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                            by <a href="https://saugi.me">Saugi</a>
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="assets/static/js/components/dark.js"></script>
    <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/compiled/js/app.js"></script>
    <script src="assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
    <script src="assets/static/js/pages/simple-datatables.js"></script> 

    <script>
    function deleteConfirm(id) {
        if (confirm(`Delete this contact with ID = ${id}?`)) {
            window.location.href = `/webprogramming_assignment_242/admin/contact.php?action=delete&id=${id}`;
        }
    }
    
  
    document.addEventListener('DOMContentLoaded', function() {
        new simpleDatatables.DataTable("#contactsTable", {
            perPage: 10,
            searchable: false, 
            paging: true,
            sortable: true
        });
    });
    </script>
</body>
</html>