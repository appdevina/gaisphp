$(document).ready(function () {
    var productindex = 0;
    var selectedproduct = ["1"];

    var select = this.value;

    $("#addProduct").on("click", function () {
        var request_type_id = $("#request_type_id").val();
        var area_id = $("#inputArea").val();

        $.ajax({
            type: "get",
            url: `http://sumo.completeselular.com:3990/product/get?req_type_id=${request_type_id}`,
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
                        (area_id == 4 || area_id == 5
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

        $("#tableproduct").empty();

        if ($(this).val() == "1") {
            $("#inputRequestFile").show();
            $("#formaddmanyproduct").show();
            $("#formaddproduct").show();
        }
        if ($(this).val() == "2") {
            $("#inputRequestFile").hide();
            $("#formaddproduct").show();
            $("#formaddmanyproduct").show();
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
});
