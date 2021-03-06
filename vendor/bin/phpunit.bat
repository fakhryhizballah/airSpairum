@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../phpunit/phpunit/phpunit
php "%BIN_TARGET%" %*
n <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

if (!version_compare(PHP_VERSION, PHP_VERSION, '=')) {
    fwrite(
        STDERR,
        sprintf(
            '%s declares an invalid value for PHP_VERSION.' . PHP_EOL .
            'This breaks fundamental functionality such as version_compare().' . PHP_EOL .
            'Please use a different PHP interpreter.' . PHP_EOL,

            PHP_BINARY
        )
    );

    die(1);
}

if (version_compare('7.2.0', PHP_VERSION, '>')) {
    fwrite(
        STDERR,
        sprintf(
            'This version of PHPUnit requires PHP >= 7.2.' . PHP_EOL .
            'You are using PHP %s (%s).' . PHP_EOL,
            PHP_VERSION,
            PHP_BINARY
        )
    );

    die(1);
}

if (!ini_get('date.timezone')) {
    ini_set('date.timezone', 'UTC');
}

foreach (array(__DIR__ . '/../../autoload.php', __DIR__ . '/../vendor/autoload.php', __DIR__ . '/vendor/autoload.php') as $file) {
    if (file_exists($file)) {
        define('PHPUNIT_COMPOSER_INSTALL', $file);

        break;
    }
}

unset($file);

if (!defined('PHPUNIT_COMPOSER_INSTALL')) {
    fwrite(
        STDERR,
        'You need to set up the project dependencies using Composer:' . PHP_EOL . PHP_EOL .
        '    composer install' . PHP_EOL . PHP_EOL .
        'You can learn all about Composer on https://getcomposer.org/.' . PHP_EOL
    );

    die(1);
}

$options = getopt('', array('prepend:'));

if (isset($options['prepend'])) {
    require $options['prepend'];
}

unset($options);

require PHPUNIT_COMPOSER_INSTALL;

PHPUnit\TextUI\Command::main();
