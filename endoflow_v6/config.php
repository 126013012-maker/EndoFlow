<?php
/**
 * EndoFlow v4.0 — Application Configuration
 */
define('APP_NAME',    'EndoFlow');
define('APP_VERSION', '4.0.0');
define('APP_TAGLINE', 'Clinical Decision Support — Endocrinology');
define('GUIDELINE_SOURCE', 'Endocrine Society Clinical Practice Guidelines (JCEM, Various Years)');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
