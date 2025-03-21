<?php

namespace app\controllers;

use Yii;
use app\models\Wishlist;
use app\models\Gift;
use app\models\GiftCategory;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * WishlistController implements the CRUD actions for Wishlist model.
 */
class WishlistController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'view', 'create', 'update', 'delete'],
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
     * Lists all Wishlist models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Wishlist::find()->where(['user_id' => Yii::$app->user->id]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Wishlist model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        // Проверяем, принадлежит ли список желаний текущему пользователю
        if ($model->user_id !== Yii::$app->user->id) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Wishlist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Wishlist();
        $model->user_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        // Получаем подарки и категории текущего пользователя
        $gifts = Gift::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->all();

        $categories = GiftCategory::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->all();

        return $this->render('create', [
            'model' => $model,
            'gifts' => $gifts,
            'categories' => $categories,
        ]);
    }

    /**
     * Updates an existing Wishlist model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // Проверяем, принадлежит ли список желаний текущему пользователю
        if ($model->user_id !== Yii::$app->user->id) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        // Получаем подарки и категории текущего пользователя
        $gifts = Gift::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->all();

        $categories = GiftCategory::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->all();

        return $this->render('update', [
            'model' => $model,
            'gifts' => $gifts,
            'categories' => $categories,
        ]);
    }

    /**
     * Deletes an existing Wishlist model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // Проверяем, принадлежит ли список желаний текущему пользователю
        if ($model->user_id !== Yii::$app->user->id) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Displays a public Wishlist.
     * @param string $token
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPublic($token)
    {
        $model = Wishlist::findOne(['public_token' => $token, 'is_public' => true]);

        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('public', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Wishlist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Wishlist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Wishlist::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}