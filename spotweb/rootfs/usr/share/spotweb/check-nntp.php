<?php

/*
 * Reports whether a usenet server has been configured in Spotweb.
 *
 * Spotweb stores this in its own database, and it is set from Spotweb's
 * settings page rather than from this app's configuration. retrieve.php does
 * not fail in any way a caller can detect when it is missing: it prints a
 * stack trace and still exits 0. So the retrieval service asks this first,
 * to keep that trace out of the log until there is a server to talk to.
 *
 * Exits 0 when a server is configured, and 1 when it is not.
 */

require_once '/var/www/spotweb/vendor/autoload.php';

try {
    $bootstrap = new Bootstrap();
    $daoFactory = $bootstrap->getDaoFactory();
    $settings = $bootstrap->getSettings($daoFactory, false);

    $server = $settings->get('nntp_hdr');
    $configured = is_array($server) && !empty($server['host']);
} catch (Throwable $exception) {
    $configured = false;
}

exit($configured ? 0 : 1);
