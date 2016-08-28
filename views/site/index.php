<?php
use yii\grid\GridView;
/* @var $this yii\web\View */

$this->title = '2ая часть задания';
?>
<div class="site-index">

    <div class="alert alert-info text-center">
        <h2>Вторая часть практического задания</h2>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-4 text-center">
                <strong>Выберите номер задания</strong>
                <form method="post" id="sql">
                    <select size="1" name="task[]">
                        <option disabled>Выберите номер задания</option>
                        <option value="1">Задание 1</option>
                        <option value="2">Задание 2</option>
                        <option value="3">Задание 3</option>
                        <option value="4">Задание 4</option>
                        <option value="5">Задание 5</option>
                        <option value="6">Задание 6</option>
                    </select>
                    <input type="submit" value="Отправить">
                </form>
            </div>
            <div class="col-lg-8">
                <?php if (!empty($taskText)):?>
                    <strong>Текст задачи № <?= $numberTask?></strong>
                    <p>
                        <?= $taskText ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h2>Текст запроса</h2>
                <div style=" width:452px; height:300px; overflow: auto;">
                    <p><?= $sqlText ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <h2>Ответ</h2>

                <p>
                    <?php
                        echo (false == $dataProvider)?$answer : GridView::widget([
                                                                'dataProvider' => $dataProvider]);
                    ?>
                </p>
            </div>
        </div>

    </div>
</div>
