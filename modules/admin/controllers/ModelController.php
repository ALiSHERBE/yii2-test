<?php

namespace app\modules\admin\controllers;

use Yii;
use app\models\Brand;
use app\models\BrandSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ModelController implements the CRUD actions for Brand model.
 */
class ModelController extends Controller
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
     * Lists all Brand models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BrandSearch();
	    $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 'model');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Brand model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Brand model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Brand();
	    $parent = Brand::findOne(1);
	    $children = $parent->children(1)->all();
	    $post = Yii::$app->request->post('Brand');

        if (!empty($post)) {
	        $model->title     = $post['title'];
	        $parent = Brand::findOne(['id' => $post['brand']]);
	        $model->appendTo($parent);

            //return $this->redirect(['view', 'id' => $model->id]);
	        return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'children' => $children,
        ]);
    }

    /**
     * Updates an existing Brand model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
	    $model->brand = $model->parent->id; // for selected

	    $parent = Brand::findOne(1);

	    $children = $parent->children(1)->all();

	    $post = Yii::$app->request->post('Brand');

	    if (!empty($post)) {
		    $model->title     = $post['title'];
		    $parent = Brand::findOne(['id' => $post['brand']]);
		    $model->appendTo($parent);

		    //return $this->redirect(['view', 'id' => $model->id]);
		    return $this->redirect(['index']);
	    }

        return $this->render('update', [
            'model' => $model,
	        'children' => $children,
        ]);
    }

    /**
     * Deletes an existing Brand model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Brand model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Brand the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Brand::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
