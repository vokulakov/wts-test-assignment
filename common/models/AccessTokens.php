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

}