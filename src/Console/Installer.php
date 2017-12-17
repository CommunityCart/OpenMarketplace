<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     3.0.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Console;

if (!defined('STDIN')) {
    define('STDIN', fopen('php://stdin', 'r'));
}

require_once(__DIR__ . '/../../vendor/autoload.php');

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;
use Cake\Utility\Security;
use Composer\Script\Event;
use Exception;
use Cake\Console\ShellDispatcher;
use Cake\Core\Configure;
use Cake\Core\Plugin;
/**
 * Provides installation hooks for when this application is installed via
 * composer. Customize this class to suit your needs.
 */
class Installer
{

    /**
     * An array of directories to be made writable
     */
    const WRITABLE_DIRS = [
        'logs',
        'tmp',
        'tmp/cache',
        'tmp/cache/models',
        'tmp/cache/persistent',
        'tmp/cache/views',
        'tmp/sessions',
        'tmp/tests'
    ];

    /**
     * Does some routine installation tasks so people don't have to.
     *
     * @param \Composer\Script\Event $event The composer event object.
     * @throws \Exception Exception raised by validator.
     * @return void
     */
    public static function postInstall(Event $event)
    {
        require_once(__DIR__ . '/../../config/bootstrap.php');

        $io = $event->getIO();

        $rootDir = dirname(dirname(__DIR__));

        $validator = function ($arg) {
            if (in_array($arg, ['Y', 'y', 'N', 'n'])) {
                return $arg;
            }
            throw new Exception('This is not a valid answer. Please choose Y or n.');
        };

        static::createAppConfig($rootDir, $io);
        static::createWritableDirectories($rootDir, $io);
        static::createAdminLTESymLinks($event);
        static::setFolderPermissions($rootDir, $io);
        static::setSecuritySalt($rootDir, $io);
        static::setDatabaseDetails($rootDir, $io);

        $shell = new Shell();
        $shell->dispatchShell([
            'command' => 'migrations migrate',
            'extra' => []
        ]);

        foreach (Plugin::loaded() as $plugin) {

            if ($plugin != 'DebugKit') {

                $shell->dispatchShell([
                    'command' => 'migrations migrate --plugin ' . $plugin,
                    'extra' => []
                ]);
            }
        }

        $shell->dispatchShell([
            'command' => 'users addSuperuser',
            'extra' => []
        ]);

        if (class_exists('\Cake\Codeception\Console\Installer')) {
            \Cake\Codeception\Console\Installer::customizeCodeceptionBinary($event);
        }
    }

    /**
     * Create the config/app.php file if it does not exist.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @return void
     */
    public static function createAppConfig($dir, $io)
    {
        $appConfig = $dir . '/config/app.php';
        $defaultConfig = $dir . '/config/app.default.php';
        if (!file_exists($appConfig)) {
            copy($defaultConfig, $appConfig);
            $io->write('Created `config/app.php` file');
        }
    }

    /**
     * Create the `logs` and `tmp` directories.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @return void
     */
    public static function createWritableDirectories($dir, $io)
    {
        foreach (static::WRITABLE_DIRS as $path) {
            $path = $dir . '/' . $path;
            if (!file_exists($path)) {
                mkdir($path);
                $io->write('Created `' . $path . '` directory');
            }
        }
    }

    /**
     * Set globally writable permissions on the "tmp" and "logs" directory.
     *
     * This is not the most secure default, but it gets people up and running quickly.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @return void
     */
    public static function setFolderPermissions($dir, $io)
    {
        // Change the permissions on a path and output the results.
        $changePerms = function ($path, $perms, $io) {
            // Get permission bits from stat(2) result.
            $currentPerms = fileperms($path) & 0777;
            if (($currentPerms & $perms) == $perms) {
                return;
            }

            $res = chmod($path, $currentPerms | $perms);
            if ($res) {
                $io->write('Permissions set on ' . $path);
            } else {
                $io->write('Failed to set permissions on ' . $path);
            }
        };

        $walker = function ($dir, $perms, $io) use (&$walker, $changePerms) {
            $files = array_diff(scandir($dir), ['.', '..']);
            foreach ($files as $file) {
                $path = $dir . '/' . $file;

                if (!is_dir($path)) {
                    continue;
                }

                $changePerms($path, $perms, $io);
                $walker($path, $perms, $io);
            }
        };

        $worldWritable = bindec('0000000111');
        $walker($dir . '/tmp', $worldWritable, $io);
        $changePerms($dir . '/tmp', $worldWritable, $io);
        $changePerms($dir . '/logs', $worldWritable, $io);
    }

    /**
     * Set the security.salt value in the application's config file.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @return void
     */
    public static function setSecuritySalt($dir, $io)
    {
        $newKey = hash('sha256', Security::randomBytes(64));
        static::setSecuritySaltInFile($dir, $io, $newKey, 'app.php');
    }

    /**
     * Set the security.salt value in a given file
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @param string $newKey key to set in the file
     * @param string $file A path to a file relative to the application's root
     * @return void
     */
    public static function setSecuritySaltInFile($dir, $io, $newKey, $file)
    {
        $config = $dir . '/config/' . $file;
        $content = file_get_contents($config);

        $content = str_replace('__SALT__', $newKey, $content, $count);

        if ($count == 0) {
            $io->write('No Security.salt placeholder to replace.');

            return;
        }

        $result = file_put_contents($config, $content);
        if ($result) {
            $io->write('Updated Security.salt value in config/' . $file);

            return;
        }
        $io->write('Unable to update Security.salt value.');
    }

