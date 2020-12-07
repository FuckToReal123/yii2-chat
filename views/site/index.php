<?php

/**
 * @var $this yii\web\View
 * @var $messageFormModel \app\models\MessageForm
 * @var $messages \app\models\Message[]
 */

use yii\widgets\Pjax;

$this->title = 'Yii2-chat';
?>


<div class="chat-container container col-12">
    <?php Pjax::begin(['id' => 'live-chat']); ?>
  <div class="chat">
      <?php foreach ($messages as $message): ?>
          <?php if (Yii::$app->user->can('readMessages')): ?>
              <?php if ($message->status === $message::STATUS_INCORRECT): ?>
                  <?= $this->render('parts/_incorrectMessage', ['model' => $message]) ?>
              <?php else: ?>
                  <?= $this->render('parts/_message', ['model' => $message]) ?>
              <?php endif; ?>
          <?php endif; ?>
      <?php endforeach; ?>
  </div>

    <?php
    $this->registerJs(
        '$("document").ready(function(){
            setTimeout(function(){
                $.pjax.reload({container:"#live-chat"});
            },6000);
        });'
    );?>

    <?php Pjax::end(); ?>

    <?= $this->render('parts/_sendForm', ['model' => $messageFormModel]) ?>
</div>
