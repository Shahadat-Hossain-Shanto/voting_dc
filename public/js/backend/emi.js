//EMI LIST
$(document).ready(function () {
    var t = $("#emi_table").DataTable({
        processing: true,
        serverSide: true,
        language: {
            processing:
                '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
        },
        dom: "lBfrtip",
        ajax: {
            url: "emi-list-data",
            dataSrc: "emi",
        },
        buttons: [
            {
                extend: "colvis",
                collectionLayout: "fixed columns",
                collectionTitle: "Column Visibility Control",
            },
            {
                extend: "excel",
                exportOptions: {
                    columns: ":visible",
                },
            },
        ],
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
            },
            {
                data: "imei_1",
            },
            {
                data: "imei_2",
            },
            {
                data: "customer_id",
            },
            {
                data: "customer_name",
            },
            {
                data: "hire_sale_price",
            },
            {
                data: "down_payment",
            },
            {
                data: "down_payment_date",
            },
            {
                data: "total_payment",
            },
            {
                data: "total_due",
            },
            {
                render: number_of_installment,
            },
            {
                data: "installment_complete",
            },
            {
                data: "next_payment_date",
            },
            {
                render: function (data, type, row, meta) {
                    if (row.next_payment_amount < 0) {
                        return 0;
                    } else {
                        return row.next_payment_amount;
                    }
                },
            },
            {
                data: "model",
            },
            {
                data: "brand",
            },
            {
                data: "color",
            },
            {
                data: "plaza_name",
            },
            {
                data: "pos_invoice_number",
            },
            {
                data: "sales_person_name",
            },
            {
                render: status,
            },
            {
                render: appStatus,
            },
            {
                data: "last_sync",
            },
            {
                data: "location",
                render: function (data, type, row) {
                    return `<button class="btn btn-primary show-location" data-imei="${row.imei_1}">
                                ${data}
                            </button>`;
                }
            },
            {
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-secondary show-policies" data-imei="${row.imei_1}">
                            Policies
                        </button>`;
                }
            },
            {
                render: devicestatus,
            },
            {
                render: lockstatus,
            },
            {
                render: lockBtn,
            },
            {
                render: getBtns,
            },
        ],
        responsive: true,
        columnDefs: [
            {
                searchable: true,
                orderable: true,
                targets: "_all",
                defaultContent: "_",
            },
        ],
        order: [[1, "asc"]],
        pageLength: 10,
        lengthMenu: [
            [
                5, 10, 20, 50, 100, 150, 200, 250, 300, 350, 400, 450, 500,
                1000, 10000000000,
            ],
            [
                5,
                10,
                20,
                50,
                100,
                150,
                200,
                250,
                300,
                350,
                400,
                450,
                500,
                1000,
                "All",
            ],
        ],
    });

    t.on("order.dt search.dt", function () {
        t.on("draw.dt", function () {
            var PageInfo = $("#emi_table").DataTable().page.info();
            t.column(0, {
                page: "current",
            })
                .nodes()
                .each(function (cell, i) {
                    cell.innerHTML = i + 1 + PageInfo.start;
                });
        });
    }).draw();
    $(".dataTables_length").find("label").find("select").css("width", "45px");
});

function number_of_installment(data, type, row, meta) {
    var id = row.imei_1;
    var number_of_installment = row.number_of_installment;
    return (
        '<a href="javascript:void(0)" class="installment btn btn-outline-success btn-sm" data-value="' +
        id +
        '">' +
        number_of_installment +
        "</i></a>"
    );
}

function appStatus(data, type, row, meta) {
    var acknowledgment = row.acknowledgment;
    if (acknowledgment == 1) {
        status = "Active";
        return '<span class="badge badge-danger">' + status + "</span>";
    } else {
        status = "Inactive";
        return '<span class="badge badge-success">' + status + "</span>";
    }
}

function devicestatus(data, type, row, meta) {
    var devicestatus = row.device_status;
    if (devicestatus == "Unlock") {
        return '<span class="badge badge-success">' + devicestatus + "</span>";
    } else {
        return '<span class="badge badge-danger">' + devicestatus + "</span>";
    }
}
function lockstatus(data, type, row, meta) {
    var lockstatus = row.lock_status;
    var device_lock = row.device_lock;
    if (lockstatus == "Unlock" && device_lock == 1) {
        return '<span class="badge badge-danger">Device is forced lock</span>';
    } else if (lockstatus == "Unlock") {
        return '<span class="badge badge-success">' + lockstatus + "</span>";
    } else {
        return '<span class="badge badge-danger">' + lockstatus + "</span>";
    }
}
function status(data, type, row, meta) {
    var emi_status = row.emi_status;
    if (emi_status == 0) {
        status = "Complete";
        return '<span class="badge badge-success">' + status + "</span>";
    } else {
        status = "Incomplete";
        return '<span class="badge badge-danger">' + status + "</span>";
    }
}

function lockBtn(data, type, row, meta) {
    var imei = row.imei_1;
    var device_lock = row.device_lock;
    if (device_lock == 1) {
        status = "Lock";
        return (
            '<span class="badge badge-danger">' +
            status +
            '</span> <a id="unlock" class="btn btn-outline-success btn-sm" data-value="' +
            imei +
            '"">(Click to Unlock)</a>'
        );
    } else {
        status = "Unlock";
        return (
            '<span class="badge badge-success">' +
            status +
            '</span> <a id="lock" class="btn btn-outline-danger btn-sm" data-value="' +
            imei +
            '">(Click to Lock)</a>'
        );
    }
}

function getBtns(data, type, row, meta) {
    var id = row.imei_1;
    return (
        '<a href="javascript:void(0)" class="print_btn btn btn-outline-success btn-sm" data-value="' +
        id +
        '"><i class="fas fa-print"></i></a>'
    );
}

//PRINT EMI
$(document).ready(function () {
    $("#emi_table").on("click", ".print_btn", function () {
        var d = new Date();

        var month = d.getMonth() + 1;
        var day = d.getDate();

        var date =
            (day < 10 ? "0" : "") +
            day +
            "-" +
            (month < 10 ? "0" : "") +
            month +
            "-" +
            d.getFullYear();

        var imei = $(this).data("value");
        $.ajax({
            type: "get",
            url: "/emi-data/" + imei,
            success: function (response) {
                if (response.responseStatus == 403) {
                    $.notify(response.responseMessage, {
                        className: "error",
                        position: "bottom right",
                    });
                } else {
                    $("#customer_id").text(response.customer_id);
                    $("#customer_name").text(response.customer_name);
                    $("#customer_nid").text(response.customer_nid);
                    $("#customer_address").text(response.customer_address);
                    $("#customer_mobile").text(response.customer_mobile);
                    $("#sales_by").text(response.sales_by);
                    $("#sales_person_name").text(response.sales_person_name);
                    $("#date").text(date);
                    $("#plaza_id").text(response.plaza_id);
                    $("#plaza_name").text(response.plaza_name);
                    $("#pos_invoice_number").text(response.pos_invoice_number);
                    $("#brand").val(response.brand);
                    $("#model").val(response.model);
                    $("#color").val(response.color);
                    $("#barcode").val(response.barcode);
                    $("#serial_number").val(response.serial_number);
                    $("#imei_1").val(response.imei_1);
                    $("#imei_2").val(response.imei_2);
                    $("#hire_sale_price").val(response.hire_sale_price);
                    $("#number_of_installment").val(
                        response.number_of_installment
                    );
                    $("#number_of_installment_complete").val(
                        response.number_of_installment_complete
                    );
                    $("#down_payment_date").val(response.down_payment_date);
                    $("#down_payment").val(response.down_payment);
                    $("#total_payment").val(response.total_payment);
                    $("#total_due").val(response.total_due);
                    if (response.emi_status == 0) {
                        status = "Complete";
                    } else {
                        status = "Incomplete";
                    }
                    $("#emi_status").val(status);

                    $("#emi_schedules_table tbody").empty();

                    response.emi_schedules.forEach(function (emi_schedule) {
                        $("#emi_schedules_table").append(
                            "<tr>\
                            <td>" +
                                emi_schedule.installment_number +
                                "</td>\
                            <td>" +
                                emi_schedule.installment_date +
                                "</td>\
                            <td>" +
                                emi_schedule.installment_amount +
                                "</td>\
                            </tr>"
                        );
                    });

                    $("#payments_table tbody").empty();

                    response.payment_details.forEach(function (payment_detail) {
                        $("#payments_table").append(
                            "<tr>\
                            <td>" +
                                payment_detail.pos_invoice_number +
                                "</td>\
                            <td>" +
                                payment_detail.payment_date +
                                "</td>\
                            <td>" +
                                payment_detail.payment_amount +
                                "</td>\
                            </tr>"
                        );
                    });
                    $("#PRINTEMIMODAL").modal("show");
                    $.print("#printData");
                }
            },
        });
    });

    $("#emi_table").on("click", ".installment", function () {
        var imei = $(this).data("value");

        $.ajax({
            type: "get",
            url: "/emi-data/" + imei,
            success: function (response) {
                if (response.responseStatus == 403) {
                    $.notify(response.responseMessage, {
                        className: "error",
                        position: "bottom right",
                    });
                } else {
                    $("#installment_emi_schedules_table tbody").empty();
                    response.emi_schedules.forEach(function (emi_schedule) {
                        $("#installment_emi_schedules_table").append(
                            "<tr>\
                            <td>" +
                                emi_schedule.installment_number +
                                "</td>\
                            <td>" +
                                emi_schedule.installment_date +
                                "</td>\
                            <td>" +
                                emi_schedule.installment_amount +
                                "</td>\
                            </tr>"
                        );
                    });
                    $("#INSTALLMENTMODAL").modal("show");
                }
            },
        });
    });

    $("#emi_table").on("click", "#lock", function () {
        var imei = $(this).data("value");

        $.ajax({
            type: "get",
            url: "/lock-notification/" + imei,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 200) {
                    $.notify(response.message, {
                        className: "success",
                        position: "bottom right",
                    });
                    location.reload();
                } else if (response.responseStatus == 403) {
                    $.notify(response.responseMessage, {
                        className: "error",
                        position: "bottom right",
                    });
                } else {
                    $.notify(response.message, {
                        className: "error",
                        position: "bottom right",
                    });
                }
            },
        });
    });

$(document).on("click", ".show-location", function () {
    let imei = $(this).data("imei");

    $.ajax({
        url: "/get-location-history",
        type: "GET",
        data: { imei_1: imei },
        success: function (response) {
            if (response.length > 0) {

                let historyList = `
                    <table class="table table-striped" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Index</th>
                                <th>Location</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                response.forEach((item, index) => {
                    let formattedDate = new Date(item.created_at).toLocaleString();
                    historyList += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.location}</td>
                            <td>${item.latitude}</td>
                            <td>${item.longitude}</td>
                            <td>${formattedDate}</td>
                        </tr>
                    `;
                });

                historyList += `</tbody></table>`;

                Swal.fire({
                    title: "Location History",
                    html: historyList,
                    icon: null,
                    customClass: {
                        popup: 'swal-popup',
                        header: 'swal-header-no-icon',
                    },
                });
            } else {
                Swal.fire({
                    title: "No History Found",
                    text: "No location history available for this IMEI.",
                    icon: "warning",
                });
            }
        },
        error: function () {
            Swal.fire({
                title: "Error",
                text: "Failed to fetch location history.",
                icon: "error",
            });
        },
    });
});

$(document).on("click", ".show-policies", function () {
    let imei = $(this).data("imei");

    $.ajax({
        url: "/get-policies",
        type: "GET",
        data: { imei_1: imei },
        success: function (response) {
            if (response.length > 0) {

                let policiesList = `
                    <table class="table table-striped" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Index</th>
                                <th>Policy Type</th>
                                <th>Policy Name</th>
                                <th>Package Name</th>
                                <th>Time & Date</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                response.forEach((item, index) => {
                         let formattedDate = new Date(item.created_at).toLocaleString()
                    policiesList += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.type}</td>
                            <td>${item.policy_name}</td>
                            <td>${item.package_name}</td>
                            <td>${formattedDate}</td>
                        </tr>
                    `;
                });

                policiesList += `</tbody></table>`;

                Swal.fire({
                    title: "Policies",
                    html: policiesList,
                    icon: null,
                    customClass: {
                        popup: 'swal-popup',
                        header: 'swal-header-no-icon',
                    },
                });
            } else {
                Swal.fire({
                    title: "No Policies Found",
                    text: "No policies available for this IMEI.",
                    icon: "warning",
                });
            }
        },
        error: function () {
            Swal.fire({
                title: "Error",
                text: "Failed to fetch policies.",
                icon: "error",
            });
        },
    });
});


    $("#emi_table").on("click", "#unlock", function () {
        var imei = $(this).data("value");

        $.ajax({
            type: "get",
            url: "/unlock-notification/" + imei,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status == 200) {
                    $.notify(response.message, {
                        className: "success",
                        position: "bottom right",
                    });
                    location.reload();
                } else if (response.responseStatus == 403) {
                    $.notify(response.responseMessage, {
                        className: "error",
                        position: "bottom right",
                    });
                } else {
                    $.notify(response.message, {
                        className: "error",
                        position: "bottom right",
                    });
                }
            },
        });
    });
});
