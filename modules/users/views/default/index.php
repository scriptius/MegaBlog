<?php
use yii\helpers\Html;
?>

<div class="text-info text-center" xmlns="http://www.w3.org/1999/html">
    <h1>Главная страница модуля вывода новостей</h1>
</div>

<hr>

<div class="container">
    <div class="page-container"
        <div class="row">
            <div class="col-md-2">
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

                <hr>
                <div class="h4">
                    Категории
                </div>

                <?php foreach($selectCategory as $category): ?>
                    <div class="pager">
                        <a href="/users/default/index/<?= $category['theme_title'] ?>"> <?= $category['theme_title'].' ('. $category['count_category'].')'; ?></a>
                    </div>
                <?php endforeach; ?>
            </div>
            <hr>

            <div class="col-md-10 ">
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
                    <hr>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>