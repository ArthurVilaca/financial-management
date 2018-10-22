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

    public function getDreFlow($filter){
        
        $arrayDreFlow = array();
        $rowRecipeProject = new \stdClass();
        $rowOtherProject = new \stdClass();
        $rowRecipeOpBrute = new \stdClass();
        $rowRetentionCofinsClient = new \stdClass();
        $rowComplementCofins = new \stdClass();
        $rowRetentionPisClient = new \stdClass();
        $rowPisSoucre = new \stdClass();
        $rowPisComplement = new \stdClass();
        $rowComplementISSQN = new \stdClass();
        $rowGrossRevenueDeduction = new \stdClass();
        $rowRecipeOpLiquid = new \stdClass();
        $rowRentalPA = new \stdClass();
        $rowEquipmentRental = new \stdClass();
        $rowPayTaxWwithheld = new \stdClass(); 
        $rowTravelExpenses = new \stdClass();
        $rowCostServicesProvided = new \stdClass();
        $rowWagesCharges = new \stdClass();
        $rowRateAnnuities = new \stdClass();
        $rowConsumables = new \stdClass();
        $rowBaseicServices = new \stdClass();
        $rowOtherExpenses = new \stdClass();
        $rowInternalCosts = new \stdClass();
        $rowOperationalEpenses = new \stdClass();
        $rowOperatingIncome = new \stdClass();
        $rowFinancialExpenses = new \stdClass();
        $rowRecipeFinancialExpenses = new \stdClass();
        $rowNetFinancialEpenses = new \stdClass();
        $rowOperatingResult = new \stdClass();
        $rowRetentionIRPJSoucre = new \stdClass();
        $rowComplementIRPJ = new \stdClass();
        $rowRetentionCSSLSource = new \stdClass();
        $rowComplementCSSL = new \stdClass();
        $rowIncomeTaxProfitContribuitions = new \stdClass();
        $rowNetIncomeYear = new \stdClass();
        $rowDisposals = new \stdClass();
        $rowAcquisitions = new \stdClass();
        $rowInvestments = new \stdClass();
        $rowCashFlowFree = new \stdClass();
        $rowAmountBorrowed = new \stdClass();
        $rowPaymentLoan = new \stdClass();
        $rowCashFlowShareholders = new \stdClass();
        $rowCapitalizationTitle = new \stdClass();
        $rowMiscellaneousFinancialInvestments = new \stdClass();
        $rowFinancialAppication = new \stdClass();
        $rowDistributionProfits = new \stdClass();
        $rowParticipations = new \stdClass();
        $rowLiqCashFlow = new \stdClass();
        $rowLoans = new \stdClass();
        $rowSpace = new \stdClass();

        $cashFlow = array();
        $year = $filter['year'];        

        for($i= 0; $i <=13; $i ++){                                  

            $rowSpace->{$i}= '';

            if($i == 0){
                $rowRecipeProject->{$i} = 'Receitas de projeto';
                $rowOtherProject->{$i} = 'Outras receitas'; 
                $rowRecipeOpBrute->{$i} = 'RECEITA OPERACIONAL BRUTA';                
                $rowRetentionCofinsClient->{$i} ='Retenção de COFINS na fonte pelo cliente';                
                $rowComplementCofins->{$i} = 'COFINS complementar';                
                $rowRetentionPisClient->{$i} = 'Retenção de PIS na fonte pelo cliente';                
                $rowPisSoucre->{$i} = 'PIS complementar';
                $rowPisComplement->{$i} = 'Retenção de ISS na fonte pelo cliente';                
                $rowComplementISSQN->{$i} = 'ISSQN complementar';
                $rowGrossRevenueDeduction->{$i} = 'DEDUÇÕES DA RECEITA BRUTA';                
                $rowRecipeOpLiquid->{$i} ='RECEITA OPERACIONAL LÍQUIDA';
                $rowRentalPA->{$i} = 'Despesas fornecedores serviços (projetos)';                
                $rowEquipmentRental->{$i} = 'Outros fornecedores (projetos)';                
                $rowPayTaxWwithheld->{$i} = 'Pagamento de impostos retidos pela INNOVARE';
                $rowTravelExpenses->{$i} = 'Despesas de viagem';
                $rowCostServicesProvided->{$i} = 'CUSTO DOS SERVIÇOS PRESTADOS';
                $rowWagesCharges->{$i} = 'Salários e encargos';
                $rowRateAnnuities->{$i} = 'Taxas e anuidades';
                $rowConsumables->{$i} = 'Materiais de Consumo';                
                $rowBaseicServices->{$i} = 'Serviços básicos';                
                $rowOtherExpenses->{$i} = 'Outras despesas';
                $rowInternalCosts->{$i} = 'CUSTOS INTERNOS';
                $rowOperationalEpenses->{$i} = 'DESPESAS OPERACIONAIS';                 
                $rowOperatingIncome->{$i} = 'LUCRO OPERACIONAL';
                $rowFinancialExpenses->{$i} = 'Despesas financeiras';
                $rowRecipeFinancialExpenses->{$i} = 'Receitas financeiras';                
                $rowNetFinancialEpenses->{$i} = 'DESPESAS FINANCEIRAS LÍQUIDAS';
                $rowOperatingResult->{$i} = 'RESULTADO OPERACIONAL(LAIR)';
                $rowRetentionIRPJSoucre->{$i} = 'Retenção de IRPJ na fonte pelo cliente';
                $rowComplementIRPJ->{$i} = 'IRPJ complementar';
                $rowRetentionCSSLSource->{$i} = 'Retenção de CSSL na fonte pelo cliente';
                $rowComplementCSSL->{$i} = 'CSSL complementar';
                $rowIncomeTaxProfitContribuitions->{$i} = 'IMPOSTO DE RENDA E CONTRIBUIÇÃO SOBRE LUCRO';                
                $rowNetIncomeYear->{$i} = 'RESULTADO LÍQUIDO DO EXERCÍCIO (lucro líquido)';
                $rowDisposals->{$i} = 'Alienações';
                $rowAcquisitions->{$i} = 'Aquisições';                
                $rowInvestments->{$i} = '(Δ)INVESTIMENTOS';                
                $rowCashFlowFree->{$i} = 'FLUXO DE CAIXA LIVRE';  
                $rowLoans->{$i} = 'EMPRÉSTIMOS';              
                $rowAmountBorrowed->{$i} = 'Valor tomado de empréstimo';                
                $rowPaymentLoan->{$i} = 'Valor pago de empréstimo';                
                $rowCashFlowShareholders->{$i} = 'FLUXO DE CAIXA DOS ACIONISTAS';                
                $rowCapitalizationTitle->{$i} = 'Título de Capitalização';                
                $rowMiscellaneousFinancialInvestments->{$i} = 'Aplicações financeiras diversas';                
                $rowFinancialAppication->{$i} = 'APLICAÇÃO FINANCEIRA';                
                $rowDistributionProfits->{$i} = 'Distribuição de lucros';                
                $rowParticipations->{$i} = 'PARTICIPAÇÕES';                
                $rowLiqCashFlow->{$i} = 'FLUXO DE CAIXA LÍQUIDO';
            }else if($i > 0 && $i <=12) {

                $firstDate = new \DateTime(strval($year).strval('-').strval($i).strval('-').strval(1));           
                $lastDate = $firstDate->modify('+1 month');

                //Receitas de projeto
                $recipeProject = DB::table('billsreceives')
                    ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
                    ->where('cost_centers.name', '=', 'Receita de projeto')
                    ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                    ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                    ->sum('billsreceives.amount');
                    $rowRecipeProject->{$i} = $recipeProject;

                //Outras receitas
                $otherProject = DB::table('billsreceives')
                    ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
                    ->where('cost_centers.name', '=', 'Receita diversas')
                    ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                    ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                    ->sum('billsreceives.amount');
                
                $rowOtherProject->{$i} = $otherProject;
                    
                
                //RECEITA OPERACIONAL BRUTA
                $RecipeOpBrute = $recipeProject  + $otherProject;
                $rowRecipeOpBrute->{$i} = $RecipeOpBrute;
                
                
                //Retenção de COFINS na fonte pelo cliente
                $retentionCofinsClient = DB::table('billsreceives')
                ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'Retenção de COFINS na fonte pelo cliente')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billsreceives.amount');

                $rowRetentionCofinsClient->{$i} = $retentionCofinsClient;
                
                
            //COFINS complementar
                $complementCofins = DB::table('billsreceives')
                ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'COFINS')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billsreceives.amount');

                $rowComplementCofins->{$i} = $complementCofins; 

                
                //Retenção de PIS na fonte pelo cliente
                $retentionPisClient = DB::table('billsreceives')
                ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'Retenção de PIS na fonte pelo cliente')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billsreceives.amount');

                $rowRetentionPisClient->{$i} = $retentionPisClient;

                //PIS complementar
                $pisSoucre = DB::table('billsreceives')
                ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'PIS')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billsreceives.amount');

                $rowPisSoucre->{$i} = $pisSoucre;
                

            //Retenção de ISS na fonte pelo cliente
                $pisComplement = DB::table('billsreceives')
                ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'Retenção de ISS na fonte pelo cliente')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billsreceives.amount');

                $rowPisComplement->{$i} = $pisComplement;


                //ISSQN complementar
                $complementISSQN = DB::table('billsreceives')
                ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'ISSQN')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billsreceives.amount');

                $rowComplementISSQN->{$i} = $complementISSQN;

                //DEDUÇÕES DA RECEITA BRUTA
                $grossRevenueDeduction = $retentionCofinsClient + $complementCofins + $pisSoucre + 
                $pisComplement + $complementISSQN;
                $rowGrossRevenueDeduction->{$i} = $grossRevenueDeduction;
                

                //RECEITA OPERACIONAL LÍQUIDA
                $recipeOpLiquid = $RecipeOpBrute  + $grossRevenueDeduction;
                $rowRecipeOpLiquid->{$i} = $recipeOpLiquid;


                //Despesas fornecedores serviços (projetos)            
                $rentalPA = DB::table('billspays')
                ->join('cost_centers', 'billspays.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'Aluguel de PA')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billspays.amount');

                $rowRentalPA->{$i} = $rentalPA;

                //Outros fornecedores (projetos)
                $equipmentRental = DB::table('billspays')
                ->join('cost_centers', 'billspays.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'Aluguel de equipamentos')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billspays.amount');

                $rowEquipmentRental->{$i} = $equipmentRental;

                //Pagamento de impostos retidos pela INNOVARE
                $payTaxWwithheld = DB::table('billspays')
                ->join('cost_centers', 'billspays.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'Pagamento de impostos retidos pela INNOVARE')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billspays.amount');

                $rowPayTaxWwithheld->{$i} = $payTaxWwithheld;

                //Despesas de viagem
                $travelExpenses = DB::table('billspays')
                ->join('cost_centers', 'billspays.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'Alimentação')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billspays.amount');
                
                $rowTravelExpenses->{$i} = $travelExpenses;

                //CUSTO DOS SERVIÇOS PRESTADOS 
                $costServicesProvided = $rentalPA + $equipmentRental + $payTaxWwithheld + $travelExpenses;
                $rowCostServicesProvided->{$i} = $costServicesProvided;
                
                //Salários e encargos
                $wagesCharges = DB::table('billspays')
                ->join('cost_centers', 'billspays.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'Bolsa de Estágio')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billspays.amount');

                $rowWagesCharges->{$i} = $wagesCharges;

                //Taxas e anuidades
                $rateAnnuities = DB::table('billspays')
                ->join('cost_centers', 'billspays.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'Taxas e anuidades')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billspays.amount');

                $rowRateAnnuities->{$i} = $rateAnnuities;

                //Materiais de Consumo
                $consumables = DB::table('billspays')
                ->join('cost_centers', 'billspays.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'Materiais Escritório')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billspays.amount');
                $rowConsumables->{$i} = $consumables;

                //Serviços básicos
                $baseicServices = DB::table('billspays')
                ->join('cost_centers', 'billspays.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'Condomínio')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billspays.amount');

                $rowBaseicServices->{$i} = $baseicServices;

                //Outras despesas
                $otherExpenses = DB::table('billspays')
                ->join('cost_centers', 'billspays.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'Cartório')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billspays.amount');

                $rowOtherExpenses->{$i} = $otherExpenses;

                //CUSTOS INTERNOS
                $internalCosts = $wagesCharges + $rateAnnuities + $consumables + $baseicServices + $otherExpenses;
                $rowInternalCosts->{$i} = $internalCosts; 

                //DESPESAS OPERACIONAIS
                $operationalEpenses = $costServicesProvided + $internalCosts;
                $rowOperationalEpenses->{$i} = $operationalEpenses;
                //LUCRO OPERACIONAL 
                $operatingIncome = $operationalEpenses + $recipeOpLiquid;
                $rowOperatingIncome->{$i} = $operatingIncome;


                //Despesas financeiras
                $financialExpenses = DB::table('billspays')
                ->join('cost_centers', 'billspays.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'Despesa financeira (juros e multas)')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billspays.amount');

                $rowFinancialExpenses->{$i} = $financialExpenses;

                //Receitas financeiras 
                $recipeFinancialExpenses = DB::table('billsreceives')
                ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'Receita financeira (rendimento de aplicações)')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billsreceives.amount');

                $rowRecipeFinancialExpenses->{$i} = $recipeFinancialExpenses;

                //DESPESAS FINANCEIRAS LÍQUIDAS
                $netFinancialEpenses = $financialExpenses + $recipeFinancialExpenses;
                $rowNetFinancialEpenses->{$i} = $netFinancialEpenses; 
                
                //RESULTADO OPERACIONAL(LAIR)
                $operatingResult = $operatingIncome + $netFinancialEpenses;
                $rowOperatingResult->{$i} = $operatingResult;

                //Retenção de IRPJ na fonte pelo cliente
                $retentionIRPJSoucre = DB::table('billspays')
                ->join('cost_centers', 'billspays.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'Retenção de IRPJ na fonte pelo cliente')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billspays.amount');
                $rowRetentionIRPJSoucre->{$i} = $retentionIRPJSoucre;


                //IRPJ complementar
                $complementIRPJ = DB::table('billspays')
                ->join('cost_centers', 'billspays.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'IRPJ')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billspays.amount');

                $rowComplementIRPJ->{$i} = $complementIRPJ;

                //Retenção de CSSL na fonte pelo cliente
                $retentionCSSLSource = DB::table('billspays')
                ->join('cost_centers', 'billspays.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'Retenção de CSSL na fonte pelo cliente')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billspays.amount');
                $rowRetentionCSSLSource->{$i} = $retentionCSSLSource;

                //CSSL complementar
                $complementCSSL = DB::table('billspays')
                ->join('cost_centers', 'billspays.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'CSSL')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billspays.amount');
                $rowComplementCSSL->{$i} = $complementCSSL; 

                //IMPOSTO DE RENDA E CONTRIBUIÇÃO SOBRE LUCRO
                $incomeTaxProfitContribuitions = $retentionIRPJSoucre + $complementIRPJ + $retentionCSSLSource + $complementCSSL;
                $rowIncomeTaxProfitContribuitions->{$i} = $incomeTaxProfitContribuitions;

                //RESULTADO LÍQUIDO DO EXERCÍCIO (lucro líquido)
                $netIncomeYear = $operatingResult + $incomeTaxProfitContribuitions;
                $rowNetIncomeYear->{$i} = $netIncomeYear;

                //Alienações
                $disposals = DB::table('billsreceives')
                ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'Receita de alienações de bens')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billsreceives.amount');
                $rowDisposals->{$i} = $disposals; 

                //Aquisições
                $acquisitions = DB::table('billsreceives')
                ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'Móvel, imóvel ou equipamento')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billsreceives.amount');
                $rowAcquisitions->{$i} = $acquisitions;

                //(Δ)INVESTIMENTOS
                $investments = $disposals + $acquisitions;
                $rowInvestments->{$i} = $investments;
                
                //FLUXO DE CAIXA LIVRE
                $cashFlowFree = $netIncomeYear + $investments;
                $rowCashFlowFree->{$i} = $cashFlowFree; 
                 

                //Valor tomado de empréstimo
                $amountBorrowed = DB::table('billsreceives')
                ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'Empréstimo')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billsreceives.amount');
                $rowAmountBorrowed->{$i} = $amountBorrowed;

                //Valor pago de empréstimo
                $paymentLoan = DB::table('billsreceives')
                ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'Pagamento Empréstimo')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billsreceives.amount');
                $rowPaymentLoan->{$i} = $paymentLoan;
                
                //EMPRÉSTIMO
                $rowLoans->{$i} = $amountBorrowed + $paymentLoan;

                //FLUXO DE CAIXA DOS ACIONISTAS
                $cashFlowShareholders = $investments + $cashFlowFree;
                $rowCashFlowShareholders->{$i} = $cashFlowShareholders; 
                
                //Título de Capitalização
                $capitalizationTitle = DB::table('billsreceives')
                ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'Título de Capitalização')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billsreceives.amount');
                $rowCapitalizationTitle->{$i} = $capitalizationTitle;

                //Aplicações financeiras diversas
                $miscellaneousFinancialInvestments = DB::table('billsreceives')
                ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'Aplicações financeiras diversas')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billsreceives.amount');
                $rowMiscellaneousFinancialInvestments->{$i} = $miscellaneousFinancialInvestments;


                //APLICAÇÃO FINANCEIRA
                $financialAppication = $capitalizationTitle + $miscellaneousFinancialInvestments;
                $rowFinancialAppication->{$i} = $financialAppication;

                //Distribuição de lucros
                $distributionProfits = DB::table('billsreceives')
                ->join('cost_centers', 'billsreceives.cost_centers_id', '=', 'cost_centers.id')
                ->where('cost_centers.name', '=', 'Antecipação de lucros')
                ->whereDate('due_date' ,$firstDate->format('Y-m-d'))
                ->whereDate('due_date' ,$lastDate->format('Y-m-d'))
                ->sum('billsreceives.amount');
                $rowDistributionProfits->{$i} = $distributionProfits;

                //PARTICIPAÇÕES
                $participations = $distributionProfits;
                $rowParticipations->{$i} = $participations;

                //FLUXO DE CAIXA LÍQUIDO
                $LiqCashFlow = $cashFlowShareholders + $financialAppication + $participations;
                $rowLiqCashFlow->{$i} = $LiqCashFlow;
        }else {
            $sum = 0;
            foreach($rowRecipeProject as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }

            $rowRecipeProject->{$i} = $sum;
            $sum = 0;
            foreach($rowOtherProject as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowOtherProject->{$i} = $sum;

            $sum = 0;
            foreach($rowRecipeOpBrute as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }                    
            }
            $rowRecipeOpBrute->{$i} = $sum;

            $sum = 0;
            foreach($rowRetentionCofinsClient as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowRetentionCofinsClient->{$i} = $sum;

            $sum = 0;
            foreach($rowComplementCofins as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowComplementCofins->{$i} = $sum;

            $sum = 0;
            foreach($rowRetentionPisClient as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowRetentionPisClient->{$i} = $sum;

            $sum = 0;
            foreach($rowPisSoucre as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowPisSoucre->{$i} = $sum;

            $sum = 0;
            foreach($rowPisComplement as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowPisComplement->{$i} = $sum;

            $sum = 0;
            foreach($rowComplementISSQN as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowComplementISSQN->{$i} = $sum;

            $sum = 0;
            foreach($rowGrossRevenueDeduction as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowGrossRevenueDeduction->{$i} = $sum;

            $sum = 0;
            foreach($rowRecipeOpLiquid as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowRecipeOpLiquid->{$i} = $sum;

            $sum = 0;
            foreach($rowRentalPA as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowRentalPA->{$i} = $sum;

            $sum = 0;
            foreach($rowEquipmentRental as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowEquipmentRental->{$i} = $sum;

            $sum = 0;
            foreach($rowPayTaxWwithheld as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowPayTaxWwithheld->{$i} = $sum;

            $sum = 0;
            foreach($rowTravelExpenses as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowTravelExpenses->{$i} = $sum;

            $sum = 0;
            foreach($rowCostServicesProvided as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowCostServicesProvided->{$i} = $sum;

            $sum = 0;
            foreach($rowWagesCharges as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowWagesCharges->{$i} = $sum;

            $sum = 0;
            foreach($rowRateAnnuities as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowRateAnnuities->{$i} = $sum;

            $sum = 0;
            foreach($rowConsumables as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowConsumables->{$i} = $sum;

            $sum = 0;
            foreach($rowBaseicServices as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowBaseicServices->{$i} = $sum;

            $sum = 0;
            foreach($rowOtherExpenses as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowOtherExpenses->{$i} = $sum;

            $sum = 0;
            foreach($rowInternalCosts as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowInternalCosts->{$i} = $sum;

            $sum = 0;
            foreach($rowOperationalEpenses as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowOperationalEpenses->{$i} = $sum;

            $sum = 0;
            foreach($rowOperatingIncome as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowOperatingIncome->{$i} = $sum;

            $sum = 0;
            foreach($rowFinancialExpenses as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowFinancialExpenses->{$i} = $sum;

            $sum = 0;
            foreach($rowRecipeFinancialExpenses as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowRecipeFinancialExpenses->{$i} = $sum;

            $sum = 0;
            foreach($rowNetFinancialEpenses as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowNetFinancialEpenses->{$i} = $sum;

            $sum = 0;
            foreach($rowOperatingResult as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowOperatingResult->{$i} = $sum;

            $sum = 0;
            foreach($rowRetentionIRPJSoucre as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowRetentionIRPJSoucre->{$i} = $sum;

            $sum = 0;
            foreach($rowComplementIRPJ as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowComplementIRPJ->{$i} = $sum;

            $sum = 0;
            foreach($rowRetentionCSSLSource as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowRetentionCSSLSource->{$i} = $sum;

            $sum = 0;
            foreach($rowComplementCSSL as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowComplementCSSL->{$i} = $sum;

            $sum = 0;
            foreach($rowIncomeTaxProfitContribuitions as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowIncomeTaxProfitContribuitions->{$i} = $sum;

            $sum = 0;
            foreach($rowNetIncomeYear as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowNetIncomeYear->{$i} = $sum;

            $sum = 0;
            foreach($rowDisposals as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowDisposals->{$i} = $sum;

            $sum = 0;
            foreach($rowAcquisitions as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowAcquisitions->{$i} = $sum;

            $sum = 0;
            foreach($rowInvestments as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowInvestments->{$i} = $sum;

            $sum = 0;
            foreach($rowCashFlowFree as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowCashFlowFree->{$i} = $sum;

            $sum = 0;
            foreach($rowAmountBorrowed as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowAmountBorrowed->{$i} = $sum;

            $sum = 0;
            foreach($rowPaymentLoan as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowPaymentLoan->{$i} = $sum;

            $sum = 0;
            foreach($rowCashFlowShareholders as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowCashFlowShareholders->{$i} = $sum;

            $sum = 0;
            foreach($rowCapitalizationTitle as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowCapitalizationTitle->{$i} = $sum;

            $sum = 0;
            foreach($rowMiscellaneousFinancialInvestments as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowMiscellaneousFinancialInvestments->{$i} = $sum;

            $sum = 0;
            foreach($rowDistributionProfits as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowDistributionProfits->{$i} = $sum;

            $sum = 0;
            foreach($rowParticipations as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowParticipations->{$i} = $sum;

            $sum = 0;
            foreach($rowLiqCashFlow as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowLiqCashFlow->{$i} = $sum;

            $sum = 0;
            foreach($rowLoans as $value){
                if(is_numeric($value)){
                    $sum += $value;
                }
            }
            $rowLoans->{$i} = $sum;
        }

    }

        array_push($cashFlow,$rowRecipeOpBrute);
        array_push($cashFlow,$rowRecipeProject);
        array_push($cashFlow,$rowOtherProject);
        array_push($cashFlow,$rowSpace);
        
        array_push($cashFlow,$rowGrossRevenueDeduction);
        array_push($cashFlow,$rowRetentionCofinsClient);
        array_push($cashFlow,$rowComplementCofins);
        array_push($cashFlow,$rowRetentionPisClient);
        array_push($cashFlow,$rowPisSoucre);
        array_push($cashFlow,$rowPisComplement);
        array_push($cashFlow,$rowComplementISSQN);         
        array_push($cashFlow,$rowSpace);

        array_push($cashFlow,$rowRecipeOpLiquid);
        array_push($cashFlow,$rowSpace);

        array_push($cashFlow,$rowOperationalEpenses);
        array_push($cashFlow,$rowCostServicesProvided);
        array_push($cashFlow,$rowRentalPA);
        array_push($cashFlow,$rowEquipmentRental);
        array_push($cashFlow,$rowPayTaxWwithheld);
        array_push($cashFlow,$rowTravelExpenses);
        array_push($cashFlow,$rowInternalCosts);        
        array_push($cashFlow,$rowWagesCharges);
        array_push($cashFlow,$rowRateAnnuities);
        array_push($cashFlow,$rowConsumables);
        array_push($cashFlow,$rowBaseicServices);
        array_push($cashFlow,$rowOtherExpenses);        
        array_push($cashFlow,$rowSpace); 

        array_push($cashFlow,$rowOperatingIncome);
        array_push($cashFlow,$rowSpace);

        array_push($cashFlow,$rowNetFinancialEpenses);
        array_push($cashFlow,$rowFinancialExpenses);
        array_push($cashFlow,$rowRecipeFinancialExpenses); 
        array_push($cashFlow,$rowSpace);

        array_push($cashFlow,$rowOperatingResult);
        array_push($cashFlow,$rowSpace);

        array_push($cashFlow,$rowIncomeTaxProfitContribuitions);
        array_push($cashFlow,$rowRetentionIRPJSoucre);
        array_push($cashFlow,$rowComplementIRPJ);
        array_push($cashFlow,$rowRetentionCSSLSource);
        array_push($cashFlow,$rowComplementCSSL);
        array_push($cashFlow,$rowSpace);        

        array_push($cashFlow,$rowNetIncomeYear);
        array_push($cashFlow,$rowSpace);

        array_push($cashFlow,$rowInvestments);
        array_push($cashFlow,$rowDisposals);
        array_push($cashFlow,$rowAcquisitions);
        array_push($cashFlow,$rowSpace);

        array_push($cashFlow,$rowCashFlowFree);
        array_push($cashFlow,$rowSpace);
        
        array_push($cashFlow,$rowLoans);
        array_push($cashFlow,$rowAmountBorrowed);
        array_push($cashFlow,$rowPaymentLoan);
        array_push($cashFlow,$rowSpace);


        array_push($cashFlow,$rowCashFlowShareholders);
        array_push($cashFlow,$rowSpace);
        
        array_push($cashFlow,$rowFinancialAppication);
        array_push($cashFlow,$rowCapitalizationTitle);
        array_push($cashFlow,$rowMiscellaneousFinancialInvestments);
        array_push($cashFlow,$rowSpace);

        array_push($cashFlow,$rowParticipations);
        array_push($cashFlow,$rowDistributionProfits);

        array_push($cashFlow,$rowLiqCashFlow);
        array_push($cashFlow,$rowSpace);
        
            return $cashFlow;
        }
}
?>