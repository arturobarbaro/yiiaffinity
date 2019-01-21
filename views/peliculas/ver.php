<?php
use app\models\Participaciones;

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
<?php foreach ($pelicula->articipaciones as $participacion): ?>
    <dl class="">
        <dt>Nombre</dt>
        <dd><?= ?></dd>
    </dl>.
<?php endforeach ?>


<?php $form = ActiveForm::begin(['enableClientValidation' => false]) ?>
    <?= $form->field($pelicula, 'titulo', $inputOptions) ?>
    <?= $form->field($pelicula, 'anyo', $inputOptions) ?>
    <?= $form->field($pelicula, 'duracion', $inputOptions) ?>
    <?= $form->field($pelicula, 'genero_id', $inputOptions) ?>
    <div class="form-group">
        <?= Html::a('Volver', ['peliculas/index'], ['class' => 'btn btn-danger']) ?>
    </div>
<?php ActiveForm::end() ?>
