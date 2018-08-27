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
            ->offset($page * $pageSize)
            ->limit($pageSize)
            ->get();         
    
        $recipe = DB::table('cost_centers')
            ->where('type', '=', 'RECEITA')
            ->offset($page * $pageSize)
            ->limit($pageSize)
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
            $rowCostCenter = new \stdClass();
                   
            if($i == 0){
                $columnHeader->headerName = 'FLUXO DE CAIXA';
                $columnHeader->field = "cod".$i;
                $rowCostCenter->{'cod'.$i} = 'DESPESAS';                
            }else{
                $columnHeader->headerName = $filter_date_limit->format('Y-m-d');
                $columnHeader->field = "cod".$i;                
                $filter_date_limit = $filter_date_limit->modify('+1 day'); 
                $rowCostCenter->{'cod'.$i} = ' ';                                   
            }            
            array_push($FullColumn,$columnHeader);
            array_push($arrayCostCenter,$rowCostCenter);
        }        

        $date_pay = $filter_date;
        $date_rec = $filter_date;
        
        $t =0;
        foreach ($expenses as  $value) {                              
            $rowBillsPay= new \stdClass();       
            
            $rowBillsPay->{'cod'.$t} = $value->name;

            for($i = 1 ; $i <= $filter['numberDays']; $i++){               
                $amountPay = DB::table('billspays')
                    ->where('billspays.status', 'Efetuada')
                    ->where('billspays.cost_centers_id', $value->id)
                    ->whereDate('billspays.payment_date' ,$date_pay->format('Y-m-d'))
                    ->sum('amount');                  
                
                $rowBillsPay->{'cod'.$i} = $amountPay;                 
                $date_pay =  $date_pay->modify('+1 day');                                                                                                      
            }
            array_push($arrayFullExpenses,$rowBillsPay);                                                      
        }
        

        foreach ($recipe as $key => $value) {
            $rowBillsRec = new \stdClass();

            $rowBillsRec->{'cod'.$t} = $value->name;

            for($i = 1 ; $i <= $filter['numberDays']; $i++){
                $amountReceive = DB::table('billsreceives')
                    ->where('status', '=', 'Efetuada')
                    ->where('cost_centers_id', '=', $value->id)
                    ->whereDate('created_at',$date_rec->format('Y-m-d'))
                    ->sum('amount');              

            
                $rowBillsRec->{'cod'.$i} = $amountReceive;               
            }
            array_push($arrayFullReceive,$rowBillsRec); 
        }
        
        $billspayCostcenter = array();

        $arrayCostCenter = json_encode($arrayCostCenter);
        var_dump($arrayCostCenter);die;
        array_push($billspayCostcenter,$FullColumn);
        array_push($billspayCostcenter,$arrayCostCenter);
        array_push($billspayCostcenter,$arrayFullExpenses);
        array_push($billspayCostcenter,$arrayFullReceive);
        return  $billspayCostcenter;        
    }
}
?>