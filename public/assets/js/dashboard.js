const labels = {
    Water: '#2CC990',
    Bier: '#EEE657',
    Shot: '#FCB941',
    Barf: '#FC6042'
};

const ctxCount = document.getElementById('countGraph').getContext('2d');
const ctxEntries = document.getElementById('entriesGraph').getContext('2d');
const viewType = document.querySelector('select[name="view_type"]');
const startDate = document.querySelector('select[name="start_date"]');

const entriesDatasets = [];

Object.entries(labels).forEach(([label, color]) => {
    entriesDatasets.push({
        label: label,
        data: _records,
        parsing: {
            xAxisKey: 'created_at',
            yAxisKey: label.toLowerCase()
        },
        borderColor: color,
        backgroundColor: color,
        tension: 0.1
    });
});

viewType.addEventListener("change", () => {
    if (viewType.value == 'all') {
        return window.location.replace(`/dashboard?type=all`);
    }

    window.location.replace(`/dashboard?startDate=${startDate.value}&type=${viewType.value}`);
});

startDate.addEventListener("change", () => {
    if (viewType.value == 'all') {
        return window.location.replace(`/dashboard?type=all`);
    }

    window.location.replace(`/dashboard?startDate=${startDate.value}&type=${viewType.value}`);
});

document.addEventListener('DOMContentLoaded', function () {
    M.FormSelect.init(
        document.querySelectorAll('select'),
        {}
    );

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

    new Chart(ctxEntries, {
        type: 'line',
        data: { datasets: entriesDatasets },
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
});
