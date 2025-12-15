<?php
include '../includes/header.php';
session_start();
session_unset();
session_destroy();

header("Location: login.php");
exit;

include '../includes/footer.php';
