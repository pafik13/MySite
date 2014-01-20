<?php

class UploadFilesController extends Controller
{
        public function actionCheckFile() {
            
            $model=new UploadFiles;
            $model->IMEI = filter_input(INPUT_GET, 'imei');
            $model->TYPE = filter_input(INPUT_GET, 'type');
            $model->HASH = filter_input(INPUT_GET, 'hash');
            //if ($model->validate()) {
            if(isset($model->IMEI) and isset($model->TYPE) and isset($model->HASH)) {
                $c = $model->count(array('condition' => 'imei = :i'
                                                 . ' AND type = :t'
                                                 . ' AND hash = :h' 
                                          , 'params' => array('i' => $model->IMEI
                                                             ,'t' => $model->TYPE
                                                             ,'h' => $model->HASH
                                                             )
                                        )
                                  );
                if($c === '1') {
                    echo 'FILE ALREADY UPLOADED';
                    //readfile('msg\uploaded.xml');
                } else {
                    echo 'FILE NEED UPLOAD';
                    //readfile('msg\need_upload.xml');
                }
                return;
            }
            echo 'IMEI = '.$model->IMEI.'<hr/>';
            echo 'TYPE = '.$model->TYPE.'<hr/>';
            echo 'HASH = '.$model->HASH.'<hr/>';
            //$this->render('checkfile',array('model'=>$model));
        }

	public function actionIndex()
	{
            $this->render('index');
	}

	public function actionParseFile() {
            
            $ufile = new UploadFiles;
            //$trans = $ufile->dbConnection->beginTransaction();
            try {
                $ufile->IMEI = filter_input(INPUT_POST, 'imei');
                $ufile->TYPE = filter_input(INPUT_POST, 'type');
                $ufile->HASH = filter_input(INPUT_POST, 'hash');
                $ufile->FILE = file_get_contents($_FILES['userfile']['tmp_name']);
                if($ufile->save()) {
                    $err = $this->ProcessFile($ufile);
                    if ($err != '') {
                        echo 'PROCESS ERRORS';
                        $ufile->ERR = $err;
                        $ufile->save(false);
                        print_r($err);
                    } else {
                        echo 'PROCESS GOOD';
                    }
                        
                } else {
                    readfile('msg\not_valid.xml');
                }
            }
            catch(Exception $e) {
                $ufile->ERR = $e->getMessage();
                $ufile->save();
                readfile('msg\exception.xml');
            }
	}
        
        
        function ProcessFile($ufile) {
            $trans = UploadFiles::model()->dbConnection->beginTransaction();
            switch ($ufile->TYPE) {
                case 'HospitalDB':
                    $err = ProcessHospitalDB::Process($ufile);
                    break;
                case 'DoctorDB':
                    $err = ProcessDoctorDB::Process($ufile);
                    break;
                case 'Demonstration':
                    $err = ProcessDemonstration::Process($ufile);
                    break;
            }
//            if($ufile->TYPE === 'HospitalDB') {
//                $err = ProcessHospitalDB::Process($ufile);//$this->ProccesHospitalDB($ufile);
//            }
            if ($err != '') {
//                echo 'rollback';
                $trans->rollback(); 
            } else {
//                echo 'commit';
                $trans->commit(); 
            }
            return $err;
        }
        
