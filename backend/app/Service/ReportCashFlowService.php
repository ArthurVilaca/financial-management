<?php 
namespace App\Service;
use Illuminate\Http\Request;
use DB;

class ReportCashFlowService extends Service
{

    public function getCashFlow($page, $pageSize,$filter){               

        $filter = json_decode($filter,true);

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
                $columnHeader->headerName = $filter_date_limit->format('Y-m-d');
                $columnHeader->field = "cod".$i;                
                $filter_date_limit = $filter_date_limit->modify('+1 day');                                                   
            }            
            array_push($FullColumn,$columnHeader);
        }        

        $date_pay = $filter_date;
        $date_rec = $filter_date;        
        $rowBillsPay;
        $t =0; $validate = 0;
        foreach ($expenses as  $value) {                              
            $rowBillsPay= new \stdClass();            
            
            if($validate == 0){
                $rowBillsPay->{'cod'.$t} = 'DESPESAS';
            }else{
                $rowBillsPay->{'cod'.$t} = $value->name;
            }            

            for($i = 1 ; $i <= $filter['numberDays']; $i++){  

                if($validate == 0){
                    $rowBillsPay->{'cod'.$i} = ' '; 
                }
                else{
                    $amountPay = DB::table('billspays')
                    ->where('billspays.status', 'Efetuada')
                    ->where('billspays.cost_centers_id', $value->id)
                    ->whereDate('billspays.payment_date' ,$date_pay->format('d-m-Y'))
                    ->sum('amount');                  
                
                $rowBillsPay->{'cod'.$i} = $amountPay;                 
                $date_pay =  $date_pay->modify('+1 day');
                }               
            }

            array_push($arrayFullExpenses,$rowBillsPay);
            
            $validate ++;
        }
        

        $validateRecipe = 0;$x =0;
        foreach ($recipe as  $value) {
            //$rowBillsRec = new \stdClass();
            $rowBillsPay= new \stdClass();            

            if($validateRecipe == 0){
                $rowBillsPay->{'cod'.$x} = 'RECEITAS';
            }else{
                $rowBillsPay->{'cod'.$x} = $value->name;
            }            

            for($i = 1 ; $i <= $filter['numberDays']; $i++){

                
                if($validateRecipe == 0){
                    $rowBillsPay->{'cod'.$i} = ' '; 
                }else{
                    
                    $amountReceive = DB::table('billsreceives')
                        ->where('status', '=', 'Efetuada')
                        ->where('cost_centers_id', '=', $value->id)
                        ->whereDate('created_at',$date_rec->format('d-m-Y'))
                        ->sum('amount');              

            
                    $rowBillsPay->{'cod'.$i} = $amountReceive;
                    $date_rec =  $date_rec->modify('+1 day');
                }                             
            }
            //array_push($arrayFullReceive,$rowBillsRec);
            array_push($arrayFullExpenses,$rowBillsPay);
            $validateRecipe ++;
        }
        
        $billspayCostcenter = array();
        //$arrayCostCenter = json_encode($arrayCostCenter);
        array_push($billspayCostcenter,$FullColumn);
        array_push($billspayCostcenter,$arrayCostCenter);
        array_push($billspayCostcenter,$arrayFullExpenses);
        //array_push($billspayCostcenter,$arrayFullReceive);
        return  $billspayCostcenter;        
    }
}
?>