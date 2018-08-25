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
            
        $arrayFullColumn = new \ArrayObject();
        $arrayFullRow = new \ArrayObject();
        $arrayFullExpenses = new \ArrayObject();
        $arrayFullReceive = new \ArrayObject();
        $arraybillsPayCost = new \ArrayObject();
        $arraybillsReceiveCost = new \ArrayObject();

        $filter_date = new \DateTime(strval($filter['year']).strval('-').strval($filter['month']).strval('-').strval(1));
        $arrayFullColumn->append('FLUXO DE CAIXA');
        $arrayFullRow->append('CENTRO DE CUSTO');
        $arraybillsPayCost->append('DESPESAS');
        $arraybillsReceiveCost->append('RECEITA');
        $arrayFullColumn->append($filter_date->format('Y-m-d'));

        
        $filter_date_limit = $filter_date;
        for ($i=1; $i < $filter['numberDays']; $i++) { 
            $filter_date_limit = $filter_date_limit->modify('+1 day'); 
            $arrayFullColumn->append($filter_date_limit->format('Y-m-d'));
            $arrayFullRow->append(' ');
            $arraybillsPayCost->append(' ');
            $arraybillsReceiveCost->append(' ');
        }

        $date_pay =  $filter_date;
        $date_rec =  $filter_date;

        foreach ($expenses as $key => $value) {
            $i =1;
            $arrayTempPay = new \ArrayObject();

            do {                
                $amountPay = DB::table('billspays')
                    ->where('status', '=', 'Efetuada')
                    ->where('cost_centers_id', '=', $value->id)
                    ->whereDate('payment_date', '=' ,$date_pay->format('Y-m-d'))
                    ->sum('amount');
                                             
                $date_pay =  $date_pay->modify('+1 day');   
                $arrayTempPay->append(array('sum' =>$amountPay, 'date' => $date_pay->format('Y-m-d')));
                $i++;
            } while ($i < $filter['numberDays']);
            $arrayFullExpenses->append( array('name' => $value->name, $arrayTempPay));
        }

        foreach ($recipe as $key => $value) {
            $i=1;
            $arrayTempRec = new \ArrayObject();

            do {
                $amountReceive = DB::table('billsreceives')
                    ->where('status', '=', 'Efetuada')
                    ->where('cost_centers_id', '=', $value->id)
                    ->whereDate('created_at', '=' ,$date_rec->format('Y-m-d'))
                    ->sum('amount');              

                $date_rec = $date_rec->modify('+1 day');
                $arrayTempRec->append(array('sum' => $amountReceive, 'date' => $date_rec));
                $i++;

            } while ($i < $filter['numberDays']);
            $arrayFullReceive->append(array('name' => $value->name, $arrayTempRec));
        }
        
        $billspayCostcenter = array();
        
        array_push($billspayCostcenter,$arrayFullColumn);
        array_push($billspayCostcenter,$arraybillsPayCost);
        array_push($billspayCostcenter,$arraybillsReceiveCost);
        array_push($billspayCostcenter,$arrayFullExpenses);
        array_push($billspayCostcenter,$arrayFullReceive);
        return  $billspayCostcenter;        
    }
}
?>