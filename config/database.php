<?php

define('DB_HOST', $_SERVER['DB_HOST'] ?? getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', $_SERVER['DB_NAME'] ?? getenv('DB_NAME') ?: 'inovatanque');
define('DB_USER', $_SERVER['DB_USER'] ?? getenv('DB_USER') ?: 'root');
define('DB_PASS', $_SERVER['DB_PASS'] ?? getenv('DB_PASS') ?: '');
define('DB_CHARSET', 'utf8mb4');
