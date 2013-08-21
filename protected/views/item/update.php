<?php
/* @var $this ItemController */
/* @var $model Item */

$this->breadcrumbs=array(
	'Items'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Manage Item','url'=>array('index')),
	array('label'=>'Create Item','url'=>array('create')),
	array('label'=>'View Item','url'=>array('view','id'=>$model->id)),
);
?>
<h1>Update Items</h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>