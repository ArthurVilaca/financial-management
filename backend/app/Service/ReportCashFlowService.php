<?php 
namespace App\Service;
use Illuminate\Http\Request;
use DB;

class ReportCashFlowService extends Service
{

    public function getCashFlow($filter){               
        //$filter = json_decode($filter,true);
        //var_dump($filter["month"]);die;

        $expenses = DB::table('cost_centers')
            ->where('type', '=', 'DESPESA')
            ->get();         
    
        $recipe = DB::table('cost_centers')
            ->where('type', '=', 'RECEITA')
            ->get();
            
        $FullColumn = array();
        $arrayCostCenter = array();
        $arraybillsPayCost = array();
        $arraybillsRecCost = array();
        $arrayFullExpenses = array();
        $arrayFullReceive = array();
        
        $arraybillsReceiveCost = new \ArrayObject();

        $filter_date = new \DateTime(strval($filter['year']).strval('-').strval($filter['month']).strval('-').strval(1));            
        
        $filter_date_limit = $filter_date;
        
        for ($i=0; $i <= $filter['numberDays']; $i++) {  

            $columnHeader= new \stdClass();
            
                   
            if($i == 0){
                $columnHeader->headerName = 'FLUXO DE CAIXA';
                $columnHeader->field = "cod".$i;                                
            }else{
                $columnHeader->headerName = $filter_date_limit->format('d-m-Y');
                $columnHeader->field = "cod".$i;                
                $filter_date_limit = $filter_date_limit->modify('+1 day');                                                   
            }            
            array_push($FullColumn,$columnHeader);
        }        

        $date_pay = $filter_date;
        $date_rec = $filter_date;        
        $rowBillsPay = new \stdClass();
        $t =0; $validate = 0;$subtotalPay = 0.00;

        $rowBillsPay->{'cod'.$validate} = 'DESPESAS';
        $validate++;
        $rowBillsPay->{'cod'.$validate} = ' '; 
        array_push($arrayFullExpenses,$rowBillsPay);

        foreach ($expenses as  $value) {                              
            $rowBillsPay = new \stdClass();    

            $rowBillsPay->{'cod'.$t} = $value->name;   

            for($i = 1 ; $i <= $filter['numberDays']; $i++){  

                $value->amountPay = DB::table('billspays')
                    ->where('status','=', 'Efetuada')
                    ->where('cost_centers_id','=', $value->id)
                    ->whereDate('payment_date' ,$date_pay->format('Y-m-d'))
                    ->sum('amount');                
                
                $rowBillsPay->{'cod'.$i} = $value->amountPay;                
                $subtotalPay += $value->amountPay;
                $date_pay =  $date_pay->modify('+1 day');
                        
            }

            array_push($arrayFullExpenses,$rowBillsPay);            
            $validate ++;
        }
        $rowBillsPay = new \stdClass();
        $s = 0; 
        $rowBillsPay->{'cod'.$s} = 'SUBTOTAL - DEPESAS';
        $s++;
        $rowBillsPay->{'cod'.$s} = $subtotalPay;
        array_push($arrayFullExpenses,$rowBillsPay);
        
        $rowBillsPay = new \stdClass();
        $validateRecipe = 0;$x =0; $subtotalRec = 0;
        $rowBillsPay->{'cod'.$validateRecipe} = 'RECEITAS';
        $validateRecipe++;
        $rowBillsPay->{'cod'.$validateRecipe} = ' '; 
        array_push($arrayFullExpenses,$rowBillsPay);

        foreach ($recipe as  $value) {
            $rowBillsPay = new \stdClass();  
            $subtotalReceive = new \stdClass();       
            
            $rowBillsPay->{'cod'.$x} = $value->name;
                       

            for($i = 1 ; $i <= $filter['numberDays']; $i++){
                
                $amountReceive = DB::table('billsreceives')
                    ->where('status', '=', 'Efetuada')
                    ->where('cost_centers_id', '=', $value->id)
                    ->whereDate('created_at',$date_rec->format('d-m-Y'))
                    ->sum('amount');              
            
                    $rowBillsPay->{'cod'.$i} = $amountReceive;
                    $subtotalRec = $subtotalRec + $amountReceive;
                    $date_rec =  $date_rec->modify('+1 day');                            
            }
            array_push($arrayFullExpenses,$rowBillsPay);
            $validateRecipe ++;
        }

        $rowBillsPay = new \stdClass();
        $s = 0; 
        $rowBillsPay->{'cod'.$s} = 'SUBTOTAL - RECEITAS';
        $s++;
        $rowBillsPay->{'cod'.$s} = $subtotalRec;
        array_push($arrayFullExpenses,$rowBillsPay);

        $rowBillsPay = new \stdClass();
        $s = 0; 
        $rowBillsPay->{'cod'.$s} = 'TOTAL';
        $s++;
        $rowBillsPay->{'cod'.$s} = $subtotalRec + $subtotalPay;
        array_push($arrayFullExpenses,$rowBillsPay);
        
        $billspayCostcenter = array();
        array_push($billspayCostcenter,$FullColumn);
        array_push($billspayCostcenter,$arrayCostCenter);
        array_push($billspayCostcenter,$arrayFullExpenses);
        return  $billspayCostcenter;        
    }

