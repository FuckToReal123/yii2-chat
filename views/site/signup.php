<?php
/**
 * @var $model app\models\User
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h2><?= Html::encode($this->title) ?></h2>
    <p>Пожалуйста заполните следующие поля для регистрации:</p>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->errorSummary($model) ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Имя') ?>
            <?= $form->field($model, 'email')->label('email') ?>
            <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>
            <div class="form-group">
                <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
