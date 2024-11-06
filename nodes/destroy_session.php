<?php
session_start();
session_unset();
session_destroy();
header("Location: LANDING_PAGE/index.php");
exit();
?>
