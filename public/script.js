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
                        (area_id == 3 ||
                            area_id == 4 ||
                            area_id == 5 ||
                            area_id == 11)
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

        console.log($("#inputRequestTypeId").val());
        console.log("cek");

        $("#tableproduct").empty();

        if ($(this).val() == "1") {
            $("#inputRequestFile").show();
            $("#inputRequestFile2").show();
            $("#formaddmanyproduct").show();
            $("#formaddproduct").show();
            $("#label-approved-file-2").show();
            $("#label-approved-file").show();
            $("#label-nota-file").hide();
        }
        if ($(this).val() == "2") {
            $("#inputRequestFile").hide();
            $("#inputRequestFile2").hide();
            $("#formaddproduct").show();
            $("#formaddmanyproduct").show();
        }
        if ($(this).val() == "3") {
            $("#inputRequestFile").show();
            $("#inputRequestFile2").hide();
            $("#formaddproduct").show();
            $("#formaddmanyproduct").show();
            $("#label-approved-file").hide();
            $("#label-approved-file-2").hide();
            $("#label-nota-file").show();
        }
    });

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

    $("#requestMonth").datepicker({
        format: "mm-yyyy",
        startView: "months",
        minViewMode: "months",
        parentEl: "#requestSettingModal .modal-body",
    });

    $("#openDate").datepicker({
        dateFormat: "yy-mm-dd",
        format: "dd/mm/yyyy",
        parentEl: "#requestSettingModal .modal-body",
    });

    $("#closedDate").datepicker({
        dateFormat: "yy-mm-dd",
        format: "dd/mm/yyyy",
        parentEl: "#requestSettingModal .modal-body",
    });

    $("#tanggalMulaiSewa").datepicker({
        dateFormat: "yy-mm-dd",
        format: "dd/mm/yyyy",
        parentEl: "#addRentsModal .modal-body",
    });

    $("#tanggalAkhirSewa").datepicker({
        dateFormat: "yy-mm-dd",
        format: "dd/mm/yyyy",
        parentEl: "#addRentsModal .modal-body",
    });
});
