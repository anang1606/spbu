function formatRupiah(angka) {
    var number_string = Math.round(parseFloat(angka)).toString(),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi),
        separator = '';

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return rupiah;
}

$(document).ready(function () {

    'use strict';
    var brandPrimary;
    var brandPrimaryRgba;

    // ------------------------------------------------------- //
    // Line Chart
    // ------------------------------------------------------ //
    var CASHFLOW = $('#cashFlow');
    if (CASHFLOW.length > 0) {
        var recieved = CASHFLOW.data('recieved');
        brandPrimary = CASHFLOW.data('color');
        brandPrimaryRgba = CASHFLOW.data('color_rgba');
        var sent = CASHFLOW.data('sent');
        var month = CASHFLOW.data('month');
        var purchase = CASHFLOW.data('purchase');
        var label1 = CASHFLOW.data('label1');
        var label2 = CASHFLOW.data('label2');
        var label3 = CASHFLOW.data('label3');
        var laba = CASHFLOW.data('laba');
        var label4 = CASHFLOW.data('label4');

        const dataSet = []

        if (label3) {
            dataSet.push(
                {
                    label: label1,
                    fill: true,
                    lineTension: 0.3,
                    backgroundColor: 'transparent',
                    borderColor: '#2264dc',
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    borderWidth: 3,
                    pointBorderColor: '#2264dc',
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 5,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: '#2264dc',
                    pointHoverBorderColor: "#2264dc",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: recieved,
                    spanGaps: false
                },
                {
                    label: label3,
                    fill: true,
                    lineTension: 0.3,
                    backgroundColor: 'transparent',
                    borderColor: "#01b4d2",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    borderWidth: 3,
                    pointBorderColor: "#01b4d2",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 5,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#01b4d2",
                    pointHoverBorderColor: "#01b4d2",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: purchase,
                    spanGaps: false
                },
                {
                    label: label2,
                    fill: true,
                    lineTension: 0.3,
                    backgroundColor: 'transparent',
                    borderColor: "#0a0046",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    borderWidth: 3,
                    pointBorderColor: "#0a0046",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 5,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#0a0046",
                    pointHoverBorderColor: "#0a0046",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: sent,
                    spanGaps: false
                },
                {
                    label: label4,
                    fill: true,
                    lineTension: 0.3,
                    backgroundColor: 'transparent',
                    borderColor: "#00c689",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    borderWidth: 3,
                    pointBorderColor: "#00c689",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 5,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#00c689",
                    pointHoverBorderColor: "#00c689",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: laba,
                    spanGaps: false
                },
            )
        } else {
            dataSet.push({
                label: label1,
                fill: true,
                lineTension: 0.3,
                backgroundColor: 'transparent',
                borderColor: '#2264dc',
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                borderWidth: 3,
                pointBorderColor: '#2264dc',
                pointBackgroundColor: "#fff",
                pointBorderWidth: 5,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: '#2264dc',
                pointHoverBorderColor: "#2264dc",
                pointHoverBorderWidth: 2,
                pointRadius: 1,
                pointHitRadius: 10,
                data: recieved,
                spanGaps: false
            },
                {
                    label: label2,
                    fill: true,
                    lineTension: 0.3,
                    backgroundColor: 'transparent',
                    borderColor: "#0a0046",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    borderWidth: 3,
                    pointBorderColor: "#0a0046",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 5,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#0a0046",
                    pointHoverBorderColor: "#0a0046",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: sent,
                    spanGaps: false
                },
                {
                    label: label4,
                    fill: true,
                    lineTension: 0.3,
                    backgroundColor: 'transparent',
                    borderColor: "#00c689",
                    borderCapStyle: 'butt',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'miter',
                    borderWidth: 3,
                    pointBorderColor: "#00c689",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 5,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#00c689",
                    pointHoverBorderColor: "#00c689",
                    pointHoverBorderWidth: 2,
                    pointRadius: 1,
                    pointHitRadius: 10,
                    data: laba,
                    spanGaps: false
                })
        }
        var cashFlow_chart = new Chart(CASHFLOW, {
            type: 'line',
            data: {
                labels: month,
                datasets: dataSet
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            // suggestedMin: 0,
                            callback: function (value, index, values) {
                                if (Math.floor(value) === value) {
                                    if (value < 0) {
                                        return '- ' + formatRupiah(value.toString());
                                    } else {
                                        return formatRupiah(value.toString());
                                    }
                                }
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                            if (value < 0) {
                                return '- ' + formatRupiah(value.toString());
                            } else {
                                return formatRupiah(value.toString());
                            }
                        }
                    }
                }
            }
        });
    };

    var SALEREPORTCHART = $('#sale-report-chart');
    if (SALEREPORTCHART.length > 0) {
        var recieved = SALEREPORTCHART.data('recieved');
        brandPrimary = SALEREPORTCHART.data('color');
        brandPrimaryRgba = SALEREPORTCHART.data('color_rgba');
        var soldqty = SALEREPORTCHART.data('soldqty');
        var datepoints = SALEREPORTCHART.data('datepoints');
        var label1 = SALEREPORTCHART.data('label1');
        var sale_report_chart = new Chart(SALEREPORTCHART, {
            type: 'line',
            data: {
                labels: datepoints,
                datasets: [
                    {
                        label: label1,
                        fill: true,
                        lineTension: 0.3,
                        backgroundColor: 'transparent',
                        borderColor: "#2264dc",
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        borderWidth: 3,
                        pointBorderColor: "#2264dc",
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 5,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "#2264dc",
                        pointHoverBorderColor: "#2264dc",
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: soldqty,
                        spanGaps: false
                    },
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            // suggestedMin: 0,
                            callback: function (value, index, values) {
                                if (Math.floor(value) === value) {
                                    return formatRupiah(value.toString());
                                }
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                            return formatRupiah(value.toString());
                        }
                    }
                }
            }
        });
    };

    var SALECHART = $('#saleChart');

    if (SALECHART.length > 0) {
        var sent = SALECHART.data('sent');
        var month = SALECHART.data('month');
        var purchase = SALECHART.data('purchase');
        var recieved = SALECHART.data('recieved');
        var label1 = SALECHART.data('label1');
        var label2 = SALECHART.data('label2');
        var label3 = SALECHART.data('label3');
        var laba = CASHFLOW.data('laba');
        var label4 = CASHFLOW.data('label4');

        const dataSet = []

        if (label3) {
            dataSet.push(
                {
                    label: label1,
                    backgroundColor: [
                        '#2264dc',
                        '#2264dc',
                        '#2264dc',
                        '#2264dc',
                        '#2264dc',
                        '#2264dc',
                        '#2264dc',
                        '#2264dc',
                        '#2264dc',
                        '#2264dc',
                        '#2264dc',
                        '#2264dc',
                        '#2264dc'
                    ],
                    borderColor: [
                        '#2264dc',
                        '#2264dc',
                        '#2264dc',
                        '#2264dc',
                        '#2264dc',
                        '#2264dc',
                        '#2264dc',
                        '#2264dc',
                        '#2264dc',
                        '#2264dc',
                        '#2264dc',
                        '#2264dc',
                        '#2264dc'
                    ],
                    borderWidth: 1,
                    data: [recieved[0], recieved[1],
                    recieved[2], recieved[3],
                    recieved[4], recieved[5],
                    recieved[6], recieved[7],
                    recieved[8], recieved[9],
                    recieved[10], recieved[11],
                        0],
                },
                {
                    label: label3,
                    backgroundColor: [
                        '#01b4d2',
                        '#01b4d2',
                        '#01b4d2',
                        '#01b4d2',
                        '#01b4d2',
                        '#01b4d2',
                        '#01b4d2',
                        '#01b4d2',
                        '#01b4d2',
                        '#01b4d2',
                        '#01b4d2',
                        '#01b4d2',
                        '#01b4d2'
                    ],
                    borderColor: [
                        '#01b4d2',
                        '#01b4d2',
                        '#01b4d2',
                        '#01b4d2',
                        '#01b4d2',
                        '#01b4d2',
                        '#01b4d2',
                        '#01b4d2',
                        '#01b4d2',
                        '#01b4d2',
                        '#01b4d2',
                        '#01b4d2',
                        '#01b4d2'
                    ],
                    borderWidth: 1,
                    data: [purchase[0], purchase[1],
                    purchase[2], purchase[3],
                    purchase[4], purchase[5],
                    purchase[6], purchase[7],
                    purchase[8], purchase[9],
                    purchase[10], purchase[11],
                        0],
                },
                {
                    label: label2,
                    backgroundColor: [
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046'
                    ],
                    borderColor: [
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046'
                    ],
                    borderWidth: 1,
                    data: [sent[0], sent[1],
                    sent[2], sent[3],
                    sent[4], sent[5],
                    sent[6], sent[7],
                    sent[8], sent[9],
                    sent[10], sent[11],
                        0],
                },
                {
                    label: label4,
                    backgroundColor: [
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689'
                    ],
                    borderColor: [
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689'
                    ],
                    borderWidth: 1,
                    data: [laba[0], laba[1],
                    laba[2], laba[3],
                    laba[4], laba[5],
                    laba[6], laba[7],
                    laba[8], laba[9],
                    laba[10], laba[11],
                        0],
                },
            )
        } else {
            dataSet.push({
                label: label1,
                backgroundColor: [
                    '#2264dc',
                    '#2264dc',
                    '#2264dc',
                    '#2264dc',
                    '#2264dc',
                    '#2264dc',
                    '#2264dc',
                    '#2264dc',
                    '#2264dc',
                    '#2264dc',
                    '#2264dc',
                    '#2264dc',
                    '#2264dc'
                ],
                borderColor: [
                    '#2264dc',
                    '#2264dc',
                    '#2264dc',
                    '#2264dc',
                    '#2264dc',
                    '#2264dc',
                    '#2264dc',
                    '#2264dc',
                    '#2264dc',
                    '#2264dc',
                    '#2264dc',
                    '#2264dc',
                    '#2264dc'
                ],
                borderWidth: 1,
                data: [recieved[0], recieved[1],
                recieved[2], recieved[3],
                recieved[4], recieved[5],
                recieved[6], recieved[7],
                recieved[8], recieved[9],
                recieved[10], recieved[11],
                    0],
            },
                {
                    label: label2,
                    backgroundColor: [
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046'
                    ],
                    borderColor: [
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046',
                        '#0a0046'
                    ],
                    borderWidth: 1,
                    data: [sent[0], sent[1],
                    sent[2], sent[3],
                    sent[4], sent[5],
                    sent[6], sent[7],
                    sent[8], sent[9],
                    sent[10], sent[11],
                        0],
                },
                {
                    label: label4,
                    backgroundColor: [
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689'
                    ],
                    borderColor: [
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689',
                        '#00c689'
                    ],
                    borderWidth: 1,
                    data: [laba[0], laba[1],
                    laba[2], laba[3],
                    laba[4], laba[5],
                    laba[6], laba[7],
                    laba[8], laba[9],
                    laba[10], laba[11],
                        0],
                },)
        }

        var saleChart = new Chart(SALECHART, {
            type: 'bar',
            data: {
                labels: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
                datasets: dataSet
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            // suggestedMin: 0,
                            callback: function (value, index, values) {
                                if (Math.floor(value) === value) {
                                    if (value < 0) {
                                        return '- ' + formatRupiah(value.toString());
                                    } else {
                                        return formatRupiah(value.toString());
                                    }
                                }
                            }
                        }
                    }]
                },
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                            if (value < 0) {
                                return '- ' + formatRupiah(value.toString());
                            } else {
                                return formatRupiah(value.toString());
                            }
                        }
                    }
                }
            }
        });
    };

    var BESTSELLER = $('#bestSeller');

    if (BESTSELLER.length > 0) {
        var sold_qty = BESTSELLER.data('sold_qty');
        brandPrimary = BESTSELLER.data('color');
        brandPrimaryRgba = BESTSELLER.data('color_rgba');
        var product_info = BESTSELLER.data('product');
        var bestSeller = new Chart(BESTSELLER, {
            type: 'bar',
            data: {
                labels: [product_info[0], product_info[1], product_info[2]],
                datasets: [
                    {
                        label: "Sale Qty",
                        backgroundColor: [
                            brandPrimaryRgba,
                            brandPrimaryRgba,
                            brandPrimaryRgba,
                            brandPrimaryRgba
                        ],
                        borderColor: [
                            brandPrimary,
                            brandPrimary,
                            brandPrimary,
                            brandPrimary
                        ],
                        borderWidth: 1,
                        data: [
                            sold_qty[0], sold_qty[1],
                            sold_qty[2], 0],
                    }
                ]
            }
        });
    };

    var PIECHART = $('#pieChart');
    if (PIECHART.length > 0) {
        var brandPrimary = PIECHART.data('color');
        var brandPrimaryRgba = PIECHART.data('color_rgba');
        var price = PIECHART.data('price');
        var cost = PIECHART.data('cost');
        var label1 = PIECHART.data('label1');
        var label2 = PIECHART.data('label2');
        var label3 = PIECHART.data('label3');
        var myPieChart = new Chart(PIECHART, {
            type: 'pie',
            data: {
                labels: [
                    label1,
                    label2,
                    label3
                ],
                datasets: [
                    {
                        data: [price, cost, price - cost],
                        borderWidth: [1, 1, 1],
                        backgroundColor: [
                            "#2264dc",
                            "#0a0046",
                            "#898890"
                        ],
                        hoverBackgroundColor: [
                            "#2264dc",
                            "#0a0046",
                            "#898890"
                        ],
                        hoverBorderWidth: [4, 4, 4],
                        hoverBorderColor: [
                            "#2264dc",
                            "#0a0046",
                            "#898890",

                        ],
                    }]
            },
            options: {
                //rotation: -0.7*Math.PI
            }
        });
    }

    var TRANSACTIONCHART = $('#transactionChart');
    if (TRANSACTIONCHART.length > 0) {
        brandPrimary = TRANSACTIONCHART.data('color');
        brandPrimaryRgba = TRANSACTIONCHART.data('color_rgba');
        var revenue = TRANSACTIONCHART.data('revenue');
        var purchase = TRANSACTIONCHART.data('purchase');
        var expense = TRANSACTIONCHART.data('expense');
        var label1 = TRANSACTIONCHART.data('label1');
        var label2 = TRANSACTIONCHART.data('label2');
        var label3 = TRANSACTIONCHART.data('label3');

        const dataSet = []

        if (label1) {
            dataSet.push(
                {
                    data: [revenue, purchase, expense],
                    borderWidth: [1, 1, 1],
                    backgroundColor: [
                        "#2264dc",
                        "#01b4d2",
                        "#0a0046",

                    ],
                    hoverBackgroundColor: [
                        "#2264dc",
                        "#01b4d2",
                        "#0a0046",

                    ],
                    hoverBorderWidth: [4, 4, 4],
                    hoverBorderColor: [
                        "#2264dc",
                        "#01b4d2",
                        "#0a0046",

                    ],
                }
            )
        } else {
            dataSet.push({
                data: [revenue, expense],
                borderWidth: [1, 1, 1],
                backgroundColor: [
                    "#2264dc",
                    "#0a0046",

                ],
                hoverBackgroundColor: [
                    "#2264dc",
                    "#0a0046",

                ],
                hoverBorderWidth: [4, 4, 4],
                hoverBorderColor: [
                    "#2264dc",
                    "#0a0046",

                ],
            })
        }

        var myTransactionChart = new Chart(TRANSACTIONCHART, {
            type: 'doughnut',
            data: {
                labels: (label1) ? [
                    label2,
                    label1,
                    label3
                ] : [
                    label2,
                    label3
                ],
                datasets: dataSet
            },
            options: {
                tooltips: {
                    callbacks: {
                        label: function (tooltipItem, data) {
                            var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                            return formatRupiah(value.toString());
                        }
                    }
                }
            }
        });
    }
});
