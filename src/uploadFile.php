<?php
require_once './config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_FILES['files']) || $_FILES['files']['error'] != UPLOAD_ERR_OK) {
        echo "Please put your file in the box!";
    } else {
        $path = $current_dir . '/' . basename($_FILES["files"]["name"]);
        move_uploaded_file($_FILES['files']['tmp_name'], $path);
        die('wp your file uploaded');
    }
}
