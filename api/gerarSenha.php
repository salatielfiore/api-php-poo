<?php
include_once "../biblioteca/password_compact/password.php";
echo password_hash("123456", PASSWORD_DEFAULT);