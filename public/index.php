<?php
/*
 *---------------------------------------------------------------
 * LOAD COMPOSER AUTOLOADER AND DOTENV
 *---------------------------------------------------------------
 */
require_once __DIR__ . '/../vendor/autoload.php';
var_dump(class_exists('Dotenv\Dotenv')); // should output true
// Load environment variables using phpdotenv
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->safeLoad(); // safeLoad avoids fatal errors if some variables are missing
}

/*
 *---------------------------------------------------------------
 * TEMPORARY DEBUG BLOCK (REMOVE IN PRODUCTION)
 *---------------------------------------------------------------
 */
echo "INDEX IS RUNNING!<br>";
echo "ENV: " . ($_ENV['CI_ENVIRONMENT'] ?? 'not found') . "<br>";
echo "DB HOST: " . ($_ENV['database.default.hostname'] ?? 'not found') . "<br>";

echo "<pre>";
var_dump($_ENV); // TEMP: dump all environment vars
echo "</pre>";

// Comment out exit if you want CI4 to continue booting
// exit;

/*
 *---------------------------------------------------------------
 * CHECK PHP VERSION
 *---------------------------------------------------------------
 */
$minPhpVersion = '8.1'; // Minimum PHP version for CI4
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    header('HTTP/1.1 503 Service Unavailable.', true, 503);
    echo sprintf(
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPhpVersion,
        PHP_VERSION
    );
    exit(1);
}

/*
 *---------------------------------------------------------------
 * SET THE CURRENT DIRECTORY
 *---------------------------------------------------------------
 */
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

/*
 *---------------------------------------------------------------
 * BOOTSTRAP CODEIGNITER
 *---------------------------------------------------------------
 */
require FCPATH . '../app/Config/Paths.php';
$paths = new Config\Paths();

require $paths->systemDirectory . '/Boot.php';

exit(CodeIgniter\Boot::bootWeb($paths));
