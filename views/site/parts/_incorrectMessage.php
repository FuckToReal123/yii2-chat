<?php
/**
 * @var $model \app\models\Message
 */

use \app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

$author = User::findIdentity($model->user_id);
?>

<div class="message message-incorrect" data-placement="right" data-toggle="tooltip" title="Некорректное сообщение">
    <?php if (Yii::$app->user->can('administer')): ?>
        <span class="author"><b><?= $author->username ?>: </b></span>
        <?= Html::a($model->text, Url::toRoute(['/message/update', 'id' => $model->id]), ['target' => '_blank']) ?>
    <?php else: ?>
        Сообщение отмечено как некорректное
    <?php endif; ?>
</div>
