<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

$this->title = 'My Yii Test Application';
?>
<div class="site-index">

    <div class="jumbotron">

        <p class="lead">Simple scheme of the translations of balance.</p>
        <p class="lead">Registration or become authorized. </p>
        <p class="lead">During creation of the new user to you will be will add positive balance.</p>

    </div>

    <div class="body-content">
        <?php if (!Yii::$app->user->isGuest) { ?>

            <div class="conversion">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'user_id')->hiddenInput()->label(false); ?>
                <?= $form->field($model, 'user_id_to_translate')->dropdownList($users) ?>
                <?= $form->field($model, 'translation') ?>
                <?= $form->field($model, 'time_transaction')
                    ->textInput(['autocomplete' => 'off','value' => date('Y-m-d H:i')])
                    ->widget(DateTimePicker::class, [
                        'name' => 'time_transaction',
                        'value' => date('Y-m-d H:i'),
                        'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                        'pluginOptions' => [
                            'format' => 'yyyy-mm-dd hh:ii',
                            'autoclose' => true,
                            'todayBtn' => true
                        ]
                    ]) ?>
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
                'id',
                'username',
                'conversion.translation',
                'conversion.time_transaction',
                'conversionsumma' => ['label' => 'Not transferred amount', 'attribute' => 'conversionsumma'],
                'balance',
            ],
        ]); ?>

    </div>
</div>
