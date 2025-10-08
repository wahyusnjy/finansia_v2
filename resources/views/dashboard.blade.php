<x-layouts.app :title="__('Dashboard')">
    <x-header title="Dashboard"/>
    <x-summary-card />
    <div class="grid auto-rows-min">
        <div>
            <div class="bg-white rounded-xl shadow-sm p-6">
                <canvas id="chart"></canvas>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chart');

new Chart(ctx, {
type: 'bar',
data: {
    labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
    datasets: [{
    label: '# of Votes',
    data: [12, 19, 3, 5, 2, 3],
    borderWidth: 1
    }]
},
options: {
    scales: {
    y: {
        beginAtZero: true
    }
    }
}
});
</script>
</x-layouts.app>


