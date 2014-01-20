<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2013 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2013 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.9, 2013-06-02
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/Moscow');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
//require_once '../Classes/PHPExcel.php';


// Create new PHPExcel object

spl_autoload_unregister(array('YiiBase','autoload'));
Yii::import('application.extensions.Classes.PHPExcel', true);
spl_autoload_register(array('YiiBase','autoload'));

$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$objPHPExcel = $objReader->load("templates/report.xlsx");

// Set document properties
$objPHPExcel->getProperties()->setCreator($m->getFIO())
                             ->setLastModifiedBy($m->getFIO())
                             ->setTitle($mp->getFIO())
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");


// Add some data
$baserow = 4;
$r = 1;
foreach($data as $d) {
    $row = $baserow + $r;
    $objPHPExcel->getActiveSheet()->insertNewRowBefore($row,1);
    
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $r)
                                  ->setCellValue('C'.$row, trim($d['NAME']))
                                  ->setCellValue('D'.$row, trim($d['ADRESS']))
                                  ->setCellValue('G'.$row, trim($d['SECOND_NAME'].' '.$d['FIRST_NAME'].' '.$d['THIRD_NAME']))
                                  ->setCellValue('I'.$row, trim($d['SPECIALITY']))
                                  ->setCellValue('J'.$row, trim($d['POSITION_']))
                                  ->setCellValue('L'.$row, date('d.m.Y', CDateTimeParser::parse($d['VISIT_DATE'], 'yyyy-MM-dd')));
    $r = $r + 1;
}

$objPHPExcel->getActiveSheet()->removeRow(4,1);

// Rename 
//$objPHPExcel->getActiveSheet()->setTitle('Simple');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
$f_date = date('d_m_Y', CDateTimeParser::parse($f_d, 'dd.MM.yyyy'));
$l_date = date('d_m_Y', CDateTimeParser::parse($l_d, 'dd.MM.yyyy'));
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$mp->getFIO().'_'.$f_date.'_'.$l_date.'.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
