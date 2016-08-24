<?php

namespace app\modules\users\controllers;

use app\modules\admin\models\News;
use app\modules\admin\models\Themes;
use yii\web\Controller;

/**
 * Default controller for the `Users` module
 */
class DefaultController extends Controller
{
    protected function SQL_Request_Creator(){
        if(true == !empty($_GET['category'])){
           return $sql = 'SELECT * FROM `news`
            WHERE theme_id IN (SELECT theme_id FROM themes WHERE theme_title = \''.(string)$_GET['category'].'\')';
        }

        switch(true){
            case !empty($_GET['month']):
                $where .= ' DATE_FORMAT(`date`, \'%M\') = \''.(string)$_GET['month'].'\' and';
            case !empty($_GET['year']):
                $where .= ' DATE_FORMAT(`date`, \'%Y\') = \''.(string)$_GET['year'].'\'';
                $statusWhere = true;
        }

        return $sql = (true == $statusWhere)? 'SELECT * FROM news WHERE '.$where.' ORDER BY date DESC' :
            'SELECT * FROM news ORDER BY date DESC';
    }



    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        $sql = $this->SQL_Request_Creator();

        $selectNews =(new News())->findBySql($sql)->all();

        $sql = "SELECT UNIX_TIMESTAMP(`date`) as timestamp, DATE_FORMAT(`date`, '%Y') as year, DATE_FORMAT(`date`, '%M') as month, COUNT(news_id) as count_news
                FROM news 
                GROUP BY DATE_FORMAT(`date`, '%M'), DATE_FORMAT(`date`, '%Y')
                ORDER BY date DESC";

        $groupByYearAndMonthFromBD = \Yii::$app->db->createCommand($sql)->queryAll();

        foreach ($groupByYearAndMonthFromBD as $item){
            $sortByYearAndMonthForView[$item['year']][$item['month']] = $item['count_news'];
        }

        $sql = 'SELECT themes.theme_title, COUNT(news.news_id) as count_category
                FROM themes
                LEFT JOIN news
                ON themes.theme_id = news.theme_id
                GROUP BY themes.theme_title';
/*
 * 'SELECT themes.theme_title, COUNT(news.news_id) as count_category
                FROM themes
                LEFT JOIN news
                ON themes.theme_id = news.theme_id
                GROUP BY themes.theme_title'
 */



        $selectCategory = \Yii::$app->db->createCommand('SELECT theme_title, COUNT(news.news_id) as count_category
                FROM themes
                LEFT JOIN news
                ON themes.theme_id = news.theme_id
                GROUP BY themes.theme_title')->queryAll();

        return $this->render('index', ['sortByYearAndMonthForView' => $sortByYearAndMonthForView,
                                       'selectNews'=> $selectNews,
                                       'selectCategory' => $selectCategory
                                      ]);
    }
}
