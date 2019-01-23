<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Modificar un papel';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin() ?>
    <?= $form->field($papel, 'papel') ?>
    <div class="form-group">
        <?= Html::submitButton('Modificar papel', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Cancelar', ['papeles/index'], ['class' => 'btn btn-danger']) ?>
    </div>
<?php ActiveForm::end() ?>
