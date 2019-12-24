<?php 

Class EverdayEntry extends CI_Controller{

	public function __construct(){

		parent:: __construct();
		$this->load->model('EverdayEntry_Model');
	}

	public function index(){
    $data['dailydata']=$this->EverdayEntry_Model->getdatadailydata();
    $data['customer'] = $this->EverdayEntry_Model->getcustomername();
		$this->load->view('daily_entry_list',$data);
	}

	public function Day_entry_list(){
         $data['customerdata']=$this->EverdayEntry_Model->getdatacustomer();
		 $this->load->view('day_entry_list',$data);
	}

	public function Night_entry_list(){
       $data['customerdata']=$this->EverdayEntry_Model->getdatacustomer();
		$this->load->view('night_entry_list',$data);
	}

	

	public function innserttiffinperday(){
   
       for ($i=0; $i <count($_POST['tiffin_day1']) ; $i++) { 
       	     $cid=$_POST['tiffin_day1'][$i]['cid'];
       	     $data=$this->EverdayEntry_Model->getrecordofcustomer($cid);
       	     $customer_id=$data[0]['_id'];
       	     $tiffin_type_id=$data[0]['tiffin_type_id'];
       	     $area_id=$data[0]['area_id'];
       	     $delivery_boy_id=$data[0]['auto_boy_id'];
       	     $day_night='day';
       	     $no_of_tiffins=$_POST['tiffin_day1'][$i]['tifinday'];
       	     $rate=$data[0]['tiffin_price'];
       	     $amount= $no_of_tiffins * $rate;
             $date= $_POST['date'];
       	     $digits = 5;
             $ddd=$this->EverdayEntry_Model->getdatabyidanddate($customer_id,$date);
             if(empty($ddd)) {
               $no = $this->EverdayEntry_Model->getlastrow();
               if (empty($no)) {
                  $srno= 1;
                }else{
                   $v1= get_object_vars($no);
                   $v2=$v1['srno'];
                   $v4= 1;
                   $v3=$v2 + $v4;
                   $srno= $v3;
                } 
             }else{
               $srno=$ddd[0]['srno'];
             }
             $tiffin_Srno='D-'.rand(pow(10, $digits-1), pow(10, $digits)-1);
            $data=array(
                       'customer_id'=>$customer_id,
                       'tiffin_type_id'=>$tiffin_type_id,
                       'area_id'=>$area_id,
                       'delivery_boy_id'=>$delivery_boy_id,
                       'day_night'=>$day_night,
                       'no_of_tiffins'=>$no_of_tiffins,
                       'rate'=>$rate,
                       'amount'=>$amount,
                       'tiffin_date'=>$date,
                       'tiffin_Srno'=>$tiffin_Srno,
                       'srno'=>$srno
                       );
            $d=$this->EverdayEntry_Model->inserttiffindata($data);
            print_r($d);
       	     
       	     
       }

	}
	public function innserttiffinpernight(){
      //print_r($_POST['tiffin_day1']);
       for ($i=0; $i <count($_POST['tiffin_day1']) ; $i++) { 
       	     $cid=$_POST['tiffin_day1'][$i]['cid'];
       	     $data=$this->EverdayEntry_Model->getrecordofcustomer($cid);
       	     $customer_id=$data[0]['_id'];
       	     $tiffin_type_id=$data[0]['tiffin_type_id'];
       	     $area_id=$data[0]['area_id'];
       	     $delivery_boy_id=$data[0]['auto_boy_id'];
       	     $day_night='night';
       	     $no_of_tiffins=$_POST['tiffin_day1'][$i]['tifinday'];
       	     $rate=$data[0]['tiffin_price'];
       	     $amount= $no_of_tiffins * $rate;
             $date= $_POST['date'];
       	     $digits = 5;
             $ddd=$this->EverdayEntry_Model->getdatabyidanddate($customer_id,$date);
             if(empty($ddd)) {
               $no = $this->EverdayEntry_Model->getlastrow();
               if (empty($no)) {
                  $srno= 1;
                }else{
                   $v1= get_object_vars($no);
                   $v2=$v1['srno'];
                   $v4= 1;
                   $v3=$v2 + $v4;
                   $srno= $v3;
                } 
             }else{
               $srno=$ddd[0]['srno'];
             }
             $tiffin_Srno='N-'.rand(pow(10, $digits-1), pow(10, $digits)-1);
            $data=array(
                       'customer_id'=>$customer_id,
                       'tiffin_type_id'=>$tiffin_type_id,
                       'area_id'=>$area_id,
                       'delivery_boy_id'=>$delivery_boy_id,
                       'day_night'=>$day_night,
                       'no_of_tiffins'=>$no_of_tiffins,
                       'rate'=>$rate,
                       'amount'=>$amount,
                       'tiffin_date'=>$date,
                       'tiffin_Srno'=>$tiffin_Srno,
                       'srno'=>$srno
                       );
            $d=$this->EverdayEntry_Model->inserttiffindata($data);
            print_r($d);
       	     
       	     
       }

	}

  public function removethetiffindata($id){
    if($this->EverdayEntry_Model->deletetiffindata($id)){
            $this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Deleted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('EverdayEntry');
           // $this->EmployeeList();
    }else{
      $this->session->set_flashdata('err','<div class="alert alert-danger">Data Not Deleted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      redirect('EverdayEntry');
    } 
  }

   public function print_day_entry_list(){
         $data['customerdata']=$this->EverdayEntry_Model->getdatacustomer();
         $data['customerdata']=$this->EverdayEntry_Model->getdatacustomer();
     $this->load->view('print_format/printdayentrylist',$data);
  }
  public function print_night_entry_list(){
         $data['customerdata']=$this->EverdayEntry_Model->getdatacustomer();
         $this->load->view('print_format/printnightentrylist',$data);
  }
   public function print_every_day_entry_list(){
    $data['dailydata']=$this->EverdayEntry_Model->getdatadailydata();
    $this->load->view('print_format/printeverydayentrylist',$data);
  }
  public function getfilterdata(){

    $customer_name =$this->input->post('customer_name');
    $date = $this->input->post('date');
    $data['dailydata']=$this->EverdayEntry_Model->getfilterdataby($customer_name,$date);
    $data['customer'] = $this->EverdayEntry_Model->getcustomername();
    $data['customer_name']=$customer_name;
    $data['date']=$date;
    $this->load->view('daily_entry_list',$data);
  }

}



 ?>