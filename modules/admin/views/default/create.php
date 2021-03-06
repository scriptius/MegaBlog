<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<div class="text-info text-center">
<h1>Создать новость</h1>
</div>

<hr>

<div class="container">
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
        </div>
        <div class="col-md-10">
            <?php
                    $form = ActiveForm::begin([
                    'id' => 'news-form',
                    'action' => '/index.php/admin/addnews'
                     ]);
            ?>
            <?= $form->field($newArticle, 'news_id')->hiddenInput()->label(false); ?>
            <?= $form->field($newArticle, 'theme_id')->dropdownList(['Выберите тему новости..' => $attrs]); ?>
            <?= $form->field($newArticle, 'title')->textInput(['size' => 5]); ?>
            <?= $form->field($newArticle, 'text')->textarea(['cols' => 2, 'rows' => 5]) ?>

            <div class="col-md-6">
                <?= $form->field($newArticle, 'date')->widget(\yii\jui\DatePicker::classname(),
                        [
                            'language' => 'ru',
                            'dateFormat' => 'yyyy-MM-dd',
                        ])
                ?>
            </div>
            <div class="col-md-6 text-center">
                <?= Html::submitButton('Создать новость', ['class' => 'btn btn-success btn-lg']) ?>
            </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
