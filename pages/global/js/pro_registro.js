txt_total_venta=0;
/*=============================================
CALENDARIO
=============================================*/
$(function () {

    $('[data-mask]').inputmask();
    $('#reservationdate').datetimepicker({
        format: 'DD-MM-YYYY'
    }
	);	 
});
/*=============================================
FUNCION OBTENER SECUENCIA DE CODIGO
=============================================*/
secuencia_codigo();
function secuencia_codigo() {

	
    var value = {
        txt_option      : '1'
    };
    $.ajax(
        {
            url: "../../Controller/Controller_pro_registro.php",
            type: "POST",
            data: value,
            beforeSend: function () {
                AlertaEspera('esperando');
            },
            success: function (data, textStatus, jqXHR) {
                var data = jQuery.parseJSON(data);
                if (data.result == 1) {

                    $("#txt_codigo").val(data.secuencia);
                    txt_total_venta = data.total;
                    document.getElementById("total_venta").innerHTML = "<h3><strong>Total : $"+data.total+"</strong></h3>";
                    AlertaExito('EXITO', 'EXITO');

                }
                else {
                    NotifiError(data.error);
                    AlertaExito('EXITO', 'EXITO');
                }
            }
        });
    
}


/*=============================================
CARGAR CADENAS
=============================================*/
cargar_cadenas();
function cargar_cadenas() {
    var parametros = {
        "txt_option": "2"
    };
    $.ajax({
        url: "../../Controller/Controller_pro_registro.php",
        type: "POST",
        data: parametros,
        success: function (option) {
            $("#txt_cadena").html(option);
        }
    });
}




/*=============================================
CARGAR TIENDAS 
=============================================*/
$(document).ready(function () {
    $("#txt_cadena").change(function () {
        $.ajax({
            url: "../../Controller/Controller_pro_registro.php",
            type: "POST",
            data: "txt_id=" + $("#txt_cadena").val()+"&txt_option=3",
            success: function (opciones) {
                $("#txt_tienda").html(opciones);
            }
        })
    });
});





/*=============================================
BUSCADOS PREDICTIVO DE PRODUCTOS
=============================================*/
var bandera = true;
txt_producto=0;
$("#txt_producto").autocomplete({

    source: function (request, response) {

        if (bandera) {
            $.ajax({
                url: "../../Controller/Controller_pro_registro.php",
                data: { term: request.term, txt_option: "4" },
                dataType: "json",
                beforeSend: function () {

                },
                success: function (json) {
                    response($.map(json.data, function (item) {
                        return {
                            label: item.text,
                            value: item.id,
                            data: item
                        }
                    }));
                },
            });
        }
        else {
            bandera = true;
        }

    },

    select: function (event, ui) {
        $(this).val("");
        event.preventDefault();
        if (ui.item.value == "0") {

        }
        else {
            $(this).val(ui.item.label);
            $(this).attr("data", ui.item.value);
            txt_producto = ui.item.value;

        }
    },
    focus: function (event, ui) {
        event.preventDefault();
        $(this).val(ui.item.label);
        $(this).attr("data", ui.item.value);
        txt_producto = ui.item.value;

    },
});

$("#txt_producto").on("dblclick", function () {
    $(this).val("");
    $(this).attr("data","");
    txt_producto=0;
 
    
});


/*=============================================
AGREGAR ITEM
=============================================*/
txt_total_venta =0;
$(document).on("click","#btn_agregra_item",function(){

    var comprobar = $('#txt_producto').val().length * $('#txt_precio').val().length * $('#txt_cantidad').val().length;
    if (comprobar > 0) {

    var value = {
        txt_option      : '5',
        txt_id          : txt_producto,
        txt_text        : $('#txt_producto').val(),
        txt_precio      : $('#txt_precio').val(),
        txt_cantidad    : $('#txt_cantidad').val()
    };
    $.ajax(
        {
            url: "../../Controller/Controller_pro_registro.php",
            type: "POST",
            data: value,
            beforeSend: function () {
                AlertaEspera('esperando');
            },
            success: function (data, textStatus, jqXHR) {
                var data = jQuery.parseJSON(data);
                if (data.result == 1) {

                   
                    AlertaExito('EXITO', 'EXITO');
                    var parametros =
                    {
                        "txt_option": '6',
                        "table": "#table_venta"

                    }
                    table_venta(parametros);
                    txt_total_venta = data.total;
                    document.getElementById("total_venta").innerHTML = "<h3><strong>Total : $"+data.total+"</strong></h3>";
                    $('#txt_producto').val(''),
                    $('#txt_precio').val(''),
                    $('#txt_cantidad').val('');
                    txt_producto=0;

                }
                else {
                    NotifiError(data.error);
                    AlertaExito('EXITO', 'EXITO');
                }
            }
        });
    }
    else {

        var  msj   = '';
        var  msj1  = '';


        if (txt_producto ==0) {
            var msj = 'Indique producto!<br>';
            $("#txt_producto").focus();
        }



        var txt_cantidad = document.getElementById("txt_cantidad").value;
        if (txt_cantidad == null || txt_cantidad.length == 0 || /^\s+$/.test(txt_cantidad)) {
           var msj1 = 'Indique cantidad!<br>';
           $("#txt_cantidad").focus();
        }
        var txt_precio = document.getElementById("txt_precio").value;
        if (txt_precio == null || txt_precio.length == 0 || /^\s+$/.test(txt_precio)) {
           var msj1 = 'Indique precio!<br>';
           $("#txt_precio").focus();
        }


		
		 NotifiError(msj+msj1);
    }
    });


