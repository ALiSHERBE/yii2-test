<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */

$this->title = 'Cars';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <p>
		    <?= Html::a('Create Car', ['create'], ['class' => 'btn btn-success btn-block']) ?>
        </p>

		<?php foreach($cars as $car):?>
            <div class="panel panel-default">
                <div class="panel-heading">
	                <?= Html::a(
		                $car->brand->title . $car->model->title,
		                ['car/view', 'id' => $car->id]) ?>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="well">
                                    <h4>Фото</h4>
	                            <?= Html::a(
		                            Html::img($car->image, ['alt' => 'изображение', 'class'=>'item-image']),
		                            ['car/view', 'id' => $car->id]) ?>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="well">
                                        <h4>Марка</h4>
                                        <p><?= $car->brand->title?></p>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="well">
                                        <h4>Модель</h4>
                                        <p><?= $car->model->title?></p>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="well">
                                        <h4>Цена</h4>
                                        <p><?= $car->price?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
	                                <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                                        ['/admin/car/view', 'id' => $car->id],
                                        ['class' => 'btn btn-primary btn-block']) ?>
                                </div>
                                <div class="col-sm-4">
	                                <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>',
		                                ['/admin/car/update', 'id' => $car->id],
		                                ['class' => 'btn btn-warning btn-block']) ?>
                                </div>
                                <div class="col-sm-4">
	                                <?= Html::a('<span class="glyphicon glyphicon-trash"></span>',
		                                ['/admin/car/delete', 'id' => $car->id],
		                                [
                                            'class' => 'btn btn-danger btn-block',
                                            'title'=> 'Delete',
                                            'data-confirm'=> 'Are you sure you want to delete this item?',
                                            'data-method'=> 'post',
                                        ]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php endforeach; ?>

		<?=
            LinkPager::widget([
                'pagination' => $pagination,
            ]);
		?>
    </div>
</div>

