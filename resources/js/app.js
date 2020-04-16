var $ = require("jquery");
var Chart = require('chart.js');
//require('./bootstrap');


function drawChart() {

    // Add a helper to format timestamp data
    Date.prototype.formatD = function () {
        return this.getDate() + '.' + ('0' + (this.getMonth() + 1)).slice(-2) + "." + this.getFullYear();
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
                    callbacks: {
                        title: function (tooltipItem, data) {
                            let d = new Date(tooltipItem[0].label);
                            return d.formatD();
                        }
                    }

                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    xAxes: [{
                        display: true,
                        gridLines: {
                            display: true
                        },
                        scaleLabel: {
                            display: false,
                            labelString: 'Month'
                        },
                        type: 'time',
                        time: {
                            unit: 'day',
                            unitStepSize: 2,
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

    $('#other-town').addClass('d-none');

    $('select[name=township]').attr('required', 'required');

    $(':radio[name=step_value]').change(function (params) {
        $('#question-form').submit();
    });
    $('#town').change(function (params) {
        let value = $(this).val();
        if (value == 0) {
            $('#other-town').removeClass('d-none');
            $('input[name=other_town]').attr('required', 'required');
        }
        else {
            $('#other-town').addClass('d-none');
            $('input[name=other_town]').remove('required');
        }

        if (value == "Kinshasa") {
            $('#township').removeClass('d-none');
            $('select[name=township]').attr('required', 'required');
        }
        else {
            $("#township").addClass('d-none');
            $('select[name=township]').removeAttr('required');
        }
    });
    let response = $('#question-form-validate-btn').data('response');
    if (response == 1 || response == 2 || response == 10 || response == 8) {
        $('#question-form-validate-btn').addClass('d-none');
    }
    // get Localisation

   /* if ("geolocation" in navigator) { 
        navigator.geolocation.getCurrentPosition(function (position) {
            console.log("Found your location <br />Lat : " + position.coords.latitude + " </br>Lang :" + position.coords.longitude);
        });
    } else {
        console.log("Browser doesn't support geolocation!");
    }*/
});



$(function () {

});