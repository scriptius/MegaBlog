<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<!--Вывод флеш-сообщений-->
<?php if(Yii::$app->session->hasFlash('addNews')): ?>
    <div class="alert alert-success text-center">
        <?php echo Yii::$app->session->getFlash('addNews'); ?>
    </div>
<?php endif; ?>
<!--Конец вывода флеш-сообщений-->
<div class="text-info text-center" xmlns="http://www.w3.org/1999/html">
    <h1>Главная страница модуля администрирования блога</h1>
</div>

<hr>

<div class="container">
    <div class="page-container"
        <div class="row">
            <div class="col-md-2">
<!--                Формирование боковой панели-->
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
                                                                                                'style' => 'width:110%']) ?> 
                    </a>
                </p>
<!--                Конец боковой панели-->
            </div>
            <div class="col-md-10 ">
<!--                Вывод новостей-->
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
                    <?= mb_substr($article->text, 0, 255).'...'; ?>
                    <p>
                        <a href="/index.php/admin/editnews/<?= $article->news_id; ?> ">Редактировать новость
                        </a>
                    </p>
                    <hr>
                <?php endforeach; ?>
<!--                Окончание вывода новостей-->
<!--                Пагинация-->
                <?php
                echo LinkPager::widget([
                    'pagination' => $pagination,
                ]);
                ?>
<!--                Конец пагинации-->
            </div>
        </div>
    </div>
</div>

