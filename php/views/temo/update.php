<?php
/* @var $this TemoController */
/* @var $model Temo */

$this->breadcrumbs=array(
	'Temos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Temo', 'url'=>array('index')),
	array('label'=>'Create Temo', 'url'=>array('create')),
	array('label'=>'View Temo', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Temo', 'url'=>array('admin')),
);
?>

<h1>Update Temo <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>