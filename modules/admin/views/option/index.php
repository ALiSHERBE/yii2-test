<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OptionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Options';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">

    <p>
        <?= Html::a('Create Option', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

	    <?php foreach($options as $option):?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-6">
		                        <?= Html::a(
			                        $option->title,
			                        ['option/view', 'id' => $option->id]) ?>
                            </div>
                            <div class="col-sm-6">
                                <span class="label label-primary"><?php echo $option->parent->title?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="col-sm-4">
		                    <?= Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
			                    ['/admin/option/view', 'id' => $option->id],
			                    ['class' => 'btn btn-primary btn-block']) ?>
                        </div>
                        <div class="col-sm-4">
		                    <?= Html::a('<span class="glyphicon glyphicon-pencil"></span>',
			                    ['/admin/option/update', 'id' => $option->id],
			                    ['class' => 'btn btn-warning btn-block']) ?>
                        </div>
                        <div class="col-sm-4">
		                    <?= Html::a('<span class="glyphicon glyphicon-trash"></span>',
			                    ['/admin/option/delete', 'id' => $option->id],
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
	    <?php endforeach; ?>

	    <?=
	    LinkPager::widget([
		    'pagination' => $pagination,
	    ]);
	    ?>

    </div>
</div>
