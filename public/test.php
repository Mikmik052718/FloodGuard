<?php
// public/test.php

// Force error display for this page (in case php.ini overrides it)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Show PHP info to confirm everything works
echo "<h1>PHP Info</h1>";
phpinfo();

// Trigger a deliberate error to verify 500 errors now display details
echo "<h2>Triggering a sample error:</h2>";
undefined_function_call();
