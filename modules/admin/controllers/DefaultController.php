<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\News;
use yii\web\Controller;

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
        return $this->render('index');
    }
    public function actionCreate()
    {
        $newArticle = new News();
        return $this->render('create', ['newArticle' => $newArticle] );
    }
}
