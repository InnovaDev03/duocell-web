/*=============================================
CARGAR TIENDAS 
=============================================*/
cargar_bodegas();
function cargar_bodegas() {
    var parametros = {
        "txt_option": "16"
    };
    $.ajax({
        url: "../../Controller/Controller_rv_consulta.php",
        type: "POST",
        data: parametros,
        success: function (option) {
			$("#txt_bodega").html(option);
        }
    });
}

function contarCaracteres() {
    var textarea = document.getElementById('txt_observaciones');
    var contador = document.getElementById('contador');
    var maxLength = 200;
    
    // Contar los caracteres actuales
    var caracteresActuales = textarea.value.length;
    
    // Actualizar el contador visual
    contador.textContent = caracteresActuales + ' / ' + maxLength;
    
    // Prevenir que el usuario ingrese más de 200 caracteres
    if (caracteresActuales > maxLength) {
        textarea.value = textarea.value.substring(0, maxLength);
    }
}

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
            url: "../../Controller/Controller_oc_registro.php",
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
        url: "../../Controller/Controller_oc_registro.php",
        type: "POST",
        data: parametros,
        success: function (option) {
            $("#txt_cadena").html(option);
        }
    });
}





/*=============================================
CARGAR CADENAS
=============================================*/
function buscarprecio(valor) {
    var canal= $('#txt_canal').val();
    var subcanal= $('#txt_subcanal').val();
    var txt_pago= $('#txt_pago').val();
    //alert(txt_cliente2);
   /* if (canal!='OPEN MARKET' || canal!='RETAIL'  ){
        NotifiError('No existen registros para este canal');
        AlertaExito('EXITO', 'EXITO');
    } else {
*/
    var parametros = {
        "valor":valor,
        "txt_producto":txt_producto,
        "txt_cliente":txt_cliente,
        "txt_cliente2":txt_cliente2,
        "canal":canal,
        "subcanal":subcanal,
        "txt_pago":txt_pago,
        "txt_option": "13",
    	"txt_cantidad":1,
    };
    $.ajax({
        url: "../../Controller/Controller_oc_registro.php",
        type: "POST",
        data: parametros,
        success: function (option) {
            var data = jQuery.parseJSON(option);
            if (data.precio>0){
            $("#txt_cantidad").val(1);
                $("#txt_precio").val(data.precio);
				$("#txt_precio_oculto").val(data.precio);

            } else {
                NotifiError('No existen registros');
                AlertaExito('EXITO', 'EXITO');
            $("#txt_cantidad").val('0');
            	$("#txt_precio").val('');
				$("#txt_precio_oculto").val('');
            }

        }
    });

//}

}
    

function buscarprecio2(valor) {
    var canal= $('#txt_canal').val();
    var subcanal= $('#txt_subcanal').val();
    var txt_pago= $('#txt_pago').val();
    var txt_cantidad= $('#txt_cantidad').val();
    //alert(txt_cliente2);
   /* if (canal!='OPEN MARKET' || canal!='RETAIL'  ){
        NotifiError('No existen registros para este canal');
        AlertaExito('EXITO', 'EXITO');
    } else {
*/
    var parametros = {
        "valor":valor,
        "txt_producto":txt_producto,
        "txt_cliente":txt_cliente,
        "txt_cliente2":txt_cliente2,
        "canal":canal,
        "subcanal":subcanal,
        "txt_pago":txt_pago,
        "txt_cantidad":txt_cantidad,
        "txt_option": "13"
    };
    $.ajax({
        url: "../../Controller/Controller_oc_registro.php",
        type: "POST",
        data: parametros,
        success: function (option) {
            var data = jQuery.parseJSON(option);
            if (data.precio>0){
              //  $("#txt_cantidad").val(1);
                $("#txt_precio").val(data.precio);
				$("#txt_precio_oculto").val(data.precio);

            } else {
                NotifiError('No existen registros');
                AlertaExito('EXITO', 'EXITO');
            	$("#txt_precio").val('');
				$("#txt_precio_oculto").val('');
            }

        }
    });

//}

}

/*=============================================
CARGAR STOCK DEL PRODUCTO 
=============================================
*/
$(document).ready(function () {
    $("#txt_producto").change(function () {
        $.ajax({
            url: "../../Controller/Controller_oc_registro.php",
            type: "POST",
            data: "txt_id=" + $("#txt_producto").val()+"&txt_option=3",
            success: function (opciones) {
                $("#txt_tienda").val(opciones);
            }
        })
    });
});



/*=============================================
CARGAR TIENDAS 
=============================================
$(document).ready(function () {
    $("#txt_cadena").change(function () {
        $.ajax({
            url: "../../Controller/Controller_oc_registro.php",
            type: "POST",
            data: "txt_id=" + $("#txt_cadena").val()+"&txt_option=3",
            success: function (opciones) {
                $("#txt_tienda").html(opciones);
            }
        })
    });
});


*/


