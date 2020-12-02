<?php

/**
 * @var $this \yii\web\View
 * @var $dataProvider \yii\data\ActiveDataProvider
 */

use yii\widgets\ListView;
use \app\assets\UserAsset;

UserAsset::register($this);
$this->title = 'Список сообщений';
$this->params['breadcrumbs'][]= $this->title;
?>

<h2><?= $this->title ?></h2>

<?=
ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => 'part/_message',
    'layout' => "{items}\n{summary}\n{pager}\n",
    'viewParams' => [
        'fullView' => true,
        'context' => 'main-page',
    ],
    'options' => [
        'class' => 'message-list table',
        'tag' => 'table'
    ]
]);
?>