    public function getCashFlowMonth($filter){               
        $expenses = DB::table('cost_centers')
            ->where('type', '=', 'DESPESA')
            ->get();         

        $recipe = DB::table('cost_centers')
            ->where('type', '=', 'RECEITA')
            ->get();

        $FullColumn = array();
        $arrayCostCenter = array();
        $arraybillsPayCost = array();
        $arraybillsRecCost = array();
        $arrayFullExpenses = array();
        $arrayFullReceive = array();

        $filter_date = new \DateTime(strval($filter['year']).strval('-').strval(1).strval('-').strval(1));
        $filter_date_limit = $filter_date;

        for ($i=0; $i <= $filter['numberMonths']; $i++) {  
            $columnHeader= new \stdClass();

            if($i == 0){
                $columnHeader->headerName = 'FLUXO DE CAIXA';
                $columnHeader->field = "cod".$i;                                
            }else{
                $columnHeader->headerName = $filter_date_limit->format('m-Y');
                $columnHeader->field = "cod".$i;                
                $filter_date_limit = $filter_date_limit->modify('+1 month');
            }            
            array_push($FullColumn ,$columnHeader);
        }        

        $date_pay = $filter_date;
        $date_rec = $filter_date;        
        $rowBillsPay = new \stdClass();
        $t =0; $validate = 0;$subtotalPay = 0.00;

        $rowBillsPay->{'cod'.$validate} = 'DESPESAS';
        $validate++;
        $rowBillsPay->{'cod'.$validate} = ' '; 
        array_push($arrayFullExpenses,$rowBillsPay);

        foreach ($expenses as  $value) {                              
            $rowBillsPay = new \stdClass();    

            $rowBillsPay->{'cod'.$t} = $value->name;   

            for($i = 1 ; $i <= $filter['numberMonths']; $i++){  

                $value->amountPay = DB::table('billspays')
                    ->where('status','=', 'Efetuada')
                    ->where('cost_centers_id','=', $value->id)
                    ->whereDate('payment_date' ,$date_pay->format('Y-m-d'))
                    ->sum('amount');                

                $rowBillsPay->{'cod'.$i} = $value->amountPay;                
                $subtotalPay += $value->amountPay;
                $date_pay =  $date_pay->modify('+1 month');

            }

            array_push($arrayFullExpenses,$rowBillsPay);            
            $validate ++;
        }

        $rowBillsPay = new \stdClass();
        $s = 0; 
        $rowBillsPay->{'cod'.$s} = 'SUBTOTAL - DEPESAS';
        $s++;
        $rowBillsPay->{'cod'.$s} = $subtotalPay;
        array_push($arrayFullExpenses,$rowBillsPay);

        $rowBillsPay = new \stdClass();
        $validateRecipe = 0;$x =0; $subtotalRec = 0;
        $rowBillsPay->{'cod'.$validateRecipe} = 'RECEITAS';
        $validateRecipe++;
        $rowBillsPay->{'cod'.$validateRecipe} = ' '; 
        array_push($arrayFullExpenses,$rowBillsPay);

        foreach ($recipe as  $value) {
            $rowBillsPay = new \stdClass();  
            $subtotalReceive = new \stdClass();       

            $rowBillsPay->{'cod'.$x} = $value->name;

            for($i = 1 ; $i <= $filter['numberMonths']; $i++){
                
                $amountReceive = DB::table('billsreceives')
                    ->where('status', '=', 'Efetuada')
                    ->where('cost_centers_id', '=', $value->id)
                    ->whereDate('created_at',$date_rec->format('d-m-Y'))
                    ->sum('amount');              
            
                    $rowBillsPay->{'cod'.$i} = $amountReceive;
                    $subtotalRec = $subtotalRec + $amountReceive;
                    $date_rec =  $date_rec->modify('+1 day');
            }
            array_push($arrayFullExpenses,$rowBillsPay);
            $validateRecipe ++;
        }

        $rowBillsPay = new \stdClass();
        $s = 0; 
        $rowBillsPay->{'cod'.$s} = 'SUBTOTAL - RECEITAS';
        $s++;
        $rowBillsPay->{'cod'.$s} = $subtotalRec;
        array_push($arrayFullExpenses,$rowBillsPay);

        $rowBillsPay = new \stdClass();
        $s = 0; 
        $rowBillsPay->{'cod'.$s} = 'TOTAL';
        $s++;
        $rowBillsPay->{'cod'.$s} = $subtotalRec + $subtotalPay;
        array_push($arrayFullExpenses,$rowBillsPay);

        $billspayCostcenter = array();
        array_push($billspayCostcenter,$FullColumn);
        array_push($billspayCostcenter,$arrayCostCenter);
        array_push($billspayCostcenter,$arrayFullExpenses);
        return  $billspayCostcenter;        
    }
}
?>