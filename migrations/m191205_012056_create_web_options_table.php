<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%web_options}}`.
 */
class m191205_012056_create_web_options_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%web_options}}', [
            'id' => $this->primaryKey(),
	        'title' => $this->string()->notNull(),
	        'parent_id' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%web_options}}');
    }
}
