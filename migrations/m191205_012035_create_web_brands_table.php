<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%web_brands}}`.
 */
class m191205_012035_create_web_brands_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%web_brands}}', [
            'id' => $this->primaryKey(),
	        'title' => $this->string()->notNull(),
	        'lft' => $this->integer()->notNull(),
	        'rgt' => $this->integer()->notNull(),
	        'depth' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%web_brands}}');
    }
}
