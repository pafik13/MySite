<?php

class UserController extends Controller
{
	public function actionList()
	{
		$this->render('list');
	}

	public function actionReport($mp_id, $pr_id)
	{
            if (isset($pr_id)) {
                $project = Project::model()->findByPk($pr_id);
            }
            $medpred = User::model()->findByPk($mp_id);
            $firstDate = filter_input(INPUT_POST, 'firstDate');
            if (!isset($firstDate)) {
                $f_Date = date('Y-m-d');
            } else {
                $f_Date = date('Y-m-d', CDateTimeParser::parse($firstDate, 'dd.MM.yyyy'));
            }
            
            $lastDate = filter_input(INPUT_POST, 'lastDate');
            if (!isset($lastDate)) {
                $l_Date = date('Y-m-d');
            } else {
                $l_Date = date('Y-m-d', CDateTimeParser::parse($lastDate, 'dd.MM.yyyy'));
            }
            $sql = 'CALL one.REPORT(:imei, :f_date, :l_date)';
            $command=Yii::app()->db->createCommand($sql);
            $command->bindParam(":imei", $medpred->IMEI, PDO::PARAM_STR);
            $command->bindParam(":f_date", $f_Date, PDO::PARAM_STR);
            $command->bindParam(":l_date", $l_Date, PDO::PARAM_STR);
            $dataReader = $command->queryAll();
            if (isset($_POST['dl'])) {
                $manager = User::model()->findByPk(Yii::app()->user->getID());
                $this->download($dataReader, $manager, $medpred, $firstDate, $lastDate);
            } else {
                $this->render('report', array('data'=>$dataReader, 'medpred'=>$medpred, 'firstDate'=>$firstDate, 'lastDate'=>$lastDate, 'project'=>$project));
            }
	}
        
        function download($data, $m, $mp, $f_d, $l_d) {
            require '/download-xlsx_1.php';
            //spl_autoload_register(array('YiiBase','autoload'));            
        }
        
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}