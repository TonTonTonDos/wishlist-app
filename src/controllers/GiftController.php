<?php

namespace app\controllers;

use Yii;
use app\models\Gift;
use app\models\GiftCategory;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * GiftController implements the CRUD actions for Gift model.
 */
class GiftController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Gift models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Gift::find()->where(['user_id' => Yii::$app->user->id]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Gift model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        // Проверяем, принадлежит ли подарок текущему пользователю
        if ($model->user_id !== Yii::$app->user->id) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Gift model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Gift();
        $model->user_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->save()) {
                $model->upload();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        // Получаем категории текущего пользователя для выпадающего списка
        $categories = GiftCategory::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->all();

        return $this->render('create', [
            'model' => $model,
            'categories' => $categories,
        ]);
    }

    /**
     * Updates an existing Gift model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // Проверяем, принадлежит ли подарок текущему пользователю
        if ($model->user_id !== Yii::$app->user->id) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $oldImage = $model->image;

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if (!$model->imageFile) {
                $model->image = $oldImage; // Сохраняем старое изображение, если новое не загружено
            }

            if ($model->save()) {
                $model->upload();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        // Получаем категории текущего пользователя для выпадающего списка
        $categories = GiftCategory::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->all();

        return $this->render('update', [
            'model' => $model,
            'categories' => $categories,
        ]);
    }

    /**
     * Deletes an existing Gift model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // Проверяем, принадлежит ли подарок текущему пользователю
        if ($model->user_id !== Yii::$app->user->id) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        // Удаляем файл изображения, если он существует
        if ($model->image) {
            $imagePath = Yii::getAlias('@webroot/uploads/gifts/' . $model->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Gift model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Gift the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Gift::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}