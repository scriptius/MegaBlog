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
                        <a href="<?= $year; ?>"> <?= $year; ?></a>
                    </div>
                    <?php foreach ($item as $month => $count):?>
                        <div class="pager">
                        <?= $month.' ('. $count.')'; ?>
                        </div>
                    <?php endforeach; ?>
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
                    <?= $article->text; ?>
                    <hr>
                <?php endforeach; ?>


            </div>
        </div>
    </div>
</div>