<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location:./login.php");
    exit;
}
require_once('./DBConnection.php');
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucwords(str_replace('_',' ',$page)) ?> | Messaging Web Application</title>
    <link rel="stylesheet" href="./fontawesome/css/all.min.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/custom.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./fontawesome/js/all.min.js"></script>
</head>

<body class="bg-light">
    <main>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-gradient" id="topNavBar">
            <div class="container">
                <a class="navbar-brand" href="./">Messaging Web Application</a>
                <div>
                    <?php if(isset($_SESSION['id'])): ?>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle bg-transparent text-light border-0"
                                    type="button" id="dropdownMenuButton1" 
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="me-1">
                                    <img src="<?php echo is_file('./uploads/avatars/'.$_SESSION['id'].'.png') ? './uploads/avatars/'.$_SESSION['id'].'.png?v='.(is_null($_SESSION['date_updated']) ? strtotime($_SESSION['date_created']) : strtotime($_SESSION['date_updated'])) : './images/no-image-available.png' ?>" alt="avatar" class="avatar rounded-circle">
                                </span> Hello <?php echo $_SESSION['firstname'] ?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="./?page=profile">My Profile</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#rulesModal">Rules</a></li>
                                <li><a class="dropdown-item" href="./Actions.php?a=logout">Logout</a></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </nav>

    <div class="container py-3" id="page-container">
            <?php 
                if(isset($_SESSION['flashdata'])):
            ?>
            <div class="dynamic_alert alert alert-<?php echo $_SESSION['flashdata']['type'] ?>">
                <div class="float-end">
                    <a href="javascript:void(0)" class="text-dark text-decoration-none" onclick="$(this).closest('.dynamic_alert').hide('slow').remove()">x</a>
                </div>
                <?php echo $_SESSION['flashdata']['msg'] ?>
            </div>
            <?php unset($_SESSION['flashdata']) ?>
            <?php endif; ?>
            
            <?php
                include $page.'.php';
            ?>
        </div>
    </main>
    <!-- Rules Modal -->
    <div class="modal fade" id="rulesModal" tabindex="-1" aria-labelledby="rulesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rulesModalLabel">Rules</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Add your rules content here -->
                    <p>1. Users are expected to communicate respectfully and considerately with each other. Any form of offensive, discriminatory, or disrespectful language is strictly prohibited.
                        2. Users must refrain from sending or sharing any content that is explicit, offensive, or inappropriate. This includes but is not limited to images, text, or any media that could be considered offensive or harmful.
                        3. Create a supportive atmosphere by offering assistance and guidance to users with disabilities. Foster inclusivity and avoid any behavior that may make others feel uncomfortable or unwelcome.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uni_modal" role='dialog' data-bs-backdrop="static" data-bs-keyboard="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header py-2">
            <h5 class="modal-title"></h5>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer py-1">
            <button type="button" class="btn btn-sm rounded-0 btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
            <button type="button" class="btn btn-sm rounded-0 btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
        </div>
    </div>
    <div class="modal fade" id="uni_modal_secondary" role='dialog' data-bs-backdrop="static" data-bs-keyboard="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header py-2">
            <h5 class="modal-title"></h5>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer py-1">
            <button type="button" class="btn btn-sm rounded-0 btn-primary" id='submit' onclick="$('#uni_modal_secondary form').submit()">Save</button>
            <button type="button" class="btn btn-sm rounded-0 btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
        </div>
    </div>
    <div class="modal fade" id="confirm_modal" role='dialog'>
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header py-2">
            <h5 class="modal-title">Confirmation</h5>
        </div>
        <div class="modal-body">
            <div id="delete_content"></div>
        </div>
        <div class="modal-footer py-1">
            <button type="button" class="btn btn-primary btn-sm rounded-0" id='confirm' onclick="">Continue</button>
            <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
        </div>
    </div>
</body>
</html>