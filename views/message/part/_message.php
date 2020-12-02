<?php

/**
 * @var $model \app\models\Message
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\User;

?>

<tr class="message-data">
    <td>
        <?= $model->id ?>
    </td>
    <td class="message-user">
        <?= Html::a(
            User::findOne(['id' => $model->user_id])->username,
            Url::toRoute(['/user/view', 'id' => $model->id]),
            ['target' => '_blank']
        ) ?>
    </td>
    <td class="user-view">
        <?= Html::a('Просмотр', Url::toRoute(['/message/view', 'id' => $model->id]), ['target' => '_blank']) ?>
    </td>
    <td class="user-update">
        <?= Html::a('Изменить', Url::toRoute(['/message/update', 'id' => $model->id]), ['target' => '_blank']) ?>
    </td>
</tr>
