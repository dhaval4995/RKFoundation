
<?php 

Class Stock extends CI_Controller{

	public function __construct(){

		parent:: __construct();
		$this->load->model('Stock_model');
		$this->load->model('Tiffin_Model');
	}

	public function add_stock(){
      $this->load->view('add_stock');
	}

	public function save(){

		if(function_exists('date_default_timezone_set')) 
		  {
		    date_default_timezone_set("Asia/Kolkata");
		  }
		$stock_type=$this->input->post('stock_type');
		$stock_name=$this->input->post('stock_name');
		$bill_no=$this->input->post('bill_no');
		$bill_date=$this->input->post('bill_date');
		$party_name=$this->input->post('party_name');
		$brand_name=$this->input->post('brand_name');
		$quantity=$this->input->post('quantity');
		$measerment_id=$this->input->post('measerment_id');
		$stock_price=$this->input->post('stock_price');
        $stock_total_price=$this->input->post('stock_total_price');
        $stock_grand_price=$this->input->post('grandtotal');
        
            $data['stock_type'] = $stock_type;
	        $data['bill_no'] = $bill_no;
	        $data['bill_date'] = $bill_date;
	        $data['party_name'] = $party_name;
	        $data['stock_name'] = json_encode($stock_name);
	        $data['brand_name'] = json_encode($brand_name);
	        $data['quantity'] = json_encode($quantity);
	        $data['measerment_id'] = json_encode($measerment_id);
	        $data['stock_price'] = json_encode($stock_price);
	        $data['stock_total_price'] = json_encode($stock_total_price);
	        $data['stock_grand_price'] = $stock_grand_price;
	        $quantity123 = $this->Stock_model->getstockquantity();
	        $st = $this->Stock_model->insertdata($data);
	       if ($st) {
	       	 $stock_add_id=$st;
	       	 $stok_nm=json_decode($data['stock_name']);
	       	 $stok_brand=json_decode($data['brand_name']);
	       	 $stok_qty=json_decode($data['quantity']);
	       	 $stock_measerment_id=json_decode($data['measerment_id']);
	       	 $measermentdata=$this->Stock_model->getmeaserment();
	       	 $measer=[];
	       	 for ($i=0; $i <count($stock_measerment_id) ; $i++) { 
	       	 	for ($j=0; $j <count($measermentdata) ; $j++) { 
	       	 		if ($stock_measerment_id[$i] == $measermentdata[$j]['measurement_type_id']) {
	       	 		    array_push($measer, $measermentdata[$j]['measurement_short_code']);
	       	 	    }
	       	 	} 	
	       	 }
	       	 // for ($i=0; $i <count($stok_nm) ; $i++) { 
	       	 // 	print_r($measer[$i]);
	       	 // 	 $this->Stock_model->insertdatainstock($stock_add_id,$stok_nm[$i],$stok_brand[$i],$stok_qty[$i],$measer[$i]);
	       	 // }
	       	 // exit();
	       	 // $this->Stock_model->insertdatainstock($stock_add_id,$stok_nm[$i],$stok_brand[$i],$stok_qty[$i],$measer123);
	       	 // echo "<pre>";
	       	 // print_r($quantity123);
	       	 // exit();
	       	 for ($i=0; $i <count($stok_nm) ; $i++) {
	       	 	if (empty($quantity123)) {
	       	 				if ($measer[$i] == 'Gm'  || $measer[$i] == 'Ml') {
	       	 					$stock_qty123 = ($stok_qty[$i]) / 1000;
	       	 					$m123='Kg';
	       	 					$this->Stock_model->insertdatainstock($stock_add_id,$data['stock_type'],$stok_nm[$i],$stok_brand[$i],$stock_qty123,$m123);
	       	 				}else{
	       	 					$measer123='Kg';
	       	 					$this->Stock_model->insertdatainstock($stock_add_id,$data['stock_type'],$stok_nm[$i],$stok_brand[$i],$stok_qty[$i],$measer123);
	       	 				}
	       	 	}
	       	 	else{
	       	 		$a = 0;
	       	 		foreach ($quantity123 as $q) {

	       	 		    if ($q['stock_name'] == $stok_nm[$i] && $q['stock_brand_name'] == $stok_brand[$i]) { 
	       	 				if ($measer[$i] == 'Gm'  || $measer[$i]== 'Ml') {
	       	 					$stok_qty123 = ($stok_qty[$i]) / 1000 ;
	       	 					$stock= $q['stock_quanity'] + $stok_qty123;
	       	 					$this->Stock_model->updatestockquantitybyname($stok_nm[$i],$stok_brand[$i],$stock);	
	       	 				}else{
	       	 					$stock= $q['stock_quanity'] + $stok_qty[$i];
	       	 					$this->Stock_model->updatestockquantitybyname($stok_nm[$i],$stok_brand[$i],$stock);
	       	 				}
	       	 		    }else{
                          $a++;
                          if($a==1)
                          {
	       	 		        if ($measer[$i] == 'Gm'  || $measer[$i] == 'Ml') {
	       	 					$stock_qty123 = ($stok_qty[$i]) / 1000;
	       	 					$m123='Kg';
	       	 					$this->Stock_model->insertdatainstock($stock_add_id,$data['stock_type'],$stok_nm[$i],$stok_brand[$i],$stock_qty123,$m123);
	       	 				}else{
	       	 					$measer123='Kg';
	       	 					$this->Stock_model->insertdatainstock($stock_add_id,$data['stock_type'],$stok_nm[$i],$stok_brand[$i],$stok_qty[$i],$measer123);
	       	 				}
	       	 			}
	       	 	        }
	       	 	   }
	       	 	}
	       	 	
	       	 }
	         $this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Stock Inserted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                 redirect('Stock/StockList');
	       }
	}

	public function update() {
	   $measermentdata=$this->Stock_model->getmeaserment();
       	 $measer1=[];
	   $id=$this->input->post('stock_id');
	   $stkqty=$this->input->post('stkqty');
	   // print_r($stkqty);
	   // exit();
	   $stkmid=$this->input->post('stkmid');
	   $stk_name=$this->input->post('stk_name');
	   $stk_brand=$this->input->post('stk_brand');
	    for ($i=0; $i <count($stkmid) ; $i++) { 
       	 	for ($j=0; $j <count($measermentdata) ; $j++) { 
       	 		if ($stkmid[$i] == $measermentdata[$j]['measurement_type_id']) {
       	 		    array_push($measer1, $measermentdata[$j]['measurement_short_code']);
       	 	    }
       	 	} 	
       	}
       	
        $stock_type = $this->input->post('stock_type');
        $stock_name = $this->input->post('stock_name');
        $bill_no = $this->input->post('bill_no');
        $bill_date = $this->input->post('bill_date');
        $party_name = $this->input->post('party_name');
        $brand_name = $this->input->post('brand_name');
        $quantity = $this->input->post('quantity');
        $measerment_id = $this->input->post('measerment_id');
        $stock_price = $this->input->post('stock_price');
        $stock_total_price = $this->input->post('stock_total_price');
        $stock_grand_price = $this->input->post('grandtotal');
        $data['stock_grand_price'] = $stock_grand_price;
        $data['stock_type'] = $stock_type;
        $data['bill_no'] = $bill_no;
        $data['bill_date'] = $bill_date;
        $data['party_name'] = $party_name;
        $data['stock_name'] = json_encode($stock_name);
        $data['brand_name'] = json_encode($brand_name);
        $data['quantity'] = json_encode($quantity);
        $data['measerment_id'] = json_encode($measerment_id);
        $data['stock_price'] = json_encode($stock_price);
        $data['stock_total_price'] = json_encode($stock_total_price);
        $st=$this->Stock_model->updateStockdata($data,$id);
        $stock_add_id=$id;
       	$stok_nm=json_decode($data['stock_name']);
       	$stok_brand=json_decode($data['brand_name']);
       	$stok_qty=json_decode($data['quantity']);
       	$stock_measerment_id=json_decode($data['measerment_id']);
       	$measer=[];
       	for ($i=0; $i <count($stock_measerment_id) ; $i++) { 
       		for ($j=0; $j <count($measermentdata) ; $j++) { 
       	 		if ($stock_measerment_id[$i] == $measermentdata[$j]['measurement_type_id']) {
       	 		    array_push($measer, $measermentdata[$j]['measurement_short_code']);
       	 	    }
       	 	} 	
       	}
       	 if ($st) {
       	 	for ($i=0; $i < count($stok_nm) ; $i++) { 
       	 		 $quantity123 = $this->Stock_model->getstockquantity();//stock quantity all data get.
   	 			if (empty($quantity123)) {
   	 		  		for ($i=0; $i <count($stok_nm) ; $i++) {
       	 				if ($measer[$i] == 'Gm'  || $measer[$i] == 'Ml') {
       	 					$stock_qty123 = ($stok_qty[$i]) / 1000;
       	 					$m123='Kg';
       	 					$this->Stock_model->insertdatainstock($stock_add_id,$data['stock_type'],$stok_nm[$i],$stok_brand[$i],$stock_qty123,$m123);
       	 				}else{
       	 					$measer123='Kg';
       	 					$this->Stock_model->insertdatainstock($stock_add_id,$data['stock_type'],$stok_nm[$i],$stok_brand[$i],$stok_qty[$i],$measer123);
       	 				}
       	 	    	}
            	}else{
       	 			$qq=$this->Stock_model->getdatabyname($stok_nm[$i],$stok_brand[$i]);
       	 			$dataquantityall= $this->Stock_model->getdataquntity($stok_nm[$i],$stok_brand[$i]);
       	 			//print_r($measer[$i]);

       	 			if ($qq){
       	 				// print_r($measer[$i]);echo "<p>";
       	 				// print_r($stok_qty[$i]);echo "<p>";
       	 				// print_r($stock_measerment_id);echo "=";print_r($stkmid);
       	 				// echo "<p>";
       	 				//print_r($stkqty[$i]);	echo "<p>";
       	 				print_r($measer[$i]);
         					echo "<p>";
            			if ($measer[$i] == 'Gm' || $measer[$i]== 'Ml') {
            				
	    					$stock_qty123 = ((float)$stok_qty[$i]) / 1000;
         					
         					
         					print_r($stock_qty123);echo "=";
         					print_r($stok_qty[$i]);echo "/1000 <p>";
	    					 
	    					
          //   				echo "<p>";
          //   				print_r($stock_measerment_id);
          //   				echo "<p>";
            				print_r($stock_measerment_id[$i]);echo "=";
            				print_r($stkmid[$i]);echo "<p>";
         					if($stock_measerment_id[$i] != $stkmid[$i]){
         						//$stkqty2 = $stkqty[$i] * 1000;
         					
         						$ttqty= ((float)$dataquantityall[0]['stock_quanity'] - $stkqty[$i]) + $stock_qty123;
         					
         					}else{
         						$stkqty1=((float)$stkqty[$i])/1000;
         						$ttqty= ((float)$dataquantityall[0]['stock_quanity'] - $stkqty1) + $stock_qty123;
         					
         					// echo "gm same <p> ";
         					// print_r($ttqty);echo "=";
         					// print_r($dataquantityall[0]['stock_quanity']); echo "-";
         					// print_r($stkqty1);echo "+";
         					// print_r($stock_qty123);
         					// echo "<p>";
         					}
            				if ($ttqty > 0) {
	         				$this->Stock_model->insertupdateqty($ttqty,$stok_nm[$i],$stok_brand[$i]);
	         				}
         				}else{
         					print_r($stock_measerment_id[$i]);echo "=";
            				print_r($stkmid[$i]);echo "<p>";
					       	if($stock_measerment_id[$i] != $stkmid[$i]){
								//$stkqty2 = $stkqty[$i] * 1000;
								 // $stkqty3=$dataquantityall[0]['stock_quanity']/1000;
					       		$stkqty2 = (float)$stkqty[$i]/1000;
					       		$ttqty= ((float)$dataquantityall[0]['stock_quanity'] - $stkqty2) + (float)$stok_qty[$i];
					       	
					       	}else{
								   // print_r($dataquantityall[0]['stock_quanity']."*" );
								   // echo "<p>";
								   // print_r($stkqty[$i]."**");
								   // echo "<p>";
								   // print_r($stok_qty[$i]."***");
								   // echo "<p>";
					       		$ttqty= ((float)$dataquantityall[0]['stock_quanity'] - (float)$stkqty[$i]) + (float)$stok_qty[$i];
					       	
					       	}
         					
                    		
							if ($ttqty > 0) {
                      			$this->Stock_model->insertupdateqty($ttqty,$stok_nm[$i],$stok_brand[$i]);
                  			}
         				}
         	  		}else{
						if ($measer[$i] == 'Gm'  || $measer[$i] == 'Ml') {
	 							$stock_qty123 = ($stok_qty[$i]) / 1000;
	 							$m123='Kg';
	 							$this->Stock_model->insertdatainstock($stock_add_id,$data['stock_type'],$stok_nm[$i],$stok_brand[$i],$stock_qty123,$m123);
	 						}else{
	 							$measer123='Kg';
	 							$this->Stock_model->insertdatainstock($stock_add_id,$data['stock_type'],$stok_nm[$i],$stok_brand[$i],$stok_qty[$i],$measer123);
	 						}
       				}

	  			}
       		} //exit();
        }
       	$this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Stock Inserted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
             redirect('Stock/StockList');
	}
	public function StockList(){
		$data['stock']=$this->Stock_model->getaLLStockdata();
		$this->load->view('vwStockLIst',$data);
	}

	public function RemoveStock($id){
       print_r($id);
       exit();
		if($this->Stock_model->deletestock($id)){
            $this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Deleted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
           redirect('Stock/StockList');
		}else{
			$this->session->set_flashdata('err','<div class="alert alert-danger">Stock Not Deleted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			redirect('Stock/StockList');
		}
	}

	public function editStock($id){
		$data['stk']=$this->Stock_model->getStockById($id);
		$this->load->view('vwupdate_stock',$data);

	}

	public function availablestock(){
		$data['stk']=$this->Stock_model->getdatabyType();
		$this->load->view('available_stock',$data);
	}

	public function availableonid(){

		$stock_type=$this->input->post('stock_type');
		if (empty($stock_type)) {
			$data['stk']=$this->Stock_model->getdatabyType();
			$data['stk_type']='All';

		}else{
			$data['stk']=$this->Stock_model->getdatabyType1($stock_type);
		    $data['stk_type']=$stock_type;
		}
		
		$this->load->view('available_stock',$data);
	}

	public function item_used_list(){
		$data['measerment']=$this->Stock_model->getmeaserment();
		$data['stockused']=$this->Stock_model->getdusedstock();
		$this->load->view('vwstockusedlist',$data);
	}

	public function add_item_used(){
		$this->load->view('add_item_used');
	}

	public function used_by_cook(){
		 if(function_exists('date_default_timezone_set')) 
	  {
	    date_default_timezone_set("Asia/Kolkata");
	  }
        $digits = 5;
        $stock_sr_no='S-'.rand(pow(10, $digits-1), pow(10, $digits)-1);
		$stock_name=$this->input->post('stock_name');
		$brand_name=$this->input->post('brand_name');
		$quantity=$this->input->post('quantity');
		$measurement_type_id=$this->input->post('measurement_type_id');
		$date=$this->input->post('date');
		$when_used=$this->input->post('when_used');
		$measer=$this->Stock_model->getmeaserment1($measurement_type_id);
		$getquantity=$this->Stock_model->getquantityby($stock_name,$brand_name);
		$measertype=$this->Stock_model->getmeasertpe($measurement_type_id);
		$data=array(
                   'stock_consumption_sr_no'=>$stock_sr_no,
                   'stock_name'=>$stock_name,
                   'date_of_consumption'=>$date, 
                   'brand_name'=>$brand_name,
                   'quantity'=>$quantity,
                   'measurement_type_id'=>$measurement_type_id,
                   'when_used'=>$when_used,
		           ); 
		//print_r($getquantity[0]['stock_quanity']);
		// print_r($measertype[0]);
		// exit();
		if ($this->Stock_model->insertstockuseddata($data)) {
            
            if ($measertype[0]['measurement_short_code'] == 'Gm' || $measertype[0]['measurement_short_code'] == 'Ml') {
                $quantity123 = $quantity / 1000 ;
            	$qtyupdate = $getquantity[0]['stock_quanity'] - $quantity123;
            	$this->Stock_model->updatequantity($qtyupdate,$stock_name,$brand_name);
            }else{
            	$qtyupdate = $getquantity[0]['stock_quanity'] - $quantity;
            	$this->Stock_model->updatequantity($qtyupdate,$stock_name,$brand_name);
            }
			
            $this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Deleted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
           redirect('Stock/item_used_list');
		}else{
			$this->session->set_flashdata('err','<div class="alert alert-danger">Stock Not Deleted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			redirect('Stock/item_used_list');
		}
	}

	public function searchusedlist(){
        $data['measerment']=$this->Stock_model->getmeaserment();
        
		$when_used=$this->input->post('when_used');
		$start_date=$this->input->post('start_date');
		$end_date=$this->input->post('end_date');
		$data['stockused']=$this->Stock_model->getsearchuseddata($when_used,$start_date,$end_date);
		$this->load->view('vwstockusedlist',$data);
	}


	public function getstockdatabyid(){
        $sid=$_POST['sid'];
		$data=$this->Stock_model->getstockdatabyid($sid);
		print_r(json_encode($data));
	}

	public function editusedlist($id){
        $data['stk'] = $this->Stock_model->getconsumptiondata($id);
        $this->load->view('updateuseditem',$data);
	}

	public function updateitemused(){
        $id=$this->input->post('id');
        $quantitynumber=$this->input->post('quantitynumber');
        $measerment=$this->input->post('measerment');
        $stk_name=$this->input->post('stk_name');
        $stk_brand_name=$this->input->post('stk_brand_name');
        $mbyname=$this->Stock_model->getmeaserment1($measerment);
       
        $stock_name=$this->input->post('stock_name');
		$brand_name=$this->input->post('brand_name');
		$quantity=$this->input->post('quantity');
		$date=$this->input->post('date');
		$when_used=$this->input->post('when_used');
		$measurement_type_id=$this->input->post('measurement_type_id');
		$updatembyname=$this->Stock_model->getmeaserment1($measurement_type_id);
		
		$data=array(
                   'stock_name'=>$stock_name,
                   'date_of_consumption'=>$date, 
                   'brand_name'=>$brand_name,
                   'quantity'=>$quantity,
                   'measurement_type_id'=>$measurement_type_id,
                   'when_used'=>$when_used,
		           ); 
		if ($this->Stock_model->updateitemuseddata($data,$id)) {
            $query=$this->Stock_model->getstockquantitybynb($stk_name,$stk_brand_name);
            //$totalquantity = $query[0]['stock_quanity'] + 
            if ($mbyname[0]['measurement_short_code'] =='Gm' || $mbyname[0]['measurement_short_code']=='Ml') {
            	$gmml = $quantitynumber / 1000;
            	$tot=  $query[0]['stock_quanity'] + $gmml;
            	if($this->Stock_model->updateqty($stk_name,$stk_brand_name,$tot)){ 
            		$query2=$this->Stock_model->getstockquantitybynb($stock_name,$brand_name);
                    if ($updatembyname[0]['measurement_short_code'] == 'Gm' || $updatembyname[0]['measurement_short_code'] == 'Ml') {
                    	$gm= $quantity / 1000;
                    	$totalgm= $query2[0]['stock_quanity'] - $gm;
                    	$this->Stock_model->updateqty1($stock_name,$brand_name,$totalgm);
                    }else{
                    	$totalgm= $query2[0]['stock_quanity'] - $quantity;
                    	$this->Stock_model->updateqty1($stock_name,$brand_name,$totalgm);
                    }
            	}
            }else{
            	$tot=  $query[0]['stock_quanity'] + $quantitynumber;
            	if($this->Stock_model->updateqty($stk_name,$stk_brand_name,$tot)){ 
            		$query1=$this->Stock_model->getstockquantitybynb1($stock_name,$brand_name);
                    if ($updatembyname[0]['measurement_short_code'] == 'Gm' || $updatembyname[0]['measurement_short_code'] == 'Ml') {
                    	$gm= $quantity / 1000;
                    	$totalgm= $query1[0]['stock_quanity'] - $gm;
                    	$this->Stock_model->updateqty1($stock_name,$brand_name,$totalgm);
                    }else{
                    	$totalgm= $query1[0]['stock_quanity'] - $quantity;
                    	$this->Stock_model->updateqty1($stock_name,$brand_name,$totalgm);
                    }
            	}
            }     
			$this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Deleted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
           redirect('Stock/item_used_list');
		}else{
			$this->session->set_flashdata('err','<div class="alert alert-danger">Stock Not Deleted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			redirect('Stock/item_used_list');
		}
	}

	// stock Voucher generate 

	public function stockvoucher(){
       $data['party'] = $this->Stock_model->getaLLStockdata1();
		$this->load->view('addstockvoucher',$data);
	}

	public function voucherList(){

		$data['voucher']=$this->Stock_model->getvoucher();
		$this->load->view('stock_payment_voucher_list',$data);
	}

	public function savevoucher(){
         
        $v=$this->Stock_model->getvoucherid();
        if (empty($v)) {
        	$voucher_sr_no= '1';
        }else{
           $v1= get_object_vars($v);
           $v2=$v1['voucher_sr_no'];
           $v4= 1;
           $v3=$v2 + $v4;
          $voucher_sr_no= $v3;
        }
        $voucher_date=date('d/m/Y');

		$party_name = $this->input->post('party_name');
		$bill_no = $this->input->post('bill_no');
		$party_city = $this->input->post('party_city');
		$party_mobile = $this->input->post('party_mobile');
		$amount = $this->input->post('amount');
		$party_comment = $this->input->post('party_comment');

		$data=array(
			       'voucher_sr_no'=>$voucher_sr_no,
                   'party_name'=>$party_name,
                   'bill_no'=>$bill_no,
                   'party_city'=>$party_city,
                   'party_mobile'=>$party_mobile,
                   'amount'=>$amount,
                   'party_comment'=>$party_comment,
                   'voucher_date'=>$voucher_date
		           );
		if($this->Stock_model->insertstockbvoucher($data)){
            $this->session->set_flashdata('err','<div class="alert alert-success">Success !!! Insert<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          redirect('Stock/voucherList');
		}else{
			$this->session->set_flashdata('err','<div class="alert alert-danger">Data Not Inserted<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
			redirect('Stock/voucherList');
		}
	}

	public function getstockvoucher(){
       $vid= $_POST['vid'];
	   $data=$this->Stock_model->getviewdata($vid);
	   print_r(json_encode($data[0]));
	}

	public function printvoucher($id){

		$data['printvoucher']=$this->Stock_model->getviewdata($id);
		$this->load->view('printvoucher',$data);
	}

	public function getstockqunatitybyid(){

		$stock_name=$_POST['stockname'];
		$brand_name=$_POST['brand_name'];
		$data=$this->Stock_model->getstockquantitybyname($stock_name,$brand_name);
		echo json_encode($data);
	}

	
	// public function getdatabytype(){
	// 	$stock_type= 'Dead'; //$_POST['stock_type'];
	// 	$data=$this->Stock_model->getdatabyType($stock_type);
	// 	$data1=''
	// 	echo json_encode($data);
	// }
}

?>