<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
//use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
'id' => 'login-form',
'options' => ['class' => 'form-horizontal'],
]) ?>
<?= $form->field($newArticle, 'title')->textInput(); ?>
<?= $form->field($newArticle, 'text')->textarea() ?>

<?php ActiveForm::end() ?>

<div class="admin-default-index">
    <h1><?= $this->context->action->uniqueId ?></h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
</div>

<?php
var_dump($newArticle);
?>
