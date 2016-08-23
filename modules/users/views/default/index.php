<?php
use yii\helpers\Html;
?>

<div class="text-info text-center" xmlns="http://www.w3.org/1999/html">
    <h1>Главная страница модуля вывода новостей</h1>
</div>

<hr>

<?php
arsort($sortByYearAndMonthForView[2016]);
var_dump($sortByYearAndMonthForView);
?>
?>

<div class="container">
    <div class="page-container"
        <div class="row">
            <div class="col-md-2">
                <?php foreach ($sortByYearAndMonthForView as $year => $item):?>
                    <div class="h4">
                    <?= $year; ?>
                    </div>
                    <?php foreach ($item as $year => $count):?>
                        <div class="pager">
                        <?= $year.'('. $count.')'; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
            <hr>

            <div class="col-md-10 ">
            </div>
        </div>
    </div>
</div>