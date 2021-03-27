<?php

// Inialize session
session_start();

// Delete all session variables
session_destroy();

// Jump to login page
header('Location: ../../web/login?type=business');

?>