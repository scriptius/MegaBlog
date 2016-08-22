<?php
use yii\helpers\Html;
?>

<div class="text-info text-center">
    <h1>Главная страница модуля администрирования блога</h1>
</div>

<hr>

<div class="container">
    <div class="row">
        <div class="col-md-2">
            <div class="text-justify">
                Это панель инструментов. Сюда при необходимости можно добавить различные меню управления.
            </div>
        </div>
        <div class="col-md-10">
            <?php  foreach ($news as $article): ?>
            <?= var_dump($article); ?>
<!--            --><?//= $article['theme']; ?>
<!--            --><?//= $article['title']; ?>
<!--            --><?//= $article['title']; ?>
<!--            --><?//= $article['title']; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

