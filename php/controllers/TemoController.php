<?php

class TemoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('create','index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        
        //$xml = simplexml_load_string($model->xml);
        $doc = new DOMDocument();
        $doc->load('Demonstrations.xml');
        //$doc->loadXML($model->xml);
        //echo $model->xml;
        //echo $doc->documentElement;
        $Demonstrations = $doc->getElementsByTagName('Demonstration');

        for ($i = 0; $i < $Demonstrations->length; $i++) {
            if ($Demonstrations->item($i)->hasChildNodes()) {
                echo '<hr />'.$Demonstrations->item($i)->nodeName;
                echo '    '. $Demonstrations->item($i)->childNodes->item(1)->nodeValue;
                $v = new Visits;
                $v->doctor_id = $Demonstrations->item($i)->childNodes->item(1)->nodeValue;
                $v->save(FALSE);                
                if($Demonstrations->item($i)->childNodes->item(3)->hasChildNodes()) {
                    $demos = $Demonstrations->item($i)->childNodes->item(3)->childNodes;
                    for($vdi = 1; $vdi < $demos->length; $vdi = $vdi + 2) {
                        //echo '<hr />'.$demos->item($vdi)->nodeName;
                        //echo '   '.$demos->item($vdi)->childNodes->item(1)->nodeName;
                        $vd = new VisitDemos;
                        $vd->slide_key = $demos->item($vdi)->childNodes->item(1)->nodeValue;
                        $vd->visit_id = $v->id;
                        $vd->save(FALSE);
                        if ($demos->item($vdi)->childNodes->item(3)->hasChildNodes()) {
                            $shows = $demos->item($vdi)->childNodes->item(3)->childNodes;
                            for ($s = 1; $s < $shows->length; $s = $s + 2) {
                                $vds = new VisitDemoShows;
                                $vds->number = $shows->item($s)->childNodes->item(3)->nodeValue;
                                $vds->time = $shows->item($s)->childNodes->item(5)->nodeValue;
                                $vds->coord_latitude = $shows->item($s)->childNodes->item(7)->childNodes->item(3)->nodeValue;
                                $vds->coord_longtitude = $shows->item($s)->childNodes->item(7)->childNodes->item(1)->nodeValue;
                                $vds->demo_id = $vd->id;
                                $vds->save(FALSE);
                            }
                        }
                    }
                }
            }
        }
        
//        foreach ($Demonstrations as $d) {
//            $v = new Visits;
//            $v->doctor_id = $d->doctorID;
//            //$demons->visit_date = $d->Demo[0]->Show[0]->date;
//            $v->save(false);
//        }
        $this->render('view', array(
            'model' => $model,
        ));
    }

    /**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Temo;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Temo']))
		{
			$model->attributes=$_POST['Temo'];
			if($model->save()) {
                                $this->redirect(array('view','id'=>$model->id));
                        }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Temo']))
		{
			$model->attributes=$_POST['Temo'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Temo');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Temo('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Temo']))
			$model->attributes=$_GET['Temo'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Temo the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Temo::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Temo $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='temo-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
