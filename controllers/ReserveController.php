<?php

namespace app\controllers;

use app\models\User;
use Yii;
use app\models\Reserve;
use app\models\ReserveSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReserveController implements the CRUD actions for Reserve model.
 */
class ReserveController extends Controller
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
     * Lists all Reserve models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReserveSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Reserve model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model->meeting_date = date('d.m.Y', strtotime($model->meeting_date));
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Reserve model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param integer $roomId
     * @return mixed
     */
    public function actionCreate($roomId = null)
    {
        $model = new Reserve();

        if (Yii::$app->user->getIsGuest()) {
            return $this->redirect(['index']);
        }

        $model->setAttribute('room_id', $roomId);
        $model->setAttribute('owner_id', Yii::$app->user->getId());
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        if ($model->meeting_date) {
            $model->meeting_date = date('d.m.Y', strtotime($model->meeting_date));
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Reserve model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->user->getIsGuest() ||
            Yii::$app->user->getId() !== $model->getAttribute('owner_id')) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $model->meeting_date = date('d.m.Y', strtotime($model->meeting_date));
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Reserve model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->user->getIsGuest() ||
            Yii::$app->user->getId() !== $model->getAttribute('owner_id')) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Reserve model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Reserve the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Reserve::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
