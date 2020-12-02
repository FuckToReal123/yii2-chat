<?php

/**
 * @var $this \yii\web\View
 * @var $model \app\models\MessageEditForm
 * @var $messageModel \app\models\Message
 */

use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

$this->title = "Изменение сообщения №{$messageModel->id}";
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?= $this->title ?></h2>

<?=
DetailView::widget([
    'model' => $messageModel,
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

<div class="edit-user-role">
    <div class="row">
        <div class="col-md-6">
            <?php $form = ActiveForm::begin() ?>

            <?= $form->errorSummary($model) ?>

            <?= $form
                ->field($model, 'status')
                ->dropDownList($messageModel->getStatuses())
                ->label('Статус сообщения')
            ?>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

