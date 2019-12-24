<?php 

Class Generate_reciept extends CI_Controller{

	public function __construct(){

		parent:: __construct();
		$this->load->model('Reciept_Model');
	}

	public function index(){
        //$data['alltiffin'] = $this->Reciept_Model->getrecieptdata();
        $data['alltiffinvoucher'] = $this->Reciept_Model->getpaymentvoucher();
        // echo "<pre>";
        // print_r($data);
        // exit();
		$this->load->view('generate_receipt',$data);
	}

	public function getcustomertiffin(){
       $id=$_POST['vid'];
	   $data= $this->Reciept_Model->gettiffindata($id);
	   print_r(json_encode($data[0]));
	}

	public function print_tiffin_reciept($id){

		 $data['printdata']= $this->Reciept_Model->gettiffindata($id);
		 $this->load->view('vw_printTiffin',$data);
	}

	public function add_reciept(){

		$this->load->view('add_reciept_customer');
	}

	public function saveCustomerpayment(){

		$v=$this->Reciept_Model->getcustomersr();
        if (empty($v)) {
        	$customer_voucher_sr= '1';
        }else{
           $v1= get_object_vars($v);
           $v2=$v1['customer_voucher_sr'];
           $v4= 1;
           $v3=$v2 + $v4;
          $customer_voucher_sr= $v3;
        }
        $date_of_payment=date('d/m/Y');
        $cv_id = $this->input->post('cv_id');
		$customer_id = $this->input->post('customer_id');
		$customer_type = $this->input->post('customer_type');
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
		if ($cv_id !== '') {
			$data=array(
	                   'customer_id'=>$customer_id,
	                   'customer_type'=>$customer_type,
	                   'payment_type'=>$payment_type,
	                   'chaque_number'=>$chaque,
	                   'paid_amount'=>$paid_amount,
	                   'payment_description'=>$payment_description,
		           );
		    if($this->Reciept_Model->updatepaymentvoucher($cv_id,$data)){
	            $this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Updated<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
	           redirect('Generate_reciept');
			}else{
				$this->session->set_flashdata('err','<div class="alert alert-danger">Employee Not Updated<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				redirect('Generate_reciept');
			}
		}	
		else{	
			$data=array(
	                   'customer_voucher_sr'=>$customer_voucher_sr,
	                   'customer_id'=>$customer_id,
	                   'customer_type'=>$customer_type,
	                   'payment_type'=>$payment_type,
	                   'chaque_number'=>$chaque,
	                   'paid_amount'=>$paid_amount,
	                   'payment_description'=>$payment_description,
	                   'date_of_payment'=>$date_of_payment
			           );
			if($this->Reciept_Model->insertcpaymentvoucher($data)){
	            $this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Inserted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
	           redirect('Generate_reciept');
			}else{
				$this->session->set_flashdata('err','<div class="alert alert-danger">Employee Not Inserted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				redirect('Generate_reciept');
			}
		}	

	}

	public function editcustomervoucher($id){

		$data['voucherdetials']=$this->Reciept_Model->getcisyomerrdatabyid($id);
		$this->load->view('add_reciept_customer',$data);
	}

	public function removecustomervocher($id){

		if($this->Reciept_Model->deletecustoervoucher($id)){
	            $this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Deleted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
	           redirect('Generate_reciept');
	    }else{
				$this->session->set_flashdata('err','<div class="alert alert-danger">Not Deleted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				redirect('Generate_reciept');
		}
	}

	public function othercosts(){
		$data['othercosts'] = $this->Reciept_Model->getothercostsdata();
		$this->load->view('vwothercostsdata',$data);
	}

	public function add_othercost(){

		$this->load->view('add_othercost');
	}

	public function add_save(){
		$oc_id=$this->input->post('oc_id');
		$oc_amount = $this->input->post('oc_amount');
		$oc_date_of_payment = $this->input->post('oc_date_of_payment');
		$oc_description = $this->input->post('oc_description');
        $v=$this->Reciept_Model->getpayothercostdata();
        if (empty($v)) {
        	$oc_srno= '1';
        }else{
           $v1= get_object_vars($v);
           $v2=$v1['oc_srno'];
           $v4= 1;
           $v3=$v2 + $v4;
          $oc_srno= $v3;
        }
        if ($oc_id) {
        	$data =array(
                   'oc_amount'=>$oc_amount,
                   'oc_date_of_payment'=>$oc_date_of_payment,
                   'oc_description'=>$oc_description
		           );
			if($this->Reciept_Model->updateothercostsdata($data,$oc_id)){
		            $this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Updated<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		           redirect('Generate_reciept/othercosts');
		    }else{
					$this->session->set_flashdata('err','<div class="alert alert-danger">Not Updated<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					redirect('Generate_reciept/othercosts');
			}
        }else{
		$data =array(
			       'oc_srno'=>$oc_srno,
                   'oc_amount'=>$oc_amount,
                   'oc_date_of_payment'=>$oc_date_of_payment,
                   'oc_description'=>$oc_description
		           );
			if($this->Reciept_Model->insertothercostsdata($data)){
		            $this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Inserted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
		           redirect('Generate_reciept/othercosts');
		    }else{
					$this->session->set_flashdata('err','<div class="alert alert-danger">Not Inserted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
					redirect('Generate_reciept/othercosts');
			}
	    } 
	}

	public function Removeothercosts($id){
        if($this->Reciept_Model->deleteothercosts($id)){
	            $this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Deleted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
	           redirect('Generate_reciept/othercosts');
	    }else{
				$this->session->set_flashdata('err','<div class="alert alert-danger">Not Deleted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
				redirect('Generate_reciept/othercosts');
		}
	}

	public function editothercosts($id){
       $data['othercostsdata']  = $this->Reciept_Model->getdataothercostsbyid($id);
       $this->load->view('add_othercost',$data);

	}
}

?>