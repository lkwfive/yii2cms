<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Menu;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if($model->menu):?>
    <?= $form->field($model, 'parent')->dropDownList($model->parents, ['options' => [$model->parent => ['Selected'=>'selected'], $model->menu->id=>['disabled'=>true]]]) ?>
    <?php else:?>
    <?= $form->field($model, 'parent')->dropDownList($model->parents) ?>
    <?php endif;?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->widget(\yii\redactor\widgets\Redactor::className(), [
        'clientOptions' => [
            'imageManagerJson' => ['/redactor/upload/image-json'],
            'imageUpload' => ['/redactor/upload/image'],
            'fileUpload' => ['/redactor/upload/file'],
            'lang' => 'zh_cn',
            'buttons'=> ['image','html'],
            'plugins' => ['imagemanager']
        ]
    ])?>

    <?= $form->field($model, 'target')->dropDownList(Menu::$targets) ?>

    <?= $form->field($model, 'isShow')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
