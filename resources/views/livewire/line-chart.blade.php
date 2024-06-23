<div x-data="lineChartComponent({ labels: {{ Js::from($labels) }}, income: {{ Js::from($income) }}, expense: {{ Js::from($expense) }}, balance: {{ Js::from($balance) }} })" x-init="initChart()" @chartUpdated.window="updateChart">
    <canvas x-ref="lineChartCanvas" style="width: 400px; height: 300px;"></canvas>
</div>

<script>
    function lineChartComponent({ labels, income, expense, balance }) {
        return {
            labels: labels,
            income: income,
            expense: expense,
            balance: balance,
            chartInstance: null,
            initChart() {
                const ctx = this.$refs.lineChartCanvas.getContext('2d');
                this.chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: this.labels,
                        datasets: [
                            {
                                label: 'Income',
                                data: this.income,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                fill: false,
                            },
                            {
                                label: 'Expenses',
                                data: this.expense,
                                borderColor: 'rgba(255, 99, 132, 1)',
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                fill: false,
                            },
                            {
                                label: 'Balance',
                                data: this.balance,
                                borderColor: 'rgba(54, 162, 235, 1)',
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                fill: false,
                            },
                        ],
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Income, Expenses, and Balance',
                        },
                        maintainAspectRatio: false,
                    },
                });
            },
            updateChart() {
                this.chartInstance.data.labels = this.labels;
                this.chartInstance.data.datasets[0].data = this.income;
                this.chartInstance.data.datasets[1].data = this.expense;
                this.chartInstance.data.datasets[2].data = this.balance;
                this.chartInstance.update();
            }
        };
    }
</script>
