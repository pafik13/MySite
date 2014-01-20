<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class MyController extends Controller
{
    public function actionOne()
    {
        echo $this->one();
    }
    
    private function one() 
    {
        return 'one';
    }
}

