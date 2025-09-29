<?php
/*
 *---------------------------------------------------------------
 * LOAD COMPOSER AUTOLOADER AND DOTENV
 *---------------------------------------------------------------
 */
require_once __DIR__ . '/../vendor/autoload.php';

// Load environment variables using phpdotenv safely
if (class_exists('Dotenv\Dotenv') && file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->safeLoad(); // safeLoad avoids fatal errors if some variables are missing
}

/*
 *---------------------------------------------------------------
 * OPTIONAL DEBUG (disable in production)
 *---------------------------------------------------------------
 */
if (($_ENV['CI_ENVIRONMENT'] ?? 'development') === 'development') {
    echo "INDEX IS RUNNING!<br>";
    echo "ENV: " . ($_ENV['CI_ENVIRONMENT'] ?? 'not found') . "<br>";
    echo "DB HOST: " . ($_ENV['database.default.hostname'] ?? 'not found') . "<br>";

    echo "<pre>";
    var_dump($_ENV);
    echo "</pre>";
}

/*
 *---------------------------------------------------------------
 * CHECK PHP VERSION
 *---------------------------------------------------------------
 */
$minPhpVersion = '8.1';
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    header('HTTP/1.1 503 Service Unavailable', true, 503);
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
