<?php

/* @var $this yii\web\View */

$this->title = '2ая часть задания';
?>
<div class="site-index">

    <div class="alert alert-info text-center">
        <h2>Вторая часть практического задания</h2>
    </div>

    <div class="text-left">
        Текст задачи
    </div>


    <div class="body-content">
        <div class="row">
            <div class="col-lg-3">
                <h2>Выберите номер задания</h2>

                <form method="post" id="sql">
                    <p><select size="6" multiple name="task[]">
                            <option disabled>Выберите номер задания</option>
                            <option value="1">Задание 1</option>
                            <option value="2">Задание 2</option>
                            <option value="3">Задание 3</option>
                            <option value="4">Задание 4</option>
                            <option value="5">Задание 5</option>
                            <option value="6">Задание 6</option>
                        </select></p>
                    <p><input type="submit" value="Отправить"></p>
                </form>
            </div>
            <div class="col-lg-3">
                <h2>Текст запроса</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-6">
                <h2>Результат</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
