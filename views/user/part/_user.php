<?php

/**
 * @var $model \app\models\User
 */

use yii\helpers\Html;
use yii\helpers\Url;

?>

<tr class="user-data">
  <td>
     <?= $model->id ?>
  </td>
  <td class="user-name">
      <?= $model->username ?>
  </td>
  <td class="user-view">
      <?= Html::a('Просмотр', Url::toRoute(['/user/view', 'id' => $model->id]), ['target' => '_blank']) ?>
  </td>
  <td class="user-update">
      <?= Html::a('Изменить', Url::toRoute(['/user/update', 'id' => $model->id]), ['target' => '_blank']) ?>
  </td>
</tr>
