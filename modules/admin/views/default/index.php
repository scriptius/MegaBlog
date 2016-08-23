<?php
use yii\helpers\Html;
?>
<?php if(Yii::$app->session->hasFlash('addNews')): ?>
    <div class="alert alert-success text-center">
        <?php echo Yii::$app->session->getFlash('addNews'); ?>
    </div>
<?php endif; ?>

<div class="text-info text-center" xmlns="http://www.w3.org/1999/html">
    <h1>Главная страница модуля администрирования блога</h1>
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
                    <a href="/admin/default/index"> <?= Html::submitButton('HOME', ['class' => 'btn btn-success btn-lg',
                                                                                    'style' => 'width:110%']) ?>
                    </a>
                </p>
                <p>
                    <a href="/admin/default/create"> <?= Html::submitButton('Создать новость', ['class' => 'btn btn-success btn-lg',
                                                                                                'style' => 'width:110%']) ?> </a>
                </p>
            </div>
            <div class="col-md-10 ">
                <?php  foreach ($news as $article): ?>
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
                    <p>
                        <a href="/index.php/admin/default/editnews/<?= $article->news_id; ?> ">Редактировать новость</a>
                    </p>
                    <hr>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>

