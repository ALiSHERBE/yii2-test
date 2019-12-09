<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%web_photos}}`.
 */
class m191205_012015_create_web_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%web_photos}}', [
            'id' => $this->primaryKey(),
	        'car_id' => $this->integer()->notNull(),
	        'file' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%web_photos}}');
    }
}