/*=============================================
TABLE VENTA
=============================================*/
var parametros =
{
    "txt_option": '6',
    "table": "#table_venta"

}
table_venta(parametros);
function table_venta(parametros) {

	$(parametros.table).dataTable().fnDestroy();
	var dt = $(parametros.table).DataTable({
		"processing": true,
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"responsive": true,
		"autoWidth": false,
		"pageLength": 100,
		"ajax": {
			"url": "../../Controller/Controller_pro_registro.php",
			"data": parametros,
			"type": "POST"
		},
		"columns":
			[
				{ "data": "id" },
				{ "data": "item" },
                { "data": "cantidad" },
                { "data": "precio" },
                { "data": "total" },
                { "data": "button" },
			]
	});
}

/*=============================================
ELIMINAR ARTICULO
=============================================*/
$(document).on("click", ".btn_delete_item", function () {

    pr_id = $(this).attr("pr_id");
    pr_id_item = $(this).attr("pr_item");
        var value = {

            txt_id                     :pr_id,
            txt_id_item                :pr_id_item,
            txt_option                 : '10'
        };
        $.ajax(
            {
                url: "../../Controller/Controller_pro_registro.php",
                type: "POST",
                data: value,
                beforeSend: function () {
                    AlertaEspera('esperando');
                },
                success: function (data, textStatus, jqXHR) {
                    var data = jQuery.parseJSON(data);
                    if (data.result == 1) {

                        var parametros =
                        {
                            "txt_option": '6',
                            "table": "#table_venta"

                        }
                        table_venta(parametros);
                        txt_total_venta = data.total;
                        document.getElementById("total_venta").innerHTML = "<h3><strong>Total : $"+data.total+"</strong></h3>";
                        AlertaExito('EXITO', 'EXITO');
                    }
                    else {
                        NotifiError(data.error);
                        AlertaExito('EXITO', 'EXITO');
                    }
                }
            });


});

/*=============================================
CARGAR DATOS PRODUCTO IMEI
=============================================*/
pr_item_imei='';
pr_item_cantidad = 0;
$(document).on("click", ".btn_imei", function () {
    

         pr_item_imei = $(this).attr("pr_item");
        $("#txt_producto_imei").val($(this).attr("pr_descripcion"));
        pr_item_cantidad = $(this).attr("pr_cantidad");
        var parametros =
        {
            "txt_option": '7',
            "txt_id": pr_item_imei,
            "table": "#table_imeis"

        }
        table_imeis(parametros);

		$("#modal_imei").modal("show");
	});


function table_imeis(parametros) {

	$(parametros.table).dataTable().fnDestroy();
	var dt = $(parametros.table).DataTable({
		"processing": true,
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"responsive": true,
		"autoWidth": false,
		"pageLength": 100,
		"ajax": {
			"url": "../../Controller/Controller_pro_registro.php",
			"data": parametros,
			"type": "POST"
		},
		"columns":
			[
				{ "data": "id" },
				{ "data": "imei" },
                { "data": "button" },
			]
	});
}


/*=============================================
AGREGAR IMEI
=============================================*/
$(document).on("click", "#btn_agregra_imei", function () {

    var comprobar = $('#txt_imei').val().length;
    if (comprobar > 0) {

        document.getElementById('btn_agregra_imei').disabled = true;
        document.getElementById("loader").innerHTML = "<center><img src='../../img/gif-load.gif'></center>";
		$('#loader').show();
        var value = {

            txt_txt_imei               : $("#txt_imei").val(),
            txt_pr_item_imei           :pr_item_imei,
            txt_pr_item_cantidad       :pr_item_cantidad,
            txt_option                 : '8'
        };
        $.ajax(
            {
                url: "../../Controller/Controller_pro_registro.php",
                type: "POST",
                data: value,
                beforeSend: function () {
                    AlertaEspera('esperando');
                },
                success: function (data, textStatus, jqXHR) {
                    var data = jQuery.parseJSON(data);
                    if (data.result == 1) {


                        $("#txt_imei").val('');
                        var parametros =
                        {
                            "txt_option": '7',
                            "txt_id": pr_item_imei,
                            "table": "#table_imeis"

                        }
                        table_imeis(parametros);
                        var parametros =
                        {
                            "txt_option": '6',
                            "table": "#table_venta"

                        }
                        table_venta(parametros);
                        AlertaExito('EXITO', 'EXITO');
                        $('#loader').hide();
                        document.getElementById('btn_agregra_imei').disabled = false;
                    }
                    else {
                        NotifiError(data.error);
                        AlertaExito('EXITO', 'EXITO');
                        $("#txt_imei").focus();
                        $("#txt_imei").val('');
                        $('#loader').hide();
                        document.getElementById('btn_agregra_imei').disabled = false;
                    }
                }
            });

    }
    else {
        var  msj   = '';
        var txt_imei = document.getElementById("txt_imei").value;
        if (txt_imei == null || txt_imei.length == 0 || /^\s+$/.test(txt_imei)) {
            var msj = 'Indique imei!<br>';
            $("#txt_imei").focus();
        }
		NotifiError(msj); 
    } 
});



