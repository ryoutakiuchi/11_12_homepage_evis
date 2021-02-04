<?php

require 'common.php';
$pdo = connect();
$st = $pdo->query("SELECT * FROM goods");
$goods = $st->fetchAll();
// var_dump($goods);
// exit();
require 't_index.php';
