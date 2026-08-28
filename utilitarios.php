<?php
declare(strict_types=1);


// 1. LIMPEZA E FORMATAÇÃO DE DADOS

// Remove espaços nas pontas e padroniza as iniciais em maiúsculas:

function formatarNome(string $nome): string {
    $nomeLimpo = trim($nome);
    return ucwords(mb_strtolower($nomeLimpo));
}

//Remove pontos, traços e barras do CPF deixando apenas dígitos:

function limparCPF(string $cpf): string {
    return str_replace(['.', '-', '/', ' '], '', trim($cpf));
}

// Formata um valor numérico para o padrão de moeda brasileiro (R$):

function formatarMoeda(float $valor): string {
    return "R$ " . number_format($valor, 2, ',', '.');
}

// 2. VALIDAÇÕES (Retorno bool)

//Valida se o CPF possui exatamente 11 dígitos numéricos após a limpeza:


function validarCPF(string $cpf): bool {
    $cpfNumeros = limparCPF($cpf);
    return strlen($cpfNumeros) === 11 && ctype_digit($cpfNumeros);
}

// Valida o formato estrutural do endereço de e-mail:

function validarEmail(string $email): bool {
    return filter_var(trim($email), FILTER_VALIDATE_EMAIL) !== false;
}

// 3. BUSCA E CONSULTAS (Retorno ?array)

// Procura um cliente pelo nome. Retorna o array do cliente ou null se não encontrar:

function buscarCliente(array $clientes, string $nome): ?array {
    $nomeBusca = mb_strtolower(trim($nome));

    foreach ($clientes as $cliente) {
        $nomeAtual = mb_strtolower(trim($cliente['nome']));
        if (str_contains($nomeAtual, $nomeBusca)) {
            return $cliente;
        }
    }

    return null;
}


// 4. CÁLCULOS E ESTATÍSTICAS

// Conta a quantidade de clientes com status ativo:

function contarClientesAtivos(array $clientes): int {
    $totalAtivos = 0;
    foreach ($clientes as $cliente) {
        if ($cliente['ativo'] === true) {
            $totalAtivos++;
        }
    }
    return $totalAtivos;
}

// Soma o valor dos contratos apenas dos clientes que estão ativos:

function calcularTotalContratosAtivos(array $clientes): float {
    $total = 0.0;
    foreach ($clientes as $cliente) {
        if ($cliente['ativo'] === true) {
            $total += (float) $cliente['contrato'];
        }
    }
    return $total;
}

//  Calcula a média geral do valor dos contratos cadastrados:


function calcularMediaContratos(array $clientes): float {
    $quantidade = count($clientes);
    if ($quantidade === 0) {
        return 0.0;
    }

    $soma = 0.0;
    foreach ($clientes as $cliente) {
        $soma += (float) $cliente['contrato'];
    }

    return $soma / $quantidade;
}

// Retorna o maior valor de contrato encontrado na lista:

function encontrarMaiorContrato(array $clientes): float {
    if (empty($clientes)) {
        return 0.0;
    }

    $maior = 0.0;
    foreach ($clientes as $cliente) {
        if ($cliente['contrato'] > $maior) {
            $maior = (float) $cliente['contrato'];
        }
    }

    return $maior;
}


// 5. ALTERAÇÃO POR REFERÊNCIA (Retorno void):

// Aplica um percentual de reajuste diretamente na variável do contrato original (&) no cabeçalho global:

function aplicarReajuste(float &$contrato, float $percentual): void {
    $reajuste = $contrato * ($percentual / 100);
    $contrato += $reajuste;

}