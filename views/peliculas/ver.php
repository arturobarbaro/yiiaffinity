<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Ver una película';
$this->params['breadcrumbs'][] = $this->title;
$inputOptions = [
    'inputOptions' => [
        'class' => 'form-control',
        'readonly' => true,
    ],
];
?>
<?php foreach ($pelicula->participaciones as $participacion): ?>
    <dl class="dl-horizontal">
        <dt><?= $participacion->papel->papel ?></dt>
        <dd><?= $participacion->persona->nombre ?></dd>
    </dl>
<?php endforeach ?>
<dl class="dl-horizontal">
    <dt>Titulo</dt>
    <dd><?= $pelicula->titulo ?></dd>
</dl>
<dl class="dl-horizontal">
    <dt>Año</dt>
    <dd><?= $pelicula->anyo ?></dd>
</dl>
<dl class="dl-horizontal">
    <dt>Duracion</dt>
    <dd><?= $pelicula->duracion ?></dd>
</dl>
<dl class="dl-horizontal">
    <dt>Genero</dt>
    <dd><?= $pelicula->genero_id ?></dd>
</dl>
