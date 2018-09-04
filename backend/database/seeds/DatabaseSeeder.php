<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            'name' => 'Arthur Vilaca', 'username' => 'arthur_vilaca',
            'email' => 'vilaca.arthur.f@gmail.com',
            'password' => bcrypt('123'), 'status' => 'ATIVO'
        ]);
        DB::table('employees')->insert([
            'name' => 'Luciana', 'username' => 'luciana',
            'email' => 'luciana@innovarepesquisa.com.br',
            'password' => bcrypt('123'), 'status' => 'ATIVO'
        ]);

        DB::table('clients')->insert([
            'name' => 'Cliente 1', 'status' => 'APROVADO'
        ]);
        DB::table('clients')->insert([
            'name' => 'Cliente 2', 'status' => 'BLOQUEADO'
        ]);

        DB::table('providers')->insert([
            'name' => 'Fornecedor 1', 'status' => 'APROVADO'
        ]);
        DB::table('providers')->insert([
            'name' => 'Fornecedor 2', 'status' => 'BLOQUEADO'
        ]);

        DB::table('banks')->insert([
            'name' => 'Banco do Brasil'
        ]);
        DB::table('banks')->insert([
            'name' => 'BRADESCO'
        ]);
        DB::table('banks')->insert([
            'name' => 'ITAU'
        ]);

        DB::table('cost_centers')->insert([
            'name' => "Alimentação",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Aluguel da sede da Innovare",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Aluguel de equipamentos",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Aluguel de PA's",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Aluguel de salas e estúdios",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Antecipação de lucros",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Aplicações financeiras diversas",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Bolsa de Estágio",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Cartório",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "COFINS",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Compra de banco de dados",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Condomínio",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Contribuição sindical",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Correios e Courier",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "CSSL",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Despesa financeira (juros e multas)",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Despesas diversas",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Despesas diversas de projetos",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Distribuição de lucros",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Empréstimo",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Energia Elétrica",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "FGTS",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Gráfica",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Honorários",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Hotel",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "INSS + outros",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "IPTU",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "IRPJ",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "IRRF",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "ISSQN",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Manutenção salas e equipamentos",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Materiais Escritório",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Materiais manutenção",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Medicina do Trabalho",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Móvel, imóvel ou equipamento",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Outras despesas de viagem",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Pagamento de impostos retidos pela INNOVARE",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Pagamento Empréstimo",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Passagem aérea",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "PIS",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Plano de Saude - UNIMED",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Pró-labore",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Receita de alienações de bens",
            'type' => 'RECEITA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Receita de projeto",
            'type' => 'RECEITA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Receita diversas",
            'type' => 'RECEITA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Receita financeira (rendimento de aplicações)",
            'type' => 'RECEITA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Recrutamento e Seleção de Empregados",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Reembolso de despesa de telefone",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Reforma de salas",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Rescisão de contrato de trabalho",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Retenção de COFINS na fonte pelo cliente",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Retenção de CSSL na fonte pelo cliente",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Retenção de IRPJ na fonte pelo cliente",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Retenção de ISS na fonte pelo cliente",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Retenção de PIS na fonte pelo cliente",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Salário",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Seguro de vida",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Agendamento de Entrevistas",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Amostra",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Campo",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Consistência de Dados",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Contabilidade",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Digitação",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Entrevistas em Profundidade",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Finalização",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Informática (manutenção)",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Máscara",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Moderação de GDs",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Processamento",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Programação",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Recodificação",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Recrutamento GDs",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Relatório qualitativo",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Revisão (Questionários)",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Revisão de texto",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Transcrição de fitas",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Software",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Tarifa bancária eventual",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Tarifa bancária recorrente",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Taxa de embarque",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Taxas e anuidades",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Taxi/ônibus/combustível/estacionamento",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Telefone / Internet",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Título de Capitalização",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Vale Refeição",
            'type' => 'DESPESA'
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Vale Transporte",
            'type' => 'DESPESA'
        ]);

        DB::table('taxes')->insert([
            'name' => 'IR',
            'amount' => 1.5,
            'description' => 'IR',
            'collection' => '%',
            'type' => 'FEDERAL',
            'reference' => 'RECEITA'
        ]);
        DB::table('taxes')->insert([
            'name' => 'IR(Banco do Brasil)',
            'amount' => 4.5,
            'description' => 'IR(Banco do Brasil)',
            'collection' => '%',
            'type' => 'FEDERAL',
            'reference' => 'RECEITA'
        ]);
        DB::table('taxes')->insert([
            'name' => 'CSLL',
            'amount' => 1,
            'description' => 'CSLL',
            'collection' => '%',
            'type' => 'FEDERAL',
            'reference' => 'RECEITA'
        ]);
        DB::table('taxes')->insert([
            'name' => 'COFINS',
            'amount' => 3,
            'description' => 'COFINS',
            'collection' => '%',
            'type' => 'FEDERAL',
            'reference' => 'RECEITA'
        ]);
        DB::table('taxes')->insert([
            'name' => 'PIS',
            'amount' => 0.65,
            'description' => 'PIS',
            'collection' => '%',
            'type' => 'MUNICIPAL',
            'reference' => 'RECEITA'
        ]);
        DB::table('taxes')->insert([
            'name' => 'ISS',
            'amount' => 2.5,
            'description' => 'ISS',
            'collection' => '%',
            'type' => 'MUNICIPAL',
            'reference' => 'RECEITA'
        ]);

        /*Contas a pagar */
        for ($i=0 ; $i < 60 ; $i++ ) { 

            DB::table('billspays')->insert([
                'name' => $request->get('name'),
                'comments' => $request->get('comments'),
                'status' => $request->get('status'),
                'type' => $request->get('type'),
                'amount' => $request->get('amount'), 
                'due_date' => $request->get('due_date'),
                'payment_date' => new \DateTime($request->get('payment_date')),
                'banks_id' => $request->get('banks_id'),
                'cost_centers_id' => $request->get('cost_centers_id'),
                'projects_phases_id' => $request->get('projects_phases_id'),
                'projects_id' => $request->get('projects_id'),
                'numberInstallments' => $request->get('numberInstallments'),
                'invoice_number' => $request->get('invoice_number'),
                'invoice_date' => new \DateTime($request->get('invoice_date')),
            ]);
            
        }
        
    }
}
