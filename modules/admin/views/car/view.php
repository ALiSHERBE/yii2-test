<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Car */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Cars', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

?>
<div class="row">
    <div class="col-md-12">
        <p>
		    <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		    <?= Html::a('Delete', ['delete', 'id' => $model->id], [
			    'class' => 'btn btn-danger',
			    'data' => [
				    'confirm' => 'Are you sure you want to delete this item?',
				    'method' => 'post',
			    ],
		    ]) ?>
        </p>
    </div>
    <div class="col-md-6">
        <?= Html::img($model->lgImage, ['alt' => 'изображение', 'class'=>'img-responsive lg-images']) ?>
        <div class="row">
            <?foreach($model->smImage as $value):?>
                <div class="col-md-6">
	                <?= Html::img($value, ['alt' => 'изображение', 'class'=>'img-responsive sm-images']) ?>
                </div>
	        <?endforeach;?>
        </div>
    </div>
    <div class="col-md-6">
        <table class="table table-striped table-bordered">
            <tbody>
                <tr>
                    <td>Id</td>
                    <td><?= $model->id ?></td>
                </tr>
                <tr>
                    <td>Создан</td>
                    <td><?= $model->created_at ?></td>
                </tr>
                <tr>
                    <td>Цена</td>
                    <td><?= $model->price ?></td>
                </tr>
                <tr>
                    <td>Телефон</td>
                    <td><?= $model->phone ?></td>
                </tr>
                <tr>
                    <td>Пробег</td>
                    <td><?= $model->mileage ?></td>
                </tr>
                <tr>
                    <td>Марка</td>
                    <td><?= $model->brand->title ?></td>
                </tr>
                <tr>
                    <td>Модель</td>
                    <td><?= $model->model->title ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>