const ctx1 = document.getElementById('monthlySales').getContext('2d');
new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Monthly Sales',
            data: [10, 20, 5, 3, 2, 4],
            backgroundColor: 'blue'
        }]
    }
});

const ctx2 = document.getElementById('distributionChart').getContext('2d');
new Chart(ctx2, {
    type: 'pie',
    data: {
        labels: ['Expensive', 'Cheap', 'Average', 'Good'],
        datasets: [{
            data: [10, 20, 30, 40],
            backgroundColor: ['red', 'blue', 'yellow', 'green']
        }]
    }
});

const ctx3 = document.getElementById('weeklyVisitors').getContext('2d');
new Chart(ctx3, {
    type: 'line',
    data: {
        labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6'],
        datasets: [{
            label: 'Weekly Visitors',
            data: [5, 10, 15, 20, 25, 30],
            borderColor: 'cyan',
            fill: false
        }]
    }
});
