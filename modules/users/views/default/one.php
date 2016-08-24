<?php
use yii\helpers\Html;
?>

<div class="text-info text-center" xmlns="http://www.w3.org/1999/html">
    <h1>Страница для одной новости</h1>
</div>

<hr>

<div class="container">
    <div class="page-container"
        <div class="row">
            <div class="col-md-2">
                <div class="text-justify">
                    Это главная панель инструментов. Сюда в случае необходимости можно добавить различные компоненты управления.
                </div>
                <hr>
                <p>
                    <a href="/"> <?= Html::submitButton('Все новости', ['class' => 'btn btn-success btn-lg',
                                                                                   'style' => 'width:110%']) ?>
                    </a>
                </p>

            </div>
            <hr>
            <div class="col-md-10 ">
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
            </div>
        </div>
    </div>
</div>