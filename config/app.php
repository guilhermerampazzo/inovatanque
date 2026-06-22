<?php

define('APP_NAME', 'Inova Tanque');
define('APP_URL', getenv('APP_URL') ?: ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost')));
define('APP_ROOT', dirname(__DIR__));

define('WHATSAPP_PRINCIPAL', '5519974060706');
define('WHATSAPP_CONSIGNACAO', '5519974162357');
define('EMAIL_CONTATO', 'contato@inovatanque.com.br');
define('EMAIL_CONSIGNACAO', 'renato@inovatanque.com.br');
define('TELEFONE', '(19) 97406-0706');

define('FACEBOOK_URL', 'https://facebook.com/inovatanque');
define('INSTAGRAM_URL', 'https://instagram.com/inovatanque');
define('LINKEDIN_URL', 'https://linkedin.com/company/inovatanque');

define('ITEMS_PER_PAGE', 12);
