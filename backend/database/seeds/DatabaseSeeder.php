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
            'password' => bcrypt('123'), 'status' => 'APROVADO'
        ]);
        DB::table('employees')->insert([
            'name' => 'Luciana', 'username' => 'luciana',
            'email' => 'luciana@innovarepesquisa.com.br',
            'password' => bcrypt('123'), 'status' => 'APROVADO'
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
            'name' => "Alimentação"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Aluguel da sede da Innovare"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Aluguel de equipamentos"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Aluguel de PA's"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Aluguel de salas e estúdios"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Antecipação de lucros"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Aplicações financeiras diversas"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Bolsa de Estágio"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Cartório"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "COFINS"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Compra de banco de dados"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Condomínio"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Contribuição sindical"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Correios e Courier"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "CSSL"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Despesa financeira (juros e multas)"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Despesas diversas"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Despesas diversas de projetos"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Distribuição de lucros"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Empréstimo"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Energia Elétrica"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "FGTS"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Gráfica"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Honorários"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Hotel"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "INSS + outros"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "IPTU"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "IRPJ"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "IRRF"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "ISSQN"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Manutenção salas e equipamentos"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Materiais Escritório"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Materiais manutenção"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Medicina do Trabalho"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Móvel, imóvel ou equipamento"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Outras despesas de viagem"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Pagamento de impostos retidos pela INNOVARE"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Pagamento Empréstimo"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Passagem aérea"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "PIS"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Plano de Saude - UNIMED"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Pró-labore"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Receita de alienações de bens"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Receita de projeto"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Receita diversas"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Receita financeira (rendimento de aplicações)"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Recrutamento e Seleção de Empregados"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Reembolso de despesa de telefone"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Reforma de salas"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Rescisão de contrato de trabalho"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Retenção de COFINS na fonte pelo cliente"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Retenção de CSSL na fonte pelo cliente"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Retenção de IRPJ na fonte pelo cliente"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Retenção de ISS na fonte pelo cliente"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Retenção de PIS na fonte pelo cliente"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Salário"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Seguro de vida"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Agendamento de Entrevistas"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Amostra"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Campo"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Consistência de Dados"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Contabilidade"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Digitação"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Entrevistas em Profundidade"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Finalização"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Informática (manutenção)"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Máscara"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Moderação de GDs"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Processamento"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Programação"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Recodificação"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Recrutamento GDs"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Relatório qualitativo"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Revisão (Questionários)"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Revisão de texto"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Serviço de Transcrição de fitas"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Software"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Tarifa bancária eventual"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Tarifa bancária recorrente"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Taxa de embarque"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Taxas e anuidades"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Taxi/ônibus/combustível/estacionamento"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Telefone / Internet"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Título de Capitalização"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Vale Refeição"
        ]);
        DB::table('cost_centers')->insert([
            'name' => "Vale Transporte"
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
    }
}
