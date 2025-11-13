<?php
require __DIR__ . '/db.php';
include __DIR__ . '/header.php';

$pdo = db();
$totalDietas = (int)$pdo->query("SELECT COUNT(*) FROM diets")->fetchColumn();
$totalComidas = (int)$pdo->query("SELECT COUNT(*) FROM meals")->fetchColumn();
$totCal = (float)$pdo->query("SELECT COALESCE(SUM(calories),0) FROM meals")->fetchColumn();
$promCal = (float)$pdo->query("SELECT COALESCE(AVG(calories),0) FROM meals")->fetchColumn();
$metaProm = (float)$pdo->query("SELECT COALESCE(AVG(calories_target),0) FROM diets")->fetchColumn();
$ultimas = $pdo->query("
  SELECT m.id, m.meal_date, m.meal_type, m.description, m.calories, d.name AS diet
  FROM meals m JOIN diets d ON d.id = m.diet_id
  ORDER BY m.meal_date DESC, m.id DESC
  LIMIT 8
")->fetchAll();
?>
<div class="row g-3">
  <div class="col-md-3"><div class="card kpi lift rise">
    <div class="left"><div class="label">Dietas</div><div class="value"><?= $totalDietas ?></div></div>
    <div class="emoji">🥗</div></div></div>
  <div class="col-md-3"><div class="card kpi lift rise">
    <div class="left"><div class="label">Comidas</div><div class="value"><?= $totalComidas ?></div></div>
    <div class="emoji">🍽️</div></div></div>
  <div class="col-md-3"><div class="card kpi lift rise">
    <div class="left"><div class="label">Calorías totales</div><div class="value"><?= number_format($totCal,0) ?></div></div>
    <div class="emoji">🔥</div></div></div>
  <div class="col-md-3"><div class="card kpi lift rise">
    <div class="left"><div class="label">Promedio vs Meta</div><div class="value"><?= number_format($promCal,0) ?> / <?= number_format($metaProm,0) ?></div></div>
    <div class="emoji">📊</div></div></div>
</div>

<div class="card card-ghost reveal mt-4">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h5 class="fw-bold mb-0">Últimas comidas registradas</h5>
        <div class="muted">Entradas recientes</div>
      </div>
      <a class="btn btn-sm btn-primary" href="diets.php">Gestionar Dietas</a>
    </div>
    <div class="divider"></div>
    <div class="table-responsive">
      <table class="table table-dark table-striped align-middle">
        <thead><tr><th>Fecha</th><th>Tipo</th><th>Descripción</th><th>Calorías</th><th>Dieta</th></tr></thead>
        <tbody>
        <?php if (!$ultimas): ?>
          <tr><td colspan="5" class="text-center muted">Sin registros</td></tr>
        <?php else: foreach($ultimas as $r): ?>
          <tr>
            <td><?= h($r['meal_date']) ?></td>
            <td><?= h($r['meal_type']) ?></td>
            <td><?= h($r['description']) ?></td>
            <td><?= number_format($r['calories'],0) ?></td>
            <td><?= h($r['diet']) ?></td>
          </tr>
        <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php include __DIR__ . '/footer.php'; ?>
