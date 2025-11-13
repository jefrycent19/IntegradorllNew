<?php
require __DIR__ . '/db.php';
$pdo = db();
$diet_id = isset($_GET['diet_id']) ? (int)$_GET['diet_id'] : 0;
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id && $diet_id) {
  $pdo->prepare("DELETE FROM meals WHERE id=? AND diet_id=?")->execute([$id,$diet_id]);
}
header("Location: meals.php?diet_id=".$diet_id);
