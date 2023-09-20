<?php
$idlePeriod = 1800; // 30 min

if (isset($_COOKIE[session_name()])) {
  $expireTime = time() + $idlePeriod;
  setcookie(session_name(), $_COOKIE[session_name()], $expireTime, "/");
}

session_start();
?>