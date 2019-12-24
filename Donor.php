<?php

Class Donor extends CI_Controller{


	public function __construct(){
		parent:: __construct();
		$this->load->model('Donor_Model');
	}

	public function index(){
		$data['donordata']=$this->Donor_Model->getdonortpaymentdata();
		$this->load->view('vwdonorpay',$data);
	}

	public function add_donor(){
		$this->load->view('add_donor');
	}

	public function save(){
        $v=$this->Donor_Model->getpaydonordata();
        if (empty($v)) {
        	$pay_donor_srno= '1';
        }else{
           $v1= get_object_vars($v);
           $v2=$v1['pay_donor_srno'];
           $v4= 1;
           $v3=$v2 + $v4;
          $pay_donor_srno= $v3;
        }
        $pay_donor_id= $this->input->post('pay_donor_id');
		$pay_donor_name = $this->input->post('pay_donor_name');
		$pay_donor_phone = $this->input->post('pay_donor_phone');
		$pay_donor_address = $this->input->post('pay_donor_address');
		$pay_donor_paymenttype = $this->input->post('pay_donor_paymenttype');
		$pay_donor_chequeno = $this->input->post('pay_donor_chequeno');
		$pay_donor_chequeno1 = $this->input->post('pay_donor_chequeno1');
		$pay_donor_amount = $this->input->post('pay_donor_amount');
		$pay_donor_comment = $this->input->post('pay_donor_comment');
		$date_of_payment=date('d/m/Y');
		if ($pay_donor_chequeno1 == '') {
			$pay_chequeno=$pay_donor_chequeno;
		}else{
			if ($pay_donor_paymenttype =='cash') {
				print_r('expression');
				$pay_chequeno='';
			}else{
				$pay_chequeno=$pay_donor_chequeno1;
			}	
		}
        if ($pay_donor_id) {
        	$data=array(
                   'pay_donor_name'=>$pay_donor_name,
                   'pay_donor_phone'=>$pay_donor_phone,
                   'pay_donor_address'=>$pay_donor_address,
                   'pay_donor_paymenttype'=>$pay_donor_paymenttype,
                   'pay_donor_chequeno'=>$pay_chequeno,
                   'pay_donor_amount'=>$pay_donor_amount,
                   'pay_donor_comment'=>$pay_donor_comment
		           );
			if($this->Donor_Model->updatedonorpayment($pay_donor_id,$data)){
		            $this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Updated<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		           redirect('Donor');
			}else{
					$this->session->set_flashdata('err','<div class="alert alert-danger">Employee Not Updated<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					redirect('Donor');
			}
        }else{
		$data=array(
			       'pay_donor_srno'=>$pay_donor_srno,
                   'pay_donor_name'=>$pay_donor_name,
                   'pay_donor_phone'=>$pay_donor_phone,
                   'pay_donor_address'=>$pay_donor_address,
                   'pay_donor_paymenttype'=>$pay_donor_paymenttype,
                   'pay_donor_chequeno'=>$pay_chequeno,
                   'pay_donor_amount'=>$pay_donor_amount,
                   'pay_donor_comment'=>$pay_donor_comment,
//                   'date_of_payment'=>$date_of_payment
		           );

		if($this->Donor_Model->insertdonorpayment($data)){
	            $this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Updated<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
	           redirect('Donor');
		}else{
				$this->session->set_flashdata('err','<div class="alert alert-danger">Employee Not Updated<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				redirect('Donor');
		}
	    }

	}
	public function remove($id){
       if($this->Donor_Model->deletedonorpayment($id)){
	            $this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Updated<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');  
	           redirect('Donor');
		}else{
				$this->session->set_flashdata('err','<div class="alert alert-danger">Employee Not Updated<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				redirect('Donor');
		}
	}

	public function edit($id){
		$data['donordata']=$this->Donor_Model->getdonordatabyid($id);
		$this->load->view('add_donor',$data);
	}

	public function printdonorp($id){

		$data['printdonor']=$this->Donor_Model->getdonordatabyid($id);
		$this->load->view('printdonor',$data);
	}
}
?>