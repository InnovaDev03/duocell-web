
console.log("ACTUALIZACION");
txt_subcanal= '';
txt_canal= '';
txt_cliente = ''; 
txt_cliente2 = ''; 
/*
simularTeclas();
function simularTeclas() {
    const event = new KeyboardEvent('keydown', {
      key: 's',
      ctrlKey: true,
      shiftKey: true
    });
    document.dispatchEvent(event);
    NotifiExito("Cache navedor borrada!!");
  }
buscar_reserva();
*/
var id_guia = '';
canal2 = '';
subcanal2 = '';
txt_cliente22 = '';
txt_cliente2=''
dias =0;

buscar_reserva();
function buscar_reserva() {
	
	    var txt_reserva = $("#txt_reserva").val();
		

		if(txt_reserva != '')
		{
			var id_guia = txt_reserva; 
			var value = {
				txt_reserva     : txt_reserva,
				txt_option      : '17'
			};
			$.ajax(
				{
					url: "../../Controller/Controller_rv_consulta.php",
					type: "POST",
					data: value,
					beforeSend: function () {
						
					},
					success: function (data, textStatus, jqXHR) {
						var data = jQuery.parseJSON(data);
						if (data.result == 1) {
							
							$("#txt_codigo").val(data.oc_id);
							$("#cliente_edit").val(data.id_cliente);
							$("#cliente_edit_fact").val(data.id_cliente);
							$("#txt_fecha").val(data.oc_fecha);
							$("#txt_formapago").val(data.oc_forma_pago);
							$("#txt_observaciones").val(data.oc_observaciones);

                            dias = data.dias;
							canal2 = data.canal;
                            subcanal2 = data.subcanal;
                        	canal = data.canal;
                            subcanal = data.subcanal;
                            txt_cliente22 = data.cliente;
                            txt_cliente2=data.cliente;
							txt_cliente = data.id_cliente;

							var parametros =
							{
								"txt_option": '7',
								"ordencompra":txt_reserva,
								"table": "#table_venta",
							}
							table_venta(parametros);
							$("#modal_editar_orden").modal('show'); 
						}
						else {
							

						}
					}
				});
		}
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
        url: "../../Controller/Controller_rv_consulta.php",
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
cargar_bodegas_consignacion();
function cargar_bodegas_consignacion() {
    var parametros = {
        "txt_option": "16"
    };
    $.ajax({
        url: "../../Controller/Controller_rv_consulta.php",
        type: "POST",
        data: parametros,
        success: function (option) {
            $("#txt_bodega_consignacion").html(option);
			$("#txt_bodega").html(option);
        }
    });
}





/*=============================================
BUSCADOS PREDICTIVO DE PROMOTOR
=============================================*/
var bandera = true;
txt_promotor=0;
$("#txt_promotor").autocomplete({

    source: function (request, response) {

        if (bandera) {
            $.ajax({
                url: "../../Controller/Controller_rv_consulta.php",
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
    txt_promotor=0;
 
    
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

    //var txt_promotor = $("#txt_promotor").val();
    var parametros =
    {
        "txt_option"      : '2',
        "table"           : "#table_ventas",
        "txt_fechain"     : txt_fechain,
        "txt_fechafin"    : txt_fechafin,
        "txt_promotor"    : txt_promotor,
        "txt_cadena"      : txt_cadena,
        "txt_tienda"      : '',
        "txt_estado"    : txt_estado,
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
 
    jQueryUI: true,
   "lengthMenu":		[[5, 10, 20, 25, 50], [5, 10, 20, 25, 50]],
  "iDisplayLength":	500,
  "dom": 'Bfrtip',
"buttons": [ 'copy', 'csv', 'excel', 'pdf', 'print' ],
   "ajax": {
    "url": "../../Controller/Controller_rv_consulta.php", 
     "type": "POST",
     "data": parametros,
   },
   "columns":
        [
            { "data": "oc_fecha" },
            { "data": "numoc" },
            { "data": "cliente" },
            { "data": "item" },
            { "data": "cantidad_rv" },
            { "data": "ocs" },
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
                "url": "../../Controller/Controller_rv_consulta.php",
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

$(document).on("click", ".btn_edit_estado", function () {
var id = $(this).attr("log_id");
var tipo = $(this).attr("tipo");

if (tipo==2){ //es tipo para mostrar el div de aprobar gerencia
    document.getElementById('divitems').style.display = 'none'; 
    document.getElementById('aprobargerenciadiv').style.display = 'inherit'; 
    id_guia2 = $(this).attr("log_id");
    $("#txt_codigo").val($(this).attr("numoc"));
    $("#cliente_edit").val($(this).attr("cliente"));
    $("#txt_fecha").val($(this).attr("oc_fecha"));
    $("#txt_observaciones").val($(this).attr("oc_observaciones"));
    $("#modal_editar_orden").modal('show'); 
    document.getElementById('tablaoculta').style.display = 'none'; 
    document.getElementById('formapagodiv').style.display = 'none'; 

    

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
            url: "../../Controller/Controller_rv_consulta.php",
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
            url: "../../Controller/Controller_rv_consulta.php",
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
            url: "../../Controller/Controller_rv_consulta.php",
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
                        url: "../../Controller/Controller_rv_consulta.php",
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

$("#table_ventas tbody").on("click","button.btn_ver_items",function(e)
{
    /*
    document.getElementById('divitems').style.display = 'inherit'; 
    document.getElementById('aprobargerenciadiv').style.display = 'none'; 
    
    document.getElementById('tablaoculta').style.display = 'inherit'; 

    document.getElementById('formapagodiv').style.display = 'inherit'; 
*/
    id_guia = $(this).attr("numoc");
    $("#txt_codigo").val($(this).attr("numoc"));
    $("#cliente_edit").val($(this).attr("cliente"));
    $("#cliente_edit_fact").val($(this).attr("cliente"));
    $("#txt_fecha").val($(this).attr("oc_fecha"));
    $("#txt_formapago").val($(this).attr("formapago"));
    $("#txt_observaciones").val($(this).attr("oc_observaciones"));

	dias = $(this).attr("dias");
    canal2 = $(this).attr("canal");
    subcanal2 = $(this).attr("subcanal");
    canal = $(this).attr("canal");
    subcanal = $(this).attr("subcanal");
    txt_cliente22 = $(this).attr("id_cliente");
    txt_cliente2=$(this).attr("id_cliente");
	txt_cliente = $(this).attr("id_cliente");

 txt_canal = $(this).attr("canal");
    txt_subcanal = $(this).attr("subcanal");

    //$("#txt_pago").val($(this).attr("forma_pago"));
//document.getElementById('total_venta').innerHTML ="<h3><strong>Total : $"+$(this).attr("total")+"</strong></h3>";
    var parametros =
    {
        "txt_option": '7',
        "ordencompra":id_guia,
        "table": "#table_venta",

    
    }
    table_venta(parametros);

    /*

if ($(this).attr("dato")==1){
} else {
    document.getElementById('btn_agregra_item').disabled = true; 
}
*/
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
		"autoWidth": true,
		"pageLength": 100,
		"ajax": {
			"url": "../../Controller/Controller_rv_consulta.php",
			"data": parametros,
			"type": "POST"
		},
		"columns":
			[
				{ "data": "id" },
				{ "data": "descripcion" },
                { "data": "cantidad2" },
                { "data": "cantidad" },
                { "data": "precio" },
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

	if (txt_producto == 0) {
		
		NotifiError("Por favor, seleccione item!!");
		return false;
	}
	
	
	
	
if ( cant > stock) {
    NotifiError("Por favor, ingrese la cantidad menor o igual a la disponible.");

} else {
    var comprobar = $('#txt_producto').val().length * $('#txt_precio').val().length * $('#txt_cantidad').val().length;
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
            url: "../../Controller/Controller_rv_consulta.php",
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
                    $('#txt_producto').val(''),
                    $('#txt_precio').val(''),
                    $('#txt_cantidad').val('');
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
                url: "../../Controller/Controller_rv_consulta.php",
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
dias=0;
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
							value1: item.dias_credito,
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
			dias= ui.item.value1;
			

        }
    },
    focus: function (event, ui) {
        event.preventDefault();
        $(this).val(ui.item.label);
        $(this).attr("data", ui.item.value);
        txt_cliente = ui.item.value;
		dias= ui.item.value1;
		

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
                url: "../../Controller/Controller_rv_consulta.php",
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
AGREGAR ITEM
=============================================*/
txt_total_venta =0;
$(document).on("click","#btn_edit_orden",function(){

    var comprobar = 1;//$('#txt_producto').val().length * $('#txt_precio').val().length * $('#txt_cantidad').val().length * $('#txt_direntrega').val().length;
    if (comprobar > 0) {
/*
    var value = {
        txt_option      : '13',
        txt_id          : txt_producto,
        txt_text        : $('#txt_producto').val(),
        txt_precio      : $('#txt_precio').val(),
        txt_cantidad    : $('#txt_cantidad').val(),
        txt_direntrega    : $('#txt_direntrega').val(),
        txt_descuento: descuento,
        id_guia: id_guia
    };
    */
   //let data = new FormData($('#registro_equipos_edit2').get(0));
    // let data =  document.getElementById("registro_equipos_edit2");
    var formElement = document.getElementById("registro_equipos_edit2");
    var request = new XMLHttpRequest();
    request.open("POST", "../../Controller/Controller_rv_consulta.php?cancelar=0&txt_dias="+dias+"");
    request.send(new FormData(formElement));

    AlertaExito('EXITO', 'EXITO');

    
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
   
   $("#modal_editar_orden").modal('hide'); 

   var txt_cadena = $("#txt_cliente").val();
   var txt_cadena = $("#txt_cliente").val();
   var txt_estado = $("#txt_estado").val();

   //var txt_promotor = $("#txt_promotor").val();
   var parametros =
   {
       "txt_option"      : '2',
       "table"           : "#table_ventas",
       "txt_fechain"     : txt_fechain,
       "txt_fechafin"    : txt_fechafin,
       "txt_promotor"    : txt_promotor,
       "txt_cadena"      : txt_cadena,
       "txt_tienda"      : '',
       "txt_estado"    : txt_estado,
   }
   
   table_ventas(parametros);

   
   AlertaExito('EXITO', 'EXITO');
   NotifiExito('Orden de Compra generada con exito!');

   /*
    $.ajax(
        {
            url: "../../Controller/Controller_rv_consulta.php",
            type: "POST",
            data: data+'&txt_option=13',
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
        */
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






    
$(document).on("click","#btn_cancel_orden",function(){

    var comprobar = 1;
    if (comprobar > 0) {
        
        var formElement = document.getElementById("registro_equipos_edit2");
        var request = new XMLHttpRequest();
        request.open("POST", "../../Controller/Controller_rv_consulta.php?cancelar=1");
        request.send(new FormData(formElement));
    
        AlertaExito('EXITO', 'EXITO');
    
        
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
    
    $("#modal_editar_orden").modal('hide'); 
 
    var txt_cadena = $("#txt_cliente").val();
    var txt_estado = $("#txt_estado").val();
 
    //var txt_promotor = $("#txt_promotor").val();
    var parametros =
    {
        "txt_option"      : '2',
        "table"           : "#table_ventas",
        "txt_fechain"     : txt_fechain,
        "txt_fechafin"    : txt_fechafin,
        "txt_promotor"    : txt_promotor,
        "txt_cadena"      : txt_cadena,
        "txt_tienda"      : '',
        "txt_estado"    : txt_estado,
    }
    
    table_ventas(parametros);
 
                    AlertaExito('EXITO', 'EXITO');
                    NotifiExito('Inventario Liberado!');

}
  
    });


/*=============================================
MODAL BITACORA DE RESERVA
=============================================*/
id_reserva = '';
producto   = '';
$("#table_venta tbody").on("click","button.btn_ver_bitacora",function(e)
{
    id_reserva = $(this).attr("id_reserva");
    producto = $(this).attr("producto");
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
			"url": "../../Controller/Controller_rv_consulta.php",
			"data": parametros,
			"type": "POST"
		},
		"columns":
			[
				{ "data": "id" },
				{ "data": "tipo" },
                { "data": "cantidad" },
                { "data": "fecha" },
                { "data": "usuario" },
                { "data": "bodega" },
			]
	});
}

/*=============================================
BOTON DE CONSIGNACION
=============================================*/
$(document).on("click", "#btn_consignacion", function () {

    $("#modal_consignacion").modal('show');

});

$(document).on("click", "#btn_procesar_consignacion", function () {

    var comprobar = 1;
    if (comprobar > 0) {

        var formElement = document.getElementById("registro_equipos_edit2");
        var request = new XMLHttpRequest();
        request.open("POST", "../../Controller/Controller_rv_consulta.php?cancelar=1&bodega="+$("#txt_bodega_consignacion").val()+"");
        request.send(new FormData(formElement));

        AlertaExito('EXITO', 'EXITO');


        // var txt_promotorb  = txt_promotor;
        var txt_fechain = $("#fechain").val();
        if (txt_fechain == '') {
            txt_fechain = '';
        }
        else {
            txt_fechain = $("#fechain").val();
        }


        var txt_fechafin = $("#fechafin").val();
        if (txt_fechafin == '') {
            txt_fechafin = '';
        }
        else {
            txt_fechafin = $("#fechafin").val();
        }

        $("#modal_editar_orden").modal('hide');

        var txt_cadena = $("#txt_cliente").val();
        var txt_estado = $("#txt_estado").val();

        //var txt_promotor = $("#txt_promotor").val();
        var parametros =
        {
            "txt_option": '2',
            "table": "#table_ventas",
            "txt_fechain": txt_fechain,
            "txt_fechafin": txt_fechafin,
            "txt_promotor": txt_promotor,
            "txt_cadena": txt_cadena,
            "txt_tienda": '',
            "txt_estado": txt_estado,
        }

        table_ventas(parametros);

        AlertaExito('EXITO', 'EXITO');
        NotifiExito('Inventario Liberado!');
        $("#modal_consignacion").modal('hide'); 

    }

});


 
$("#cliente_edit_fact").autocomplete({

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
                            value2: item.subcanal,
                            value3: item.canal,
							value4: item.dias_credito,
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
            event.preventDefault();
            $(this).val(ui.item.label);
            $(this).attr("data", ui.item.value);
            txt_subcanal= ui.item.value2;
            txt_canal= ui.item.value3;
            txt_cliente = ui.item.value; 
            txt_cliente2 = ui.item.value; 

            canal2 = ui.item.value3;
            subcanal2 = ui.item.value2;
            txt_cliente22 = ui.item.value; 
            txt_cliente2=ui.item.value; 
			dias= ui.item.value4;
			
			
        }
    },
    focus: function (event, ui) {
        event.preventDefault();
        $(this).val(ui.item.label);
        $(this).attr("data", ui.item.value);
        txt_subcanal= ui.item.value2;
        txt_canal= ui.item.value3;
        txt_cliente = ui.item.value; 
        txt_cliente2 = ui.item.value; 

        canal2 = ui.item.value3;
        subcanal2 = ui.item.value2;
        txt_cliente22 = ui.item.value; 
        txt_cliente2=ui.item.value; 
		dias= ui.item.value4;
		
       
    },
});

$("#cliente_edit_fact").on("dblclick", function () {
    $(this).val("");
    $(this).attr("data",""); 
    
txt_subcanal= '';
txt_canal= ''; 
txt_cliente = ''; 
txt_cliente2 = '';   
});


/*=============================================
CARGAR CADENAS
=============================================*/


function buscarprecio(valor) {
    var txt_pago= $('#txt_pago').val();

    var parametros = {
        "valor":valor,
        "txt_producto":txt_producto,
        "txt_cliente":txt_cliente2,
        "txt_cliente2":txt_cliente22,
        "canal":canal2,
        "subcanal":subcanal2,
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
                $("#txt_cantidad").val(1);
             $("#txt_precio").val(data.precio);


            } else {
                NotifiError('No existen registros');
                AlertaExito('EXITO', 'EXITO');
             $("#txt_precio").val('');
            }

        }
    });



}

function buscarprecio2(valor) {
    var txt_pago= $('#txt_pago').val();
var txt_cantidad= $('#txt_cantidad').val();

    var parametros = {
        "valor":valor,
        "txt_producto":txt_producto,
        "txt_cliente":txt_cliente2,
        "txt_cliente2":txt_cliente22,
        "canal":canal2,
        "subcanal":subcanal2,
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
                $("#txt_precio").val(data.precio);


            } else {
                NotifiError('No existen registros');
                AlertaExito('EXITO', 'EXITO');
             $("#txt_precio").val('');
            }

        }
    });



}
function buscarprecio1(i) {

    if(txt_cliente != '')
    {
        var txt_pago = $('#txt_formapago').val();
        var id_item = $('#id_item' + i).val();
    var txt_cantidad = $('.cantidadnueva' + i).val();
        var parametros = {
            "valor": '',
            "txt_producto": id_item,
            "txt_cliente": txt_cliente,
            "txt_cliente2": txt_cliente2,
            "canal": txt_canal,
            "subcanal": txt_subcanal,
            "txt_pago": txt_pago,
            "txt_cantidad": txt_cantidad,
            "txt_option": "13"
        };
        $.ajax({
            url: "../../Controller/Controller_oc_registro.php",
            type: "POST",
            data: parametros,
            success: function (option) {
                var data = jQuery.parseJSON(option);
                if (data.precio > 0) {
                    $("#precionuevo"+i).val(data.precio);


                } else {
                    NotifiError('No existen registros');
                    AlertaExito('EXITO', 'EXITO');
                	$("#precionuevo"+i).val('');
                }

            }
        });
    }
    

}


function valdiar_cantidad(n,c,i) {

    if(n > c){

        NotifiError('Cantidad no puede ser superior a la asignada en la reserva!!!');
        $(".cantidadnueva"+i).val('0');

    }


}