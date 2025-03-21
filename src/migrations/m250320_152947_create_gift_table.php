<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%gift}}`.
 */
class m250320_152947_create_gift_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%gift}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'price' => $this->decimal(10, 2),
            'link' => $this->string(2048),
            'image' => $this->string(255),
            'category_id' => $this->integer(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // Добавляем внешний ключ на таблицу user
        $this->addForeignKey(
            'fk-gift-user_id',
            '{{%gift}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Добавляем внешний ключ на таблицу gift_category
        $this->addForeignKey(
            'fk-gift-category_id',
            '{{%gift}}',
            'category_id',
            '{{%gift_category}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-gift-category_id', '{{%gift}}');
        $this->dropForeignKey('fk-gift-user_id', '{{%gift}}');
        $this->dropTable('{{%gift}}');
    }
}