$(document).ready(function () {
    var productindex = 0;
    var selectedproduct = ["1"];

    var select = this.value;
    $("#label-nota-file").hide();

    $("#addProduct").on("click", function () {
        var request_type_id = $("#request_type_id").val();
        var area_id = $("#inputArea").val();
        var baseUrl = window.location.protocol + "//" + window.location.host;

        $.ajax({
            type: "get",
            url: `${baseUrl}/product/get?req_type_id=${request_type_id}`,
            success: function (data) {
                console.log(data);

                console.log(area_id);

                console.log(request_type_id);

                $("#tableproduct").append(
                    '<tr id="rowproduct' +
                        productindex +
                        '"><td><select class="form-control" id="selectproduct' +
                        productindex +
                        '" name="products[]" required></select></td>' +
                        ((request_type_id == 2 || request_type_id == 3) &&
                        (area_id == 3 || area_id == 4 || area_id == 5)
                            ? '<td><input type="number" placeholder="Sisa" class="form-control col-lg-3" name="qty_remainings[]"></td>'
                            : "") +
                        '<td><input type="number" placeholder="request" class="form-control col-lg-3" name="qty_requests[]" min="1"></td><td><input type="text" placeholder="..." class="form-control col-lg-3" name="descriptions[]"></td><td><a href="#formreplaceproduct" class="badge bg-danger btn_remove" id="product' +
                        productindex +
                        '"><span class="lnr lnr-circle-minus"></span></a></td></tr>'
                );

                $.each(data, function (index, value) {
                    var productUnitType =
                        value.product +
                        " - " +
                        value.unit_type.unit_type +
                        " - " +
                        value.category.category;
                    $("#selectproduct" + productindex).append(
                        '<option value="' +
                            value.id +
                            '"> ' +
                            productUnitType +
                            " </option>"
                    );
                });
                // $("#selectproduct" + productindex).change(function (e) {
                //     console.log($(this).val());
                //     selectedproduct.push($(this).val());
                // });
                productindex++;
            },
        });
    });

    $(document).on("click", ".btn_remove", function () {
        var button_id = $(this).attr("id");
        $("#row" + button_id + "").remove();
    });

    $("#request_type_id").on("change", function () {
        $("#inputRequestTypeId").val($(this).val());

        console.log($("#inputRequestTypeId").val($(this).val()));

        $("#tableproduct").empty();

        if ($(this).val() == "1") {
            $("#inputRequestFile").show();
            $("#formaddmanyproduct").show();
            $("#formaddproduct").show();
            $("#label-approved-file").show();
            $("#label-nota-file").hide();
        }
        if ($(this).val() == "2") {
            $("#inputRequestFile").hide();
            $("#formaddproduct").show();
            $("#formaddmanyproduct").show();
        }
        if ($(this).val() == "3") {
            $("#inputRequestFile").show();
            $("#formaddproduct").show();
            $("#formaddmanyproduct").show();
            $("#label-approved-file").hide();
            $("#label-nota-file").show();
        }
    });

    // $("#request_type_id_2").change(function () {
    //     console.log($(this).val());
    //     if ($(this).val() == "1") {
    //         $("#inputRequestFile").show();
    //         $("#formaddmanyproduct").show();
    //         $("#formaddproduct").show();
    //     }
    //     if ($(this).val() == "2") {
    //         $("#inputRequestFile").hide();
    //         $("#formaddproduct").show();
    //         $("#formaddmanyproduct").show();
    //     }
    // });

    $("#tanggal-problem").daterangepicker();

    $("#tanggal-problem-report").daterangepicker({
        parentEl: "#exportProblemReport .modal-body",
    });

    $("#tanggal-request").daterangepicker();

    $("#tanggal-export-request").daterangepicker({
        parentEl: "#exportRequest .modal-body",
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    $("#tanggalMulaiAsuransi").datepicker({
        dateFormat: "yy-mm-dd",
        format: "dd/mm/yyyy",
        parentEl: "#addinsurancesModal .modal-body",
    });

    $("#tanggalAkhirAsuransi").datepicker({
        dateFormat: "yy-mm-dd",
        format: "dd/mm/yyyy",
        parentEl: "#addinsurancesModal .modal-body",
    });
});
