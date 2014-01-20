<?php
/* @var $this TemoController */
/* @var $model Temo */

$this->breadcrumbs=array(
	'Temos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Temo', 'url'=>array('index')),
	array('label'=>'Manage Temo', 'url'=>array('admin')),
);
?>

<h1>Create Temo</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>