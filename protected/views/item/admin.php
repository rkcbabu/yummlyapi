<?php
$this->breadcrumbs = array(
    'Items' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'Create Item', 'url' => array('create')),
);
?>
<h1>Manage Items</h1>
<?php echo CHtml::link('Create Items with CSV', array('create'), array('class' => 'btn')); ?>
<?php
$this->widget('bootstrap.widgets.TbExtendedGridView', array(
    'id' => 'item-grid',
    'fixedHeader' => FALSE,
    'headerOffset' => 40,
    'type' => 'striped',
    'responsiveTable' => true,
    'ajaxUrl' => Yii::app()->request->getUrl(),
    'dataProvider' => $model->search(),
    'filter' => $model,
    'template' => '{items}{summary}{pager}',
    'columns' => array(
        array('name' => 'id',
            'value' => '$data->id',
        ),
        array('name' => 'url',
            'value' => '$data->url',
        ),
//		array('name' => 'value1',
//                    'value' => '$data->value1',
//                ),
        array(
            'header' => 'Actions',
            'template' => '{view}{update}{delete}',
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
));
?>
