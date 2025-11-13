<?php
require __DIR__ . '/db.php';
include __DIR__ . '/header.php';
$pdo = db();
$diet_id = isset($_GET['diet_id']) ? (int)$_GET['diet_id'] : 0;
if (!$diet_id){ echo '<div class="alert alert-danger">Parámetro diet_id requerido.</div>'; include 'footer.php'; exit; }
$diet = $pdo->prepare("SELECT * FROM diets WHERE id=?"); $diet->execute([$diet_id]); $diet = $diet->fetch();
if(!$diet){ echo '<div class="alert alert-danger">Dieta no encontrada.</div>'; include 'footer.php'; exit; }
$rows = $pdo->prepare("SELECT * FROM meals WHERE diet_id=? ORDER BY meal_date DESC, id DESC"); $rows->execute([$diet_id]); $rows=$rows->fetchAll();
$sum = $pdo->prepare("SELECT COALESCE(SUM(calories),0) AS total FROM meals WHERE diet_id=?"); $sum->execute([$diet_id]); $sum=(float)$sum->fetchColumn();
?>
<div class="d-flex justify-content-between align-items-center mb-2">
  <div>
    <h3 class="fw-bold mb-0">Comidas: <?= h($diet['name']) ?></h3>
    <div class="muted">Meta: <?= number_format($diet['calories_target'],0) ?> kcal/día</div>
  </div>
  <div class="d-flex gap-2">
    <a class="btn btn-secondary" href="diets.php">Volver</a>
    <a class="btn btn-primary" href="meal_form.php?diet_id=<?= (int)$diet_id ?>">Nueva Comida</a>
  </div>
</div>
<div class="divider"></div>

<div class="card rise lift mb-3">
  <div class="card-body">
    <div><strong>Calorías registradas:</strong> <?= number_format($sum,0) ?> kcal</div>
    <div class="<?= $sum > $diet['calories_target'] ? 'text-danger' : 'text-success' ?>">
      <?= $sum > $diet['calories_target'] ? '⚠️ Sobrepasaste la meta.' : '✅ Dentro de la meta.' ?>
    </div>
  </div>
</div>

<div class="card reveal lift">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-dark table-striped align-middle">
        <thead><tr><th>Fecha</th><th>Tipo</th><th>Descripción</th><th>Calorías</th><th>Acciones</th></tr></thead>
        <tbody>
        <?php if(!$rows): ?>
          <tr><td colspan="5" class="text-center muted">No hay comidas</td></tr>
        <?php else: foreach($rows as $r): ?>
          <tr>
            <td><?= h($r['meal_date']) ?></td>
            <td><?= h($r['meal_type']) ?></td>
            <td><?= h($r['description']) ?></td>
            <td><?= number_format($r['calories'],0) ?></td>
            <td class="d-flex gap-2">
              <a class="btn btn-sm btn-warning" href="meal_form.php?diet_id=<?= (int)$diet_id ?>&id=<?= (int)$r['id'] ?>">Editar</a>
              <a class="btn btn-sm btn-danger" href="meal_delete.php?diet_id=<?= (int)$diet_id ?>&id=<?= (int)$r['id'] ?>" onclick="return confirm('¿Eliminar esta comida?');">Eliminar</a>
            </td>
          </tr>
        <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php include __DIR__ . '/footer.php'; ?>

