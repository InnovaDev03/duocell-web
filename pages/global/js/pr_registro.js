/*=============================================
CALENDARIO
=============================================*/
$(function () {

    $('[data-mask]').inputmask();
    $('#reservationdate').datetimepicker({
        format: 'DD-MM-YYYY'
    });

});


/*=============================================
CARGAR CADENA
=============================================*/
cargar_cadena();
function cargar_cadena() {
    var parametros = {
        "txt_option": "1"
    };
    $.ajax({
        url: "../../Controller/Controller_mat_orden_matenimiento.php",
        type: "POST",
        data: parametros,
        success: function (option) {
            $("#txt_categoria").html(option);
        }
    });
}