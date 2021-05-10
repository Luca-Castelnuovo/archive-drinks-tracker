const labels = {
    Water: '#2CC990',
    Bier: '#EEE657',
    Shot: '#FCB941',
    Barf: '#FC6042'
};

const viewType = document.querySelector('select[name="view_type"]');
const startDate = document.querySelector('select[name="start_date"]');
const filterUrl = e => {
    if (viewType.value == 'all') {
        if (e?.target?.value) {
            return '';
        }

        return window.location.replace('/dashboard?type=all');
    }

    return window.location.replace(
        `/dashboard?startDate=${startDate.value}&type=${viewType.value}`
    );
}

viewType.addEventListener("change", () => filterUrl());
document.querySelector('select[name="start_date"]').addEventListener("change", e => filterUrl(e));

const recordData = _records;
const recordDatasets = [];
const countData = recordData.slice(-1)[0];

Object.entries(labels).forEach(([label, color]) => {
    recordDatasets.push({
        label: label,
        data: recordData,
        parsing: {
            xAxisKey: 'created_at',
            yAxisKey: label.toLowerCase()
        },
        borderColor: color,
        backgroundColor: color,
        tension: 0.1
    });
});

document.addEventListener('DOMContentLoaded', function () {
    M.FormSelect.init(
        document.querySelectorAll('select'),
        {}
    );

    const ctxCount = document.getElementById('countGraph').getContext('2d');
    new Chart(ctxCount, {
        type: 'doughnut',
        data: {
            labels: [...Object.keys(labels)],
            datasets: [
                {
                    data: [...Object.values(countData)],
                    backgroundColor: [...Object.values(labels)],
                    hoverOffset: 4
                }
            ]
        }
    });

    const ctxRecords = document.getElementById('recordsGraph').getContext('2d');
    new Chart(ctxRecords, {
        type: 'line',
        data: { datasets: recordDatasets },
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
