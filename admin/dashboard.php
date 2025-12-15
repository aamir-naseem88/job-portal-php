<?php
include '../includes/header.php'; 
require '../includes/auth.php';
checkRole('admin');

echo "Admin Dashboard";

include '../includes/footer.php';