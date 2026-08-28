<?php
declare(strict_types=1);

require_once __DIR__ . '/../utilitarios.php';

$totalTestes = 0;
$totalPassou = 0;
$resultados = [];

function verificarTeste(string $id, string $descricao, mixed $esperado, mixed $obtido): void {
    global $totalTestes, $totalPassou, $resultados;
    $totalTestes++;

    $passou = $esperado === $obtido;
    if ($passou) {
        $totalPassou++;
    }

    $resultados[] = [
        'id' => $id,
        'descricao' => $descricao,
        'esperado' => var_export($esperado, true),
        'obtido' => var_export($obtido, true),
        'status' => $passou ? 'PASSOU' : 'NEGADO'
    ];
}

// Dados de teste (mesmos do index.php)
$clientes = [
    ["nome" => "  ANA CLARA SILVA ", "cpf" => "123.456.789-00", "email" => "ana.clara@email.com", "contrato" => 1500.00, "ativo" => true],
    ["nome" => "Carlos Souza", "cpf" => "987.654.321-00", "email" => "carlos.souza@email.com", "contrato" => 850.50, "ativo" => false],
    ["nome" => "  JOAO PEDRO SANTOS  ", "cpf" => "111.222.333-44", "email" => "joao@email.com", "contrato" => 2000.00, "ativo" => true],
    ["nome" => "Maria Oliveira", "cpf" => "555.666.777-88", "email" => "maria@email.com", "contrato" => 1200.75, "ativo" => true],
];

// CT01 - formatarNome com espaços extras
verificarTeste("CT01", "formatarNome com espaços extras", "Ana Clara Silva", formatarNome("  ANA CLARA SILVA "));

// CT02 - limparCPF remove pontuação
verificarTeste("CT02", "limparCPF remove pontuação", "12345678900", limparCPF("123.456.789-00"));

// CT03 - validarCPF com CPF válido
verificarTeste("CT03", "validarCPF com CPF válido", true, validarCPF("123.456.789-00"));

// CT04 - validarCPF com CPF incompleto
verificarTeste("CT04", "validarCPF com CPF incompleto", false, validarCPF("123.456"));

// CT05 - validarCPF com letras
verificarTeste("CT05", "validarCPF com letras", false, validarCPF("abc.def.ghi-00"));

// CT05B - validarCPF com dígitos repetidos (limitação conhecida)
verificarTeste("CT05B", "validarCPF com dígitos repetidos (limitação conhecida)", true, validarCPF("111.111.111-11"));

// CT06 - validarEmail válido
verificarTeste("CT06", "validarEmail válido", true, validarEmail("ana.clara@email.com"));

// CT07 - validarEmail inválido
verificarTeste("CT07", "validarEmail sem @", false, validarEmail("anaclaraemail.com"));

// CT08 - formatarMoeda
verificarTeste("CT08", "formatarMoeda com valor decimal", "R$ 1.500,00", formatarMoeda(1500.00));

// CT09 - buscarCliente existente
$resultadoBusca = buscarCliente($clientes, "Carlos Souza");
verificarTeste("CT09", "buscarCliente existente", "Carlos Souza", $resultadoBusca['nome'] ?? null);

// CT10 - buscarCliente inexistente
verificarTeste("CT10", "buscarCliente inexistente", null, buscarCliente($clientes, "Zé da Silva"));

// CT11 - buscarCliente com nome parcial (comportamento do str_contains)
$buscaParcial = buscarCliente($clientes, "Joao");
verificarTeste("CT11", "buscarCliente com nome parcial 'Joao'", "  JOAO PEDRO SANTOS  ", $buscaParcial['nome'] ?? null);

// CT14 - calcularTotalContratosAtivos (Ana + João + Maria = ativos)
verificarTeste("CT14", "calcularTotalContratosAtivos", 4700.75, calcularTotalContratosAtivos($clientes));

// CT15 - aplicarReajuste (por referência)
$contratoTeste = 1000.00;
aplicarReajuste($contratoTeste, 10.0);
verificarTeste("CT15", "aplicarReajuste 10% sobre 1000", 1100.00, $contratoTeste);

// CT16 - contarClientesAtivos
verificarTeste("CT16", "contarClientesAtivos", 3, contarClientesAtivos($clientes));

// EXTRA1 - calcularMediaContratos
verificarTeste("EXTRA1", "calcularMediaContratos", 1387.8125, calcularMediaContratos($clientes));

// EXTRA2 - encontrarMaiorContrato
verificarTeste("EXTRA2", "encontrarMaiorContrato", 2000.00, encontrarMaiorContrato($clientes));
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Testes - CRM Senai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #333;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .passou {
            color: green;
            font-weight: bold;
        }
        .negado {
            color: red;
            font-weight: bold;
        }
        .resumo {
            margin-top: 20px;
            padding: 15px;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
            font-size: 18px;
        }
    </style>
</head>
<body>
    <h1>Relatório de Testes - CRM Senai</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Descrição</th>
                <th>Esperado</th>
                <th>Obtido</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resultados as $r): ?>
            <tr>
                <td><?php echo $r['id']; ?></td>
                <td><?php echo $r['descricao']; ?></td>
                <td><?php echo htmlspecialchars($r['esperado']); ?></td>
                <td><?php echo htmlspecialchars($r['obtido']); ?></td>
                <td class="<?php echo $r['status'] === 'PASSOU' ? 'passou' : 'negado'; ?>">
                    <?php echo $r['status']; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="resumo">
        <strong>Resumo:</strong> <?php echo $totalPassou; ?> de <?php echo $totalTestes; ?> testes PASSOU
    </div>
</body>
</html>