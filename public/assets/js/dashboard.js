console.log(_drinks)

const ctx = document.getElementById('drinksGraph').getContext('2d');

const drinkDay = _drinks[1];
const labels = drinkDay.map(drink => drink.created_at);
const types = drinkDay.map(drink => drink.type);

console.log(labels);

const data = {
    labels: labels,
    datasets: [
        // {
        //     label: 'Glazen Water',
        //     data: [
        //         1, 2
        //     ],
        //     borderColor: 'rgb(100, 192, 192)',
        //     tension: 0.1
        // },
        // {
        //     label: 'Glazen Bier',
        //     data: [
        //         1, 2
        //     ],
        //     borderColor: 'rgb(75, 192, 192)',
        //     tension: 0.1
        // },
        // {
        //     label: 'Shotjes',
        //     data: [
        //         1, 4
        //     ],
        //     borderColor: 'rgb(50, 192, 192)',
        //     tension: 0.1
        // },
        {
            label: 'Barfjes',
            data: [
                1, 2
            ],
            // borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        }
    ]
};
new Chart(ctx, {
    type: 'line',
    data: data
});
