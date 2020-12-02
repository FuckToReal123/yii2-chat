<?php

/**
 * @var $this \yii\web\View
 * @var $model \app\models\User
 */

use yii\widgets\DetailView;
use \yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Просмотр информации о пользователе {$model->username}";
$this->params['breadcrumbs'][]= $this->title;
?>

<h2><?= $this->title ?></h2>

<?=
DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'username',
        'email',
        [
            'attribute' => 'status',
            'value' => function($model) {
                return boolval($model->status) ? 'Активен' : 'Заблокирован';
            }
        ],
        [
            'attribute' => 'created_at',
            'value' => function($model) {
                return date('d.m.Y H:i:s', $model->created_at);
            }
        ],
        [
            'attribute' => 'updated_at',
            'value' => function($model) {
                return date('d.m.Y H:i:s', $model->updated_at);
            }
        ],
    ],
]);
?>

<?= Html::a('Изменить', Url::toRoute(['/user/update', 'id' => $model->id]), ['class' => 'btn btn-primary']) ?>
