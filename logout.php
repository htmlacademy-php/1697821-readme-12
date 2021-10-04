<?php

require_once("init.php");
unset($_SESSION['isAuth'], $_SESSION['userLogin'], $_SESSION['userEmail'], $_SESSION['avatarUrl'], $_SESSION['id']);
header("Location: /");
