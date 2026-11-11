import Chart from 'chart.js/auto';

window.presentationStatsChart = function (data) {
    let chart;

    return {
        init() {
            this.$nextTick(() => {
                if (!this.$refs.canvas?.isConnected) return;

                chart = new Chart(this.$refs.canvas, {
                    type: 'bar',
                    data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, ticks: { precision: 0, maxTicksLimit: 4, color: '#6b7280' } },
                            x: { grid: { display: false }, ticks: { maxTicksLimit: 7, maxRotation: 0, color: '#6b7280' } },
                        },
                    },
                });
            });
        },

        destroy() {
            chart?.destroy();
        },
    };
};
