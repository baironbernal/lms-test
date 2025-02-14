<?php
require_once '../database/Database.php';
require_once '../routes/api.php';

header("Content-Type: application/json");
handleRoutes();
