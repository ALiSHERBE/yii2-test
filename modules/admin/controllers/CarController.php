<?php

namespace app\modules\admin\controllers;

use app\models\Brand;
use app\models\Option;
use app\models\Photo;
use Yii;
use app\models\Car;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CarController implements the CRUD actions for Car model.
 */
class CarController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Car models.
     * @return mixed
     */
    public function actionIndex()
    {
        $cars = Car::getAll(5);

        return $this->render('index', [
	        'cars'          => $cars['cars'],
	        'pagination'    => $cars['pagination'],
        ]);
    }

    /**
     * Displays a single Car model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $model = Car::findOne($id),
        ]);
    }

    /**
     * Creates a new Car model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Car();
        $photo = new Photo();
        $options = Option::tree();
	    $photo->scenario = 'add';
	    $brands = Brand::findOne(['id' => '1'])->children(1)->all();
	    $transaction = Yii::$app->db->beginTransaction();

	    if ($model->load(Yii::$app->request->post()) && $model->save()) {
	    	$selectOptions = Yii::$app->request->post('options');
		    $model->saveOptions($selectOptions);
	        $photo->file = UploadedFile::getInstances($photo, 'file');

	        try  {
		        if ($photo->upload($model->photos, $model->id)) {
			        $transaction->commit();
		        } else {
			        $transaction->rollBack();
		        }
	        } catch (Exception $e) {
		        $transaction->rollBack();
	        }

		    //return $this->redirect(['view', 'id' => $model->id]);
		    return $this->redirect(['index']);
        }
        
        return $this->render('create', [
            'model' => $model,
            'photo' => $photo,
            'brands' => $brands,
            'options' => $options,
        ]);
    }

    /**
     * Updates an existing Car model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
	    $photos = Photo::find()->where(['car_id' => $id])->all();
	    $countPhotos = count($photos);
	    $options = Option::tree();
	    $selectedOptions = $model->getSelectedOption();

	    $photo = new Photo();
	    $photo->scenario = "".$countPhotos;
	    $transaction = Yii::$app->db->beginTransaction();

	    $brands = Brand::findOne(['id' => '1'])->children(1)->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

	        $selectOptions = Yii::$app->request->post('options');
	        $model->saveOptions($selectOptions);

	        $photo->file = UploadedFile::getInstances($photo, 'file');

	        try  {
		        if ($photo->upload($model->photos, $model->id)) {
			        $transaction->commit();
		        } else {
			        $transaction->rollBack();
		        }
	        } catch (Exception $e) {
		        $transaction->rollBack();
	        }

            //return $this->redirect(['update', 'id' => $model->id]);
	        return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model'             => $model,
	        'photos'            => $photos,
	        'photo'             => $photo,
	        'brands'            => $brands,
	        'countPhotos'       => $countPhotos,
	        'options'           => $options,
	        'selectedOptions'   => $selectedOptions,
        ]);
    }

	public function actionMain($id, $image)
	{
		$model = Car::findOne($id);
		$model->main_photo_id = $image;
		$model->save();

		return $this->redirect(['view', 'id' => $model->id]);

		//return $this->redirect(['update', 'id' => $id]);
	}

    /**
     * Deletes an existing Car model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
	    $photo = new Photo();
	    $photo->deleteCurrentImages($model->photos);
	    foreach ($model->photos as $photoModel){
		    $photoModel->delete();
	    }
	    $model->clearCurrentOptions();
	    $model->delete();

	    return $this->redirect(['index']);
    }

    /**
     * Finds the Car model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Car the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Car::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

	public function actionGetModels()
	{
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$models = Brand::findOne(['id' => (int) Yii::$app->request->get('brand')])->children()->all();
		return $models;
	}
}
