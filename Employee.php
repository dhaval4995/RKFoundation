<?php 

Class Employee extends CI_Controller{

	public function __construct(){

		parent:: __construct();
		$this->load->model('Employee_model');
	}

	public function add_employee(){
      $this->load->view('add_employee');
	}

	public function save_employee(){
		$id=$this->input->post('id');
		if ($id) {
		$data=array(
                   'employee_type'=>$this->input->post('employee_type'),
                   'employee_name'=>$this->input->post('employee_name'),
                   'employee_address'=>$this->input->post('employee_address'),
                   'employee_city'=>$this->input->post('employee_city'),
                   'employee_phone'=>$this->input->post('employee_phone'),
                   'vehicle_no'=>$this->input->post('auto_no')
		           );
		if($this->Employee_model->updatedata($data,$id)){
            $this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Updated<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('Employee/EmployeeList');
           // $this->EmployeeList();
		}else{
			$this->session->set_flashdata('err','<div class="alert alert-danger">Data Not Updated<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			$this->editemployee($id);
		}
		}else{
			$digits = 5;
            $employee_sr_no='RK-'.rand(pow(10, $digits-1), pow(10, $digits)-1);
            $employee_join_date=date('d/m/Y');
		$data=array(
                   'employee_type'=>$this->input->post('employee_type'),
                   'employee_name'=>$this->input->post('employee_name'),
                   'employee_address'=>$this->input->post('employee_address'),
                   'employee_city'=>$this->input->post('employee_city'),
                   'employee_phone'=>$this->input->post('employee_phone'),
                   'employee_sr_no'=>$employee_sr_no,
                   'employee_join_date'=>$employee_join_date,
                   'vehicle_no'=>$this->input->post('auto_no')
		           );
		if($this->Employee_model->savedata($data)){
            $this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Inserted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
           redirect('Employee/EmployeeList');
		}else{
			$this->session->set_flashdata('err','<div class="alert alert-danger">Data Not Insert<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			redirect('Employee/EmployeeList');
		}
		}
        
		
	}

	public function EmployeeList(){

		$data['employee']=$this->Employee_model->getEmployeedata();
		$this->load->view('vwEmployeeLIst',$data);
	}

	public function removeemployee($id){

		if($this->Employee_model->deleteEmployee($id)){
            $this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Deleted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
           redirect('Employee/EmployeeList');
		}else{
			$this->session->set_flashdata('err','<div class="alert alert-danger">Employee Not Deleted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			redirect('Employee/EmployeeList');
		}
	}

	public function editemployee($id){
		$data['emp']=$this->Employee_model->getdataById($id);
		$this->load->view('add_employee',$data);

	}

	public function employee_payment(){
		$data['emp_payement']=$this->Employee_model->getemployeepayment();
		$this->load->view('employee_payment_list',$data);
	}

	public function addpayment(){
		$this->load->view('add_employee_payment');
	}

	public function savepayment(){
        $digits = 5;
        $payment_sr_no='P-'.rand(pow(10, $digits-1), pow(10, $digits)-1);
        $date_of_payment=date('d/m/Y');
        $payment_id = $this->input->post('payment_id');
		$employee_id = $this->input->post('employee_id');
		$employee_type = $this->input->post('employee_type');
		$salary_start_date = $this->input->post('salary_start_date');
		$salary_end_date = $this->input->post('salary_end_date');
		$payment_type = $this->input->post('payment_type');
		$paid_amount = $this->input->post('paid_amount');
		$chaque_number = $this->input->post('chaque_number');
		$chaque_number1 = $this->input->post('chaque_number1');
		if ($chaque_number1 == '') {
			$chaque=$chaque_number;
		}else{
			if ($payment_type=='Cash') {
				$chaque='';
			}else{
				$chaque=$chaque_number1;
			}	
		}
		$payment_description = $this->input->post('payment_description');
		if ($payment_id !== '') {
			$data=array(
                   'payment_type'=>$payment_type,
                   'date_of_payment'=>$date_of_payment,
                   'employee_type'=>$employee_type,
                   'employee_id'=>$employee_id,
                   'chaque_number'=>$chaque,
                   'salary_start_date'=>$salary_start_date,
                   'salary_end_date'=>$salary_end_date,
                   'paid_amount'=>$paid_amount,
                   'payment_description'=>$payment_description
		           );
		    if($this->Employee_model->updatepaymentvoucher($payment_id,$data)){
	            $this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Updated<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
	           redirect('Employee/employee_payment');
			}else{
				$this->session->set_flashdata('err','<div class="alert alert-danger">Employee Not Updated<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				redirect('Employee/employee_payment');
			}
		}	
		else{	
			$data=array(
	                   'payment_type'=>$payment_type,
	                   'payment_sr_no'=>$payment_sr_no,
	                   'date_of_payment'=>$date_of_payment,
	                   'employee_type'=>$employee_type,
	                   'employee_id'=>$employee_id,
	                   'chaque_number'=>$chaque,
	                   'salary_start_date'=>$salary_start_date,
	                   'salary_end_date'=>$salary_end_date,
	                   'paid_amount'=>$paid_amount,
	                   'payment_description'=>$payment_description
			           );
			if($this->Employee_model->insertoaymentvoucher($data)){
	            $this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Inserted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
	           redirect('Employee/employee_payment');
			}else{
				$this->session->set_flashdata('err','<div class="alert alert-danger">Employee Not Inserted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				redirect('Employee/employee_payment');
			}
		}	
	
	}

	public function remove_employepayment($id){
  
         if($this->Employee_model->removepayementvoucher($id)){
            $this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Deleted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
           redirect('Employee/employee_payment');
		}else{
			$this->session->set_flashdata('err','<div class="alert alert-danger">Employee Not Deleted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			redirect('Employee/employee_payment');
		}
	}

	public function editemployeepayment($id){

		$data['employee_payement']=$this->Employee_model->getdatabyidpayment($id);
		$this->load->view('add_employee_payment',$data);

	}

	public function removeselectedemployee(){
       $id=$_POST['tiffin_day1'];
	   $data=$this->Employee_model->deleteselectedemployee($id);
	   print_r($data);
	}

	public function employee_print($id){
         $data['printdataemployee'] = $this->Employee_model->getemployeepaydata($id);
         $this->load->view('print_employeebill',$data);
         // print_r($data['printdataemployee'][0]);
         // exit();
	}

	public function auto_LIst(){
        $data['auto']=$this->Employee_model->getautoList();
		$this->load->view('vwautoList',$data);
	}
	public function print_auto_LIst(){
		$data['auto']=$this->Employee_model->getautoList();
		$this->load->view('print_format/printautoList',$data);	
	}

	public function checkList(){
	   $id=$_POST['vid'];	
       $data=$this->Employee_model->getautolistbyid($id);	
       print_r(json_encode($data));
	}

	public function printemployeelist(){
    $data['employee']=$this->Employee_model->getEmployeedata();
    
    $this->load->view('print_format/printemployeelist',$data);
  }
}

?>