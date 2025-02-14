<?php
require_once '../database/Database.php';
require_once '../routes/api.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
handleRoutes();
