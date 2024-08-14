/*=============================================
VALIDAR EXISTENCIA RESERVA
=============================================*/
function validar_reserva() 
{
        
    var txt_cliente = $("#txt_cliente").val();

    var value = {
        txt_cliente     : txt_cliente,
        txt_option      : '14'
    };
    $.ajax(
        {
            url: "../../Controller/Controller_rv_registro.php",
            type: "POST",
            data: value,
            beforeSend: function () {
                AlertaEspera('esperando');
            },
            success: function (data, textStatus, jqXHR) {
                var data = jQuery.parseJSON(data);
                if (data.result > 0) {


                    Swal.fire({
                        title: "Posee reverva?",
                        text: "Cliente : " + txt_cliente + " posee reverva, cargarla?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si'
                      }).then((result) => {

                        if (result.isConfirmed) {
                          
                            window.location.href = 'http://179.49.8.237/pages/global/rv_consulta.php?txt_reserva='+data.oc_id;
                        }
                        else
                        {
                            AlertaExito('EXITO', 'EXITO');
                            $(this).val("");
                            $(this).attr("data","");
                            txt_cliente=0;
                            txt_cliente23=0;
                            txt_canalid= 0;
                            txt_subcanal= '';
                            txt_canal='';
                            $("#txt_canal").val('');
                            $("#txt_subcanal").val('');
                            $("#txt_cupodisponible").val('');
                            $("#txt_saldovencido").val('');
                            $("#txt_cliente").val('');
                        }
                      })
                }
                else {
                    AlertaExito('EXITO', 'EXITO');

                }
            }
        });
    
}

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
$("#txt_bodega").val('12');
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
BUSCADOS PREDICTIVO DE PRODUCTOS
=============================================*/
var bandera = true;
txt_cliente=0;
txt_cliente23=0;
txt_canalid=0;
txt_subcanalid = 0;
txt_canal='';
txt_subcanal='';
codigovendedor=0;
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
                            value6: item.cupo_disponible,
							value7: item.saldo_vencido,
                            value8: item.codigovendedor,
							value9: item.subcanal,
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
			txt_subcanalid= 0;
            txt_canal='';
            $("#txt_canal").val('');
            $("#txt_subcanal").val('');
        }
        else {
            $(this).val(ui.item.label);
            $(this).attr("data", ui.item.value);
            txt_cliente23 = ui.item.value5;            
            txt_cliente = ui.item.value;            
            txt_canalid= ui.item.value2;
			txt_subcanalid = ui.item.value9;
            txt_subcanal= ui.item.value3;
            txt_canal= ui.item.value4;
            xyzv= ui.item.value6;
			xyzv2= ui.item.value7;
            codigovendedor= ui.item.value8;
            $("#txt_canal").val(txt_canal);
            $("#txt_subcanal").val(txt_subcanal);
            $("#txt_cupodisponible").val(xyzv);
			$("#txt_saldovencido").val(xyzv2);

        }
    },
    focus: function (event, ui) {
        event.preventDefault();
        $(this).val(ui.item.label);
        $(this).attr("data", ui.item.value);
        txt_cliente23 = ui.item.value5;
        txt_cliente = ui.item.value;            
        txt_canalid= ui.item.value2;
		txt_subcanalid = ui.item.value9;
        txt_subcanal= ui.item.value3;
        txt_canal= ui.item.value4;
        xyzv= ui.item.value6;
		xyzv2= ui.item.value7;
        codigovendedor= ui.item.value8;
        $("#txt_canal").val(txt_canal);
        $("#txt_subcanal").val(txt_subcanal);
        $("#txt_cupodisponible").val(xyzv);
		$("#txt_saldovencido").val(xyzv2);
    },
});

$("#txt_cliente").on("dblclick", function () {
    $(this).val("");
    $(this).attr("data","");
    txt_cliente=0;
    txt_cliente23=0;
    txt_canalid= 0;
	txt_subcanalid = 0;
    txt_subcanal= '';
    txt_canal='';
    $("#txt_canal").val('');
    $("#txt_subcanal").val('');
    codigovendedor= 0;
    
});

