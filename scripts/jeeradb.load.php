<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

$application->bootstrap();
$db = $application->getBootstrap()->getResource('db');

$schema = file_get_contents('jeeradb.schema.sql');
$db->exec($schema);

$table = new Jeera_Model_DbTable_Users($db);

$now = date('Y-m-d H:i:s');

$hash = new Jeera_PasswordHash(8);

$users = array(
    array(
        'username' => 'jeremy.kendall',
        'passwordHash' => $hash->hashPassword('admin'),
        'userRole' => 'admin',
        'firstName' => 'Jeremy',
        'lastName' => 'Kendall',
        'department' => 'IT',
        'created' => $now,
        'updated' => $now
    ),
    array(
        'username' => 'david.haskins',
        'passwordHash' => $hash->hashPassword('admin'),
        'userRole' => 'admin',
        'firstName' => 'David',
        'lastName' => 'Haskins',
        'department' => 'IT',
        'created' => $now,
        'updated' => $now
    ),
    array(
        'username' => 'eddie.baker',
        'passwordHash' => $hash->hashPassword('admin'),
        'userRole' => 'admin',
        'firstName' => 'Eddie',
        'lastName' => 'Baker',
        'department' => 'IT',
        'created' => $now,
        'updated' => $now
    ),
    array(
        'username' => 'tom.user',
        'passwordHash' => $hash->hashPassword('password'),
        'userRole' => 'user',
        'firstName' => 'Tom',
        'lastName' => 'User',
        'department' => 'Accounting',
        'created' => $now,
        'updated' => $now
    ),
    array(
        'username' => 'dick.user',
        'passwordHash' => $hash->hashPassword('password'),
        'userRole' => 'user',
        'firstName' => 'Dick',
        'lastName' => 'User',
        'department' => 'HR',
        'created' => $now,
        'updated' => $now
    ),
    array(
        'username' => 'harry.user',
        'passwordHash' => $hash->hashPassword('password'),
        'userRole' => 'user',
        'firstName' => 'Harry',
        'lastName' => 'User',
        'department' => 'Marketing',
        'created' => $now,
        'updated' => $now
    )
    
);

foreach ($users as $user) {
    $table->insert($user);
}
