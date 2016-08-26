<?php
use yii\widgets\LinkPager;
?>

<div class="text-info text-center" xmlns="http://www.w3.org/1999/html">
    <h1>Главная страница модуля вывода новостей</h1>
</div>

<hr>

<div class="container">
    <div class="page-container"
        <div class="row">
            <div class="col-md-2">
<!--                Формирование боковой панели сортировки по годам и месяцам-->
                <?php foreach ($sortByYearAndMonthForView as $year => $item):?>
                    <div class="h4">
                        <a href="/users/default/index/<?= $year; ?>"> <?= $year; ?></a>
                    </div>
                    <?php foreach ($item as $month => $count):?>
                        <div class="pager">
                            <a href="/users/default/index/<?= $year.'/'.$month ?>"> <?= $month.' ('. $count.')'; ?></a>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
<!--                    Окончание формирования боковой панели сортировки по годам и месяцам-->
                <hr>

                <div class="h4">
                    Категории
                </div>
<!--                     Формирование боковой панели сортировки по категориям-->
                <?php foreach($selectCategory as $category): ?>
                    <div class="pager">
                        <a href="/users/default/index/<?= $category['theme_title'] ?>"> <?= $category['theme_title'].' ('. $category['count_category'].')'; ?></a>
                    </div>
                <?php endforeach; ?>
<!--                Окончание формирования боковой панели сортировки по категориям-->
            </div>
            <hr>

            <div class="col-md-10 ">
<!--                Формирование блока новостей-->
                <?php foreach ($selectNews as $article): ?>
                    <div class="col-md-6 text-left">
                        <?= 'Дата публикации: '.$article->date; ?>
                    </div>
                    <div class="col-md-6 text-right">
                        <?= 'Категория: '. $article->theme->theme_title; ?>
                    </div>
                    <div class="h3 text-success">
                        <?= $article->title; ?>
                    </div>
                    <?= mb_substr($article->text, 0, 255).' ...'; ?>
                    <a href="/users/one/<?= $article->news_id ?>">Читать далее</a>
                    <hr>
                <?php endforeach; ?>
<!--                Окончание формирования блока новостей-->
<!--                Формирование блока пагинации-->
                <?php
                    echo LinkPager::widget(['pagination' => $pagination ]);
                ?>
<!--                Окончание формирования блока пагинации-->
            </div>
        </div>
    </div>
</div>

