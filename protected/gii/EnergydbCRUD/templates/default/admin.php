<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n";
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	'$label'=>array('index'),
	'Manage',
);\n";
?>

$this->menu=array(
	array('label'=>'Create <?php echo $this->modelClass; ?>','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage <?php echo $this->pluralize($this->class2name($this->modelClass)); ?></h1>

<?php echo "<?php echo CHtml::link('Create', array('create'), array('class' => 'btn'));?>\n
<br><br>"; ?>
<?php echo "<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn'));?>"; ?>

<div class="search-form" style="display:none">
<?php echo "<?php \$this->renderPartial('_search',array(
	'model'=>\$model,
)); ?>\n"; 
?>
</div><!-- search-form -->

<?php echo "<?php"; ?> $this->widget('bootstrap.widgets.TbExtendedGridView',array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
	'fixedHeader' => false,
        'headerOffset' => 40, 
        'type' => 'striped',
        'responsiveTable' => true,
        
        'ajaxUrl' => Yii::app()->request->getUrl(),
        'dataProvider' => $model->search(),
        'filter' => $model,
        'template' => '{items}{summary}{pager}',
	'columns'=>array(
<?php
$count=0;
foreach($this->tableSchema->columns as $column)
{
	if(++$count==7)
		echo "\t\t/*\n";
	//echo "\t\t'".$column->name."',\n";
        echo "\t\tarray('name' => '$column->name',
                    'value' => '\$data->$column->name',
                ),\n";
}
if($count>=7)
	echo "\t\t*/\n";
?>
		array(
                    'header'=>'Actions',
                    'template'=>'{view}{update}{delete}',
                    'class' => 'bootstrap.widgets.TbButtonColumn',
                ),
	),
)); ?>
