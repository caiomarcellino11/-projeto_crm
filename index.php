<?php
declare(strict_types=1);

// Importa as funções
require_once 'utilitarios.php';

// Dados dos clientes
$clientes = [
    [
        "nome" => "  ANA CLARA SILVA ",
        "cpf" => "123.456.789-00",
        "email" => "ana.clara@email.com",
        "contrato" => 1500.00,
        "ativo" => true
    ],
    [
        "nome" => "Carlos Souza",
        "cpf" => "987.654.321-00",
        "email" => "carlos.souza@email.com",
        "contrato" => 850.50,
        "ativo" => false
    ],
    [
        "nome" => "  JOAO PEDRO SANTOS  ",
        "cpf" => "111.222.333-44",
        "email" => "joao@email.com",
        "contrato" => 2000.00,
        "ativo" => true
    ],
    [
        "nome" => "Maria Oliveira",
        "cpf" => "555.666.777-88",
        "email" => "maria@email.com",
        "contrato" => 1200.75,
        "ativo" => true
    ]
];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>CRM Senai - Central de Atendimento</title>
</head>
<body>
    <h1>CRM Senai - Central de Atendimento</h1>
    
    <h2>Buscar Cliente</h2>
    <form method="get">
        <label>Nome:</label>
        <input type="text" name="nome" placeholder="Digite o nome...">
        <button type="submit">Buscar</button>
    </form>
    
    <?php
    if (isset($_GET['nome']) && $_GET['nome'] != '') {
        $nomeBusca = trim($_GET['nome']);
        $cliente = buscarCliente($clientes, $nomeBusca);
        
        if ($cliente != null) {
            echo '<h3>Cliente encontrado:</h3>';
            echo '<p><strong>Nome:</strong> ' . formatarNome($cliente['nome']) . '</p>';
            echo '<p><strong>CPF:</strong> ' . limparCPF($cliente['cpf']) . '</p>';
            echo '<p><strong>Email:</strong> ' . $cliente['email'] . '</p>';
            echo '<p><strong>Contrato:</strong> ' . formatarMoeda($cliente['contrato']) . '</p>';
            echo '<p><strong>Situação:</strong> ' . ($cliente['ativo'] ? 'Ativo' : 'Inativo') . '</p>';
        } else {
            echo '<p>Cliente não encontrado!</p>';
        }
    }
    ?>
    
    <h2>Lista de Clientes</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Nome</th>
                <th>CPF</th>
                <th>Email</th>
                <th>Contrato</th>
                <th>Situação</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($clientes as $cliente) {
                echo '<tr>';
                echo '<td>' . formatarNome($cliente['nome']) . '</td>';
                echo '<td>' . limparCPF($cliente['cpf']) . '</td>';
                echo '<td>' . $cliente['email'] . '</td>';
                echo '<td>' . formatarMoeda($cliente['contrato']) . '</td>';
                echo '<td>' . ($cliente['ativo'] ? 'Ativo' : 'Inativo') . '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    
    <h2>Resumo</h2>
    <p><strong>Total de clientes:</strong> <?php echo count($clientes); ?></p>
    <p><strong>Clientes ativos:</strong> <?php echo contarClientesAtivos($clientes); ?></p>
    <p><strong>Total contratos ativos:</strong> <?php echo formatarMoeda(calcularTotalContratosAtivos($clientes)); ?></p>
    <p><strong>Maior contrato:</strong> <?php echo formatarMoeda(max(array_column($clientes, 'contrato'))); ?></p>
    
    <h2>Reajuste de Contrato</h2>
    <?php
    $contratoExemplo = &$clientes[0]['contrato'];
    echo '<p>Antes: ' . formatarMoeda($clientes[0]['contrato']) . '</p>';
    aplicarReajuste($contratoExemplo, 10);
    echo '<p>Depois de 10%: ' . formatarMoeda($clientes[0]['contrato']) . '</p>';
    ?>
</body>
</html>