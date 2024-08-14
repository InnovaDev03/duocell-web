/*=============================================
CALENDARIO
=============================================*/
$(function () {

    $('[data-mask]').inputmask();
    $('#fechaindate1').datetimepicker({
        format: 'DD-MM-YYYY'
    }
	);	

    $('#fechafindate1').datetimepicker({
        format: 'DD-MM-YYYY'
    }
	);
    
    
   
    
});


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
CARGAR ESTADOS
=============================================*/
cargar_estados();
function cargar_estados() {
    var parametros = {
        "txt_option": "4"
    };
    $.ajax({
        url: "../../Controller/Controller_oc_consulta.php",
        type: "POST",
        data: parametros,
        success: function (option) {
            $("#txt_estado").html(option);
        }
    });
}



/*=============================================
CARGAR TIENDAS 
=============================================*/
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


/*=============================================
BUSCADOS PREDICTIVO DE PROMOTOR
=============================================*/
var bandera = true;
txt_promotor=0;
$("#txt_promotor").autocomplete({

    source: function (request, response) {

        if (bandera) {
            $.ajax({
                url: "../../Controller/Controller_oc_consulta.php",
                data: { term: request.term, txt_option: "1" },
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
            txt_promotor = ui.item.value;

        }
    },
    focus: function (event, ui) {
        event.preventDefault();
        $(this).val(ui.item.label);
        $(this).attr("data", ui.item.value);
        txt_promotor = ui.item.value;

    },
});

$("#txt_promotor").on("dblclick", function () {
    $(this).val("");
    $(this).attr("data","");
    txt_promotor='';
});


/*=============================================
BUSCAR TAREA
=============================================*/ 
$(document).on("click","#btn_buscar",function(){
 
   // var txt_promotorb  = txt_promotor;
    var txt_fechain    =  $("#fechain").val();
    if(txt_fechain == '')
    {
        txt_fechain = '';
    }
    else
    {
        txt_fechain = $("#fechain").val();
    }
    
    
    var txt_fechafin  =  $("#fechafin").val();
    if(txt_fechafin == '')
    {
        txt_fechafin = '';
    }
    else
    {
        txt_fechafin = $("#fechafin").val();
    }
    
    
    var txt_cadena = $("#txt_cliente").val();
    var txt_estado = $("#txt_estado").val();
    var txt_pagoC = $("#txt_pagoC").val();

    var txt_promotor = $("#txt_promotor").attr("data");
  
    var parametros =
    {
        "txt_option"      : '2',
        "table"           : "#table_ventas",
        "txt_fechain"     : txt_fechain,
        "txt_fechafin"    : txt_fechafin,
        "txt_promotor"    : txt_promotor,
        "txt_cadena"      : txt_cadena,
        "txt_tienda"      : '',
        "txt_estado"      : txt_estado,
        "txt_pagoC"       : txt_pagoC,
    }
    
    table_ventas(parametros);
    
});


var txt_fechain    =  $("#fechain").val();
var txt_fechafin  =  $("#fechafin").val();
var parametros =
{
    "txt_option"          : '2',
        "table"           : "#table_ventas",
        "txt_fechain"     : txt_fechain,
        "txt_fechafin"    : txt_fechafin,
        "txt_promotor"    : '',
        "txt_cadena"      : '',
        "txt_tienda"      : '',
        "txt_estado"    : '',
}
table_ventas(parametros);

function table_ventas(parametros) {

$(parametros.table).dataTable().fnDestroy();
var dt = $(parametros.table).DataTable({                    
    "bProcessing": true,
    "serverSide": true,
    "paging": true,
    "lengthChange": true,
    "searching": false,
    "ordering": false,
    "info": false,
    "responsive": true,
    "autoWidth": true,
  "iDisplayLength":	500,
"buttons": [ 'copy', 'csv', 'excel', 'pdf', 'print' ],
   "ajax": {
    "url": "../../Controller/Controller_oc_consulta.php", 
     "type": "POST",
     "data": parametros,
   },
   "columns":
        [
            { "data": "oc_fecha" },
            { "data": "numoc" },
            { "data": "vendedor" },
            { "data": "cliente" },
            { "data": "oc_estatus2" },
            { "data": "forma_pago" },
            { "data": "total" },
            { "data": "factura" },
            { "data": "button" },
        ],
 }); 	
}
/* ITEMS DE TABLE_VENTAS REMOVED
{ "data": "item" },
{ "data": "cantidad" },
{ "data": "precio" },
*/

/*=============================================
MOSTRAR ITEM IMEI
=============================================*/
pr_id='';
$(document).on("click", ".btn_imei", function () {
    


        $("#txt_venta").val($(this).attr("pr_codigo"));
        pr_id  = $(this).attr("pr_id");
        var parametros =
        {
            "txt_option": '3',
            "txt_id": pr_id,
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
                "url": "../../Controller/Controller_oc_consulta.php",
                "data": parametros,
                "type": "POST"
            },
            "columns":
                [
                    { "data": "id" },
                    { "data": "producto" },
                    { "data": "imei" },
                ]
        });
    }


function cambiar1(){
    $('#claseoriginal')
    .removeClass('col-lg-12')
    .addClass('col-lg-9')
}

function cambiar2(){
    $('#claseoriginal')
    .removeClass('col-lg-9')
    .addClass('col-lg-12')
}
/*=============================================
EDIT ESTADO
=============================================*/
id_guia2 ='';
$(document).on("click", ".btn_edit_estado", function () {
var id = $(this).attr("log_id");
var tipo = $(this).attr("tipo");

if (tipo==2){ 

    id_guia2 = $(this).attr("oc_id");
    $("#aprobacion_orden").val($(this).attr("orden"));
    $("#aprobacion_orden_cliente").val($(this).attr("cliente"));
    $("#modal_aprobacion_orden").modal('show'); 


    

} else {

    var value = {
        txt_id_edit    :  id,
        txt_obs_gerencia:'',
        tipo:1,
        valorimgf:'NOTIENE',
        txt_option            : '5'
    };
    $.ajax(
        {
            url: "../../Controller/Controller_oc_consulta.php",
            type: "POST",
            data: value,
            beforeSend: function () {
                AlertaEspera('esperando');
            },
            success: function (data, textStatus, jqXHR) {
              
                  
var txt_fechain    =  $("#fechain").val();
var txt_fechafin  =  $("#fechafin").val();
var parametros =
{
    "txt_option"          : '2',
        "table"           : "#table_ventas",
        "txt_fechain"     : txt_fechain,
        "txt_fechafin"    : txt_fechafin,
        "txt_promotor"    : '',
        "txt_cadena"      : '',
        "txt_tienda"      : '',
        "txt_estado"    : '',
}
table_ventas(parametros);

                    AlertaExito('EXITO', 'EXITO');
                    NotifiExito('Orden de Compra Aprobada con exito!');
                  
}

        });

    }
});



/*=============================================
EDIT ESTADO COBRANZA
=============================================*/

$(document).on("click", ".btn_edit_estado_bodega", function () {
    var id = $(this).attr("log_id");
    var tipo = $(this).attr("tipo");
    
        var value = {
            txt_id_edit    :  id,
            txt_obs_gerencia:'',
            tipo:tipo,
            valorimgf:'NOTIENE',
            txt_option            : '14'
        };
        $.ajax(
            {
                url: "../../Controller/Controller_oc_consulta.php",
                type: "POST",
                data: value,
                beforeSend: function () {
                    AlertaEspera('esperando');
                },
                success: function (data, textStatus, jqXHR) {
                  
                      
    var txt_fechain    =  $("#fechain").val();
    var txt_fechafin  =  $("#fechafin").val();
    var parametros =
    {
        "txt_option"          : '2',
            "table"           : "#table_ventas",
            "txt_fechain"     : txt_fechain,
            "txt_fechafin"    : txt_fechafin,
            "txt_promotor"    : '',
            "txt_cadena"      : '',
            "txt_tienda"      : '',
            "txt_estado"    : '',
    }
    table_ventas(parametros);
    
                        AlertaExito('EXITO', 'EXITO');
                        NotifiExito('Orden de Compra Aprobada con exito!');
                      
    }
    
            });
    
        
    });

$(document).on("click", "#btn_aprobar_gerencia", function () {


    //cargamos archivo
    var formData = new FormData();

        var files = $('#image')[0].files[0];
        formData.append('file0',files);
    formData.append('cantidad',1);

    $.ajax({
        url: 'upload2.php',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response != 0) {
                 valorimg = response;
                
    var txt_obs_gerencia    =  $("#txt_obs_gerencia").val();

    var value = {
        txt_id_edit    :  id,
        txt_obs_gerencia:txt_obs_gerencia,
        tipo:tipo,
        valorimgf:valorimg,
        txt_option            : '5'
    };
    $.ajax(
        {
            url: "../../Controller/Controller_oc_consulta.php",
            type: "POST",
            data: value,
            beforeSend: function () {
                AlertaEspera('esperando');
            },
            success: function (data, textStatus, jqXHR) {
              
                  
var txt_fechain    =  $("#fechain").val();
var txt_fechafin  =  $("#fechafin").val();
var parametros =
{
    "txt_option"          : '2',
        "table"           : "#table_ventas",
        "txt_fechain"     : txt_fechain,
        "txt_fechafin"    : txt_fechafin,
        "txt_promotor"    : '',
        "txt_cadena"      : '',
        "txt_tienda"      : '',
        "txt_estado"    : '',
}
table_ventas(parametros);

                    AlertaExito('EXITO', 'EXITO');
                    NotifiExito('Orden de Compra Aprobada por Gerencia con exito!');
                  
               
           // }
        //});

}
});

                 var xyz = valorimg;
              


            } else {
            
                 valorimg = 'NOAPLICA';
                
    var txt_obs_gerencia    =  $("#txt_obs_gerencia").val();

    var value = {
        txt_id_edit    :  id,
        txt_obs_gerencia:txt_obs_gerencia,
        tipo:tipo,
        valorimgf:valorimg,
        txt_option            : '5'
    };
    $.ajax(
        {
            url: "../../Controller/Controller_oc_consulta.php",
            type: "POST",
            data: value,
            beforeSend: function () {
                AlertaEspera('esperando');
            },
            success: function (data, textStatus, jqXHR) {
              
                  
var txt_fechain    =  $("#fechain").val();
var txt_fechafin  =  $("#fechafin").val();
var parametros =
{
    "txt_option"          : '2',
        "table"           : "#table_ventas",
        "txt_fechain"     : txt_fechain,
        "txt_fechafin"    : txt_fechafin,
        "txt_promotor"    : '',
        "txt_cadena"      : '',
        "txt_tienda"      : '',
        "txt_estado"    : '',
}
table_ventas(parametros);

                    AlertaExito('EXITO', 'EXITO');
                    NotifiExito('Orden de Compra Aprobada por Gerencia con exito!');
                  
               
           // }
        //});

}
});

                 var xyz = valorimg;
              


            }
        }
    });



    $("#txt_obs_gerencia").val('');
    $("#image").val('');
    
    $("#modal_editar_orden").modal('hide'); 
    


});





