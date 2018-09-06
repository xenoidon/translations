<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\User;
use app\models\UserSearch;
use app\models\ConversionForm;
use app\models\Conversion;
use yii\db\Expression;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new ConversionForm();
        if (!Yii::$app->user->isGuest) {
            $model->user_id = Yii::$app->user->identity->id;
            $users = User::find()->where('id != :id', [':id' => $model->user_id])->all();
            if ($model->load(Yii::$app->request->post())) {
                if($model->validate()) {
                    $model->status = 2;
                    $model->save();
                    $model = new ConversionForm();
                } else {

                }
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
            'users' => isset($users)?$users:null
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionWork()
    {
        $workItems = Conversion::find()
            ->where('status = :status', [':status' =>  2])
            ->andWhere('time_transaction <= NOW()')
            ->all();
        foreach ($workItems as $key => $item) {

            $userIn = User::findOne($item->user_id);
            $userTo = User::findOne($item->user_id_to_translate);
            $userTo->balance += $item->translation;
            $userIn->balance = $userIn->balance - $item->translation;
            $userIn->save();
            $userTo->save();
            $item->status = 3;
            $item->save();
        }
        return $this->render('work', [
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    /**
     * SingUp user.
     *
     * @return User
     */
    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }




}
