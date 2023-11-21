<?php

namespace common\models;

use Yii;
use yii\base\Exception;

class AccessTokens extends BaseAccessTokens
{
    /**
     * @throws Exception
     */
    public static function generateAccessToken($userID): string
    {
        $token = new AccessTokens();

        $token->userID = $userID;
        $token->accessToken = Yii::$app->security->generateRandomString(32);
        $token->save();

        return $token->accessToken;
    }

    /**
     * Finds user by access token
     *
     * @param string $token
     * @return \common\models\User
     */
    public static function getUserFromToken($token)
    {
        $_object = static::findOne(['accessToken' => $token]);
        if (empty($_object)) {
            return null;
        }

        return User::findOne(['id' => $_object->userID]);
    }

}