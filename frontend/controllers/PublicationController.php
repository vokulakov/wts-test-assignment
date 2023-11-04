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
                'only' => ['add', 'all'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ],
                'languages' => [
                    'en'
                ]
            ],
            'access' => [
                'class' => AccessControl::class,
                'only' => ['add', 'all'],
                'rules' => [
                    [
                        'actions' => ['add', 'all'],
                        'allow' => true,
                        'roles' => ['?'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'add' => ['post'],
                    'all' => ['get'],
                    '' => ['get']
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
            return json_encode(
                [
                    'status' => 'success',
                    'data' => [
                        'accessToken' => $model->accessToken
                    ],
                    'errors' => $model->errors
                ],
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(
            [
                'status' => 'error',
                'data' => null,
                'errors' => $model->errors
            ],
            JSON_PRETTY_PRINT
        );

    }

    /*
     * Получить все публикации
     */
    public function actionAllList()
    {
        $request = Yii::$app->request;
        if (!$request->isGet)
        {
            return false;
        }

        $model = new PublicationList();
        $params = $request->get();
        $params['limit'] = $params['limit'] ?? 15;
        $params['offset'] = $params['offset'] ?? 0;

        if ($model->load($params, "") && $model->getAllPublication())
        {
            return JSON::encode(
                [
                    'status' => 'success',
                    'data' => [
                        'publications' => $model->publications
                    ],
                    'errors' => $model->errors
                ],
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(
            [
                'status' => 'error',
                'data' => null,
                'errors' => $model->errors
            ],
            JSON_PRETTY_PRINT
        );


    }

}