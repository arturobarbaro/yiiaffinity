<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Nuevo papel';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin() ?>
    <?= $form->field($papel, 'papel') ?>
        <?= Html::submitButton('Insertar un nuevo papel', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Cancelar', ['papeles/index'], ['class' => 'btn btn-danger']) ?>
    </div>
<?php ActiveForm::end() ?>
