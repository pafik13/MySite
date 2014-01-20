<?php
/* @var $this TemoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Temos',
);

$this->menu=array(
	array('label'=>'Create Temo', 'url'=>array('create')),
	array('label'=>'Manage Temo', 'url'=>array('admin')),
);
?>

<h1>Temos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
