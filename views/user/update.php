<?php

/**
 * @var $this \yii\web\View
 * @var $model \app\models\UserForm
 * @var $userModel \app\models\User
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

$this->title = "Изменение роли пользователя {$userModel->username}";
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?= $this->title ?></h2>

<?=
DetailView::widget([
    'model' => $userModel,
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

<div class="edit-user-role">
  <div class="row">
      <div class="col-md-6">
          <?php $form = ActiveForm::begin() ?>

          <?= $form->errorSummary($model) ?>

          <?= $form
              ->field($model, 'role')
              ->dropDownList($model->getRolesList())
              ->label('Роль пользователя')
          ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>

          <?php ActiveForm::end(); ?>
      </div>
  </div>
</div>