    /**
     * Set the APP_NAME value in a given file
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @param string $appName app name to set in the file
     * @param string $file A path to a file relative to the application's root
     * @return void
     */
    public static function setAppNameInFile($dir, $io, $appName, $file)
    {
        $config = $dir . '/config/' . $file;
        $content = file_get_contents($config);
        $content = str_replace('__APP_NAME__', $appName, $content, $count);

        if ($count == 0) {
            $io->write('No __APP_NAME__ placeholder to replace.');

            return;
        }

        $result = file_put_contents($config, $content);
        if ($result) {
            $io->write('Updated __APP_NAME__ value in config/' . $file);

            return;
        }
        $io->write('Unable to update __APP_NAME__ value.');
    }

    public static function setDatabaseDetails($dir, $io)
    {
        static::setDatabaseHost($dir, $io);
        static::setDatabasePort($dir, $io);
        static::setDatabaseName($dir, $io);
        static::setDatabaseUsername($dir, $io);
        static::setDatabasePassword($dir, $io);
    }

    /**
     *
     * Set the database details in the application's config file.
     *
     * @param string $dir The application's root directory.
     * @param \Composer\IO\IOInterface $io IO interface to write to console.
     * @return void
     */
    public static function setDatabaseName($dir, $io)
    {
        $config = $dir . '/config/app.php';
        $content = file_get_contents($config);

        $databaseName = readline('Enter the database name: ');

        $content = str_replace("'database' => 'my_app',", "'database' => '" . $databaseName . "',", $content, $count);

        if ($count == 0) {
            $io->write('No database placeholder to replace.');

            return;
        }

        $result = file_put_contents($config, $content);
        if ($result) {
            $io->write('Updated database value in config/app.php');

            return;
        }
        $io->write('Unable to update database value.');
    }

    public static function setDatabasePort($dir, $io)
    {
        $config = $dir . '/config/app.php';
        $content = file_get_contents($config);

        $databasePort = readline('Enter the database port: ');

        if($databasePort == '') {

            $databasePort = 3306;
        }

        $content = str_replace("//'port' => 'non_standard_port_number',", "'port' => '" . $databasePort . "',", $content, $count);

        if ($count == 0) {
            $io->write('No database port placeholder to replace.');

            return;
        }

        $result = file_put_contents($config, $content);
        if ($result) {
            $io->write('Updated database port value in config/app.php');

            return;
        }
        $io->write('Unable to update database port value.');
    }

    public static function setDatabaseUsername($dir, $io)
    {
        $config = $dir . '/config/app.php';
        $content = file_get_contents($config);

        $databaseUsername = readline('Enter the database username: ');

        $content = str_replace("'username' => 'my_app',", "'username' => '" . $databaseUsername . "',", $content, $count);

        if ($count == 0) {
            $io->write('No database username placeholder to replace.');

            return;
        }

        $result = file_put_contents($config, $content);
        if ($result) {
            $io->write('Updated database username value in config/app.php');

            return;
        }
        $io->write('Unable to update database username value.');
    }

    public static function setDatabasePassword($dir, $io)
    {
        $config = $dir . '/config/app.php';
        $content = file_get_contents($config);

        $databasePass = readline('Enter the database user password: ');

        $content = str_replace("'password' => 'secret',", "'password' => '" . $databasePass . "',", $content, $count);

        if ($count == 0) {
            $io->write('No database password placeholder to replace.');

            return;
        }

        $result = file_put_contents($config, $content);
        if ($result) {
            $io->write('Updated database password value in config/app.php');

            return;
        }
        $io->write('Unable to update password database value.');
    }


    public static function setDatabaseHost($dir, $io)
    {
        $config = $dir . '/config/app.php';
        $content = file_get_contents($config);

        $databaseHost = readline('Enter the database host: ');

        if($databaseHost == '') {

            $databaseHost = '127.0.0.1';
        }

        $content = str_replace("'host' => 'localhost',", "'host' => '" . $databaseHost . "',", $content, $count);

        if ($count == 0) {
            $io->write('No database host placeholder to replace.');

            return;
        }

        $result = file_put_contents($config, $content);
        if ($result) {
            $io->write('Updated database host value in config/app.php');

            return;
        }
        $io->write('Unable to update host database value.');
    }

    public static function createAdminLTESymLinks(Event $event)
    {
        $io = $event->getIO();

        $rootDir = dirname(dirname(__DIR__));

        $io->write('Installing AdminLTE vendor SymLinks to Webroot');

        try {
            symlink($rootDir . '/vendor/almasaeed2010/adminlte/bootstrap', $rootDir . '/webroot/bootstrap');
            $io->write('Created Symlink: ' . $rootDir . '/webroot/bootstrap');

            symlink($rootDir . '/vendor/almasaeed2010/adminlte/dist', $rootDir . '/webroot/dist');
            $io->write('Created Symlink: ' . $rootDir . '/webroot/dist');

            symlink($rootDir . '/vendor/almasaeed2010/adminlte/documentation', $rootDir . '/webroot/documentation');
            $io->write('Created Symlink: ' . $rootDir . '/webroot/documentation');

            symlink($rootDir . '/vendor/almasaeed2010/adminlte/pages', $rootDir . '/webroot/pages');
            $io->write('Created Symlink: ' . $rootDir . '/webroot/pages');

            symlink($rootDir . '/vendor/almasaeed2010/adminlte/plugins', $rootDir . '/webroot/plugins');
            $io->write('Created Symlink: ' . $rootDir . '/webroot/plugins');
        }
        catch(Exception $ex)
        {

        }
        return 0;
    }
}
