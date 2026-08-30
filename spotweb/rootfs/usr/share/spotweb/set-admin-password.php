<?php

/*
 * Sets the password of Spotweb's admin account.
 *
 * Spotweb creates that account with a well-known default password and offers
 * no console command to change it; bin/upgrade-db.php can only reset it to
 * another fixed value. This uses the very same service the rest of Spotweb
 * uses, so the password ends up hashed exactly as the web interface expects.
 *
 * The password is read from the environment rather than from an argument, so
 * it does not sit in the process list while this runs.
 */

require_once '/var/www/spotweb/vendor/autoload.php';

$password = getenv('SPOTWEB_ADMIN_PASSWORD');

if ($password === false || $password === '') {
    fwrite(STDERR, 'No password provided'.PHP_EOL);

    exit(1);
}

$bootstrap = new Bootstrap();
$daoFactory = $bootstrap->getDaoFactory();
$settings = $bootstrap->getSettings($daoFactory, false);

$svcUpgradeUsers = new Services_Upgrade_Users($daoFactory, $settings);
$svcUpgradeUsers->resetUserPassword('admin', $password);
