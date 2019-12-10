<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%web_car_option}}`.
 */
class m191209_234427_create_web_car_option_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%web_car_option}}', [
	        'id' => $this->primaryKey(),
	        'car_id'=>$this->integer()->notNull(),
	        'option_id'=>$this->integer()->notNull()
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%web_car_option}}');
    }
}
