<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%images}}`.
 */
class m230603_082020_create_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%images}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->unique(),
            'extension' => $this->string(5)->notNull(),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%images}}');
    }
}
