$(function() {
    $("#btn-upl-validate").on("click", function(){
        var url = window.location.toString();
        var urlParams = new URLSearchParams(window.location.search);
        $.ajax
        ({
            type: "POST",
            url: url.replace(window.location.search, "").replace("index", "") + "validate",
            cache: false,
            data: {
                upl_no: urlParams.get("uplNo"),
            },
            beforeSend: function() {
                $('#loader').modal('show');
            },
            success: function (data) {
                if(data.status == '200') {
                    $("#btn-upl-validate").attr("disabled", true);
                    $("#btn-upl-commit").attr("disabled", false);
                    $('#datatable').DataTable().ajax.reload();
                } else {
                    showNotification(data.status, data.message);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                showNotification(500, xhr.responseJSON.message);
            },
            complete: function() {
                $('#loader').modal('hide');
            },
        });
    });

    $("#btn-upl-commit").on("click", function(){
        var url = window.location.toString();
        var urlParams = new URLSearchParams(window.location.search);
        $.ajax
        ({
            type: "POST",
            url: url.replace(window.location.search, "").replace("index", "") + "commit",
            cache: false,
            data: {
                upl_no: urlParams.get("uplNo"),
            },
            beforeSend: function() {
                $('#loader').modal('show');
            },
            success: function (data) {
                if(data.status == '200') {
                    $("#btn-upl-validate").attr("disabled", true);
                    $("#btn-upl-commit").attr("disabled", true);
                    $('#datatable').DataTable().ajax.reload();
                } else {
                    showNotification(data.status, data.message);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                showNotification(500, xhr.responseJSON.message);
            },
            complete: function() {
                $('#loader').modal('hide');
            },
        });
    });

    $("#btn-upl-cancel").on("click", function(){
        var url = window.location.toString();
        window.location.href = url.replace(window.location.search, "").replace("/index", "");
    });
})