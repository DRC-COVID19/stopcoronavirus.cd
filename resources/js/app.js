var $ = require("jquery");
var Chart = require('chart.js');
//require('./bootstrap');


function drawChart() {

    // Add a helper to format timestamp data
    Date.prototype.formatD = function () {
        return this.getDate()+'.'+(this.getMonth()+1); //+"."+this.getFullYear();
    }

    var jsonData = $.ajax({
        url: '/api/pandemicstatsasc',
        dataType: 'json',
    }).done(function (results) {

        // Split timestamp and data into separate arrays
        var labels = [], data = [], sick = [], confirmed = [], dead = [], healed = [];
        results["data"].forEach(function (d) {

            confirmed.push(d.confirmed);
            dead.push(d.dead);
            healed.push(d.healed);
            labels.push(d.last_update);
        });

        // Create the chart.js data structure using 'labels' and 'data'
        var tempData = {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: "Confirmés",
                        fill: true,
                        borderColor: "rgb(166,180,205)",
                        backgroundColor: "rgb(166,180,205, 0.2)",
                        data: confirmed
                    },
                    {
                        label: "Guéris",
                        fill: true,
                        borderColor: "rgba(0,176,101,1)",
                        backgroundColor: "rgba(0,176,101,0.8)",
                        data: healed
                    },
                    {
                        label: "Décès",
                        fill: true,
                        borderColor: "rgba(10,10,10,0.2)",
                        backgroundColor: "rgba(10,10,10,1)",
                        data: dead
                    },
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                title: {
                    display: false,
                    text: ''
                },
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        gridLines: {
                            display: false
                        },
                        scaleLabel: {
                            display: false,
                            labelString: 'Month'
                        },
                        type: 'time',
                        time: {
                            unit: 'day',
                            unitStepSize: 1,
                            displayFormats: {
                                'day': 'DD.MM'
                            }
                        }
                    }],
                    yAxes: [{
                        display: true,
                        ticks: {
                            beginAtZero: true
                        },
                        scaleLabel: {
                            display: false,
                            labelString: 'Value'
                        }
                    }]
                }
            }
        };

        // Get the context of the canvas element we want to select
        var ctx = document.getElementById("statsChart").getContext("2d");

        // Instantiate a new chart
        var myLineChart = new Chart(ctx, tempData);

    });
}

$(document).ready(function () {
    if ($('#statsChart').length)
        drawChart();
});