/*=============================================
	DELETE ESTACION
	=============================================*/
	$(document).on("click", ".btn_delete_sistema", function () {


		var  mt_id     = $(this).attr("mt_id");
        var  mt_nombre     = $(this).attr("mt_nombre")

		Swal.fire({
			title: "Desea eliminar la Orden de Compra?",
			text: "Orden de Compra a eliminar: #" + $(this).attr("mt_nombre"),
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si'
		  }).then((result) => {

			if (result.isConfirmed) {
			  
				var value = {
					txt_id     : mt_id,
					txt_nombre : mt_nombre,
					txt_option : '6'
				};
				$.ajax(
					{
                        url: "../../Controller/Controller_oc_consulta.php",
						type: "POST",
						data: value,
						beforeSend: function () {
							AlertaEspera('esperando');
						},
						success: function (data, textStatus, jqXHR) {
							var data = jQuery.parseJSON(data);
							if (data.result == 1) {

                                     
var txt_fechain    =  $("#fechain").val();
var txt_fechafin  =  $("#fechafin").val();
var parametros =
{
    "txt_option"          : '2',
        "table"           : "#table_ventas",
        "txt_fechain"     : txt_fechain,
        "txt_fechafin"    : txt_fechafin,
        "txt_promotor"    : '',
        "txt_cadena"      : '',
        "txt_tienda"      : '',
        "txt_estado"    : '',
}
table_ventas(parametros);
                               
								AlertaExito('EXITO', 'EXITO');
								NotifiExito('Orden de Compra eliminada!');
							}
							else {
								NotifiError(data.error);
								AlertaExito('EXITO', 'EXITO');
							}
						}
					});

			}
		  })
	});




    
