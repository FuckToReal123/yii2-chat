<?php

/**
 * @var $model \app\models\MessageForm
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<div class="send-message">
    <?php $form = ActiveForm::begin(['id' => 'form-send-message']); ?>

  <div class="form-row row">
      <?= $form->errorSummary($model) ?>
    <div class="col-md-10">
        <?= $form
            ->field($model, 'text')
            ->textarea(['placeholder' => 'Введите сообщение...'])
            ->label(false)
        ?>
    </div>
    <div class="col-md-2">
        <?= Html::submitButton('Отправить', [
            'class' => 'btn btn-primary',
            'name' => 'send-message-button',
            'value' => 'send'
        ]) ?>
    </div>
  </div>

    <?php ActiveForm::end(); ?>
</div>
