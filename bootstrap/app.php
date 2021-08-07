<?php

const __ROOT__ = '../';
const __CORE__ = '../core/';

// Get main config
$config = require_once '../config/app.php';

// Libraries
require_once __CORE__ . '/lib/SystemFunctions.php';

// Connecting the required classes
require_once __CORE__ . 'exceptions/SystemException.php';
require_once __CORE__ . 'database/Connection.php';

Connection::make($config);

echo 'Готово';
