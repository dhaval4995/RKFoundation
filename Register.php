<?php 

Class Register extends CI_Controller{


   public function __construct(){

   	parent:: __construct();
   	$this->load->model('Register_Model');
   }

   public function index(){
   	$data['register']=$this->Register_Model->getregisterdata2();
   	  $this->load->view('vwregisterList',$data);
   }

   public function add_register(){
     
   	 $this->load->view('add_register');
   }

   public function save(){
     $digits = 5;
     $customer_sr_no='CT-'.rand(pow(10, $digits-1), pow(10, $digits)-1);
   	 $customer_type = $this->input->post('customer_type');
   	 $tiffin_type = $this->input->post('tiffin_type');
   	 $customer_name = $this->input->post('customer_name');
   	 $customer_address = $this->input->post('customer_address');
   	 $customer_city = $this->input->post('customer_city');
   	 $customer_mobile = $this->input->post('customer_mobile');
   	 $donor_name = $this->input->post('donor_name');
   	 $donor_address = $this->input->post('donor_address');
   	 $donor_city = $this->input->post('donor_city');
   	 $donor_mobile= $this->input->post('donor_mobile');
   	 $open_date= $this->input->post('open_date');
   	 $close_date= $this->input->post('close_date');
   	 $tiffin_day= $this->input->post('tiffin_day');
   	 $tiffin_night= $this->input->post('tiffin_night');
   	 $auto_id= $this->input->post('auto_id');
   	 $area_id= $this->input->post('area_id');
   	 $tiffin_price= $this->input->post('tiffin_price');
    if ($donor_name !=='' && $donor_address !=='' && $donor_city !=='' && $donor_mobile !=='') {
    	$donor_sr_no='D-'.rand(pow(10, $digits-1), pow(10, $digits)-1);
    	$donor_id=$this->Register_Model->insertdonordata(array('donor_sr_no'=>$donor_sr_no,'donor_name'=>$donor_name,'donor_address'=>$donor_address,'donor_city'=>$donor_city,'donor_phone'=>$donor_mobile,'date_of_registration'=>date("d/m/Y")));
       if ($donor_id) {
         $data=array(
               'customer_sr_no'=>$customer_sr_no,
                 'customer_type'=>$customer_type,
                 'tiffin_type_id'=>$tiffin_type,
                 'customer_name'=>$customer_name,
                 'customer_address'=>$customer_address,
                 'customer_city'=>$customer_city,
                 'customer_phone'=>$customer_mobile,
                 'donor_id'=>$donor_id,
                 'open_date'=>$open_date,
                 'close_date'=>$close_date,
                 'tiffin_day'=>$tiffin_day,
                 'tiffin_night'=>$tiffin_night,
                 'auto_boy_id'=>$auto_id,
                 'area_id'=>$area_id,
                 'tiffin_price'=>$tiffin_price,
                 );
     }
    } 
   	else{
   	 	$data=array(
   	 	         'customer_sr_no'=>$customer_sr_no,
                 'customer_type'=>$customer_type,
                 'tiffin_type_id'=>$tiffin_type,
                 'customer_name'=>$customer_name,
                 'customer_address'=>$customer_address,
                 'customer_city'=>$customer_city,
                 'customer_phone'=>$customer_mobile,
                 'open_date'=>$open_date,
                 'close_date'=>$close_date,
                 'tiffin_day'=>$tiffin_day,
                 'tiffin_night'=>$tiffin_night,
                 'auto_boy_id'=>$auto_id,
                 'area_id'=>$area_id,
                 'tiffin_price'=>$tiffin_price,
   	             );
   	 }   
   	 	  if($this->Register_Model->insertcustomerdata($data)){
            $this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Inserted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('Register');
           // $this->EmployeeList();
		}else{
			$this->session->set_flashdata('err','<div class="alert alert-danger">Data Not Inserted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			redirect('Register');
		}	 
   }

   public function removeregisterdata(){

   	 $register_id=$this->input->get('var1');
   	 $donor_id=$this->input->get('var2');
     if ($this->Register_Model->removeregisterdata($register_id)) {
   	 	if($donor_id !==''){
           $this->Register_Model->removedonor($donor_id);
        }
         $this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Deleted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('Register');
     }else{
			$this->session->set_flashdata('err','<div class="alert alert-danger">Data Not Deleted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			redirect('Register'); 
     }
   	 
   }

   public function editregitserdata($id){
   	$data['editdata']=$this->Register_Model->getdatabyid($id);
   	$data['donoreditdata']=$this->Register_Model->getdonordatabyid($data['editdata'][0]['donor_id']);
   	$this->load->view('update_register',$data);
   }

   public function update(){
     $r_id=$this->input->post('id');
     $d_id=$this->input->post('d_id');
   	 $customer_type = $this->input->post('customer_type');
   	 $tiffin_type = $this->input->post('tiffin_type');
   	 $customer_name = $this->input->post('customer_name');
   	 $customer_address = $this->input->post('customer_address');
   	 $customer_city = $this->input->post('customer_city');
   	 $customer_mobile = $this->input->post('customer_mobile');
   	 $donor_name = $this->input->post('donor_name');
   	 $donor_address = $this->input->post('donor_address');
   	 $donor_city = $this->input->post('donor_city');
   	 $donor_mobile= $this->input->post('donor_mobile');
   	 $open_date= $this->input->post('open_date');
   	 $close_date= $this->input->post('close_date');
   	 $tiffin_day= $this->input->post('tiffin_day');
   	 $tiffin_night= $this->input->post('tiffin_night');
   	 $auto_id= $this->input->post('auto_id');
   	 $area_id= $this->input->post('area_id');
   	 $tiffin_price= $this->input->post('tiffin_price');

   	 if ($d_id == '') {
   	 	 if ($donor_name !=='' && $donor_address !=='' && $donor_city !=='' && $donor_phone !=='') {
   	 	 	 $digits = 5;
    	$donor_sr_no='D-'.rand(pow(10, $digits-1), pow(10, $digits)-1);
    	$donor_id=$this->Register_Model->insertdonordata(array('donor_sr_no'=>$donor_sr_no,'donor_name'=>$donor_name,'donor_address'=>$donor_address,'donor_city'=>$donor_city,'donor_phone'=>$donor_mobile,'date_of_registration'=>date("d/m/Y")));
           if ($donor_id) {
             $data=array(
                   'customer_sr_no'=>$customer_sr_no,
                     'customer_type'=>$customer_type,
                     'tiffin_type_id'=>$tiffin_type,
                     'customer_name'=>$customer_name,
                     'customer_address'=>$customer_address,
                     'customer_city'=>$customer_city,
                     'customer_phone'=>$customer_mobile,
                     'donor_id'=>$donor_id,
                     'open_date'=>$open_date,
                     'close_date'=>$close_date,
                     'tiffin_day'=>$tiffin_day,
                     'tiffin_night'=>$tiffin_night,
                     'auto_boy_id'=>$auto_id,
                     'area_id'=>$area_id,
                     'tiffin_price'=>$tiffin_price,
                     );
         }
       } 
     else{
   	 	$data=array(
   	 	         'customer_sr_no'=>$customer_sr_no,
                 'customer_type'=>$customer_type,
                 'tiffin_type_id'=>$tiffin_type,
                 'customer_name'=>$customer_name,
                 'customer_address'=>$customer_address,
                 'customer_city'=>$customer_city,
                 'customer_phone'=>$customer_mobile,
                 'open_date'=>$open_date,
                 'close_date'=>$close_date,
                 'tiffin_day'=>$tiffin_day,
                 'tiffin_night'=>$tiffin_night,
                 'auto_boy_id'=>$auto_id,
                 'area_id'=>$area_id,
                 'tiffin_price'=>$tiffin_price,
   	             );
   	 }
   	 }
   	 else{
   	 	if ($donor_name !=='' && $donor_address !=='' && $donor_city !=='' && $donor_phone !=='') {
   	 		$donor_sr_no='D-'.rand(pow(10, $digits-1), pow(10, $digits)-1);
    	$donor_id=$this->Register_Model->updatedonordata(array('donor_sr_no'=>$donor_sr_no,'donor_name'=>$donor_name,'donor_address'=>$donor_address,'donor_city'=>$donor_city,'donor_phone'=>$donor_mobile,'date_of_registration'=>date("d/m/Y")),$d_id);
    	if ($donor_id) {
   	 	   $data=array(
   	 	         'customer_sr_no'=>$customer_sr_no,
                 'customer_type'=>$customer_type,
                 'tiffin_type_id'=>$tiffin_type,
                 'customer_name'=>$customer_name,
                 'customer_address'=>$customer_address,
                 'customer_city'=>$customer_city,
                 'customer_phone'=>$customer_mobile,
                 'donor_id'=>$d_id,
                 'open_date'=>$open_date,
                 'close_date'=>$close_date,
                 'tiffin_day'=>$tiffin_day,
                 'tiffin_night'=>$tiffin_night,
                 'auto_boy_id'=>$auto_id,
                 'area_id'=>$area_id,
                 'tiffin_price'=>$tiffin_price,
   	             );
   	    }else{
   	 	$data=array(
   	 	         'customer_sr_no'=>$customer_sr_no,
                 'customer_type'=>$customer_type,
                 'tiffin_type_id'=>$tiffin_type,
                 'customer_name'=>$customer_name,
                 'customer_address'=>$customer_address,
                 'customer_city'=>$customer_city,
                 'customer_phone'=>$customer_mobile,
                 'open_date'=>$open_date,
                 'close_date'=>$close_date,
                 'tiffin_day'=>$tiffin_day,
                 'tiffin_night'=>$tiffin_night,
                 'auto_boy_id'=>$auto_id,
                 'area_id'=>$area_id,
                 'tiffin_price'=>$tiffin_price,
   	             );
   	    }
   	    }else{
   	    	$donor_id1=$this->Register_Model->removedonor($d_id);
	    	if ($donor_id1) {
	    		$d_id='';
	    	}
	    	$data=array(
   	 	         'customer_sr_no'=>$customer_sr_no,
                 'customer_type'=>$customer_type,
                 'tiffin_type_id'=>$tiffin_type,
                 'customer_name'=>$customer_name,
                 'customer_address'=>$customer_address,
                 'customer_city'=>$customer_city,
                 'customer_phone'=>$customer_mobile,
                 'donor_id'=>$d_id,
                 'open_date'=>$open_date,
                 'close_date'=>$close_date,
                 'tiffin_day'=>$tiffin_day,
                 'tiffin_night'=>$tiffin_night,
                 'auto_boy_id'=>$auto_id,
                 'area_id'=>$area_id,
                 'tiffin_price'=>$tiffin_price,
   	             );
   	    }
   	 }
   	 if($this->Register_Model->updatecustomerdata($data,$r_id)){
            $this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Updated<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('Register');
           // $this->EmployeeList();
		}else{
			$this->session->set_flashdata('err','<div class="alert alert-danger">Data Not Updated<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			redirect('Register');
		}	

   }

   public function getdataview(){
     $vid=$_POST['vid'];
     $data=$this->Register_Model->getdataview123($vid);
     echo json_encode($data);
   }
   public function print_register(){
    $data['a']=$this->Register_Model->getdataviewprint();
     //$data1=$data->result();
    // echo "<pre>";
    // print_r($data1);
    // exit();
    $this->load->view('print_format/printregister',$data);

   }

}

?>