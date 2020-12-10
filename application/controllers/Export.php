<?php
if(!defined('BASEPATH'))
    exit('No direct script access allowed');
    class Export extends CI_Controller{
        public function __contruct(){
            parent::__contruct();
            $this->load->model('Export_model', 'export');
        }
        public function index(){
            $data['title']='Display Feedback Data';
            $this->load->model('Export_model', 'export');
            $data['feedbackInfo'] = $this->export->employeeList();
            $this->load->view('users/feedbacklist',$data);
        }
        public function createXLS() {
      $this->load->library("Excel");
      $object = new PHPExcel();
      $object->setActiveSheetIndex(0);
      $table_columns = array("Name", "Email", "Feedback");
      $column = 0;
      foreach($table_columns as $field)
      {
       $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
       $column++;
      }
      $this->load->model('Export_model', 'export');
      $feedbackInfo = $this->export->employeeList();
      $excel_row = 2;
      foreach($feedbackInfo as $row)
      {
       $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->name);
       $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->email);
       $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->feedback1);
       $excel_row++;
      }
    
      $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="feedback Data.xls"');
            $object_writer->save('php://output');
     }
        }
            
    
    
    ?>