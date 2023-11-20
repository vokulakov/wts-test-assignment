<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;

use frontend\models\PublicationAdd;
use frontend\models\PublicationList;

use common\models\BasePublications;

class PublicationController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            [
                'class' => ContentNegotiator::class,
                'only' => ['add', 'all', 'my'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ],
                'languages' => [
                    'en'
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'add' => ['post'],
                    'all' => ['get'],
                    'my' => ['get']
                ],
            ]
        ];
    }

    /*
     * Опубликовать пост
     */
    public function actionAdd()
    {
        $request = Yii::$app->request;

        if (!$request->isPost)
        {
            return false;
        }

        $model = new PublicationAdd();
        $params = $request->post();

        if ($model->load($params, "") && $model->add())
        {
            return [
                'status' => 'success',
                'data' => [
                    'accessToken' => $model->accessToken
                ],
                'errors' => $model->errors
            ];
        }

        return [
            'status' => 'error',
            'data' => null,
            'errors' => $model->errors
        ];
    }

    /*
     * Получить все публикации
     */
    public function actionAll()
    {
        $request = Yii::$app->request;
        if (!$request->isGet)
        {
            return false;
        }

        $model = new PublicationList();
        $params = $request->get();
        $params['limit'] = $params['limit'] ?? Yii::$app->params['limitDefault'];
        $params['offset'] = $params['offset'] ?? Yii::$app->params['offsetDefault'];

        if ($model->load($params, "") && $model->getAllPublication())
        {
            return [
                'status' => 'success',
                'data' => [
                    'publications' => $model->publications
                ],
                'errors' => $model->errors
            ];
        }

        return [
            'status' => 'error',
            'data' => null,
            'errors' => $model->errors
        ];
    }

    /*
     * Получить список моих публикаций/ публикаций пользователя
     */
    public function actionMy()
    {
        $request = Yii::$app->request;
        if (!$request->isGet)
        {
            return false;
        }

        $model = new PublicationList();
        $params = $request->get();
        $params['limit'] = $params['limit'] ?? Yii::$app->params['limitDefault'];
        $params['offset'] = $params['offset'] ?? Yii::$app->params['offsetDefault'];

        if ($model->load($params, "") && $model->getUserPublications())
        {
            return [
                'status' => 'success',
                'data' => [
                    'accessToken' => $model->accessToken,
                    'publications' => $model->publications
                ],
                'errors' => $model->errors
            ];
        }

        return [
            'status' => 'error',
            'data' => null,
            'errors' => $model->errors
        ];

    }

}