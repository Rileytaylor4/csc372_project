<?php
session_start();
session_destroy();

header("Location: appointment.php");
exit();