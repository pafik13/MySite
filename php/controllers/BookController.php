<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class BookController extends Controller
{
    public function actionIndex($id = false) {
        #$id = filter_input(INPUT_GET, 'id');  #$_GET['id'];
        $model = UploadFiles::model()->findByPk($id);
        file_put_contents('uploads\000.xml', $model->FILE);
        if (isset($model)) {
        //$filename = 'Demonstrations.xml';
        //$sxml = simplexml_load_file($filename);
        $sxml = simplexml_load_string($model->FILE);

        $ch = $sxml->Demonstration[1]->demos->children();
        
        $this->render('index', array('echo' => $ch, 'model' => $model));
        }
        //$mdstr = Temo::model()->findByPK(3);
        //$hash = md5($mdstr->xml); #md5_file('movies.xml');
        //echo $hash;
        #echo $v;
    }

}
