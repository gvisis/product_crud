<?php
function randomString($n) {
  $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $str = '';
  for ($i = 0; $i < $n; $i++) {
    $index = rand(0,strlen($chars) - 1);
    $str .= $chars[$index];
  }
  return $str;
}
?>