        public function actionForm() {
            echo '<!-- Тип кодирования данных, enctype, ДОЛЖЕН БЫТЬ указан ИМЕННО так -->
                  <form enctype="multipart/form-data" action="/index.php?r=uploadfiles/parsefile" method="POST">
                      <!-- Поле MAX_FILE_SIZE должно быть указано до поля загрузки файла -->
                      <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
                      <!-- Название элемента input определяет имя в массиве $_FILES -->
                      Отправить этот файл: <input name="userfile" type="file" /> <hr/>
                      Отправить этот imei: <input name="imei" type="text" value="3214151"/> <hr/>
                      Отправить этот type: <input name="type" type="text" value="HospitalDB"/> <hr/>
                      Отправить этот hash: <input name="hash" type="text" value="333xxx333"/> <hr/>
                      <input type="submit" value="Send File" />
                  </form>';
            
            $guest = Yii::app()->user->isGuest;
            if (!$guest) {
               echo '</hr>'.  Yii::app()->user->getId();
            }
             
//            $connection=Yii::app()->db; // так можно делать, если в конфигурации настроен компонент соединения "db"
//            // В противном случае можно создать соединение явно:
//            // $connection=new CDbConnection($dsn,$username,$password);
//            $sql = 'CALL one.proc(:id)';
//            $command=$connection->createCommand($sql);
//            $id = '333xxx333';
//            $command->bindParam(":id", $id, PDO::PARAM_STR);
//            $dataReader = $command->queryAll();
//            //while(($row=$dataReader->read())!==false) { … }
//            // используем foreach для построчного обхода данных
//            print_r($dataReader);
//            foreach($dataReader as $row) {
//                $command->
//                $sql = 'SELECT * FROM one.';
//                $command=$connection->createCommand($sql); 
//                
//            }
            // при необходимости SQL-выражение можно изменить:
            // $command->text=$newSQL;
        }
        
//        public function ProccesHospitalDB ($ufile) {
//            $err = '';
//            if (isset($ufile)) {
//                //$ret = TRUE;
//                $imei = (int)$ufile->IMEI; 
//                $hxml = simplexml_load_string($ufile->FILE);
//                
//                $hospitals = $hxml->children();
//                foreach ($hospitals as $h) {
//                     $err = $err.$this->SaveHospital($imei, $h);
//                        
//                    $plannerItems = $h->planners->children();
//                    foreach ($plannerItems as $pI) {
//                         $err = $err.$this->SaveHPlannerItem($imei, $h->ID, $pI); 
//                    }
//                }
//                return $err;
//            }
//            return 'HospitalDB FILE NOT FOUND';
//        }
//        
//        function SaveHospital($imei, $xmlhospital) {
//            $newHospital = Hospital::model()->find(array('condition' => 'imei = :i'
//                                                                 . ' AND hospital_id = :h_id', 
//                                                         'params' => array('i' => $imei,
//                                                                        'h_id' => $xmlhospital->ID
//                                                                           )
//                                                         )
//                                                  );
//            if (!isset($newHospital)) {
//                $newHospital = new Hospital();
//                $newHospital->imei        = (int)$imei;
//                $newHospital->hospital_id = (int)$xmlhospital->ID;
//            }
//            $newHospital->name   = $xmlhospital->Name;
//            $newHospital->adress = $xmlhospital->Adress;
//            if ($newHospital->validate()) {
//                $newHospital->save(false);
//                $result = '';
//            } else {
//                $result = $this->MakeErrorsTextH($newHospital);
//            }
//            return $result;
//        }
//        
//        function SaveHPlannerItem($imei, $hospital_id, $xmlhpitem) {
//            $newHPItem = HPlannerItem::model()->find(array('condition' => 'imei = :i'
//                                                                   . ' AND hospital_id = :h_id', 
//                                                              'params' => array('i' => $imei,
//                                                                             'h_id' => $hospital_id
//                                                                               )
//                                                           )
//                                                    );
//            if (!isset($newHPItem)) {
//                $newHPItem = new HPlannerItem();
//                $newHPItem -> imei        = (int)$imei;
//                $newHPItem -> hospital_id = (int)$hospital_id;
//            }
//            $newHPItem -> weeknum   = (int)$xmlhpitem->weekNum;
//            $newHPItem -> dayofweek =      $xmlhpitem->dayOfWeek;
//            if ($newHPItem->validate()) {
//                $newHPItem->save(false);
//                $result = '';
//            } else {
//                $result = $this->MakeErrorsTextH($newHPItem);
//            }
//            return $result;
//        }
//        
//        function MakeErrorsTextH ($model) {
//            $errors = $model->getErrors();
//            $colon_separated = array();
//            foreach ($errors as $key => $value) {
//                foreach ($value as $k => $v) {
//                    $colon_separated[] = "$key: [$k = $v]";
//                }
//            }
//            $result = "{hospital_id = ".$model->hospital_id."\n";
//            $result = $result.implode("\n", $colon_separated);
//            $result = $result."\n}\n";
//            return $result;  
//        }
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