/*=============================================
ELIMINAR IMEI
=============================================*/
$(document).on("click", ".btn_delete_imei", function () {

    pr_id = $(this).attr("pr_id");
        var value = {

            txt_id                     :pr_id,
            txt_option                 : '9'
        };
        $.ajax(
            {
                url: "../../Controller/Controller_pro_registro.php",
                type: "POST",
                data: value,
                beforeSend: function () {
                    AlertaEspera('esperando');
                },
                success: function (data, textStatus, jqXHR) {
                    var data = jQuery.parseJSON(data);
                    if (data.result == 1) {


                        $("#txt_imei").val('');
                        var parametros =
                        {
                            "txt_option": '7',
                            "txt_id": pr_item_imei,
                            "table": "#table_imeis"

                        }
                        table_imeis(parametros);
                        var parametros =
                        {
                            "txt_option": '6',
                            "table": "#table_venta"

                        }
                        table_venta(parametros);
                        AlertaExito('EXITO', 'EXITO');
                    }
                    else {
                        NotifiError(data.error);
                        AlertaExito('EXITO', 'EXITO');
                    }
                }
            });


}); 



/*=============================================
GUARDAR VENTA
=============================================*/
$(document).on("click","#btn_crear_venta",function(){

    
    if (txt_total_venta ==0) {
        NotifiError("No hay venta cargada!");
        return false;
    }    
    var comprobar = $('#txt_cadena').val().length * $('#txt_tienda').val().length * $('#txt_fecha').val().length * $('#txt_pago').val().length;
    if (comprobar > 0) {

    var value = {
        txt_option        : '11',
        txt_codigo        : $('#txt_codigo').val(),
        txt_fecha         : $('#txt_fecha').val(),
        txt_cadena        : $('#txt_cadena').val(),
        txt_tienda        : $('#txt_tienda').val(),
        txt_pago          : $('#txt_pago').val(),
        txt_total         : txt_total_venta
    };
    $.ajax(
        {
            url: "../../Controller/Controller_pro_registro.php",
            type: "POST",
            data: value,
            beforeSend: function () {
                AlertaEspera('esperando');
            },
            success: function (data, textStatus, jqXHR) {
                var data = jQuery.parseJSON(data);
                if (data.result == 1) {

                   
                    AlertaExito('EXITO', 'EXITO');
                    var parametros =
                    {
                        "txt_option": '6',
                        "table": "#table_venta"

                    }
                    table_venta(parametros);

                    secuencia_codigo();
                    $('#txt_cadena').val('');
                    $('#txt_tienda').val('');
                    $('#txt_pago').val('');
                    txt_total_venta=0;
                    NotifiExito("Venta creada!");
                   // document.getElementById("total_venta").innerHTML = "<h3><strong>Total : $0.00</strong></h3>";

                }
                else {
                    NotifiError(data.error);
                    AlertaExito('EXITO', 'EXITO');
                }
            }
        });
    }
    else {


        if (txt_total_venta ==0) {
            NotifiError("No hay venta cargada!");
        }

        var  msj   = '';
        var  msj1  = '';
        var  msj2  = '';
        var  msj3  = '';
        var txt_fecha = document.getElementById("txt_fecha").value;
        if (txt_fecha == null || txt_fecha.length == 0 || /^\s+$/.test(txt_fecha)) {
           var msj3 = 'Idique fecha!<br>';
           $("#txt_fecha").focus();
        }

        var txt_cadena = document.getElementById("txt_cadena").value;
        if (txt_cadena == null || txt_cadena.length == 0 || /^\s+$/.test(txt_cadena)) {
           var msj = 'Seleccione cadena!<br>';
           $("#txt_cadena").focus();
        }
        var txt_tienda = document.getElementById("txt_tienda").value;
        if (txt_tienda == null || txt_tienda.length == 0 || /^\s+$/.test(txt_tienda)) {
           var msj1 = 'Seleccione tienda!<br>';
           $("#txt_tienda").focus();
        }
        var txt_pago = document.getElementById("txt_pago").value;
        if (txt_pago == null || txt_pago.length == 0 || /^\s+$/.test(txt_pago)) {
           var msj2 = 'Seleccione pago!<br>';
           $("#txt_pago").focus();
        }

		
		 NotifiError(msj3+msj+msj1+msj2);
    }
    });