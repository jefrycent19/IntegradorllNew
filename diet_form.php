<?php
require __DIR__ . '/db.php';
include __DIR__ . '/header.php';
$pdo = db();
$diet_id = isset($_GET['diet_id']) ? (int)$_GET['diet_id'] : 0;
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$diet = $pdo->prepare("SELECT * FROM diets WHERE id=?"); $diet->execute([$diet_id]); $diet = $diet->fetch();
if(!$diet){ echo '<div class="alert alert-danger">Dieta no encontrada.</div>'; include 'footer.php'; exit; }

$errors = []; $meal_date = date('Y-m-d'); $meal_type='Desayuno'; $description=''; $calories='';

if ($id) {
  $stmt=$pdo->prepare("SELECT * FROM meals WHERE id=? AND diet_id=?"); $stmt->execute([$id,$diet_id]); $row=$stmt->fetch();
  if(!$row){ echo '<div class="alert alert-danger">Comida no encontrada.</div>'; include 'footer.php'; exit; }
  $meal_date=$row['meal_date']; $meal_type=$row['meal_type']; $description=$row['description']; $calories=(string)$row['calories'];
}
if ($_SERVER['REQUEST_METHOD']==='POST'){
  $meal_date=trim($_POST['meal_date']??''); $meal_type=trim($_POST['meal_type']??''); $description=trim($_POST['description']??''); $calories=trim($_POST['calories']??'');
  if($meal_date==='') $errors[]="La fecha es requerida.";
  if($meal_type==='') $errors[]="El tipo es requerido.";
  if($calories==='' || !is_numeric($calories) || $calories<=0) $errors[]="Calorías debe ser un número positivo.";
  if(!$errors){
    if($id){
      $stmt=$pdo->prepare("UPDATE meals SET meal_date=?, meal_type=?, description=?, calories=? WHERE id=? AND diet_id=?");
      $stmt->execute([$meal_date,$meal_type,$description,$calories,$id,$diet_id]);
    } else {
      $stmt=$pdo->prepare("INSERT INTO meals (diet_id, meal_date, meal_type, description, calories) VALUES (?,?,?,?,?)");
      $stmt->execute([$diet_id,$meal_date,$meal_type,$description,$calories]);
    }
    header("Location: meals.php?diet_id=".$diet_id); exit;
  }
}
?>
<div class="card rise lift">
  <div class="card-body">
    <h4 class="fw-bold mb-3"><?= $id ? 'Editar Comida' : 'Nueva Comida' ?></h4>
    <?php if ($errors): ?><div class="alert alert-danger"><ul class="mb-0"><?php foreach($errors as $e): ?><li><?= h($e) ?></li><?php endforeach; ?></ul></div><?php endif; ?>

    <form method="post" novalidate>
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Fecha</label>
          <input type="date" class="form-control" name="meal_date" value="<?= h($meal_date) ?>" required>
        </div>
        <div class="col-md-4">
          <label class="form-label">Tipo</label>
          <select class="form-select" name="meal_type" required>
            <?php $tipos=['Desayuno','Almuerzo','Cena','Snack'];
              foreach($tipos as $t){ $sel=$t===$meal_type?'selected':''; echo "<option value='".h($t)."' $sel>".h($t)."</option>"; } ?>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">Calorías</label>
          <input type="number" class="form-control" name="calories" min="1" step="1" value="<?= h($calories) ?>" required>
        </div>
        <div class="col-12">
          <label class="form-label">Descripción</label>
          <input type="text" class="form-control" name="description" value="<?= h($description) ?>" placeholder="Ej: Arroz con pollo, 1 taza">
        </div>
      </div>
      <div class="mt-3 d-flex gap-2">
        <button class="btn btn-primary" type="submit">Guardar</button>
        <a class="btn btn-secondary" href="meals.php?diet_id=<?= (int)$diet_id ?>">Cancelar</a>
      </div>
    </form>
  </div>
</div>
<?php include __DIR__ . '/footer.php'; ?>


