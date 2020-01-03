<?php
if (!isset($_SESSION['CREATED']) && isset($_SESSION['ID'])) {
    $_SESSION['CREATED'] = time();
} else if (time() - $_SESSION['CREATED'] > 1800) {
    // session started more than 30 minutes ago
    // change session ID for the current session and invalidate old session ID
    session_regenerate_id(true);
    // update creation time
    $_SESSION['CREATED'] = time();
}