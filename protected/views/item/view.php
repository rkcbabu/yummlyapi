<?php
$this->breadcrumbs=array(
	'Items'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Manage Item','url'=>array('index')),
	array('label'=>'Create Item','url'=>array('create')),
	array('label'=>'Update Item','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Item','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1>View Item #<?php echo $model->id; ?></h1>

<?php 
//$this->widget('bootstrap.widgets.TbDetailView',array(
//	'data'=>$model,
//	'attributes'=>array(
//		array('name'=>'id','value'=>$model->id),
//		array('name'=>'value','value'=>$model->value),
//	),
//));
Main::out(unserialize($model->value2));
?>
<div class="form-actions">
<?php echo CHtml::link("Home", array("index"), array("class" => "btn btn-primary")); ?>
</div>