<?php
/**
 * @var $model \app\models\Message
 */

use \app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;

$author = User::findIdentity($model->user_id);
$isSelfMessage = $model->user_id === Yii::$app->user->id;
$userRoles = Yii::$app->authManager->getRolesByUser($model->user_id);
$isAdminMessage = in_array(User::ROLE_ADMIN, array_column($userRoles, 'name'));
$messageTitle = 'Сообщение пользователя';
$isIncorrectMessage = $model->status === $model::STATUS_INCORRECT;

$messageClasses = ['message'];

if ($isSelfMessage) {
    $messageClasses[] = 'self-message';
    $messageTitle = 'Ваше сообщение';
}

if ($isAdminMessage) {
    $messageClasses[] = 'admin-message';
    $messageTitle = 'Сообщение администратора';
}
?>

<div class="<?= implode(' ', $messageClasses) ?>"
     data-placement="<?= $isSelfMessage ? 'left' : 'right'?>"
     data-toggle="tooltip"
     title="<?= $messageTitle ?>"
>
  <span class="author"><b><?= $author->username ?>: </b></span>
    <?php if (Yii::$app->user->can('administer')): ?>
        <?= Html::a($model->text, Url::toRoute(['/message/update', 'id' => $model->id]), ['target' => '_blank']) ?>
    <?php else: ?>
        <?= $model->text ?>
    <?php endif; ?>
</div>
