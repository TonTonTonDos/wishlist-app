<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "wishlist".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property bool $is_public
 * @property string|null $public_token
 * @property int $user_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 * @property Gift[] $gifts
 * @property GiftCategory[] $categories
 */
class Wishlist extends ActiveRecord
{
    /**
     * @var array Selected gift IDs
     */
    public $giftIds = [];

    /**
     * @var array Selected category IDs
     */
    public $categoryIds = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%wishlist}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['is_public'], 'boolean'],
            [['user_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['public_token'], 'string', 'max' => 64],
            [['public_token'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['giftIds', 'categoryIds'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => 'Описание',
            'is_public' => 'Публичный',
            'public_token' => 'Публичный токен',
            'user_id' => 'Пользователь',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'giftIds' => 'Подарки',
            'categoryIds' => 'Категории',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Gifts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGifts()
    {
        return $this->hasMany(Gift::class, ['id' => 'gift_id'])
            ->viaTable('{{%wishlist_gift}}', ['wishlist_id' => 'id']);
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(GiftCategory::class, ['id' => 'category_id'])
            ->viaTable('{{%wishlist_category}}', ['wishlist_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function afterFind()
    {
        parent::afterFind();

        // Загружаем связанные подарки и категории
        $this->giftIds = \yii\helpers\ArrayHelper::getColumn($this->gifts, 'id');
        $this->categoryIds = \yii\helpers\ArrayHelper::getColumn($this->categories, 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // Генерируем публичный токен, если список помечен как публичный
        if ($this->is_public && empty($this->public_token)) {
            $this->public_token = Yii::$app->security->generateRandomString(64);
            $this->updateAttributes(['public_token']);
        }

        // Удаляем публичный токен, если список не является публичным
        if (!$this->is_public && !empty($this->public_token)) {
            $this->public_token = null;
            $this->updateAttributes(['public_token']);
        }

        // Обновляем связи с подарками
        $this->unlinkAll('gifts', true);
        if (!empty($this->giftIds)) {
            foreach ($this->giftIds as $giftId) {
                $gift = Gift::findOne($giftId);
                if ($gift && $gift->user_id === $this->user_id) {
                    $this->link('gifts', $gift);
                }
            }
        }

        // Обновляем связи с категориями
        $this->unlinkAll('categories', true);
        if (!empty($this->categoryIds)) {
            foreach ($this->categoryIds as $categoryId) {
                $category = GiftCategory::findOne($categoryId);
                if ($category && $category->user_id === $this->user_id) {
                    $this->link('categories', $category);
                }
            }
        }
    }

    /**
     * Получить URL для публичного доступа к списку
     *
     * @return string|null URL для публичного доступа или null, если список не публичный
     */
    public function getPublicUrl()
    {
        if ($this->is_public && $this->public_token) {
            return Yii::$app->urlManager->createAbsoluteUrl(['wishlist/public', 'token' => $this->public_token]);
        }

        return null;
    }
}