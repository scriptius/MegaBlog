<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\News;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use \app\modules\admin\models\Themes;
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
        $news = \Yii::$app->db->createCommand('SELECT * FROM news ORDER BY date ASC')->queryAll();

        var_dump($news);
        die;
        return $this->render('index', ['news' => $news]);
    }

    public function actionAddnews()
    {
        $news = new News();
        if (isset($_POST['News'])){
            $news->attributes = $_POST['News'];
            if($news->validate()) {
                $news->save();
                \Yii::$app->session->setFlash('addNews', 'Ваша новость успешно добавлена');
            }
        }
        $this->redirect('/index.php/admin/default/create');
    }
    public function actionCreate()
    {
        $newArticle = new News();
        $attrs = ArrayHelper::map(Themes::find()->all(), 'theme_id','theme_title');
        return $this->render('create', ['newArticle' => $newArticle, 'attrs' => $attrs] );
    }
}
