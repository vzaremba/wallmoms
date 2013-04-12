<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comment-form',
	'enableAjaxValidation'=>true,
    'action' => $action_url
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Submit' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->















<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'comment-form',
    //'action'=>Yii::app()->createUrl('/post/createc/'), // тут конечно ваша ссылка для добавления коммента
    'action' => $action_url,
    'enableClientValidation'=>false,
    'enableAjaxValidation'=>true, // Включаем аякс отправку
    'clientOptions'=>array(
        'validateOnSubmit'=>true,
        'validateOnChange'=>false,
        'inputContainer'=>'.controls',
        'afterValidate'=>'js:function(form, data, hasError){
            if(!hasError){
                //window.location.reload(true); // можете написать вашу функцию
                $.fn.yiiListView.update("comments");
            }
        }'
    )
)); ?>

<div class="controls">
  <?php echo $form->textArea($model,'content', array('rows'=>3, 'class'=>'redactor')); ?>
  <?php echo $form->error($model,'content', array('class'=>'alert alert-error')); ?>
</div>

<div class="controls ta-right">
  <?php echo CHtml::htmlButton($model->isNewRecord ? 'Опубликовать' : 'Сохранить', array('class'=>'btn', 'type'=>'submit') ); ?>
</div>

<?php $this->endWidget(); ?>