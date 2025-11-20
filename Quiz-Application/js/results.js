// Create charts for results page
document.addEventListener('DOMContentLoaded', function() {
    createPerformanceChart();
    createTimeChart();
});

// Create performance chart
function createPerformanceChart() {
    const ctx = document.getElementById('performance-chart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Correct', 'Incorrect'],
            datasets: [{
                data: [resultsData.correct, resultsData.incorrect],
                backgroundColor: ['#28a745', '#dc3545'],
                borderWidth: 1,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = resultsData.correct + resultsData.incorrect;
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return `${context.label}: ${context.parsed} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}

// Create time spent chart
function createTimeChart() {
    const ctx = document.getElementById('time-chart').getContext('2d');
    
    // Create background colors based on correctness (you would need to pass this data from PHP)
    const backgroundColors = resultsData.timeSpent.map((_, index) => {
        // This is a simplified version - in a real app, you'd pass correctness data
        return index < resultsData.correct ? '#28a745' : '#dc3545';
    });

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: resultsData.labels,
            datasets: [{
                label: 'Time Spent (seconds)',
                data: resultsData.timeSpent,
                backgroundColor: backgroundColors,
                borderWidth: 1,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Seconds'
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Questions'
                    },
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return `Time: ${context.parsed}s`;
                        }
                    }
                }
            }
        }
    });
}