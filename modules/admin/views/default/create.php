<?php
use yii\bootstrap\ActiveForm;
use \app\modules\admin\models\Themes;
use yii\helpers\ArrayHelper;



$attrs = ArrayHelper::map(Themes::find()->all(), 'theme_id','theme_title');
?>
<div class="text-info text-center">
<h1>Создать новость</h1>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-2">
            ff
        </div>
            <div class="col-md-10">
                <?php
                    $form = ActiveForm::begin([
                    'id' => 'news-form',
                    'options' => ['class' => 'form-horizontal'],
                     ]);
                ?>
                 <?= $form->field($newArticle, 'theme_id')->dropdownList(
                     ['Выберите тему новости..' => $attrs]
                 );
                 ?>
                 <?= $form->field($newArticle, 'title')->textInput(['size' => 5]); ?>
                 <?= $form->field($newArticle, 'text')->textarea(['cols' => 2, 'rows' => 5]) ?>

                 <?= $form->field($newArticle, 'date')->widget(\yii\jui\DatePicker::classname(),
                    [
                        'language' => 'ru',
                        'dateFormat' => 'yyyy-MM-dd',
                    ]
                ) ?>
            <?php ActiveForm::end() ?>

        </div>
    </div>
</div>
