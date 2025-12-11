<?php
session_start();
session_unset();
session_destroy();
header("Location: https://github.com/25s17/progect-11-19");
exit();