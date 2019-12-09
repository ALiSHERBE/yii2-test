<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%web_cars}}`.
 */
class m191205_011657_create_web_cars_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%web_cars}}', [
	        'id' => $this->primaryKey(),
	        'created_at' => $this->dateTime(),
	        'updated_at' => $this->dateTime(),
	        'price' => $this->string()->notNull(),
	        'phone' => $this->string()->notNull(),
	        'mileage' => $this->string(),
	        'main_photo_id' => $this->integer()->notNull(),
	        'model_id' => $this->integer()->notNull(),
	        'brand_id' => $this->integer()->notNull(),
	        'user_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%web_cars}}');
    }
}