/*=============================================
BUSCADOS PREDICTIVO DE PRODUCTOS
=============================================*/
var bandera = true;
txt_producto=0;
txt_productofinal='';
txt_categoria = 0;
$("#txt_producto").autocomplete({

    source: function (request, response) {

        if (bandera) {
            $.ajax({
                url: "../../Controller/Controller_oc_registro.php",
                data: { term: request.term, txt_option: "4" },
                dataType: "json",
                beforeSend: function () {

                },
                success: function (json) {
                    response($.map(json.data, function (item) {
                        return {
                            label: item.text,
                            value: item.id,
                            categoria: item.categoria,
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

            txt_productofinal= '';
            $("#txt_cantidad").val("");
            $("#txt_precio").val("");

        }
        else {
            $(this).val(ui.item.label);
            $(this).attr("data", ui.item.value);
            txt_producto = ui.item.value;
            

            txt_productofinal= ui.item.id + ' - '+ui.item.text;
            txt_categoria = ui.item.categoria;
            
        }
    },
    focus: function (event, ui) {
        event.preventDefault();
        $(this).val(ui.item.label);
        $(this).attr("data", ui.item.value);
        txt_producto = ui.item.value;

        txt_productofinal= ui.item.id + ' - '+ui.item.text;
            
    },
});

$("#txt_producto").on("dblclick", function () {
    $(this).val("");
    $(this).attr("data","");
    txt_producto=0;
    txt_productofinal= '';
    txt_categoria = 0;
    $("#stock").val("");
    $("#txt_cantidad").val("");
    $("#txt_precio").val("");


});


/*=============================================
AGREGAR ITEM
=============================================*/
txt_total_venta =0;
$(document).on("click","#btn_agregra_item",function(){


		if(txt_categoria == '015' || txt_categoria == '027')
        {
			var cant =0;
			var stock=0;		
        }
        else
        {
			var cant =parseInt($('#txt_cantidad').val());
			var stock=parseInt($('#stock').val());
		}


if ( cant > stock) {
    NotifiError("Por favor, ingrese la cantidad menor o igual a la disponible.");

} else {


    if (txt_producto == 0 ) {
        NotifiError("Por favor, seleccione un producto!");
        return false;
    }

    var comprobar = $('#txt_producto').val().length * $('#txt_precio').val().length * $('#txt_cantidad').val().length
    if (comprobar > 0) {
if ($('#txt_descuento').val()>0){
var descuento = $('#txt_descuento').val();
} else {
descuento=0;
}
    var value = {
        txt_option        : '5',
        txt_id            : txt_producto,
        txt_text          : $('#txt_producto').val(),
        txt_precio        : $('#txt_precio').val(),
		txt_precio_oculto : $('#txt_precio_oculto').val(),
        txt_cantidad      : $('#txt_cantidad').val(),
        txt_direntrega    : $('#txt_direntrega').val(),
        txt_bodega    : $('#txt_bodega').val(),
        txt_descuento: descuento
    };
    $.ajax(
        {
            url: "../../Controller/Controller_oc_registro.php",
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
                    $('#txt_descuento').val('');
                    txt_producto=0;
                    $("#stock").val("");
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
		"autoWidth": true,
		"pageLength": 100,
		"ajax": {
			"url": "../../Controller/Controller_oc_registro.php",
			"data": parametros,
			"type": "POST"
		},
		"columns":
			[
				{ "data": "id" },
				{ "data": "item" },
                { "data": "cantidad" },
                { "data": "precio" },
                { "data": "dcto" },
                { "data": "pvp" },
                { "data": "dctoiva" },
                { "data": "iva" },
                { "data": "total" },
                { "data": "direccion_entrega" },

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
                url: "../../Controller/Controller_oc_registro.php",
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
			"url": "../../Controller/Controller_oc_registro.php",
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
                url: "../../Controller/Controller_oc_registro.php",
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
                url: "../../Controller/Controller_oc_registro.php",
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


    validarvendedor();


//VALIDAMS QUE LA FECHA SEA MAYOR O IGUAL QUE TODAY
let date = new Date();
let year = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(date);
let month = new Intl.DateTimeFormat('es', { month: '2-digit' }).format(date);
let day = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(date);
var fechaavalidar=(`${day}-${month}-${year}`);

if($('#txt_fecha').val()>=fechaavalidar){

} else {
    NotifiError("La fecha de la OC debe ser mayor o igual a la fecha actual!");
    return false;
}

if (txt_total_venta ==0) {
    NotifiError("No hay venta cargada!");
    return false;
}

if (txt_total_venta ==0) {
    NotifiError("No hay venta cargada!");
    return false;
}

//    * $('#txt_tienda').val().length
//    txt_tienda        : $('#txt_tienda').val(),


    var comprobar = $('#txt_cliente').val().length  * $('#txt_fecha').val().length * $('#txt_pago').val().length;
    if (comprobar > 0) {
    // archivo para cargar
        var formData = new FormData();
        var files = $('#txt_adjunto')[0].files[0];
        formData.append('file0',files);
          
$.ajax({
    url: 'upload2.php',
    type: 'post',
    data: formData,
    contentType: false,
    processData: false,
    success: function(response) {
        if (response != 0) {
             valorimg = response;
        } else {
            valorimg ='no';
        }

    var value = {
        txt_option        : '11',
        txt_codigo        : $('#txt_codigo').val(),
        txt_fecha         : $('#txt_fecha').val(),
        txt_cadena        : $('#txt_cliente').val(),
        txt_cliente2:    txt_cliente2,
        txt_pago          : $('#txt_pago').val(),
        txt_cupodisponible: $('#txt_cupodisponible').val(),
        txt_saldovencido: $('#txt_saldovencido').val(),
        txt_observaciones          : $('#txt_observaciones').val(),
        txt_bodega          : $('#txt_bodega').val(),
        txt_dias_credito          : $('#txt_dias_credito').val(),
        valorimg:valorimg,
        txt_total         : txt_total_venta
    };
    $.ajax(
        {
            url: "../../Controller/Controller_oc_registro.php",
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

                    //secuencia_codigo();
                    $('#txt_cadena').val('');
                    //$('#txt_tienda').val('');
                    $('#txt_pago').val('');
                    
                    txt_total_venta=0;
                    NotifiExito("Orden de Compra Registrada!");
                 
                   /*   sleep(2000);
                    if (data.error!='00'){
                        NotifiExito("Preventa creada #" + data.error);
                    } else {
                        NotifiError("Error al crear Preventa");
                    }
                 */
                   // document.getElementById("total_venta").innerHTML = "<h3><strong>Total : $0.00</strong></h3>";

                }
                else {
                    NotifiError(data.error);
                    AlertaExito('EXITO', 'EXITO');
                }
            }
        });
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

        var txt_cliente = document.getElementById("txt_cliente").value;
        if (txt_cliente == null || txt_cliente.length == 0 || /^\s+$/.test(txt_cliente)) {
           var msj = 'Seleccione cliente!<br>';
           $("#txt_cliente").focus();
        }
       /* var txt_tienda = document.getElementById("txt_tienda").value;
        if (txt_tienda == null || txt_tienda.length == 0 || /^\s+$/.test(txt_tienda)) {
           var msj1 = 'Seleccione tienda!<br>';
           $("#txt_tienda").focus();
        } */
        var txt_pago = document.getElementById("txt_pago").value;
        if (txt_pago == null || txt_pago.length == 0 || /^\s+$/.test(txt_pago)) {
           var msj2 = 'Seleccione pago!<br>';
           $("#txt_pago").focus();
        }

		
		 NotifiError(msj3+msj+msj2);
         AlertaExito('EXITO', 'EXITO');
    }
    });




    
/*=============================================
BUSCADOS STOCK DE PRODUCTOS
=============================================*/
var bandera1 = true;
txt_stockproducto=0;

    function stock_productos() {


        if(txt_categoria == '015' || txt_categoria == '027')
        {
            $("#stock").val('0');
        }
        else
        {
            datos = $("#txt_producto").attr("data");
            var txt_bodega = $("#txt_bodega").val();
            if (bandera1) {
                $.ajax({
                    url: "../../Controller/Controller_oc_registro.php",
                    data: { term: datos, txt_option: "12", txt_bodega: txt_bodega },
                    dataType: "json",
                    beforeSend: function () {
                        AlertaEspera('Consultando Stock...');
                    },
                    success: function (json) {
                        $("#stock").val(json);
                        $('#loader').hide();
                        AlertaExito('EXITO', 'EXITO');

                    },
                });
            }
            else {
                bandera = true;
            }
        }   
        


    }







    
/*=============================================
BUSCADOS PREDICTIVO DE PRODUCTOS
=============================================*/
var bandera = true;
txt_cliente=0;
txt_cliente2=0;
txtclienteid=0;
txt_canalid=0;
txt_canal='';
txt_subcanal='';
var codigovendedor='';
$("#txt_cliente").autocomplete({

    source: function (request, response) {

        if (bandera) {
            $.ajax({
                url: "../../Controller/Controller_mer_registro.php",
                data: { term: request.term, txt_option: "12" },
                dataType: "json",
                beforeSend: function () {

                },
                success: function (json) {
                    response($.map(json.data, function (item) {
                        return {
                            label: item.text,
                            value: item.id,
                            value2: item.canal,
                            value3: item.subcanalnombre,
                            value4: item.canalnombre,
                            value5: item.codigocliente,
                            value7: item.codigovendedor,
                            value8: item.cupo_disponible,
							value9: item.saldo_vencido,
                            value10: item.dias_credito,
                            value11: item.subcanal,
                            value12: item.canalnombre,
                            value13: item.subcanalnombre,
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
            txt_canalid= 0;
            txt_subcanal= '';
            codigovendedor= '';
            txt_canal='';
            $("#txt_canal").val('');
            $("#txt_subcanal").val('');

            $("#txt_canalnombre").val('');
            $("#txt_subcanalnombre").val('');
        }
        else {
            $(this).val(ui.item.label);
            $(this).attr("data", ui.item.value);
            txt_cliente2 = ui.item.value5;            
            txt_cliente = ui.item.value;            
            txt_canalid= ui.item.value2;
            txt_subcanal= ui.item.value11;
            codigovendedor = ui.item.value7;            
            txt_canal= ui.item.value2;
            xyzv= ui.item.value8;
			xyzv2= ui.item.value9;
            dias= ui.item.value10;

            txt_canalnombre= ui.item.value12;
            txt_subcanalnombre= ui.item.value13;
            $("#txt_canalnombre").val(txt_canalnombre);
            $("#txt_subcanalnombre").val(txt_subcanalnombre);
            
            $("#txt_canal").val(txt_canal);
            $("#txt_cupodisponible").val(xyzv);
			$("#txt_saldovencido").val(xyzv2);
            $("#txt_subcanal").val(txt_subcanal);
            $("#txt_dias_credito").val(dias);
            vaciar_venta();

        }
    },
    focus: function (event, ui) {
        event.preventDefault();
        $(this).val(ui.item.label);
        $(this).attr("data", ui.item.value);
        txt_cliente2 = ui.item.value5;
        codigovendedor = ui.item.value7;            
        txt_cliente = ui.item.value;            
        txt_canalid= ui.item.value2;
        txt_subcanal= ui.item.value11;
        txt_canal= ui.item.value2;
        xyzv= ui.item.value8;
		xyzv2= ui.item.value9;
        dias= ui.item.value10;

        txt_canalnombre= ui.item.value12;
        txt_subcanalnombre= ui.item.value13;
        $("#txt_canalnombre").val(txt_canalnombre);
        $("#txt_subcanalnombre").val(txt_subcanalnombre);

        $("#txt_canal").val(txt_canal);
        $("#txt_cupodisponible").val(xyzv);
		$("#txt_saldovencido").val(xyzv2);
        $("#txt_subcanal").val(txt_subcanal);
        $("#txt_dias_credito").val(dias);
        vaciar_venta();
    },
});

$("#txt_cliente").on("dblclick", function () {
    $(this).val("");
    $(this).attr("data","");
    txt_cliente=0;
    txt_cliente2=0;
    txt_canalid= 0;
    txt_subcanal= '';
    codigovendedor ='';            
    txt_canal='';
    $("#txt_canal").val('');
    $("#txt_subcanal").val('');
    $("#txt_dias_credito").val('');
    $("#txt_canalnombre").val('');
    $("#txt_subcanalnombre").val('');
    vaciar_venta();
});




function vaciar_venta(){
    var value = {

        txt_option                 : '15'
    };
    $.ajax(
        {
            url: "../../Controller/Controller_oc_registro.php",
            type: "POST",
            data: value,
            beforeSend: function () {
                //AlertaEspera('esperando');
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

                } else if (data.result == 3) {
                    AlertaExito('EXITO', 'EXITO');
                    return false;
                }
            }
        });

}

function sleep(milliseconds) {
    const date = Date.now();
    let currentDate = null;
    do {
      currentDate = Date.now();
    } while (currentDate - date < milliseconds);
  }
  


  function validarvendedor(){
        var value = {

            txt_id                     :codigovendedor,
            abc:'3',
            txt_option                 : '14'
        };
        $.ajax(
            {
                url: "../../Controller/Controller_oc_registro.php",
                type: "POST",
                data: value,
                beforeSend: function () {
                    AlertaEspera('esperando');
                },
                success: function (data, textStatus, jqXHR) {
                    var data = jQuery.parseJSON(data);
                    if (data.result == 1) {
                       // NotifiExito("es 1, no es vendedor");

                    } else if (data.result == 3) {
                        NotifiError("No tiene autorización como vendedor.");
                        AlertaExito('EXITO', 'EXITO');

                        return false;
                                        } else if (data.result == 2) {
                       // NotifiError(" tiene autorización  vendedor.");
                        //AlertaExito('EXITO', 'EXITO');
                    }
                }
            });

  }