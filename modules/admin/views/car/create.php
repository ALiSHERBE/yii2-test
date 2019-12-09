<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Car */
/* @var $photo app\models\Photo */
/* @var $brands app\models\Brand */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Create Car';
$this->params['breadcrumbs'][] = ['label' => 'Cars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$paramsBrand = [
	'prompt' => 'Выберите марку...'
];
$paramsModel = [
	'prompt' => 'Выберите модель...'
];
?>
<div class="car-create">

    <div class="car-form">

		<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'brand_id', ['inputOptions' => ['id' => 'select-brand', 'class'=>'form-control']])
			->dropDownList(ArrayHelper::map($brands, 'id', 'title'), $paramsBrand) ?>

		<?= $form->field($model, 'model_id', ['inputOptions' => ['id' => 'select-model', 'class'=>'form-control']])
			->dropDownList([], $paramsModel) ?>

		<?= $form->field($model, 'mileage')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

		<?= $form->field($photo, 'file[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>

        <div class="form-group">
			<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

		<?php ActiveForm::end(); ?>

    </div>
</div>
