<?php

namespace frontend\controllers;

use common\models\LoginByEmail;
use frontend\models\SignupForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class UserController extends Controller
{
    /*
     * https://www.yiiframework.com/doc/guide/2.0/en/security-best-practices
     * csrf блокирует post-запросы
     */
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            [
                'class' => ContentNegotiator::class,
                'only' => ['signup', 'login'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'application/xml' => Response::FORMAT_XML
                ],
                'languages' => [
                    'en'
                ]
            ],
            'access' => [
                'class' => AccessControl::class,
                'only' => ['signup', 'login'],
                'rules' => [
                    [
                        'actions' => ['signup', 'login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'signup' => ['post'],
                    'login' => ['post']
                ],
            ]
        ];
    }

    /*
     * Регистрация пользователя
     */
    public function actionSignup()
    {
        $request = Yii::$app->request;

        if (!$request->isPost)
        {
            return false;
        }

        $model = new SignupForm();
        $params = $request->post();

        if ($model->load($params, "") && $model->signup())
        {
            return json_encode(
                [
                    'status' => 'success',
                    'data' => [
                        'username' => $model->username,
                        'email' => $model->email,
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
     * Авторизация пользователя
     */
    public function actionLogin()
    {
        $request = Yii::$app->request;

        if (!$request->isPost)
        {
            return false;
        }

        $model = new LoginByEmail();
        $params = $request->post();

        if ($model->load($params, "") && $model->login())
        {
            return json_encode(
                [
                    'status' => 'success',
                    'data' => [
                        'email' => $model->email,
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

}
