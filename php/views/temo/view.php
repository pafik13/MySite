<?php
/* @var $this TemoController */
/* @var $model Temo */

$this->breadcrumbs=array(
	'Temos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Temo', 'url'=>array('index')),
	array('label'=>'Create Temo', 'url'=>array('create')),
	array('label'=>'Update Temo', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Temo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Temo', 'url'=>array('admin')),
);
?>

<h1>View Temo #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'xml',
	),
)); ?>
