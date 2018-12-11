<?php
use yii\helpers\Html;

$this->title = 'Ver película';
$this->params['breadcrumbs'][] = ['label' => 'Películas', 'url' => ['peliculas/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<table class="table">
        <tr>
            <td align="right"><strong>Titulo</strong></td>
            <td><?= Html::encode($pelicula['titulo']) ?></td>
        </tr>
        <tr>
            <td align="right"><strong>Año</strong></td>
            <td><?= Html::encode($pelicula['anyo']) ?></td>
        </tr>
        <tr>
            <td align="right"><strong>Duracion</strong></td>
            <td><?= Html::encode($pelicula['duracion']) ?></td>
        </tr>
        <tr>
            <td align="right"><strong>Participantes</strong></td>
            <td>
                <?php foreach ($participantes as $participante): ?>
                    <? Html::encode($participante['nombre']) . '(' .
                     Html::encode($participante['rol']) . ')' ?>
                     <br>
                <?php endforeach ?>
            </td>
        </tr>
</table>
