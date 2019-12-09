<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%web_users}}`.
 */
class m191205_011931_create_web_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%web_users}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%web_users}}');
    }
}
