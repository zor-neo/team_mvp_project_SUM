<?php
require_once __DIR__ . '/includes/auth.php';
logout_user();
flash('You have been logged out.');
redirect_to('index.php');

