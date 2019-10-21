require('./bootstrap');
require('chart.js');

let base_url = document.location.origin,
    addTransactionModal = $('#addTransaction'),
    editBudgetModal = $('#editBudget'),
    editResourceModal = $('#editResource'),
    editCriptoResourceModal = $('#editCriptoResource'),
    resourceDeleteForm = $('#resourceDeleteForm'),
    criptoResourceDeleteForm = $('#criptoResourceDeleteForm'),
    transactionDeleteForm = $('#transactionDeleteForm'),
    investitionDeleteForm = $('#investitionDeleteForm'),
    budgetDeleteForm = $('#budgetDeleteForm');

document.addEventListener('DOMContentLoaded', (event) => {
    $('#articles').on('click','.remove-btn',function (e) {
        let article = $(e.currentTarget),
            confirmMessage = 'Confirm deletion of article: '+article.data('article_name');

        if(confirm(confirmMessage)){
            let url = budgetDeleteForm.attr('action');
            let str = url.substr(url.lastIndexOf('/') + 1) + '$';
            let newActionUrl = url.replace( new RegExp(str), article.data('article_id') );
            budgetDeleteForm.attr('action',newActionUrl)
                .submit();
        }
    });
    $('#resources').on('click','.remove-btn',function (e) {
        let item = $(e.currentTarget),
            confirmMessage = 'Confirm deletion of resource: '+item.data('resource_name');

        if(confirm(confirmMessage)){
            let url = resourceDeleteForm.attr('action');
            let str = url.substr(url.lastIndexOf('/') + 1) + '$';
            let newActionUrl = url.replace( new RegExp(str), item.data('resource_id') );
            resourceDeleteForm.attr('action',newActionUrl)
                .submit();
        }
    });
    $('#transactions').on('click','.remove-btn',function (e) {
        let item = $(e.currentTarget),
            confirmMessage = 'Confirm deletion of transaction: '+item.data('transaction_name');

        if(confirm(confirmMessage)){
            let url = transactionDeleteForm.attr('action');
            let str = url.substr(url.lastIndexOf('/') + 1) + '$';
            let newActionUrl = url.replace( new RegExp(str), item.data('transaction_id') );
            transactionDeleteForm.attr('action',newActionUrl)
                .submit();
        }
    });
    $('#criptoResources').on('click','.remove-btn',function (e) {
        let item = $(e.currentTarget),
            confirmMessage = 'Confirm deletion of resource: '+item.data('resource_name');

        if(confirm(confirmMessage)){
            let url = criptoResourceDeleteForm.attr('action');
            let str = url.substr(url.lastIndexOf('/') + 1) + '$';
            let newActionUrl = url.replace( new RegExp(str), item.data('resource_id') );
            criptoResourceDeleteForm.attr('action',newActionUrl)
                .submit();
        }
    });
    $('#investitions').on('click','.remove-btn',function (e) {
        let item = $(e.currentTarget),
            confirmMessage = 'Confirm deletion';

        if(confirm(confirmMessage)){
            let url = investitionDeleteForm.attr('action');
            let str = url.substr(url.lastIndexOf('/') + 1) + '$';
            let newActionUrl = url.replace( new RegExp(str), item.data('investition_id') );
            investitionDeleteForm.attr('action',newActionUrl)
                .submit();
        }
    });

    if($('body.reports-page').length){
        let ctx = document.getElementById('myChart').getContext('2d');
        let myChart = Chart.Line(ctx, {
            data: {
                labels: chartIElabels,
                datasets: [ {
                    label: 'Income',
                    borderColor: "rgb(54, 162, 235)",
                    backgroundColor: "rgb(54, 162, 235)",
                    fill: false,
                    data: chartIEincome,
                    yAxisID: 'y-axis-2'
                },{
                    label: 'Expenses',
                    borderColor: "rgb(255, 99, 132)",
                    backgroundColor: "rgb(255, 99, 132)",
                    fill: false,
                    data: chartIEexpenses,
                    yAxisID: 'y-axis-1',
                }]
            },
            options: {
                responsive: true,
                hoverMode: 'index',
                stacked: false,
                title: {
                    display: false,
                    text: 'Chart.js Line Chart - Multi Axis'
                },
                scales: {
                    yAxes: [{
                        type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                        display: true,
                        position: 'left',
                        id: 'y-axis-1',
                    }, {
                        type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                        display: true,
                        position: 'right',
                        id: 'y-axis-2',

                        // grid line settings
                        gridLines: {
                            drawOnChartArea: false, // only want the grid lines for one axis to show up
                        },
                    }],
                }
            }
        });

        // passive income 1
        let passiveChartctx = document.getElementById('passiveChart').getContext('2d');
        let passiveChart = Chart.Line(passiveChartctx, {
            data: {
                labels: chartPassivelabels,
                datasets: [ {
                    label: 'Passive income',
                    borderColor: "rgb(56, 193, 114)",
                    backgroundColor: "rgb(56, 193, 114)",
                    fill: false,
                    data: chartPassiveIncome,
                    yAxisID: 'y-axis-2'
                }]
            },
            options: {
                responsive: true,
                hoverMode: 'index',
                stacked: false,
                title: {
                    display: false,
                    text: 'Chart.js Line Chart - Multi Axis'
                },
                scales: {
                    yAxes: [{
                        type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                        display: true,
                        position: 'left',
                        id: 'y-axis-1',
                    }, {
                        type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                        display: true,
                        position: 'right',
                        id: 'y-axis-2',

                        // grid line settings
                        gridLines: {
                            drawOnChartArea: false, // only want the grid lines for one axis to show up
                        },
                    }],
                }
            }
        });

        // passive income 2
        let passiveChart2ctx = document.getElementById('passiveChart2').getContext('2d');
        let passiveChart2 = Chart.Line(passiveChart2ctx, {
            data: {
                labels: chartPassive2labels,
                datasets: [ {
                    label: 'Expenses coverage (%)',
                    borderColor: "rgb(101, 116, 205)",
                    backgroundColor: "rgb(101, 116, 205)",
                    fill: false,
                    data: chartPassiveIncome2,
                    yAxisID: 'y-axis-2'
                }]
            },
            options: {
                responsive: true,
                hoverMode: 'index',
                stacked: false,
                title: {
                    display: false,
                    text: 'Chart.js Line Chart - Multi Axis'
                },
                scales: {
                    yAxes: [{
                        type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                        display: true,
                        position: 'left',
                        id: 'y-axis-1',
                    }, {
                        type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                        display: true,
                        position: 'right',
                        id: 'y-axis-2',

                        // grid line settings
                        gridLines: {
                            drawOnChartArea: false, // only want the grid lines for one axis to show up
                        },
                    }],
                }
            }
        });

        // balance
        let balanceCTX = document.getElementById('balanceChart').getContext('2d');
        let balanceChart1 = Chart.Bar(balanceCTX, {
            data: {
                labels: balanceChartLabels,
                datasets: [{
                    label: 'Balance',
                    backgroundColor: "rgb(75, 192, 192)",
                    borderColor: "rgb(75, 192, 192)",
                    data: balanceChart,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    }

});

editBudgetModal.on('show.bs.modal', function (e) {
    let article_id = $(e.relatedTarget).data('article_id');
    editBudgetModal.addClass('loading');
    $.ajax({
        url: base_url + "/load-article-data/" + article_id,
        success: function (result) {
            if (result.success === true) {
                editBudgetModal.find('input[name="article_id"]').val(result.article.id);
                editBudgetModal.find('input[name="name"]').val(result.article.name);
                editBudgetModal.find('input[name="value"]').val(result.article.value);
                editBudgetModal.find('select[name="currency_id"]').val(result.article.currency_id);
            }
        },
        complete: function () {
            editBudgetModal.removeClass('loading');
        }
    });
});
editResourceModal.on('show.bs.modal', function (e) {
    let resource_id = $(e.relatedTarget).data('resource_id');
    editResourceModal.addClass('loading');
    $.ajax({
        url: base_url + "/load-resource-data/" + resource_id,
        success: function (result) {
            if (result.success === true) {
                editResourceModal.find('input[name="resource_id"]').val(result.item.id);
                editResourceModal.find('input[name="name"]').val(result.item.name);
                editResourceModal.find('input[name="value"]').val(result.item.value);
                editResourceModal.find('select[name="currency_id"]').val(result.item.currency_id);
            }
        },
        complete: function () {
            editResourceModal.removeClass('loading');
        }
    });
});
addTransactionModal.on('show.bs.modal', function (e) {
    let type = $(e.relatedTarget).data('type');
    addTransactionModal.find('input[name="type"]').val(type);
    addTransactionModal.find('input[name="is_passive_income"]').val(0);
    if(type === 1){
        addTransactionModal.find('.is_passive_income_block').show();
        addTransactionModal.find('.modal-title').html("Add input");
        addTransactionModal.find('.resource_id_label').html("To:");
    } else {
        addTransactionModal.find('.is_passive_income_block').hide();
        addTransactionModal.find('.modal-title').html("Add output");
        addTransactionModal.find('.resource_id_label').html("From:");
    }
});
editCriptoResourceModal.on('show.bs.modal', function (e) {
    let resource_id = $(e.relatedTarget).data('resource_id');
    editCriptoResourceModal.addClass('loading');
    $.ajax({
        url: base_url + "/load-cripto-resource-data/" + resource_id,
        success: function (result) {
            if (result.success === true) {
                editCriptoResourceModal.find('input[name="resource_id"]').val(result.item.id);
                editCriptoResourceModal.find('input[name="name"]').val(result.item.name);
                editCriptoResourceModal.find('select[name="currency_id"]').val(result.item.currency_id);
            }
        },
        complete: function () {
            editCriptoResourceModal.removeClass('loading');
        }
    });
});