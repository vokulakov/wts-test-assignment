<?php

use yii\db\Migration;

class m231027_152948_create_publications_table extends Migration
{

    public function safeUp()
    {
        $this->createTable('{{%publications}}', [
            'postID' => $this->primaryKey(),
            'tittle' => $this->string()->notNull()->unique(),
            'text' => $this->text()->notNull(),
            'authorID' => $this->integer()->notNull(),
            'createdAt' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'authorID',
            'publications',
            'authorID',
            'user',
            'id',
            'CASCADE'
        );

    }

    public function safeDown()
    {
        $this->dropForeignKey(
            'authorID',
            'publications'
        );

        $this->dropTable('{{%publications}}');
    }

}
