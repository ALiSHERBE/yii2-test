<?php

namespace app\modules\admin\controllers;

use app\models\Brand;
use app\models\Car;
use app\models\Option;
use app\models\Photo;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
    	$cars = Car::find()->count();
    	$brands = Brand::find()->where(['depth' => 1])->count();
    	$models = Brand::find()->where(['depth' => 2])->count();
	    $options = Option::find()->where(['not', ['parent_id' => null]])->count();
    	$photos = Photo::find()->count();

    	$items = [
    		'Машин' => $cars,
    		'Марок' => $brands,
    		'Моделей' => $models,
    		'Опций' => $options,
    		'Фотографий' => $photos,
	    ];

	    return $this->render('index', [
		    'items' => $items,
	    ]);
    }
}
