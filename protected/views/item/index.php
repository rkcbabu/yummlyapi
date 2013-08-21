<?php
$this->breadcrumbs=array(
	'Items',
);

$this->menu=array(
	array('label'=>'Create Item','url'=>array('create')),
	//array('label'=>'Manage Item','url'=>array('admin')),
);
?>

<h1>Items</h1>

<?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(
	'id'=>'item-grid',
	'fixedHeader' => true,
        'headerOffset' => 40, // 40px is the height of the main navigation at bootstrap
        'type' => 'striped',
        'responsiveTable' => true,
        'dataProvider' => $dataProvider,
	'columns'=>array(
		'id',
		'value',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>