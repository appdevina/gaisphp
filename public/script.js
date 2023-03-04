$(document).ready(function () {
    var productindex = 0;
    var selectedproduct = ["1"];

    var requesttype = jQuery("#request_type_id");
    var select = this.value;

    $("#addProduct").on("click", function () {
        $.ajax({
            type: "get",
            url: "http://gais.ddnsku.my.id:3990/product/get",
            success: function (data) {
                console.log(data);
                $("#tableproduct").append(
                    '<tr id="rowproduct' +
                        productindex +
                        '"><td><select class="form-control" id="selectproduct' +
                        productindex +
                        '" name="products[]" required></select></td><td><input type="number" placeholder="Qty" class="form-control col-lg-3" name="qty_requests[]" min="1"></td><td><input type="text" placeholder="..." class="form-control col-lg-3" name="descriptions[]"></td><td><a href="#formreplaceproduct" class="badge bg-danger btn_remove" id="product' +
                        productindex +
                        '"><span class="lnr lnr-circle-minus"></span></a></td></tr>'
                );

                $.each(data, function (index, value) {
                    $("#selectproduct" + productindex).append(
                        '<option value="' +
                            value.id +
                            '"> ' +
                            value.product +
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

    $("#request_type_id").change(function () {
        $("#inputRequestTypeId").val($(this).val());
        $("#inputRequestTypeId2").val($(this).val());

        console.log($(this).val());
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
