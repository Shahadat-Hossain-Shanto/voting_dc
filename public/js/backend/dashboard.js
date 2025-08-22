var myChart; // Define the chart variable outside the event listener

$(document).ready(function () {
    $.ajax({
        type: "GET",
        url: "/dashboard-consumes",
        success: function (response) {
            const xValues0 = response.months;     // e.g. ['Jan', 'Feb', ..., 'Dec']
            const yValues0 = response.consumes;   // e.g. [10, 15, ..., 20]
            const barColors0 = [
                "#3c8dbc", "#00c0ef", "#00a65a", "#f39c12", "#d81b60",
                "#605ca8", "#39cccc", "#ff851b", "#dd4b39", "#001f3f",
                "#0074D9", "#7FDBFF"
            ];
    
            new Chart("myChart0", {
                type: "bar",
                data: {
                    labels: xValues0,
                    datasets: [{
                        label: 'Devices Added',
                        backgroundColor: barColors0,
                        data: yValues0
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Month-wise Devices (Current Year)',
                            font: {
                                size: 16
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Devices'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Months'
                            }
                        }
                    }
                }
            });
        },
        error: function () {
            console.error("Failed to load device data for chart.");
        }
    });
    $.ajax({
        type: "GET",
        url: "/dashboard-subscriptions",
        success: function (response) {
            const xValues = response.months;           // e.g. ['Jan', 'Feb', ..., 'Dec']
            const yValues = response.subscriptions;    // e.g. [100, 150, ..., 80]
            const barColors = [
                "#f56954", "#00a65a", "#f39c12", "#00c0ef", "#3c8dbc",
                "#d81b60", "#605ca8", "#39cccc", "#ff851b", "#001f3f",
                "#0074D9", "#7FDBFF"
            ];
    
            new Chart("myChart", {
                type: "bar",
                data: {
                    labels: xValues,
                    datasets: [{
                        label: 'Purchased Subscriptions',
                        backgroundColor: barColors,
                        data: yValues
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Month-wise Purchased Subscriptions (Current Year)',
                            font: {
                                size: 16
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Total Subscriptions'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Months'
                            }
                        }
                    }
                }
            });
        },
        error: function () {
            console.error("Failed to load subscription data for chart.");
        }
    });

  // Get today's date in YYYY-MM-DD format
let today = new Date().toISOString().split('T')[0];

$('#deviceTable').DataTable({
    ajax: {
        url: "dashboard-device-data",
        dataSrc: "mobile",
    },
    columns: [
        {
            data: null,
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        { data: 'imei_1' },
        { data: 'imei_2' },
        { data: 'serial' },
        { data: 'model' },
        { data: 'manufacturer' },
        { data: 'customer.name' },
        {
            data: 'status',
            render: function (data, type, row) {
                return data == 1 ? 'Active' : 'Inactive';
            }
        },
        { data: 'add_time' },
    ]
});

    

});
