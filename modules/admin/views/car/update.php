<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Car */
/* @var $photo app\models\Photo */
/* @var $photos app\models\Photo */
/* @var $countPhotos string */

$this->title = 'Update Car: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cars', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="car-update">

    <h1><?= Html::encode($this->title) ?></h1>

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'mileage')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

	<?= ($countPhotos == 1 || $countPhotos == 2) ? $form->field($photo, 'file[]')
        ->fileInput(['multiple' => true, 'accept' => 'image/*']) : '' ?>

    <div class="form-group">
		<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

	<?php ActiveForm::end(); ?>

</div>

<h2>Images</h2>
<div class="col-md-6 col-md-offset-3">
    <div class="well">
        <div class="row">
            <?foreach($photos as $code => $value):?>
                <div class="col-xs-4 <?= ($model->main_photo_id == $value->id) ? 'checked' : ''?>">
                    <?= Html::img('/'.$value->getSmFolder().$value->file,
                        ['alt' => 'Наш логотип', 'class'=>'img-responsive img-radio']) ?>
                    <?= Html::a('Главная', ['/admin/car/main', 'id' => $model->id, 'image' => $value->id],
                        ['class' => 'btn btn-primary btn-radio']) ?>
                    <?= Html::a('Удалить', ['/admin/photo/delete-photo', 'id' => $value->id, 'car' => $model->id],
                        ['class' => 'btn btn-primary btn-radio']) ?>
                </div>
            <?endforeach;?>
        </div>
    </div>
</div>