<?php
session_start();
require_once(__DIR__ . '/security.php');
Security::logout();
