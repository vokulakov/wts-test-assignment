<?php

use yii\db\Migration;

class m231027_150454_access_tokens_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%accessTokens}}', [
            'tokenID' => $this->primaryKey(),
            'userID' => $this->integer()->notNull(),
            'accessToken' => $this->string(32)->notNull()
        ]);

        $this->addForeignKey(
            'userID',
            'accessTokens',
            'userID',
            'user',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'userID',
            'accessTokens'
        );

        $this->dropTable('{{%accessTokens}}');
    }

}
