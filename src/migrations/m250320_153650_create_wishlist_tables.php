<?php

use yii\db\Migration;

class m250320_153650_create_wishlist_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Создаем таблицу списков желаний
        $this->createTable('{{%wishlist}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'is_public' => $this->boolean()->defaultValue(false),
            'public_token' => $this->string(64)->unique(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // Добавляем внешний ключ на таблицу user
        $this->addForeignKey(
            'fk-wishlist-user_id',
            '{{%wishlist}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Создаем таблицу связи между списками желаний и подарками
        $this->createTable('{{%wishlist_gift}}', [
            'wishlist_id' => $this->integer()->notNull(),
            'gift_id' => $this->integer()->notNull(),
            'PRIMARY KEY(wishlist_id, gift_id)',
        ]);

        // Добавляем внешние ключи для таблицы связи
        $this->addForeignKey(
            'fk-wishlist_gift-wishlist_id',
            '{{%wishlist_gift}}',
            'wishlist_id',
            '{{%wishlist}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-wishlist_gift-gift_id',
            '{{%wishlist_gift}}',
            'gift_id',
            '{{%gift}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        // Создаем таблицу связи между списками желаний и категориями
        $this->createTable('{{%wishlist_category}}', [
            'wishlist_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'PRIMARY KEY(wishlist_id, category_id)',
        ]);

        // Добавляем внешние ключи для таблицы связи с категориями
        $this->addForeignKey(
            'fk-wishlist_category-wishlist_id',
            '{{%wishlist_category}}',
            'wishlist_id',
            '{{%wishlist}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-wishlist_category-category_id',
            '{{%wishlist_category}}',
            'category_id',
            '{{%gift_category}}',
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
        $this->dropForeignKey('fk-wishlist_category-category_id', '{{%wishlist_category}}');
        $this->dropForeignKey('fk-wishlist_category-wishlist_id', '{{%wishlist_category}}');
        $this->dropTable('{{%wishlist_category}}');

        $this->dropForeignKey('fk-wishlist_gift-gift_id', '{{%wishlist_gift}}');
        $this->dropForeignKey('fk-wishlist_gift-wishlist_id', '{{%wishlist_gift}}');
        $this->dropTable('{{%wishlist_gift}}');

        $this->dropForeignKey('fk-wishlist-user_id', '{{%wishlist}}');
        $this->dropTable('{{%wishlist}}');
    }
}