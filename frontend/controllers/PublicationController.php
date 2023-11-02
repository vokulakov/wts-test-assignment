<?php

namespace frontend\controllers;

use frontend\models\PublicationAdd;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class PublicationController extends Controller
{
    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            [
                'class' => ContentNegotiator::class,
                'only' => ['add'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ],
                'languages' => [
                    'en'
                ]
            ],
            'access' => [
                'class' => AccessControl::class,
                'only' => [],
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['?'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'add' => ['post'],
                    '' => ['get'],
                    '' => ['get']
                ],
            ]
        ];
    }

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
                ]
            );
        }

        return json_encode(
            [
                'status' => 'error',
                'data' => null,
                'errors' => $model->errors
            ]
        );

    }

}