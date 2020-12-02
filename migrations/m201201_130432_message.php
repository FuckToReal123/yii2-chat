<?php

use yii\db\Migration;

/**
 * Class m201201_130432_message
 */
class m201201_130432_message extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('message', [
            'id' => $this->primaryKey(),
            'text' => $this->string(255)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'status' => $this->integer(1)->notNull()->defaultValue(1),
            'user_id' => $this->integer()
        ]);

        $this->addForeignKey(
            'fk-message-user_id',
            'message',
            'user_id',
            'user',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('message');
    }
}
