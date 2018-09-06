<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\datetime\DateTimePicker;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">

        <p class="lead">Simple scheme of the translations of balance.</p>
        <p class="lead">Registration or become authorized. </p>
        <p class="lead">During creation of the new user to you will be will add positive balance.</p>

<!--        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>-->
    </div>

    <div class="body-content">
<?php    if (!Yii::$app->user->isGuest) {?>
        <div class="conversion">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'user_id')->hiddenInput()->label(false);?>
            <?= $form->field($model, 'user_id_to_translate')->dropdownList( ArrayHelper::map($users,'id','username')) ?>
            <?= $form->field($model, 'time_transaction')->textInput(['readonly' => false, 'value' => date('Y-m-d H:i')]) ?>
            <?= $form->field($model, 'translation') ?>

            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div><!-- conversion -->
        <?php } ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'id',
                'username',
                'conversion.translation',
                'conversion.time_transaction',
                'conversionsumma' => ['label'=>'Not transferred amount','attribute' =>'conversionsumma'],
                'balance',
            ],
        ]); ?>

    </div>
</div>
