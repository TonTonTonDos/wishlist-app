<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "gift".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property float|null $price
 * @property string|null $link
 * @property string|null $image
 * @property int|null $category_id
 * @property int $user_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property GiftCategory $category
 * @property User $user
 */
class Gift extends ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%gift}}';
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
            [['price'], 'number'],
            [['category_id', 'user_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['link'], 'string', 'max' => 2048],
            [['link'], 'url', 'defaultScheme' => 'https'],
            [['image'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg, gif'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => GiftCategory::class, 'targetAttribute' => ['category_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'price' => 'Цена',
            'link' => 'Ссылка',
            'image' => 'Изображение',
            'imageFile' => 'Изображение',
            'category_id' => 'Категория',
            'user_id' => 'Пользователь',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(GiftCategory::class, ['id' => 'category_id']);
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
     * Upload image
     *
     * @return boolean
     */
    public function upload()
    {
        if ($this->imageFile) {
            $fileName = 'gift_' . $this->id . '_' . time() . '.' . $this->imageFile->extension;
            $path = Yii::getAlias('@webroot/uploads/gifts/');

            // Создаем директорию, если не существует
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $this->imageFile->saveAs($path . $fileName);
            $this->image = $fileName;
            return $this->save(false);
        }

        return true;
    }

    /**
     * Get image URL
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->image
            ? Yii::getAlias('@web/uploads/gifts/' . $this->image)
            : Yii::getAlias('@web/img/no-image.png'); // путь к изображению-заглушке
    }
}