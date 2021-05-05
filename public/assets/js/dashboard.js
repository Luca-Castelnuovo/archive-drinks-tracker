const labels = {
    Water: '#2CC990',
    Bier: '#EEE657',
    Shot: '#FCB941',
    Barf: '#FC6042'
};

const ctxCount = document.getElementById('countGraph').getContext('2d');4
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


const data = [
    {
        "water": 0,
        "x": 5,
        "shot": 0,
        "barf": 0,
        "y": "16:02"
    },
    {
        "water": 0,
        "x": 6,
        "shot": 0,
        "barf": 0,
        "y": "16:03"
    },
    {
        "water": 0,
        "x": 4,
        "shot": 0,
        "barf": 0,
        "y": "16:04"
    },
    {
        "water": 0,
        "x": 2,
        "shot": 0,
        "barf": 0,
        "y": "16:05"
    }, {
        "water": 0,
        "x": 3,
        "shot": 0,
        "barf": 0,
        "y": "16:06"
    }, {
        "water": 0,
        "x": 1,
        "shot": 0,
        "barf": 0,
        "y": "16:07"
    }, {
        "water": 2,
        "x": 6,
        "shot": 1,
        "barf": 0,
        "y": "16:14"
    }, {
        "water": 2,
        "x": 6,
        "shot": 0,
        "barf": 0,
        "y": "16:14"
    }, {
        "water": 1,
        "x": 6,
        "shot": 0,
        "barf": 0,
        "y": "16:14"
    }
];

const data2 = [
    1, 2, 3
];

console.log(data);

const ctxEntries = document.getElementById('entriesGraph').getContext('2d');
const dataEntries = {
    labels: ['Jan', 'Feb', 'mar'],
    datasets: [
        {
            label: 'Watertjes',
            data: data2,
            // parsing: {
            //     xAxisKey: 'water',
            //     yAxisKey: 'created_at'
            // },
            // parsing: {
            //     yAxisKey: 'net'
            // },
            borderColor: labels.Water,
            backgroundColor: labels.Water,
            tension: 0.1
        }
    ]
};
new Chart(ctxEntries, {
    type: 'line',
    data: dataEntries,
});
