<?php
use yii\helpers\Html;
$this->title = 'Listado de papeles';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1>Listado de papeles</h1>
<table class="table table-striped">
    <thead>
        <th>Nombre</th>
        <th>Acciones</th>
    </thead>
    <tbody>
        <?php foreach ($papeles as $papel): ?>
            <tr>
                <td><?= Html::encode($papel->papel) ?></td>
                <td>
                    <?= Html::a('Modificar', ['papeles/update', 'id' => $papel->id], ['class' => 'btn-xs btn-info']) ?>
                    <?= Html::a('Borrar', ['papeles/delete', 'id' => $papel->id], [
                        'class' => 'btn-xs btn-danger',
                        'data-confirm' => '¿Seguro que desea borrar?',
                        'data-method' => 'POST',
                    ]) ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<div class="row">
    <div class="text-center">
        <?= Html::a('Insertar papel', ['papeles/create'], ['class' => 'btn btn-info']) ?>
    </div>
</div>
