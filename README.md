# Projeto CRM Senai

## Descrição

Este projeto foi desenvolvido como parte da atividade SABP do SENAI, com o objetivo de 
organizar o cadastro de clientes de uma empresa de serviços. Atualmente, esses dados são 
mantidos em uma planilha desorganizada: nomes com formatações diferentes, documentos com 
pontuação inconsistente e valores de contrato sem padronização.

A solução consiste em uma biblioteca de funções em PHP (utilitarios.php) responsável por 
cadastrar, limpar, formatar e calcular os dados dos clientes, evitando a repetição de 
lógica em diferentes partes do sistema (princípio DRY). Essas funções são utilizadas por 
uma tela de relatório (index.php), que exibe os clientes cadastrados, permite buscas por 
nome, aplica reajustes percentuais nos contratos e apresenta um resumo financeiro geral.

O projeto funciona inteiramente com dados simulados em arrays, sem uso de banco de dados 
ou autenticação, focando no aprendizado de boas práticas com funções tipadas, validação 
de dados e organização de código em PHP.

## Requisitos Funcionais

| ID | Requisito | Descrição |
|----|-----------|-----------|
| RF01 | Listagem de clientes | Exibir todos os clientes usando `foreach`, mostrando nome, CPF, e-mail, contrato e situação. |
| RF02 | Busca por nome | Pesquisar cliente pelo nome e exibir seus dados; informar quando não encontrado. |
| RF03 | Cadastro de cliente | Inserir/simular novo cliente, validando nome, e-mail, CPF e valor do contrato. |
| RF04 | Limpeza de dados | Remover espaços desnecessários dos nomes e formatação (pontuação) dos CPFs. |
| RF05 | Formatação | Padronizar nomes e exibir valores no formato de moeda brasileira (R$). |
| RF06 | Resumo financeiro | Calcular soma dos contratos ativos e média dos valores dos contratos. |
| RF07 | Alteração por referência | Aplicar reajuste percentual em um contrato, alterando o valor original via `&`. |
| RF08 | Relatório final | Exibir total de clientes, quantidade de clientes ativos e maior contrato cadastrado. |

## Requisitos Não Funcionais

| ID | Requisito | Descrição |
|----|-----------|-----------|
| RNF01 | Tipagem estrita | Todos os arquivos PHP devem usar `declare(strict_types=1);`. |
| RNF02 | Funções tipadas | Funções devem ter parâmetros tipados e tipo de retorno definido. |
| RNF03 | Diversidade de retornos | O sistema deve conter ao menos uma função `void`, uma `bool` e uma `?array`. |
| RNF04 | Reutilização de código | Aplicar o princípio DRY, evitando repetição de lógica entre telas/funções. |
| RNF05 | Separação de responsabilidades | Separar funções de processamento (biblioteca) do código de apresentação (tela HTML). |
| RNF06 | Importação padronizada | Usar `require_once` para importar `utilitarios.php` em `index.php`. |
| RNF07 | Uso de funções nativas | Utilizar `count()`, `strlen()`, `str_replace()`, `trim()` e `number_format()`. |
| RNF08 | Validação de entradas | Uso de `if / elseif / else` para tratar entradas inválidas. |
| RNF09 | Ausência de persistência | Sistema deve operar apenas com dados simulados em arrays (sem banco de dados ou autenticação). |


## Estrutura de arquivos
...

## Como executar
...

## Testes realizados
(aqui entra a tabela de casos de teste, preenchida depois)

## Autores / Grupo


