<?php
/* @var $this ItemController */
/* @var $model Item */
/* @var $form TbActiveForm */
?>

<?php $checkCondition = in_array(Yii::app()->controller->action->id, array('create', 'update'));
    $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'item-form',
	'enableAjaxValidation'=>true,
        'type' => 'horizontal',
         'htmlOptions' => array('enctype' => 'multipart/form-data'),
));/* @var $form TbActiveForm */ ?>
<?php if ($checkCondition):?>
    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
<?php endif;?>
<div class="row-form">
	<?php //echo $form->textAreaRow($model,'value',array('rows'=>6, 'cols'=>50, 'class'=>'span')); 
        echo $form->fileFieldRow($model, 'csv');
        ?>

</div>
<div class="form-actions">

    <?php 
        if ($checkCondition)                    
        $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'label'=>$model->isNewRecord ? 'Create items' : 'Update items',
)); ?>
&nbsp;
<?php echo CHtml::link("Back", array("index"), array("class" => "btn btn-primary")) ?></div>

<?php $this->endWidget(); ?>
