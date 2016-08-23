<?php

namespace app\modules\users\controllers;

use app\modules\admin\models\News;
use yii\web\Controller;

/**
 * Default controller for the `Users` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        /*
         *
         *  SELECT
UNIX_TIMESTAMP(`date`) as timestamp,
DATE_FORMAT(`date`, '%Y') as year, DATE_FORMAT(`date`, '%M') as month, COUNT(news_id) as count_news
FROM news
GROUP BY DATE_FORMAT(`date`, '%M')
ORDER BY timestamp DESC
         */

        $sql = "SELECT UNIX_TIMESTAMP(`date`) as timestamp, DATE_FORMAT(`date`, '%Y') as year, DATE_FORMAT(`date`, '%M') as month, COUNT(news_id) as count_news
                FROM news 
                GROUP BY DATE_FORMAT(`date`, '%M')
                ORDER BY timestamp DESC";
        $groupByYearAndMonthFromBD = \Yii::$app->db->createCommand($sql)->queryAll();;
        
        foreach ($groupByYearAndMonthFromBD as $item){
            $sortByYearAndMonthForView[$item['year']][$item['month']] = $item['count_news'];
        }

        return $this->render('index', ['sortByYearAndMonthForView' => $sortByYearAndMonthForView]);
    }
}