/*=============================================
MODAL EDITAR
=============================================*/
var idcli ='';
var idmensa='';
var idruta ='';
var id_guia = '';
$("#table_ventas tbody").on("click","button.btn_ver_items",function(e)
{
    document.getElementById('divitems').style.display = 'inherit'; 
    document.getElementById('aprobargerenciadiv').style.display = 'none'; 
    
    document.getElementById('tablaoculta').style.display = 'inherit'; 

    document.getElementById('formapagodiv').style.display = 'inherit'; 

    id_guia = $(this).attr("log_id");
    $("#txt_codigo").val($(this).attr("numoc"));
    //$("#txt_cliente").val($(this).attr("cliente"));
    $("#clientever").val($(this).attr("cliente"));
    
    $("#txt_fecha").val($(this).attr("oc_fecha"));
    $("#txt_observaciones").val($(this).attr("oc_observaciones"));
    $("#txt_pago").val($(this).attr("forma_pago"));
document.getElementById('total_venta').innerHTML ="<h3><strong>Total : $"+$(this).attr("total")+"</strong></h3>";
    var parametros =
    {
        "txt_option": '7',
        "ordencompra":id_guia,
        "table": "#table_venta"
    
    }
    table_venta(parametros);

if ($(this).attr("dato")==1){
} else {
    document.getElementById('btn_agregra_item').disabled = true; 
}
    $("#modal_editar_orden").modal('show'); 
   /*
    cargar_cliente_edit();
   // cargar_servicio_edit();
    cargar_productor_edit();
    cargar_hacienda_edit();
    cargar_zona_edit();
    cargar_marcacaja_edit();

    $("#txt_cupo_edit").val($(this).attr("cupo"));
    $("#txt_semanaexpo_req_edit").val($(this).attr("semana_exportadora"));

    $("#txt_sticker_edit").val($(this).attr("sticker"));
    $("#txt_peso_edit").val($(this).attr("peso"));
    $("#txt_tipo_req_edit").val($(this).attr("tipo"));

 idcli = $(this).attr("id_cliente");
 idmensa=$(this).attr("id_mensajero_number");
 id_productor_number=$(this).attr("id_productor_number");
 id_hacienda_number=$(this).attr("id_hacienda_number");
 id_zona=$(this).attr("id_zona");
 id_marcacaja=$(this).attr("id_marcacaja");
 //id_servicio_number=$(this).attr("id_servicio_number");

    setTimeout(cargarcli_edit, 1000);
    setTimeout(cargarproduc_edit, 1000);
    setTimeout(cargarhacienda_edit, 1000);
    setTimeout(cargarzona_edit, 1000);
    setTimeout(cargarmarcacajas_edit, 1000);

    /*
    $.ajax({
        url: "../../Controller/Controller_requerimientos.php",
        type: "POST",
        data: "id_cliente=" + idcli+"&txt_option=24",
        success: function (opciones) {
            $("#txt_servicio_edit").html(opciones);
            //$('#txt_servicio_edit').select2();  
        //document.getElementById('txt_servicio_edit').style.height = '400px';
        }
    });
    */

  ///  setTimeout(cargarservicio_edit, 1000);

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
    
    $("#stock").val("");

 
    
});




