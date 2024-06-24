<div x-data="pieChartComponent({ categoryData: @entangle('categoryData') })" x-init="initChart()" @chart-updated.window="updateChart">
    <canvas x-ref="pieChartCanvas" style="width: 400px; height: 300px;"></canvas>
</div>

<script>
    function pieChartComponent({ categoryData }) {
        return {
            categoryData: categoryData,
            chartInstance: null,
            initChart() {
                const ctx = this.$refs.pieChartCanvas.getContext('2d');
                this.chartInstance = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: Object.keys(this.categoryData),
                        datasets: [{
                            data: Object.values(this.categoryData),
                            backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)', 'rgba(153, 102, 255, 0.2)'],
                            borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)', 'rgba(153, 102, 255, 1)'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        title: {
                            display: true,
                            text: 'Expenses by Category',
                        },
                        maintainAspectRatio: false,
                    },
                });
            },
            updateChart() {
                this.chartInstance.data.labels = Object.keys(this.categoryData);
                this.chartInstance.data.datasets[0].data = Object.values(this.categoryData);
                this.chartInstance.update();
            }
        };
    }
</script>
