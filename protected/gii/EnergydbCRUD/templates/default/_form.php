<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php echo "<?php\n"; ?>
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */
/* @var $form TbActiveForm */
?>

<?php echo "<?php \$checkCondition = in_array(Yii::app()->controller->action->id, array('create', 'update'));
    \$form=\$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'".$this->class2id($this->modelClass)."-form',
	'enableAjaxValidation'=>true,
        'type' => 'horizontal',
));/* @var \$form TbActiveForm */ ?>\n"; ?>
<?php echo "<?php if (\$checkCondition):?>\n"?>
    <p class="help-block">Fields with <span class="required">*</span> are required.</p>

    <?php echo "<?php echo \$form->errorSummary(\$model); ?>\n"; ?>
<?php echo "<?php endif;?>\n"?>
<div class="row-form">
<?php
foreach($this->tableSchema->columns as $column)
{
	if($column->autoIncrement)
		continue;
        else if(preg_match('/status_id/i', $column->name)){
            echo "\t<?php echo \$form->toggleButtonRow(\$model, '$column->name'); ?>\n";
            continue;
        }
?>
	<?php echo "<?php echo ".$this->generateActiveRow($this->modelClass,$column)."; ?>\n"; ?>

<?php
}
?>
</div>
<div class="form-actions">
<?php echo "
    <?php 
        if (\$checkCondition)                    
        \$this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'label'=>\$model->isNewRecord ? 'Create' : 'Save',
)); ?>\n"; ?>
&nbsp;
<?php echo '<?php echo CHtml::link("Home", array("index"), array("class" => "btn btn-primary")) ?>' ?>
</div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>
