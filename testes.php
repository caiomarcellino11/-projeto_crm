
<?php
declare(strict_types=1);


// 1. LIMPEZA E FORMATAÇÃO DE DADOS

// Remove espaços nas pontas e coloca as iniciais das palavras em maiúsculas:
function formatarNome(string $nome): string {
    $nomeLimpo = trim($nome);
    return ucwords(mb_strtolower($nomeLimpo));
}

// Remove pontos, traços, barras e espaços do CPF,
// deixando somente os números:
function limparCPF(string $cpf): string {
    return str_replace(['.', '-', '/', ' '], '', trim($cpf));
}

// Formata um valor numérico para o formato de moeda brasileira,
// usando R$, vírgula nos centavos e ponto nos milhares:
function formatarMoeda(float $valor): string {
    return "R$ " . number_format($valor, 2, ',', '.');
}


// 2. VALIDAÇÕES (Retorno bool)

// Verifica se o CPF possui exatamente 11 números.
// Retorna true se for válido e false se não for:
// ✅ Status: validação de CPF
function validarCPF(string $cpf): bool {
    $cpfNumeros = limparCPF($cpf);
    return strlen($cpfNumeros) === 11 && ctype_digit($cpfNumeros);
}

// Verifica se o e-mail possui um formato válido.
// Retorna true quando o e-mail é válido e false quando não é:
// ✅ Status: validação de e-mail
function validarEmail(string $email): bool {
    return filter_var(trim($email), FILTER_VALIDATE_EMAIL) !== false;
}


// 3. BUSCA E CONSULTAS (Retorno ?array)

// Procura um cliente pelo nome dentro da lista.
// Retorna os dados do cliente quando encontra.
// Caso não encontre, retorna null:
// ✅ Status: busca de cliente
function buscarCliente(array $clientes, string $nome): ?array {
    $nomeBusca = mb_strtolower(trim($nome));

    // Percorre todos os clientes da lista:
    foreach ($clientes as $cliente) {

        // Converte o nome atual para letras minúsculas
        // para facilitar a comparação:
        $nomeAtual = mb_strtolower(trim($cliente['nome']));

        // Verifica se o nome pesquisado aparece no nome do cliente:
        if (str_contains($nomeAtual, $nomeBusca)) {
            return $cliente;
        }
    }

    // Retorna null caso nenhum cliente seja encontrado:
    return null;
}


// 4. CÁLCULOS E ESTATÍSTICAS

// Conta quantos clientes estão com o status ativo.
// Retorna a quantidade total de clientes ativos:
// ✅ Status: contagem de clientes ativos
function contarClientesAtivos(array $clientes): int {
    $totalAtivos = 0;

    // Percorre todos os clientes:
    foreach ($clientes as $cliente) {

        // Verifica se o cliente está ativo:
        if ($cliente['ativo'] === true) {
            $totalAtivos++;
        }
    }

    return $totalAtivos;
}

// Soma o valor dos contratos somente dos clientes ativos.
// Retorna o valor total dos contratos:
// ✅ Status: cálculo dos contratos ativos
function calcularTotalContratosAtivos(array $clientes): float {
    $total = 0.0;

    // Percorre todos os clientes:
    foreach ($clientes as $cliente) {

        // Soma o contrato somente se o cliente estiver ativo:
        if ($cliente['ativo'] === true) {
            $total += (float) $cliente['contrato'];
        }
    }

    return $total;
}

// Calcula a média geral dos valores dos contratos cadastrados.
// Se não houver clientes, retorna 0:
// ✅ Status: cálculo da média dos contratos
function calcularMediaContratos(array $clientes): float {
    $quantidade = count($clientes);

    // Evita divisão por zero quando não existem clientes:
    if ($quantidade === 0) {
        return 0.0;
    }

    $soma = 0.0;

    // Soma o valor de todos os contratos:
    foreach ($clientes as $cliente) {
        $soma += (float) $cliente['contrato'];
    }

    // Divide a soma pela quantidade de clientes:
    return $soma / $quantidade;
}

// Encontra o maior valor de contrato entre os clientes.
// Retorna 0 caso a lista esteja vazia:
// ✅ Status: busca do maior contrato
function encontrarMaiorContrato(array $clientes): float {
    
    // Verifica se não existem clientes:
    if (empty($clientes)) {
        return 0.0;
    }

    $maior = 0.0;

    // Percorre todos os clientes:
    foreach ($clientes as $cliente) {

        // Compara o contrato atual com o maior valor encontrado:
        if ($cliente['contrato'] > $maior) {
            $maior = (float) $cliente['contrato'];
        }
    }

    return $maior;
}


// 5. ALTERAÇÃO POR REFERÊNCIA (Retorno void)

// Aplica um percentual de reajuste no valor do contrato.
// O & faz com que o valor original seja alterado diretamente.
// Como a função não retorna nenhum valor, ela usa void:
// ✅ Status: aplicação de reajuste
function aplicarReajuste(float &$contrato, float $percentual): void {
    
    // Calcula quanto será acrescentado ao contrato:
    $reajuste = $contrato * ($percentual / 100);

    // Adiciona o reajuste ao valor original:
    $contrato += $reajuste;
}
