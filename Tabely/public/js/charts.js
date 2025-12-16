document.addEventListener('DOMContentLoaded', () => {
    if (window.humidity_data) {
        renderChart('humidityChart', window.humidity_data, 'Humidity', 0, 100);
    }

    if (window.temperature_data) {
        renderChart('temperatureChart', window.temperature_data, 'Temperature', null, null
        );
    }
});

function renderChart(canvasId, chartData, yLabel, min, max) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;

    const ctx = canvas.getContext('2d');

    const datasets = chartData.datasets.map((ds, index) => ({
        label: ds.label,
        data: ds.data,
        tension: 0.4,
        borderWidth: 2,
        fill: false,
        borderColor: `hsl(${index * 60}, 70%, 50%)`
    }));

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    position: 'bottom'
                }
            },
            scales: {
                y: {
                    min,
                    max,
                    title: {
                        display: true,
                        text: yLabel
                    }
                }
            }
        }
    });
}
