<?php

namespace app\modules\users\controllers;

use app\modules\admin\models\News;
use yii\web\Controller;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;

/**
 * Default controller for the `Users` module
 */
class DefaultController extends Controller
{
    /**
     * @param string $mode what kind of text to create a sql-query
     * @return string text sql-query
     */
    protected function SQL_Request_Creator(string $mode, $param = NULL)
    {
        switch ($mode){
            case 'fromGet':
                if(true == !empty($_GET['category'])){
                    return $sql = 'SELECT * FROM `news`
                                   WHERE theme_id IN (SELECT theme_id 
                                                      FROM themes 
                                                      WHERE theme_title = \''.(string)$_GET['category'].'\')';
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


            case 'groupByYearAndMonth':
                return "SELECT UNIX_TIMESTAMP(`date`) as timestamp, DATE_FORMAT(`date`, '%Y') as year, DATE_FORMAT(`date`, '%M') as month, COUNT(news_id) as count_news
                        FROM news 
                        GROUP BY DATE_FORMAT(`date`, '%M'), DATE_FORMAT(`date`, '%Y')
                        ORDER BY date DESC";

            case 'sortByCategory':
                return 'SELECT themes.theme_title, COUNT(news.news_id) as count_category
                        FROM themes
                        LEFT JOIN news
                        ON themes.theme_id = news.theme_id
                        GROUP BY themes.theme_title';

            case 'findById':
                return 'SELECT * FROM '.$param['table'].' WHERE news_id = '. $param['id'];
        }

    }



    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        $sql = $this->SQL_Request_Creator('fromGet');
//        $query1 =(new News())->findBySql($sql);
        $query =(new News())->findBySql('SELECT * FROM news ORDER BY date DESC ');

        $dataProvider = new ActiveDataProvider([
            'query' => $query ,
            'pagination' => [
                'pageSize' => 1,
            ],
        ]);

//        $query = \Yii::$app->db->createCommand()->query();
//        $query =(new News())->findOne('Select * from news Where news_id = 24');
//        $query = News::findBySql('Select * from news');
//        var_dump($query);
//        var_dump($query2);
//        die();

        $countQuery = clone $query;
        $pagination = new Pagination(['totalCount' => $countQuery->count(),  'pageSize' => 2]);
        $pagination->pageSizeParam = false;
        $selectNews = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $sql = $this->SQL_Request_Creator('groupByYearAndMonth');
        $groupByYearAndMonthFromBD = \Yii::$app->db->createCommand($sql)->queryAll();

        foreach ($groupByYearAndMonthFromBD as $item){
            $sortByYearAndMonthForView[$item['year']][$item['month']] = $item['count_news'];
        }

        $sql = $this->SQL_Request_Creator('sortByCategory');
/*
 * 'SELECT themes.theme_title, COUNT(news.news_id) as count_category
                FROM themes
                LEFT JOIN news
                ON themes.theme_id = news.theme_id
                GROUP BY themes.theme_title'
 */
        $selectCategory = \Yii::$app->db->createCommand($sql)->queryAll();

        return $this->render('index', ['sortByYearAndMonthForView' => $sortByYearAndMonthForView,
                                       'selectNews'=> $selectNews,
                                       'selectCategory' => $selectCategory,
                                       'pagination' => $pagination,
            'dataProvider' => $dataProvider
                                      ]);
    }

    public function actionOne(int $id)
    {
        $sql = $this->SQL_Request_Creator('findById', ['id' => $id, 'table' => 'news']);
        $article = (new News())->findBySql($sql)->one();
        return $this->render('one', ['article' => $article]);
    }
}
