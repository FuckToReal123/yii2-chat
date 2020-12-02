<?php

/**
 * @var $this \yii\web\View
 * @var $model \app\models\Message
 */

use app\models\User;
use yii\widgets\DetailView;
use \yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Просмотр информации о сообщении №{$model->id}";
$this->params['breadcrumbs'][]= $this->title;
?>

<h2><?= $this->title ?></h2>

<?=
DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'text',
        [
            'attribute' => 'user_id',
            'format'=>'raw',
            'value' => function($model) {
                return Html::a(
                    User::findOne(['id' => $model->user_id])->username,
                    Url::toRoute(['/user/view', 'id' => $model->id])
                );
            },

        ],
        [
            'attribute' => 'status',
            'value' => function($model) {
                return $model->getStatuses()[$model->status];
            }
        ],
        [
            'attribute' => 'created_at',
            'value' => function($data) {
                return date('d.m.Y H:i:s', $data->created_at);
            }
        ],
        [
            'attribute' => 'updated_at',
            'value' => function($data) {
                return date('d.m.Y H:i:s', $data->updated_at);
            }
        ],
    ],
]);
?>

<?= Html::a('Изменить', Url::toRoute(['/message/update', 'id' => $model->id]), ['class' => 'btn btn-primary']) ?>
