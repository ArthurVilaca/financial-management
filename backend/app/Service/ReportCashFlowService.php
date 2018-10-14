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

    public function getDreFlow($year){

        $FullColumn = array();
        $FullRow = array();

        $arrayMonths = array("f1", "Jan", "Fev", "Mar", "Abr","Mai", "Jun","Jul", "Ago", "Set", "Nov", "Dez", "Total");


        foreach ($arrayMonths as $key => $value) {
            $columnHeader= new \stdClass();

            $columnHeader->headerName = $value;
            $columnHeader->field = $key;                                
            array_push($FullColumn ,$columnHeader);
        }
                
        for($i= 0; $i <=12; $i ++){
            
            $rowTitle = new \stdClass();

            $rowRecipeProject = new \stdClass(); 

            if($i == 0){
                $rowTitle->{$i} ='';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='RECEITA OPERACIONAL BRUTA';  
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Receitas de projeto';                             
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Outras receitas';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} =' ';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='DEDUÇÕES DA RECEITA BRUTA';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Retenção de COFINS na fonte pelo cliente';
                array_push($FullRow,$rowTitle);
                $rowTitle->{$i} ='COFINS complementar';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Retenção de PIS na fonte pelo cliente';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='PIS complementar';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Retenção de ISS na fonte pelo cliente';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='ISSQN complementar';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} =' ';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='RECEITA OPERACIONAL LÍQUIDA';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} =' ';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='DESPESAS OPERACIONAIS';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='CUSTO DOS SERVIÇOS PRESTADOS';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Despesas fornecedores serviços (projetos)';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Outros fornecedores (projetos)';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Pagamento de impostos retidos pela INNOVARE';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Despesas de viagem';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='CUSTOS INTERNOS';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Salários e encargos';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Taxas e anuidades';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Materiais de consumo';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Serviços básicos';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Outras despesas';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} =' ';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='LUCRO OPERACIONAL / EBITDA';
                array_push($FullRow, $rowTitle);              
                $rowTitle->{$i} =' ';                  
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='DESPESAS FINANCEIRAS LÍQUIDAS';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} =' ';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Despesas financeiras';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Receitas financeiras';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} =' ';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='RESULTADO OPERACIONAL (LAIR)';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} =' ';                
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='IMPOSTO DE RENDA E CONTRIBUIÇÃO SOBRE LUCRO';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Retenção de IRPJ na fonte pelo cliente';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='IRPJ complementar';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Retenção de CSSL na fonte pelo cliente';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='CSSL complementar';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} =' ';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='RESULTADO LÍQUIDO DO EXERCÍCIO (lucro líquido)';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} =' ';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='(Δ)INVESTIMENTOS';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Alienações';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Aquisições';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} =' ';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='FLUXO DE CAIXA LIVRE';                
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} =' ';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='(Δ)EMPRÉSTIMOS';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Valor tomado de empréstimo';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Valor pago de empréstimo';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} =' ';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='FLUXO DE CAIXA DOS ACIONISTAS';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} =' ';                
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='APLICAÇÃO FINANCEIRA';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Título de Capitalização';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Aplicações financeiras diversas';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} =' ';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='PARTICIPAÇÕES';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} ='Distribuição de lucros';
                array_push($FullRow, $rowTitle);
                $rowTitle->{$i} =' '; 
                $rowTitle->{$i} ='FLUXO DE CAIXA LÍQUIDO';               
                array_push($FullRow, $rowTitle);

            }else{

                $firstDate = new \DateTime(strval($year).strval('-').strval($i).strval('-').strval(1));           
                $lastDate = $firstDate->modify('+1 month');

                $rowRecipeProject = new \stdClass();    
            
                $recipeProject = DB::table('billsreceives')
                ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'Receita de projeto')
                ->whereMonth('billsreceives.payment_date', $i)
                ->sum('billsreceives.amount');
                $rowRecipeProject->{$i} = $recipeProject;
            }

            $rowRecipeOtherProject = new \stdClass();

            $otherProject = DB::table('billsreceives')
            ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
            ->where('cost_centers.name', '=', 'Outras receitas')
            ->whereMonth('billsreceives.payment_date', $i)
            ->sum('billsreceives.amount');
            
            $rowOtherProject = new \stdClass();
            $rowRecipeProject->{$i} = $otherProject;

            $rowRecipeOpBrute = new \stdClass();

            $rowRecipeOpBrute->{$i} = 'DEDUÇÕES DA RECEITA BRUTA';
            array_push($FullRow, $rowRecipeOpBrute);
            
            $rowRecipeOpBrute->{$i} = $recipeProject  + $otherProject;

            array_push($FullRow, $rowRecipeOpBrute);
            array_push($FullRow, $rowRecipeProject);
            array_push($FullRow, $rowRecipeProject);

            array_push($FullRow, " ");

            $rowRetentionCofins = new \stdClass();    
           
            $retentionCofinsClient = DB::table('billsreceives')
            ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
            ->where('cost_centers.name', '=', 'Retenção de COFINS na fonte pelo cliente')
            ->whereMonth('billsreceives.payment_date', $i)
            ->sum('billsreceives.amount');
            $rowRetentionCofinsClient->{$i} = $retentionCofinsClient;
            
            
            $rowComplementCofins = new \stdClass();    
           
            $complementCofins = DB::table('billsreceives')
            ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
            ->where('cost_centers.name', '=', 'COFINS complementar')
            ->whereMonth('billsreceives.payment_date', $i)
            ->sum('billsreceives.amount');
            $rowComplementCofins->{$i} = $complementCofins;



            $rowPisSoucre = new \stdClass();    
           
            $PisSoucre = DB::table('billsreceives')
            ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
            ->where('cost_centers.name', '=', 'Retenção de PIS na fonte pelo cliente')
            ->whereMonth('billsreceives.payment_date', $i)
            ->sum('billsreceives.amount');
            $rowPisSoucre->{$i} = $PisSoucre;


            $rowPisComplement = new \stdClass();    
           
            $PisComplement = DB::table('billsreceives')
            ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
            ->where('cost_centers.name', '=', 'PIS complementar')
            ->whereMonth('billsreceives.payment_date', $i)
            ->sum('billsreceives.amount');
            $rowPisComplement->{$i} = $PisComplement;

            $rowComplementISSQN = new \stdClass();

            $complementISSQN = DB::table('billsreceives')
            ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
            ->where('cost_centers.name', '=', 'ISSQN complementar')
            ->whereMonth('billsreceives.payment_date', $i)
            ->sum('billsreceives.amount');
            $rowComplementISSQN->{$i} = $complementISSQN;

            $rowGrossRevenueDeduction = new \stdClass();
            $rowGrossRevenueDeduction->{$i} = 'DEDUÇÕES DA RECEITA BRUTA';
            array_push($FullRow, $rowGrossRevenueDeduction);
            $rowGrossRevenueDeduction->{$i} = $rowRetentionCofinsClient + $rowComplementCofins + $rowPisSoucre + 
            $rowPisComplement + $rowComplementISSQN;
            array_push($FullRow, $rowGrossRevenueDeduction);

            array_push($FullRow, $rowRetentionCofinsClient);
            array_push($FullRow, $rowComplementCofins);
            array_push($FullRow, $rowPisSoucre);
            array_push($FullRow, $rowPisComplement);
            array_push($FullRow, $rowComplementISSQN);

            array_push($FullRow, " ");

            $rowNetOperatingRevenue = new \stdClass();
            $rowNetOperatingRevenue->{$i} = 'RECEITA OPERACIONAL LÍQUIDA';
            array_push($FullRow, $rowNetOperatingRevenue);
            $rowNetOperatingRevenue->{$i} = $rowRecipeOpBrute + $rowGrossRevenueDeduction;    
            array_push($FullRow, $rowNetOperatingRevenue);

            array_push($FullRow, "");

            $rowExpensesSuppliersServices = new \stdClass();
            $expensesSuppliersServices = DB::table('billsreceives')
            ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
            ->where('cost_centers.name', '=', 'Despesas fornecedores serviços (projetos)')
            ->whereMonth('billsreceives.payment_date', $i)
            ->sum('billsreceives.amount');
            $rowExpensesSuppliersServices->{$i} = $expensesSuppliersServices;


            $rowOtherSuppliers = new \stdClass();
            $otherSuppliers = DB::table('billsreceives')
            ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
            ->where('cost_centers.name', '=', 'Outros fornecedores (projetos)')
            ->whereMonth('billsreceives.payment_date', $i)
            ->sum('billsreceives.amount');
            $rowOtherSuppliers->{$i} = $otherSuppliers;

            $rowPaymentTaxesInnovare = new \stdClass();
            $paymentTaxesInnovare = DB::table('billsreceives')
            ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
            ->where('cost_centers.name', '=', 'Pagamento de impostos retidos pela INNOVARE')
            ->whereMonth('billsreceives.payment_date', $i)
            ->sum('billsreceives.amount');
            $rowPaymentTaxesInnovare->{$i} = $paymentTaxesInnovare;

            $rowTravelExpenses = new \stdClass();
            $travelExpenses = DB::table('billsreceives')
            ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
            ->where('cost_centers.name', '=', 'Despesas de viagem')
            ->whereMonth('billsreceives.payment_date', $i)
            ->sum('billsreceives.amount');
            $rowTravelExpenses->{$i} = $travelExpenses;

            $rowFeesAnnuities = new \stdClass();
            $feesAnnuities = DB::table('billsreceives')
            ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
            ->where('cost_centers.name', '=', 'Taxas e anuidades')
            ->whereMonth('billsreceives.payment_date', $i)
            ->sum('billsreceives.amount');
            $rowFeesAnnuities->{$i} = $feesAnnuities;

            $rowConsumables = new \stdClass();
            $consumables = DB::table('billsreceives')
            ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
            ->where('cost_centers.name', '=', 'Materiais de consumo')
            ->whereMonth('billsreceives.payment_date', $i)
            ->sum('billsreceives.amount');
            $rowConsumables->{$i} = $Consumables;

            $rowBasicServices = new \stdClass();
            $basicServices = DB::table('billsreceives')
            ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
            ->where('cost_centers.name', '=', 'Serviços básicos')
            ->whereMonth('billsreceives.payment_date', $i)
            ->sum('billsreceives.amount');
            $rowBasicServices->{$i} = $basicServices;


            $rowOtherExpenses = new \stdClass();
            $otherExpenses = DB::table('billsreceives')
            ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
            ->where('cost_centers.name', '=', 'Outras despesas')
            ->whereMonth('billsreceives.payment_date', $i)
            ->sum('billsreceives.amount');
            $rowOtherExpenses->{$i} = $otherExpenses;

            array_push($FullRow, "");
            
            //DESPESAS FINANCEIRAS LÍQUIDAS
            $rowFinancialExpenses = new \stdClass();
            $financialExpenses = DB::table('billsreceives')
            ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
            ->where('cost_centers.name', '=', 'Despesas financeiras')
            ->whereMonth('billsreceives.payment_date', $i)
            ->sum('billsreceives.amount');
            $rowFinancialExpenses->{$i} = $financialExpenses;




        }
    }
}
?>