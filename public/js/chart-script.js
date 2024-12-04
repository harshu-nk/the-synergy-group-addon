jQuery(document).ready(function ($) {
    if ($("#myChart").length) {
        const ctx = $("#myChart")[0].getContext("2d");

        const data = chartData;

        const datasets = Object.keys(data).map(function (ref, index) {
            return {
                label: ref,
                data: data[ref].data,
                borderColor: `hsl(${index * 40}, 70%, 50%)`,
                backgroundColor: `hsla(${index * 40}, 70%, 50%, 0.2)`,
                fill: true,
                tension: 0.4,
                borderWidth: 2,
                pointRadius: 0,
            };
        });

        const labels = data[Object.keys(data)[0]].labels;

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: datasets,
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                        },
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    },
                },
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date',
                        },
                        ticks: {
                            maxRotation: 0,
                            autoSkip: true,
                        },
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Creds',
                        },
                        beginAtZero: true,
                        min: 0,
                    },
                },
            },
        });
    }
});
