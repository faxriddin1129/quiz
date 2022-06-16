<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\TgUser */

$this->title = Yii::t('app', 'Create Tg User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tg Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tg-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
