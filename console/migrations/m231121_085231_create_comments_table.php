<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comments}}`.
 */
class m231121_085231_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comments}}', [
            'commentId' => $this->primaryKey(),
            'commentContent' => $this->text()->notNull(),
            'createdAt' => $this->integer()->notNull(),
            'updatedAt' => $this->integer()->notNull(),
            'postId' => $this->integer()->notNull(),
            'authorId' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            'FK_postId',
            'comments',
            'postId',
            'publications',
            'postID',
            'CASCADE'
        );

        $this->addForeignKey(
            'FK_authorId',
            'comments',
            'authorId',
            'user',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'postId',
            'comments'
        );

        $this->dropForeignKey(
            'authorId',
            'comments'
        );

        $this->dropTable('{{%comments}}');
    }
}
