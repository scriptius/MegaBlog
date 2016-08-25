<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\News;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use \app\modules\admin\models\Themes;
use yii\data\Pagination;
/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $query = News::find();

        $pagination = new Pagination(['totalCount' => $query->count(),  'pageSize' => 5]);
        $news = $query->orderBy('date DESC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', ['news' => $news, 'pagination' => $pagination,]);
    }

    public function actionAddnews()
    {
        $news = new News();

        if (true == !empty($_POST['News']['news_id'])){
            $sql = 'SELECT * FROM news WHERE news_id = '. $_POST['News']['news_id'];
            $news = $news->findBySql($sql)->one();
        }

        if (isset($_POST['News'])){
            $news->attributes = $_POST['News'];
            if($news->validate()) {
                $news->save();
                \Yii::$app->session->setFlash('addNews', 'Ваша новость успешно добавлена');
            }
        }
        $this->redirect('/index.php/admin/default/index');
    }
    public function actionCreate()
    {
        $newArticle = new News();
        $attrs = ArrayHelper::map(Themes::find()->all(), 'theme_id','theme_title');
        return $this->render('create', ['newArticle' => $newArticle, 'attrs' => $attrs] );
    }

    public function actionEditnews(int $id)
    {
        $news = new News();
        $sql = 'SELECT * FROM news WHERE news_id = '. $id;
        $newArticle = $news->findBySql($sql)->one();

        $attrs = ArrayHelper::map(Themes::find()->all(), 'theme_id','theme_title');
        return $this->render('create', ['newArticle' => $newArticle, 'attrs' => $attrs] );
    }

}
