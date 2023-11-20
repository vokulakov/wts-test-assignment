<?php

namespace backend\controllers;

use common\models\Publications;
use backend\models\PublicationsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PublicationsController implements the CRUD actions for BasePublications model.
 */
class PublicationsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all BasePublications models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PublicationsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BasePublications model.
     * @param int $postID Post ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($postID)
    {
        return $this->render('view', [
            'model' => $this->findModel($postID),
        ]);
    }

    /**
     * Creates a new BasePublications model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Publications();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'postID' => $model->postID]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BasePublications model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $postID Post ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($postID)
    {
        $model = $this->findModel($postID);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'postID' => $model->postID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BasePublications model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $postID Post ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($postID)
    {
        $this->findModel($postID)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BasePublications model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $postID Post ID
     * @return Publications the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($postID)
    {
        if (($model = Publications::findOne(['postID' => $postID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
