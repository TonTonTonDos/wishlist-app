<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%gift_category}}`.
 */
class m250320_152155_create_gift_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%gift_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // Добавляем внешний ключ на таблицу user
        $this->addForeignKey(
            'fk-gift_category-user_id',
            '{{%gift_category}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-gift_category-user_id', '{{%gift_category}}');
        $this->dropTable('{{%gift_category}}');
    }
}