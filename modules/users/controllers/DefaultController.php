<?php

namespace app\modules\users\controllers;

use app\modules\admin\models\News;
use yii\web\Controller;
use yii\data\Pagination;

/**
 * Default controller for the `Users` module
 * @author Mamonov Viktor
 */
class DefaultController extends Controller
{
    /**
     * @param string $mode what kind of text to create a sql-query
     * @return string text sql-query
     * Данный метод задумывался для того чтобы генерировать текст SQL-запроса по заданным параметрам.
     * Данную возможность реализовал, т.к нельзя пользоваться DAO. Можно вынести его в отдельный компонент,
     * но я решил оставить его здесь. Вообще не совсем верно с арихитектурной точки зрения делать контроллеры
     * такими большими, но для простоты проверки я включил все сюда.
     */
    protected function SQL_Request_Creator(string $mode, $param = NULL)
    {
        switch ($mode){
            case 'fromGet': /* Здесь генерируется SQL-запрос для выборки новостей в соотвествии с условиями (все|категория|год и месяц)
                               перед генерацией SQL-запроса проверяется наличие параметров из $_GET */
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


            case 'groupByYearAndMonth': /* Здесь генерируется SQL-запрос выборки данных для сортировки по годам и месяцам*/
                return "SELECT UNIX_TIMESTAMP(`date`) as timestamp, DATE_FORMAT(`date`, '%Y') as year, DATE_FORMAT(`date`, '%M') as month, COUNT(news_id) as count_news
                        FROM news 
                        GROUP BY DATE_FORMAT(`date`, '%M'), DATE_FORMAT(`date`, '%Y')
                        ORDER BY date DESC";

            case 'sortByCategory': /* Здесь генерируется SQL-запрос выборки данных для сортировки по категориям */
                return 'SELECT themes.theme_title, COUNT(news.news_id) as count_category
                        FROM themes
                        LEFT JOIN news
                        ON themes.theme_id = news.theme_id
                        GROUP BY themes.theme_title';

            case 'findById': /* Здесь генерируется SQL-запрос выборки данных по id */
                return 'SELECT * FROM '.$param['table'].' WHERE news_id = '. $param['id'];
        }

    }

    /**
     * Renders the index view for the module
     * @return string view
     */
    public function actionIndex()
    {
        /* Здесь генерируется SQL-запрос для выборки новостей в соотвествии с условиями (все|категория|год и месяц)
           В данном случае не используется метод SQL_Request_Creator, т.к для пагинации требуется использование DAO */
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

        // Формирование пагинации
        $pagination = new Pagination(['totalCount' => $query->count(),  'pageSize' => 5]);
        $selectNews = $query->orderBy('date DESC')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        // Формирование сортировки по годам и месяцам
        $sql = $this->SQL_Request_Creator('groupByYearAndMonth');
        $groupByYearAndMonthFromBD = \Yii::$app->db->createCommand($sql)->queryAll();

        // Обработка данных сортировки по годам и мсяцам в удобном для вывода виде
        foreach ($groupByYearAndMonthFromBD as $item){
            $sortByYearAndMonthForView[$item['year']][$item['month']] = $item['count_news'];
        }

        // Формирование сортировки по категории
        $sql = $this->SQL_Request_Creator('sortByCategory');
        $selectCategory = \Yii::$app->db->createCommand($sql)->queryAll();

        return $this->render('index', ['sortByYearAndMonthForView' => $sortByYearAndMonthForView,
                                       'selectNews'=> $selectNews,
                                       'selectCategory' => $selectCategory,
                                       'pagination' => $pagination,
                                      ]);
    }

    /**
     * @param int $id identifier for search one article
     * @return string view
     */
    public function actionOne(int $id)
    {
        $sql = $this->SQL_Request_Creator('findById', ['id' => $id, 'table' => 'news']);
        $article = (new News())->findBySql($sql)->one();
        return $this->render('one', ['article' => $article]);
    }
}