/*=============================================
BUSCADOS STOCK DE PRODUCTOS
=============================================*/
var bandera1 = true;
txt_stockproducto=0;

    function stock_productos() {
        
datos = $("#txt_producto").attr("data");
//alert($("#txt_producto").data());
        if (bandera1) {
            $.ajax({
                url: "../../Controller/Controller_oc_registro.php",
                data: { term:  datos, txt_option: "12" },
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




    
/*=============================================
TABLE VENTA
=============================================*/

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
			"url": "../../Controller/Controller_oc_consulta.php",
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
                { "data": "button" },
			]
	});
}




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
    var comprobar = $('#txt_producto').val().length * $('#txt_precio').val().length * $('#txt_cantidad').val().length * $('#txt_direntrega').val().length;
    if (comprobar > 0) {
if ($('#txt_descuento').val()>0){
var descuento = $('#txt_descuento').val();
} else {
descuento=0;
}
    var value = {
        txt_option      : '8',
        txt_id          : txt_producto,
        txt_text        : $('#txt_producto').val(),
        txt_precio      : $('#txt_precio').val(),
        txt_cantidad    : $('#txt_cantidad').val(),
        txt_direntrega    : $('#txt_direntrega').val(),
        txt_descuento: descuento,
        id_guia: id_guia
    };
    $.ajax(
        {
            url: "../../Controller/Controller_oc_consulta.php",
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
        "txt_option": '7',
        "ordencompra":id_guia,
        "table": "#table_venta"
    
    }
    table_venta(parametros);
                    txt_total_venta = data.total;
                    document.getElementById("total_venta").innerHTML = "<h3><strong>Total : $"+data.total+"</strong></h3>";
                    $('#txt_producto').val(''),
                    $('#txt_precio').val(''),
                    $('#txt_cantidad').val('');
                    $('#txt_descuento').val('');
                    $('#txt_direntrega').val(''),

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
ELIMINAR ARTICULO
=============================================*/
$(document).on("click", ".btn_delete_item", function () {

    pr_id = $(this).attr("pr_id");
    pr_id_item = $(this).attr("pr_item");
    id_ordencompra = $(this).attr("id_ordencompra");

    var value = {

            txt_id                     :pr_id,
            id_ordencompra                :id_ordencompra,
            txt_id_item                :pr_id_item,
            txt_option                 : '10'
        };
        $.ajax(
            {
                url: "../../Controller/Controller_oc_consulta.php",
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
                            "txt_option": '7',
                            "ordencompra":id_guia,
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
BUSCADOS PREDICTIVO DE CLIENTES
=============================================*/
var bandera = true;
txt_cliente=0;
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
            txt_cliente = ui.item.value;

        }
    },
    focus: function (event, ui) {
        event.preventDefault();
        $(this).val(ui.item.label);
        $(this).attr("data", ui.item.value);
        txt_cliente = ui.item.value;

    },
});

$("#txt_cliente").on("dblclick", function () {
    $(this).val("");
    $(this).attr("data","");
    txt_cliente=0;
 
    
});

    




/*=============================================
EDIT USER
=============================================*/

$(document).on("click", ".btn_edit_cantidad", function () {
    var pr_id = $(this).attr("pr_id");
    var id_ordencompra = $(this).attr("id_ordencompra");
    var precio = $(this).attr("precio");
    var descuento = $(this).attr("descuento");
    
    var cantidad = $("#cantidadnueva"+pr_id).val();
        var value = {
            txt_id_edit    :  pr_id,
            precio    :  precio,
            id_ordencompra:id_ordencompra,
            cantidad    :  cantidad,
            descuento:descuento,
            txt_option            : '13'
        };
        $.ajax(
            {
                url: "../../Controller/Controller_oc_consulta.php",
                type: "POST",
                data: value,
                beforeSend: function () {
                    AlertaEspera('esperando');
                },
                success: function (data, textStatus, jqXHR) {
                    var data = jQuery.parseJSON(data);
                  
                    var parametros =
                    {
                        "txt_option": '7',
                        "ordencompra":id_guia,
                        "table": "#table_venta"
                    
                    }

                    table_venta(parametros);
                    txt_total_venta = data.total;
                    document.getElementById("total_venta").innerHTML = "<h3><strong>Total : $"+data.error+"</strong></h3>";
                  
                        AlertaExito('EXITO', 'EXITO');
                        NotifiExito('Item editado con exito!');
                      
                   
               // }
            //});
    
    
    
    
    }
    });
    
    
    
    });



    /*=============================================
MODAL BITACORA DE RESERVA
=============================================*/
id_reserva = '';
producto   = '';
$("#table_ventas tbody").on("click","button.btn_ver_bitacora",function(e)
{
    id_reserva = $(this).attr("id_order");
    producto = $(this).attr("orden");
    $("#producto_reserva").val(producto);
    var parametros =
    {
        "txt_option": '15',
        "txt_id_reserva":id_reserva,
        "table": "#table_reserva_bitacora"
    
    }
    table_reserva_bitacora(parametros);
    $("#modal_reserva_bitacora").modal('show'); 


});


/*=============================================
TABLE BITACORA RESERVA
=============================================*/

function table_reserva_bitacora(parametros) {

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
			"url": "../../Controller/Controller_oc_consulta.php",
			"data": parametros,
			"type": "POST"
		},
		"columns":
			[
				{ "data": "id" },
				{ "data": "accion" },
                { "data": "observacion" },
                { "data": "usuario" },
                { "data": "fecha" },
			]
	});
}
    

