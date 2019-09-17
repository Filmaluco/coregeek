<?php
/**
 * Created by PhpStorm.
 * User: FilipeA
 * Date: 9/30/2018
 * Time: 22:53
 */

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Pricing extends AUTH_Controller
{

    public function __construct()
    {
        parent::__construct();
        //This Controller requires a sideBar Menu
        $this->load->library('navigation_menu');

        // REQUIRED ----------------------------------------------------------------------------------------------------
        $this->set_ControllerName('Pricing');
        $this->set_ParentPath(site_url('v1/pricing'));
        $this->set_ParentPathName('Pricing');
        //--------------------------------------------------------------------------------------------------------------

    }

    public function Index(){

        // REQUIRED ----------------------------------------------------------------------------------------------------
        $this->set_CurrentMethod('Home');
        $this->set_group();
        $this->set_permissions();
        if($this->access_check()== AUTHENTICATION_ERROR){
            redirect('/login');
        }

        //--------------------------------------------------------------------------------------------------------------

        redirect("v1/pricing/search");
        die();


    }

    public function Add(){

        // REQUIRED ----------------------------------------------------------------------------------------------------
        $this->set_CurrentMethod('Add');
        $this->set_group();
        $this->set_permissions();
        if($this->access_check()== AUTHENTICATION_ERROR){
            redirect('/login');
        }

        //--------------------------------------------------------------------------------------------------------------

        echo $this->load->view('dashboard/pricing/add', $this->get_data(), true);
        die();


    }

    public function Upload(){

       //todo add token, check API and JS cookie library
        if (!empty($_FILES['file'])){
            $target = "assets/pricing/".EXCEL_FILE_NAME;

            move_uploaded_file($_FILES['file']['tmp_name'], $target);
            echo json_encode(['uploaded' => $target]);
        }else {
            echo json_encode(['error'=>'No files found for upload.']);
        }
    }

    public function Search(){
        // REQUIRED ----------------------------------------------------------- -----------------------------------------
        $this->set_CurrentMethod('Search');
        $this->set_group();
        $this->set_permissions();
        if($this->access_check()== AUTHENTICATION_ERROR){
            redirect('/login');
        }
        //--------------------------------------------------------------------------------------------------------------
        //TODO no file found
        $inputFileName = 'assets/pricing/' . EXCEL_FILE_NAME;

        /**  Identify the type of $inputFileName  **/
        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);

        /**  Create a new Reader of the type that has been identified  **/
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

        /**  Load $inputFileName to a Spreadsheet Object  **/
        $spreadsheet = $reader->load($inputFileName);

        /**  Convert Spreadsheet Object to an Array for ease of use  **/
        $schedules= $spreadsheet->getActiveSheet()->toArray();
        $this->add_data($schedules, 'schedules', true);


        echo $this->load->view('dashboard/pricing/search', $this->get_data(), true);
        die();

    }

}