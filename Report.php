
<?php

Class Report extends CI_Controller{


	public function __construct(){

		parent:: __construct();
		$this->load->model('Report_Model');
	}

	public function index(){

		$data['employee_debit'] = $this->Report_Model->getdataemployeedebit();
		$data['stock_debit'] = $this->Report_Model->getdatastockdebit();
		$data['tiffin_credit'] = $this->Report_Model->getdataTiffinCredit();
		$data['donor_credit'] = $this->Report_Model->getdatadonorCredit();
		$data['other_debit'] = $this->Report_Model->getdataotherdebit();
		$this->load->view('report',$data);
	}

	public function searchdate(){

		$start_date =$this->input->post('start_date');
		$end_date =$this->input->post('end_date');
		// $s_date = date("d-m-Y",strtotime($start_date));
		// $e_date = date("d-m-Y",strtotime($end_date));
		$data['employee_debit'] = $this->Report_Model->getdataemployeedebitbydate($start_date,$end_date);
		$data['stock_debit'] = $this->Report_Model->getdatastockdebitbydate($start_date,$end_date);
		$data['tiffin_credit'] = $this->Report_Model->getdataTiffinCreditbydate($start_date,$end_date);
		$data['donor_credit'] = $this->Report_Model->getdatadonorCreditbydate($start_date,$end_date);
		$data['other_debit'] = $this->Report_Model->getdataotherdebitbydate($start_date,$end_date);
		$this->load->view('report',$data);
	}
}


?>