<?php
$this->breadcrumbs=array(
	'Items'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Item','url'=>array('index')),
);
?>

<h1>Create Items</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>