$(document).on("click", "#btn_aprobar_estado", function () {
				
    

    var txt_estado_orden = $("#txt_estado_orden"+pr_id).val();
    var txt_observaciones_orden = $("#txt_observaciones_orden"+pr_id).val();
    var value = {
        txt_id  :  id_guia2,
        txt_estado_orden  :  txt_estado_orden,
        txt_observaciones_orden  :  txt_observaciones_orden,
        txt_option            : '16'
    };
    $.ajax(
        {
            url: "../../Controller/Controller_oc_consulta.php",
            type: "POST",
            data: value,
            beforeSend: function () {
                AlertaEspera('esperando');
            },
            success: function (data, textStatus, jqXHR) {
                var data = jQuery.parseJSON(data);
              
                var txt_fechain    =  $("#fechain").val();
                var txt_fechafin  =  $("#fechafin").val();
                var parametros =
                {
                    "txt_option"          : '2',
                        "table"           : "#table_ventas",
                        "txt_fechain"     : txt_fechain,
                        "txt_fechafin"    : txt_fechafin,
                        "txt_promotor"    : '',
                        "txt_cadena"      : '',
                        "txt_tienda"      : '',
                        "txt_estado"    : '',
                }
                table_ventas(parametros);
                $("#modal_reserva_bitacora").modal('hide'); 
                 AlertaExito('EXITO', 'EXITO');
                NotifiExito('Estado aplicado!');
                

}
});
						 
});


factura ='';
$("#table_ventas tbody").on("click", "button.btn_descargar_ride", function(e) {
    e.preventDefault();
    
    var factura = $(this).attr("factura");

    var value = {
        txt_option: '17',
        txt_factura: factura
    };
    
    $.ajax({
        url: "../../Controller/Controller_oc_consulta.php",
        type: "POST",
        data: value,
        xhrFields: {
            responseType: 'blob'
        },
        beforeSend: function() {
            // Puedes mostrar una alerta o un loader aquí si lo deseas
        },
        success: function(data, textStatus, jqXHR) {
            if (jqXHR.status == 200) {
                var blob = new Blob([data], { type: 'application/pdf' });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "FACTURA" + factura + ".pdf";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else {
                NotifiError('Error al descargar el archivo.');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            NotifiError('Error en la solicitud: ' + textStatus);
        }
    });
});  