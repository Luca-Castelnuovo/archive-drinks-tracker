const labels = {
    Water: '#2CC990',
    Bier: '#EEE657',
    Shot: '#FCB941',
    Barf: '#FC6042'
};

const ctxCount = document.getElementById('countGraph').getContext('2d'); 4
new Chart(ctxCount, {
    type: 'doughnut',
    data: {
        labels: [...Object.keys(labels)],
        datasets: [
            {
                data: [...Object.values(_count)],
                backgroundColor: [...Object.values(labels)],
                hoverOffset: 4
            }
        ]
    }
});

const entriesDatasets = [];

Object.entries(labels).forEach(([label, color]) => {
    entriesDatasets.push({
        label: label,
        data: _entries,
        parsing: {
            xAxisKey: 'created_at',
            yAxisKey: label.toLowerCase()
        },
        borderColor: color,
        backgroundColor: color,
        tension: 0.1
    });
});

const ctxEntries = document.getElementById('entriesGraph').getContext('2d');
new Chart(ctxEntries, {
    type: 'line',
    data: { datasets: entriesDatasets},
    options: {
        scales: {
            y: {
                type: 'linear',
                grace: '5%',
                min: 0,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
