<?php

namespace app\modules\users\controllers;

use app\modules\admin\models\News;
use app\modules\admin\models\Themes;
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

        /*
        $sql = $this->SQL_Request_Creator('fromGet');
        $countNews = (new News())->findBySql('SELECT * FROM news ORDER BY date DESC')->count();
        $showPosts = 2;
        $page = (int)$_GET['page'];
        $steps = ceil($countNews/$showPosts);
        $limit = ($page -1) * $showPosts;

        $i = 1;
        do{
            echo $i;
            ++$i;
        }while($i <= $steps);

        echo '<br>';

        echo 'SELECT * FROM news ORDER BY date DESC limit '
            .$limit.', '.$showPosts;

//        die;

        if (!empty($_GET['page'])){
            $query =(new News())->findBySql('SELECT * FROM news ORDER BY date DESC limit '
                                            .$limit.', '.$showPosts)->all();
        }
        var_dump($query);
        die;
    */

//        switch(true){
//            case !empty($_GET['month']):
//                $where[] = ['DATE_FORMAT(`date`, \'%M\')' => (string)$_GET['month']];
//            case !empty($_GET['year']):
//                $where[] = ['DATE_FORMAT(`date`, \'%Y\')' => (string)$_GET['year']];
//            default:
//                $where[] = 1;
//        }
//        $sql = (true == $statusWhere)? 'SELECT * FROM news WHERE '.$where.' ORDER BY date DESC' :
//            'SELECT * FROM news ORDER BY date DESC';

        switch(true){
            case !empty($_GET['month']):
                $where .= ' DATE_FORMAT(`date`, \'%M\') = \''.(string)$_GET['month'].'\' and';
            case !empty($_GET['year']):
                $where .= ' DATE_FORMAT(`date`, \'%Y\') = \''.(string)$_GET['year'].'\'';
                break;
            default:
                $where = 1;
        }

        $query = News::find()->where($where);

        if(true == !empty($_GET['category'])){
            $query = News::find()->where('theme_id IN (SELECT theme_id
                                            FROM themes
                                            WHERE theme_title = \''.(string)$_GET['category'].'\')');

        }

        $pagination = new Pagination(['totalCount' => $query->count(),  'pageSize' => 5]);
        $selectNews = $query->orderBy('date DESC')
            ->offset($pagination->offset)
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
                                      ]);
    }

    public function actionOne(int $id)
    {
        $sql = $this->SQL_Request_Creator('findById', ['id' => $id, 'table' => 'news']);
        $article = (new News())->findBySql($sql)->one();
        return $this->render('one', ['article' => $article]);
    }
}
