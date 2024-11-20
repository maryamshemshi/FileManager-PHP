<?php

if (isset($_REQUEST['address'])) {
    $current_dir = $_REQUEST['address'];
} else {
    $current_dir = __DIR__ . '/../files';
}