function sleep(milliseconds) {
    const date = Date.now();
    let currentDate = null;
    do {
      currentDate = Date.now();
    } while (currentDate - date < milliseconds);
  }
  
/*=============================================
FUNCION OBTENER SECUENCIA DE CODIGO
=============================================*/
//secuencia_codigo();
function secuencia_codigo() {

	
    var value = {
        txt_option      : '1'
    };
    $.ajax(
        {
            url: "../../Controller/Controller_rv_registro.php",
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
        url: "../../Controller/Controller_rv_registro.php",
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
    var canal= txt_canalid;
    var subcanal= txt_subcanalid;
    var txt_pago= $('#txt_pago').val();
    
   /* if (canal!='OPEN MARKET' || canal!='RETAIL'  ){
        NotifiError('No existen registros para este canal');
        AlertaExito('EXITO', 'EXITO');
    } else {
*/
    var parametros = {
        "valor":valor,
        "txt_producto":txt_producto,
        "txt_cliente":txt_cliente,
        "txt_cliente2":txt_cliente23,
        "canal":canal,
        "subcanal":subcanal,
        "txt_pago":txt_pago,
        "txt_cantidad":1,
        "txt_option": "13"
    };
    $.ajax({
        url: "../../Controller/Controller_oc_registro.php",
        type: "POST",
        data: parametros,
        success: function (option) {
            var data = jQuery.parseJSON(option);
            if (data.precio>0){
                $("#txt_precio").val(data.precio);

            } else {
                NotifiError('No existen registros');
                AlertaExito('EXITO', 'EXITO');
             $("#txt_precio").val('');
            }

        }
    });

//}

}
    

function buscarprecio2(valor) {
    var canal= txt_canalid;
    var subcanal= txt_subcanalid;
    var txt_pago= $('#txt_pago').val();
    var txt_cantidad= $('#txt_cantidad').val();
    
   /* if (canal!='OPEN MARKET' || canal!='RETAIL'  ){
        NotifiError('No existen registros para este canal');
        AlertaExito('EXITO', 'EXITO');
    } else {
*/
    var parametros = {
        "valor":valor,
        "txt_producto":txt_producto,
        "txt_cliente":txt_cliente,
        "txt_cliente2":txt_cliente23,
        "canal":canal,
        "subcanal":subcanal,
        "txt_pago":txt_pago,
        "txt_cantidad":txt_cantidad,
        "txt_cantidad":1,
        "txt_option": "13"
    };
    $.ajax({
        url: "../../Controller/Controller_oc_registro.php",
        type: "POST",
        data: parametros,
        success: function (option) {
            var data = jQuery.parseJSON(option);
            if (data.precio>0){
                $("#txt_precio").val(data.precio);

            } else {
                NotifiError('No existen registros');
                AlertaExito('EXITO', 'EXITO');
             $("#txt_precio").val('');
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
            url: "../../Controller/Controller_rv_registro.php",
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
            url: "../../Controller/Controller_rv_registro.php",
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

$("#txt_producto").autocomplete({

    source: function (request, response) {

        if (bandera) {
            $.ajax({
                url: "../../Controller/Controller_rv_registro.php",
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

            txt_productofinal= '';
            $("#txt_cantidad").val("");
            $("#txt_precio").val("");

        }
        else {
            $(this).val(ui.item.label);
            $(this).attr("data", ui.item.value);
            txt_producto = ui.item.value;

            txt_productofinal= ui.item.id + ' - '+ui.item.text;
            
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
    $("#stock").val("");
    $("#txt_cantidad").val("");
    $("#txt_precio").val("");


});


/*=============================================
AGREGAR ITEM
=============================================*/
txt_total_venta =0;
$(document).on("click","#btn_agregra_item",function(){
    var cant =parseInt($('#txt_cantidad').val());
    var stock=parseInt($('#stock').val());
if ( cant > stock) {
    NotifiError("Por favor, ingrese la cantidad menor o igual a la disponible.");

} else {
    var comprobar = $('#txt_producto').val().length * $('#txt_cantidad').val().length ;
    if (comprobar > 0) {
    var value = {
        txt_option      : '5',
        txt_id          : txt_producto,
        txt_text        : $('#txt_producto').val(),
        txt_cantidad    : $('#txt_cantidad').val(),
        txt_precio      : $('#txt_precio').val(),

    };
    $.ajax(
        {
            url: "../../Controller/Controller_rv_registro.php",
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
                   // txt_total_venta = data.total;
                    //document.getElementById("total_venta").innerHTML = "<h3><strong>Total : $"+data.total+"</strong></h3>";
                    $('#txt_producto').val(''),
                    $('#txt_cantidad').val('');
                    txt_producto=0;
                    $("#stock").val("");
                    $("#txt_precio").val("");
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
		"autoWidth": false,
		"pageLength": 100,
		"ajax": {
			"url": "../../Controller/Controller_rv_registro.php",
			"data": parametros,
			"type": "POST"
		},
		"columns":
			[
				{ "data": "id" },
				{ "data": "item" },
                { "data": "cantidad" },
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
                url: "../../Controller/Controller_rv_registro.php",
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
                      /*
                        txt_total_venta = data.total;
                        document.getElementById("total_venta").innerHTML = "<h3><strong>Total : $"+data.total+"</strong></h3>";
                      */
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
			"url": "../../Controller/Controller_rv_registro.php",
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
                url: "../../Controller/Controller_rv_registro.php",
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
                url: "../../Controller/Controller_rv_registro.php",
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

    
    var comprobar = $('#txt_cliente').val().length  * $('#txt_fecha').val().length * $('#txt_pago').val().length;
    if (comprobar > 0) {
    // archivo para cargar
        var formData = new FormData();
        var files = $('#txt_adjunto')[0].files[0];
        formData.append('file0',files);
        valorimg ='no';  
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
    }
});
    
    var value = {
        txt_option        : '11',
        txt_codigo        : $('#txt_codigo').val(),
        txt_fecha         : $('#txt_fecha').val(),
        txt_cadena        : $('#txt_cliente').val(),
        txt_cliente:   txt_cliente,
        txt_codigovendedor:   codigovendedor,
        txt_pago          : $('#txt_pago').val(),
        txt_cupodisponible: $('#txt_cupodisponible').val(),
        txt_saldovencido: $('#txt_saldovencido').val(),
        txt_observaciones          : $('#txt_observaciones').val(),
        valorimg:valorimg,
    };
    $.ajax(
        {
            url: "../../Controller/Controller_rv_registro.php",
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
                    NotifiExito("Reserva creada!");
                 
                      sleep(2000);
                    if (data.error!='00'){
                        NotifiExito("Preventa creada #" + data.error);
                    } else {
                        NotifiError("Error al crear Preventa");
                    }
                 
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

       
        var txt_pago = document.getElementById("txt_pago").value;
        if (txt_pago == null || txt_pago.length == 0 || /^\s+$/.test(txt_pago)) {
           var msj2 = 'Seleccione pago!<br>';
           $("#txt_pago").focus();
        }

		
		 NotifiError(msj3+msj+msj2);
    }
    });




    
/*=============================================
BUSCADOS STOCK DE PRODUCTOS
=============================================*/
var bandera1 = true;
txt_stockproducto=0;

    function stock_productos() {
        
datos = $("#txt_producto").attr("data");
var txt_bodega = $("#txt_bodega").val();
//alert($("#txt_producto").data());
        if (bandera1) {
            $.ajax({
                url: "../../Controller/Controller_oc_registro.php",
                data: { term:  datos, txt_option: "12", txt_bodega: txt_bodega },
                dataType: "json",
                beforeSend: function () {
                 //   $('#loader').show();
                    AlertaEspera('Consultando Stock...');
                },
                success: function (json) {
                    //console.log(json[0]);
                   //console.log(json);
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





