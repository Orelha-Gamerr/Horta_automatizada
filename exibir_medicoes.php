<?php
include_once 'db_class.php';
$db = new db("medicao");

// Consulta todas as medições
$medicoes = $db->all();

// Prepara os dados para o gráfico
$labels = [];
$valores = [];

foreach ($medicoes as $m) {
    $labels[] = $m->data;
    $valores[] = floatval($m->umidade);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Medições de Umidade</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">

<div class="container mt-5">
    <h1 class="mb-4 text-center">Histórico de Umidade</h1>

    <!-- Gráfico -->
    <div class="card mb-4">
        <div class="card-body">
            <canvas id="graficoUmidade"></canvas>
        </div>
    </div>

    <!-- Tabela -->
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Umidade (%)</th>
                <th>Data/Hora</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($medicoes as $m): ?>
                <tr>
                    <td><?= $m->id ?></td>
                    <td><?= htmlspecialchars($m->umidade) ?></td>
                    <td><?= htmlspecialchars($m->data) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Script do gráfico -->
<script>
const ctx = document.getElementById('graficoUmidade').getContext('2d');

const chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: 'Umidade (%)',
            data: [],
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.3,
            fill: true,
            pointRadius: 4
        }]
    },
    options: {
        responsive: true,
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Data/Hora'
                }
            },
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Umidade (%)'
                }
            }
        }
    }
});

function atualizarDados() {
    fetch('api_medicoes.php')
        .then(response => response.json())
        .then(data => {
            const labels = data.map(m => m.data);
            const valores = data.map(m => parseFloat(m.umidade));

            // Atualiza gráfico
            chart.data.labels = labels;
            chart.data.datasets[0].data = valores;
            chart.update();

            // Atualiza tabela
            const tbody = document.querySelector("table tbody");
            tbody.innerHTML = '';
            data.forEach(m => {
                const linha = `
                    <tr>
                        <td>${m.id}</td>
                        <td>${m.umidade}</td>
                        <td>${m.data}</td>
                    </tr>
                `;
                tbody.innerHTML += linha;
            });
        });
}

// Atualiza a cada 5 segundos
setInterval(atualizarDados, 5000);
atualizarDados(); // inicial
</script>


</body>
</html>
