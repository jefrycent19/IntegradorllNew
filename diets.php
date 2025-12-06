<?php
require __DIR__ . '/db.php';
include __DIR__ . '/header.php';

$pdo = db();
$rows = $pdo->query("SELECT * FROM diets ORDER BY id DESC")->fetchAll();
?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Dietas</h3>
  <a class="btn btn-primary btn-ink" href="diet_form.php">Nueva Dieta</a>
</div>

<div class="card reveal hover-lift">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-dark table-striped align-middle">
        <thead><tr>
          <th>#</th><th>Nombre</th><th>Meta kcal/día</th><th>Notas</th><th>Acciones</th>
        </tr></thead>
        <tbody>
        <?php if(!$rows): ?>
          <tr><td colspan="5" class="text-center text-secondary">No hay dietas</td></tr>
        <?php else: foreach($rows as $r): ?>
          <tr>
            <td><?= (int)$r['id'] ?></td>
            <td><?= h($r['name']) ?></td>
            <td><?= number_format($r['calories_target'],0) ?></td>
            <td><?= h($r['notes']) ?></td>
            <td class="d-flex gap-2">
              <a class="btn btn-sm btn-warning btn-ink" href="diet_form.php?id=<?= (int)$r['id'] ?>">Editar</a>
              <a class="btn btn-sm btn-danger btn-ink" href="diet_delete.php?id=<?= (int)$r['id'] ?>" onclick="return confirm('¿Eliminar esta dieta? También eliminará sus comidas.');">Eliminar</a>
              <a class="btn btn-sm btn-info btn-ink" href="meals.php?diet_id=<?= (int)$r['id'] ?>">Comidas</a>
            </td>
          </tr>
        <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>
