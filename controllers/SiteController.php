<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\data\SqlDataProvider;

class SiteController extends Controller
{
    /**
     * @inheritdoc
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
     * @inheritdoc
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
        if (!empty($_POST['task'][0])){
            switch ($_POST['task'][0]){
                case 1:
                    $numberTask = $_POST['task'][0];
                    $taskText = 'Предположим, нам необходимо хранить в БД часть информации какого-либо блога. Конкретно - записи (posts) и авторы (authors).
                                 В детали вдаваться не стоит, достаточно основных, ключевых полей. Необходимо учесть, что одна запись может писаться несколькими авторами.
                                 Предложите структуру таблиц и связи, напишите SQL запрос(ы), которые это реализуют.';
                    $answer = 'Первоначально таблицы записи (posts) и авторы (authors) соединены связью многие-ко-многим. Преобразуем структуру, создав новую таблицу публикации (publish), в которой будем хранить данные о том, какой автор написал какую статью. Таким образом мы преобразовали связь многие-ко-многим в один-ко-многим. Ниже представлены SQL запросы, которые это реализуют.';
                    $sqlText = include("../views/site/sql1.php");
                    $sql = '';
                    break;
                case 2:
                    $numberTask = $_POST['task'][0];
                    $taskText = 'Напишите sql-запрос, выбирающий информацию по каждому менеджеру, включая количество связанных с ним заявок и их общую сумму (в 2 дополнительных поля: claim_count, claim_total_sum). Выборка должна быть выполнена одним запросом!';
                    $sqlText = include("../views/site/sql2.php");
                    $sql = 'SELECT `manager`.*, COUNT(`claim`.`id`) as claim_count, SUM(`claim`.`sum`) claim_total_sum
                            FROM `manager`
                            LEFT JOIN `claim`
                            ON `manager`.`id` = `claim`.`manager_id`
                            GROUP BY `manager`.`id`;';
                    break;
                case 3:
                    $numberTask = $_POST['task'][0];
                    $taskText = 'Напишите запрос, который выведет двух менеджеров, у которых количество связанных заявок меньше, чем у остальных. При этом, объедините значения first_name и last_name в одно поле full_name';
                    $sqlText = include("../views/site/sql3.php");
                    $sql = 'SELECT GROUP_CONCAT(DISTINCT first_name, last_name ORDER BY first_name DESC SEPARATOR \' \') as `full_name`, COUNT(`claim`.`id`) as claim_count
                            FROM `manager`
                            LEFT JOIN `claim`
                            ON `manager`.`id` = `claim`.`manager_id`
                            GROUP BY `manager`.`id`
                            ORDER BY `claim_count` ASC
                            LIMIT 2;';
                break;
                case 4:
                $numberTask = $_POST['task'][0];
                $taskText = 'Напишите запрос, который выведет список менеджеров, количество заявок у которых больше, чем у их руководителя (связь с руководителем по полю chief_id).';
                $sqlText = include("../views/site/sql4.php");
                $sql = 'SELECT `manager`.*, COUNT(`claim`.`id`) as claim_count
                            FROM `manager`
                            LEFT JOIN `claim`
                            ON `manager`.`id` = `claim`.`manager_id`
                            GROUP BY `manager`.`id`
                            HAVING claim_count > (SELECT avg_manager(2))
                                                  AND `manager`.`chief_id` IS NOT NULL';
                    break;
                case 5:
                    $numberTask = $_POST['task'][0];
                    $taskText = 'Напишите запрос, результатом которого будет "месячный отчет" по заявкам. Т.е. в результате, мы должны увидеть таблицу с полями month, claim_count, claim_total_sum. Каждый месяц - одна строка. В поле month, должно быть полное название месяца и год (e.g. November 2012). В поле claim_count - количество заявок в этом месяце, а claim_total_sum - общая сумма по заявкам.';
                    $sqlText = include("../views/site/sql5.php");
                    $sql = 'SELECT DATE_FORMAT(`created_at`, \'%M %Y\') as `month`, COUNT(`claim`.`id`) as claim_count, SUM(`claim`.`sum`) claim_total_sum
                            FROM `manager`
                            LEFT JOIN `claim`
                            ON `manager`.`id` = `claim`.`manager_id`
                            GROUP BY `month`';
                    break;
                case 6:
                    $numberTask = $_POST['task'][0];
                    $taskText = 'Выберите топ-менеджеров за июль 2013 (07.2013) по результатам среднего значения суммы заявки.';
                    $sqlText = include("../views/site/sql6.php");
                    $sql = 'SELECT DATE_FORMAT(`created_at`, \'%M %Y\') as `month`, `manager`.*, COUNT(`claim`.`id`) as claim_count, AVG(`claim`.`sum`) as `srednee`
                            FROM `manager`
                            LEFT JOIN `claim`
                            ON `manager`.`id` = `claim`.`manager_id` 
                            WHERE DATE_FORMAT(`created_at`, \'%M %Y\')  like \'July 2013\'
                            GROUP BY `manager`.`id`
                            ORDER BY `srednee` DESC;';
                    break;
            }
        }
        ;

        if (NULL != $sql){
            $totalCount = count(Yii::$app->db->createCommand($sql)->queryAll());
            $dataProvider = new SqlDataProvider([
                'sql' => $sql,
                'totalCount' => $totalCount,
                'pagination' => [
                    // количество пунктов на странице
                    'pageSize' => 10,
                ]
            ]);
        }else{
            $dataProvider = '';
        }

        return $this->render('index', ['taskText' => $taskText,
                            'answer' => $answer,
                            'numberTask' => $numberTask,
                            'sqlText' =>$sqlText,
                            'dataProvider' => $dataProvider]
                            );
    }

    /**
     * Login action.
     *
     * @return string
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
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

}
