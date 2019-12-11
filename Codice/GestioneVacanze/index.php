<?php

/**
 * Load the config file.
 */
require 'application/config/config.php';

/**
 * Load the class application.
 */
require 'application/libs/application.php';


/**
 * Start the session.
 */
session_start();

/**
 * Start the application.
 */
$app = new Application();

