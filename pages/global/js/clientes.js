/*=============================================
CARGAR UNIDADES
=============================================*/
load_unidades();
function load_unidades() {
    var parametros = {
        "txt_option": "6"
    };
    $.ajax({
        url: "../../Controller/Controller_clientes.php",
        type: "POST",
        data: parametros,
        success: function (option) {
            $("#txt_unidad").html(option);
        }
    });
}


/*=============================================
CARGAR SERVICIOS
=============================================*/
/*cargar_ciudad_ini();
cargar_ciudad_fin();
cargar_zona();
load_servicios();
*/
function load_servicios() {
    var parametros = {
        "txt_option": "9"
    };
    $.ajax({
        url: "../../Controller/Controller_clientes.php",
        type: "POST",
        data: parametros,
        success: function (option) {
            $("#txt_servicio").html(option);
        }
    });
}

/*

function cargar_ciudad_ini() {
    var parametros = {
        "txt_option": "31"
    };
    $.ajax({
        url: "../../Controller/Controller_trans_requerimiento.php",
        type: "POST",
        data: parametros,
        success: function (option) {
            $("#txt_ciudad_ini").html(option);
        }
    });
}

function cargar_ciudad_fin() {
    var parametros = {
        "txt_option": "31"
    };
    $.ajax({
        url: "../../Controller/Controller_trans_requerimiento.php",
        type: "POST",
        data: parametros,
        success: function (option) {
            $("#txt_ciudad_fin").html(option);
        }
    });
}
*/

function cargar_zona() {
    var parametros = {
        "txt_option": "13"
    };
    $.ajax({
        url: "../../Controller/Controller_clientes.php",
        type: "POST",
        data: parametros,
        success: function (option) {
            $("#txt_zona").html(option);
        }
    });
}



/*=============================================
BUSCADOR SERVICIOS
=============================================*/
/*
var bandera = true;
$("#txt_servicio").autocomplete({

    source: function (request, response) {

        if (bandera) {
            $.ajax({
                url: "../../Controller/Controller_log_clientes.php",
                data: { term: request.term, txt_option: "7" },
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
            id_equipo = ui.item.value;
        }
    },
    focus: function (event, ui) {
        event.preventDefault();
        $(this).val(ui.item.label);
        $(this).attr("data", ui.item.value);
        id_equipo = ui.item.value;
    },
});
*/



/*=============================================
REGISTRAR CLIENTES
=============================================*/
$(document).on("click", "#btn_save_cliente", function () {

        
    var formData = new FormData();
    var files = $('#image')[0].files[0];
    formData.append('file',files);
    $.ajax({
        url: 'upload.php',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response != 0) {
                 valorimg = response;
                

                 var xyz = valorimg;
               
                 //CARGAMOS TODO EL CODIGO QUE DEBE IR PARA EL INSERT DE FOTOS

                 var comprobar = $('#txt_nombre').val().length * $('#txt_identificacion').val().length;
                 if (comprobar > 0) {
             
                     var value = {
                         txt_nombre             : $("#txt_nombre").val(),
                         txt_identificacion     : $("#txt_identificacion").val(),
                         txt_direccion          : $("#txt_direccion").val(),
                         txt_telefono           : $("#txt_telefono").val(),
                         txt_email              : $("#txt_email").val(),
                         txt_ciudad             : $("#txt_ciudad").val(),
                         url_imagen              :xyz,  
                         txt_option             : '1'
                     };
                     $.ajax(
                         {
                             url: "../../Controller/Controller_clientes.php",
                             type: "POST",
                             data: value,
                             beforeSend: function () {
                                 AlertaEspera('esperando');
                             },
                             success: function (data, textStatus, jqXHR) {
                                 var data = jQuery.parseJSON(data);
                                 if (data.result == 1) {
             
                                     $("#txt_nombre").val('');
                                     $("#txt_identificacion").val('');
                                     $("#txt_direccion").val('');
                                     $("#txt_telefono").val('');
                                     $("#txt_email").val('');
                                     $("#txt_ciudad").val('');
                                     $("#image").val('');
                                     var parametros =
                                     {
                                         "txt_option": '2',
                                         "table": "#table_clientes"
             
                                     }
                                     table_clientes(parametros);
                                     AlertaExito('EXITO', 'EXITO');
                                     NotifiExito('Cliente Registrado!');
                                     $("#editar_cliente").hide();
                                     $("#create_cliente").show();
                                 }
                                 else {
                                     NotifiError(data.error);
                                     AlertaExito('EXITO', 'EXITO');
                                 }
                             }
                         });
             
                 }
                 else {
                     
                     var  msj    = '';
                     var  msj1   = '';
                     var txt_nombre = document.getElementById("txt_nombre").value;
                     if (txt_nombre == null || txt_nombre.length == 0 || /^\s+$/.test(txt_nombre)) {
                         var msj = 'Indique nombre!<br>';
                     }
             
             
                     var txt_identificacion = document.getElementById("txt_identificacion").value;
                     if (txt_identificacion == null || txt_identificacion.length == 0 || /^\s+$/.test(txt_identificacion)) {
                         var msj1 = 'Indique ididenticación!<br>';
                     }
                     
                      NotifiError(msj+msj1);
                 } 

            } else {

                               

                var xyz = 'nologo';
              
                //CARGAMOS TODO EL CODIGO QUE DEBE IR PARA EL INSERT DE FOTOS

                var comprobar = $('#txt_nombre').val().length * $('#txt_identificacion').val().length;
                if (comprobar > 0) {
            
                    var value = {
                        txt_nombre             : $("#txt_nombre").val(),
                        txt_identificacion     : $("#txt_identificacion").val(),
                        txt_direccion          : $("#txt_direccion").val(),
                        txt_telefono           : $("#txt_telefono").val(),
                        txt_email              : $("#txt_email").val(),
                        txt_ciudad             : $("#txt_ciudad").val(),
                        url_imagen              :xyz,  
                        txt_option             : '1'
                    };
                    $.ajax(
                        {
                            url: "../../Controller/Controller_clientes.php",
                            type: "POST",
                            data: value,
                            beforeSend: function () {
                                AlertaEspera('esperando');
                            },
                            success: function (data, textStatus, jqXHR) {
                                var data = jQuery.parseJSON(data);
                                if (data.result == 1) {
            
                                    $("#txt_nombre").val('');
                                    $("#txt_identificacion").val('');
                                    $("#txt_direccion").val('');
                                    $("#txt_telefono").val('');
                                    $("#txt_email").val('');
                                    $("#txt_ciudad").val('');
                                    $("#image").val('');
                                    var parametros =
                                    {
                                        "txt_option": '2',
                                        "table": "#table_clientes"
            
                                    }
                                    table_clientes(parametros);
                                    AlertaExito('EXITO', 'EXITO');
                                    NotifiExito('Cliente Registrado!');
                                    $("#editar_cliente").hide();
                                    $("#create_cliente").show();
                                }
                                else {
                                    NotifiError(data.error);
                                    AlertaExito('EXITO', 'EXITO');
                                }
                            }
                        });
            
                }
                else {
                    
                    var  msj    = '';
                    var  msj1   = '';
                    var txt_nombre = document.getElementById("txt_nombre").value;
                    if (txt_nombre == null || txt_nombre.length == 0 || /^\s+$/.test(txt_nombre)) {
                        var msj = 'Indique nombre!<br>';
                    }
            
            
                    var txt_identificacion = document.getElementById("txt_identificacion").value;
                    if (txt_identificacion == null || txt_identificacion.length == 0 || /^\s+$/.test(txt_identificacion)) {
                        var msj1 = 'Indique ididenticación!<br>';
                    }
                    
                     NotifiError(msj+msj1);
                } 

                //alert('Formato de imagen incorrecto.');
            }
        }
    });






});


/*=============================================
TABLE ESTACIONES
=============================================*/
var parametros =
{
    "txt_option": '2',
    "table": "#table_clientes"

}
table_clientes(parametros);
function table_clientes(parametros) {

	$(parametros.table).dataTable().fnDestroy();
	var dt = $(parametros.table).DataTable({
		"processing": true,
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"responsive": false,
		"autoWidth": false,
		"pageLength": 5,
		"ajax": {
			"url": "../../Controller/Controller_clientes.php",
			"data": parametros,
			"type": "POST"
		},
		"columns":
			[
				{ "data": "id" },
				{ "data": "Nombre" },
                { "data": "Direccion" },
                { "data": "Telefono" },
                { "data": "button" },
			]
	});
}



/*=============================================
TABLE ESTACIONES
=============================================*/
function validar_identificacion(t) {

    var txt_option = '3';
    var txt_identificacion = t;
    var value =
    {
        txt_option: txt_option,
        txt_identificacion: txt_identificacion,
    };
    $.ajax(
        {
            url: "../../Controller/Controller_clientes.php",
            type: "POST",
            data: value,
            success: function (data, textStatus, jqXHR) {
                var data = jQuery.parseJSON(data);

                if (data.result == 1) {

                }
                else {
                    $("#txt_identificacion").val('');
                    NotifiError(data.error);
                }

            }
        });
}


/*=============================================
CARGAR DATOS CLIENETE  EDITAR
=============================================*/
log_id_cliente='';
$("#table_clientes tbody").on("click","button.btn_load_edit_cliente",function(e)
	{
	    e.preventDefault();
	    var table = $('#table_clientes').DataTable(); 
	    var data=table.row($(this).parents("tr")).data();
	    var cell = table.cell( $(this).parents("td"));
	    $('#table_clientes  tr').removeClass("success");  
	    table.row($(this).parents("tr").addClass("success"));

        log_id_cliente = $(this).attr("log_id");
        $("#txt_nombre").val($(this).attr("log_nombre"));
        $("#txt_identificacion").val($(this).attr("log_identificacion"));
        $("#txt_direccion").val($(this).attr("log_direccion"));
        $("#txt_telefono").val($(this).attr("log_telefono"));
        $("#txt_email").val($(this).attr("log_email"));
		$("#txt_ciudad").val($(this).attr("log_ciudad"));


        $("#editar_cliente").show();
        $("#create_cliente").hide();
});



/*=============================================
EDITAR CLIENTES
=============================================*/
$(document).on("click", "#btn_editar_cliente", function () {

  
    var formData = new FormData();
    var files = $('#image')[0].files[0];
    formData.append('file',files);
    $.ajax({
        url: 'upload.php',
        type: 'post',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response != 0) {
                 valorimg = response;
                 var xyz = valorimg;
               
                 //CARGAMOS TODO EL CODIGO QUE DEBE IR PARA EL INSERT DE FOTOS

               

    var comprobar = $('#txt_nombre').val().length * $('#txt_identificacion').val().length;
    if (comprobar > 0) {

        var value = {
            txt_nombre             : $("#txt_nombre").val(),
            txt_identificacion     : $("#txt_identificacion").val(),
            txt_direccion          : $("#txt_direccion").val(),
            txt_telefono           : $("#txt_telefono").val(),
            txt_email              : $("#txt_email").val(),
            txt_id                 : log_id_cliente,
            url_imagen              :xyz,  
            txt_option             : '4'
        };
        $.ajax(
            {
                url: "../../Controller/Controller_clientes.php",
                type: "POST",
                data: value,
                beforeSend: function () {
                    AlertaEspera('esperando');
                },
                success: function (data, textStatus, jqXHR) {
                    var data = jQuery.parseJSON(data);
                    if (data.result == 1) {

                        $("#txt_nombre").val('');
                        $("#txt_identificacion").val('');
                        $("#txt_direccion").val('');
                        $("#txt_telefono").val('');
                        $("#txt_email").val('');
                        var parametros =
                        {
                            "txt_option": '2',
                            "table": "#table_clientes"

                        }
                        table_clientes(parametros);
                        AlertaExito('EXITO', 'EXITO');
                        NotifiExito('Cliente Editado!');
                        $("#editar_cliente").hide();
                        $("#create_cliente").show();
                    }
                    else {
                        NotifiError(data.error);
                        AlertaExito('EXITO', 'EXITO');
                    }
                }
            });

    }
    else {
		
		var  msj    = '';
        var  msj1   = '';
        var txt_nombre = document.getElementById("txt_nombre").value;
        if (txt_nombre == null || txt_nombre.length == 0 || /^\s+$/.test(txt_nombre)) {
            var msj = 'Indique nombre!<br>';
        }


        var txt_identificacion = document.getElementById("txt_identificacion").value;
        if (txt_identificacion == null || txt_identificacion.length == 0 || /^\s+$/.test(txt_identificacion)) {
            var msj1 = 'Indique ididenticación!<br>';
        }
		
		 NotifiError(msj+msj1);
    } 
            } else {

                               

                var xyz = 'nologo';
              
                //CARGAMOS TODO EL CODIGO QUE DEBE IR PARA EL INSERT DE FOTOS


                var comprobar = $('#txt_nombre').val().length * $('#txt_identificacion').val().length;
                if (comprobar > 0) {
            
                    var value = {
                        txt_nombre             : $("#txt_nombre").val(),
                        txt_identificacion     : $("#txt_identificacion").val(),
                        txt_direccion          : $("#txt_direccion").val(),
                        txt_telefono           : $("#txt_telefono").val(),
                        txt_email              : $("#txt_email").val(),
                        txt_id                 : log_id_cliente,
                        url_imagen              :xyz,  
                        txt_option             : '4'
                    };
                    $.ajax(
                        {
                            url: "../../Controller/Controller_clientes.php",
                            type: "POST",
                            data: value,
                            beforeSend: function () {
                                AlertaEspera('esperando');
                            },
                            success: function (data, textStatus, jqXHR) {
                                var data = jQuery.parseJSON(data);
                                if (data.result == 1) {
            
                                    $("#txt_nombre").val('');
                                    $("#txt_identificacion").val('');
                                    $("#txt_direccion").val('');
                                    $("#txt_telefono").val('');
                                    $("#txt_email").val('');
                                    var parametros =
                                    {
                                        "txt_option": '2',
                                        "table": "#table_clientes"
            
                                    }
                                    table_clientes(parametros);
                                    AlertaExito('EXITO', 'EXITO');
                                    NotifiExito('Cliente Editado!');
                                    $("#editar_cliente").hide();
                                    $("#create_cliente").show();
                                }
                                else {
                                    NotifiError(data.error);
                                    AlertaExito('EXITO', 'EXITO');
                                }
                            }
                        });
            
                }
                else {
                    
                    var  msj    = '';
                    var  msj1   = '';
                    var txt_nombre = document.getElementById("txt_nombre").value;
                    if (txt_nombre == null || txt_nombre.length == 0 || /^\s+$/.test(txt_nombre)) {
                        var msj = 'Indique nombre!<br>';
                    }
            
            
                    var txt_identificacion = document.getElementById("txt_identificacion").value;
                    if (txt_identificacion == null || txt_identificacion.length == 0 || /^\s+$/.test(txt_identificacion)) {
                        var msj1 = 'Indique ididenticación!<br>';
                    }
                    
                     NotifiError(msj+msj1);
                } 
                //alert('Formato de imagen incorrecto.');
            }
        }
    });










});




/*=============================================
	DELETE CLIENTE
	=============================================*/
	$(document).on("click", ".btn_delete_cliente", function () {


		var  log_id              = $(this).attr("log_id");
		var  log_nombre          = $(this).attr("log_nombre");
        var  log_identificacion  = $(this).attr("log_identificacion");


		Swal.fire({
			title: "Desea eliminar cliente?",
			text: "Cliente a eliminar: " + $(this).attr("log_identificacion")+" - "+$(this).attr("log_nombre") + "",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si'
		  }).then((result) => {

			if (result.isConfirmed) {
			  
				var value = {
					txt_id             : log_id,
					txt_nombre         : log_nombre,
                    txt_identificacion : log_identificacion,
					txt_option         : '5'
				};
				$.ajax(
					{
						url: "../../Controller/Controller_clientes.php",
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
                                    "txt_option": '2',
                                    "table": "#table_clientes"

                                }
                                table_clientes(parametros);
								AlertaExito('EXITO', 'EXITO');
								NotifiExito('Cliente eliminado!');
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
CARGAR SERVICIOS DEL CLIENTE
=============================================*/
log_id_cliente_servicio='';
$("#table_clientes tbody").on("click","button.btn_select_servicio_cliente",function(e)
	{
	    e.preventDefault();
	    var table = $('#table_clientes').DataTable(); 
	    var data=table.row($(this).parents("tr")).data();
	    var cell = table.cell( $(this).parents("td"));
	    $('#table_clientes  tr').removeClass("success");  
	    table.row($(this).parents("tr").addClass("success"));

        log_id_cliente_servicio = $(this).attr("log_id");
        $("#txt_identificacion_s").val($(this).attr("log_nombre"));
        $("#txt_cliente").val($(this).attr("log_identificacion"));
        $("#txt_actividad").focus();

        var parametros =
        {
            "txt_option": '8',
            "txt_id": log_id_cliente_servicio,
            "table": "#table_servicios"

        }
        table_servicios(parametros);
        $("#txt_servicio").focus();
});


/*=============================================
TABLE SERVICIOS
=============================================*/

function table_servicios(parametros) {

	$(parametros.table).dataTable().fnDestroy();
	var dt = $(parametros.table).DataTable({
		"processing": true,
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"responsive": false,
		"autoWidth": false,
		"pageLength": 100,
		"ajax": {
			"url": "../../Controller/Controller_clientes.php",
			"data": parametros,
			"type": "POST"
		},
		"columns":
			[
				{ "data": "id" },				
                { "data": "Descripcion" },
                { "data": "Precio" },
                { "data": "button" },
			]
	});
}






/*=============================================
REGISTRAR SERVICIOS
=============================================*/
$(document).on("click", "#btn_save_servico", function () {

    var comprobar = $('#txt_precio').val().length;
    if (comprobar > 0) {

        var value = {
            txt_id_cliente         : log_id_cliente_servicio,
            txt_precio             : $("#txt_precio").val(),
            txt_descripcion        : $("#txt_descripcion").val(),
            txt_option             : '10'
        };
        $.ajax(
            {
                url: "../../Controller/Controller_clientes.php",
                type: "POST",
                data: value,
                beforeSend: function () {
                    AlertaEspera('esperando');
                },
                success: function (data, textStatus, jqXHR) {
                    var data = jQuery.parseJSON(data);
                    if (data.result == 1) {

                        $("#txt_precio").val('');
                        $("#txt_descripcion").val('');

                       /*var parametros =
                        {
                            "txt_option": '8',
                            "txt_id": log_id_cliente_servicio,
                            "table": "#table_servicios"

                        }
                        table_servicios(parametros);*/
                    	var table = $('#table_servicios').DataTable(); 
                        table.ajax.reload( null, false );
                    
                        AlertaExito('EXITO', 'EXITO');
                        NotifiExito('Tarifa Registrada!');
                        $("#editar_servico").hide();
                        $("#create_servicio").show();
                    }
                    else {
                        NotifiError(data.error);
                        AlertaExito('EXITO', 'EXITO');
                    }
                }
            });
        }
        else {
            

            var  msj    = '';
            var  msj1   = '';
            var  msj2   = '';
            var txt_servicio = document.getElementById("txt_servicio").value;
            if (txt_servicio == null || txt_servicio.length == 0 || /^\s+$/.test(txt_servicio)) {
                var msj = 'Indique Servicio!<br>';
            }


            var txt_unidad = $("#txt_unidad").val();
            if (txt_unidad == 0 ) {
                var msj1 = 'Indique unidad!<br>';
            }


            var txt_precio = document.getElementById("txt_precio").value;
            if (txt_precio == null || txt_precio.length == 0 || /^\s+$/.test(txt_precio)) {
                var msj2 = 'Indique precio!<br>';
            }

            NotifiError(msj+msj1+msj2);
        }
   
});



/*=============================================
CARGAR DATOS SERVICIO  EDITAR
=============================================*/
log_id_servicio='';
$("#table_servicios tbody").on("click","button.btn_load_edit_servicio",function(e)
	{
	    e.preventDefault();
	    var table = $('#table_servicios').DataTable(); 
	    var data=table.row($(this).parents("tr")).data();
	    var cell = table.cell( $(this).parents("td"));
	    $('#table_servicios  tr').removeClass("success");  
	    table.row($(this).parents("tr").addClass("success"));

        log_id_servicio = $(this).attr("log_id");
       /* $("#txt_unidad").val($(this).attr("log_id_unidad"));
       $("#txt_ciudad_ini").val($(this).attr("id_ciudad_ini"));
        $("#txt_zona").val($(this).attr("id_zona"));
        $("#txt_ciudad_fin").val($(this).attr("id_ciudad_fin"));
       */
        $("#txt_precio").val($(this).attr("log_precio"));
        $("#txt_descripcion").val($(this).attr("log_descripcion"));
        



        $("#editar_servico").show();
        $("#create_servicio").hide();
        $("#txt_identificacion_s").focus();
});




/*=============================================
EDITAR SERVICIOS
=============================================*/
$(document).on("click", "#btn_editar_servicio", function () {

    var comprobar = $('#txt_precio').val().length;
    if (comprobar > 0) {

        var value = {
            txt_id_servicio         : log_id_servicio,
            txt_precio             : $("#txt_precio").val(),
            txt_descripcion        : $("#txt_descripcion").val(),
            txt_option             : '11'
        };
        $.ajax(
            {
                url: "../../Controller/Controller_clientes.php",
                type: "POST",
                data: value,
                beforeSend: function () {
                    AlertaEspera('esperando');
                },
                success: function (data, textStatus, jqXHR) {
                    var data = jQuery.parseJSON(data);
                    if (data.result == 1) {
                        $("#txt_precio").val('');
                        $("#txt_descripcion").val('');
                       /*var parametros =
                        {
                            "txt_option": '8',
                            "txt_id": log_id_cliente_servicio,
                            "table": "#table_servicios"

                        }
                        table_servicios(parametros);*/
                    	var table = $('#table_servicios').DataTable(); 
                        table.ajax.reload( null, false );
                    
                        AlertaExito('EXITO', 'EXITO');
                        NotifiExito('Tarifa Editada!');
                        $("#editar_servico").hide();
                        $("#create_servicio").show();
                    }
                    else {
                        NotifiError(data.error);
                        AlertaExito('EXITO', 'EXITO');
                    }
                }
            });
        }
        else {
            

            var  msj    = '';
            var  msj1   = '';
            var  msj2   = '';
            var txt_servicio = document.getElementById("txt_servicio").value;
            if (txt_servicio == null || txt_servicio.length == 0 || /^\s+$/.test(txt_servicio)) {
                var msj = 'Indique Servicio!<br>';
            }


            var txt_unidad = $("#txt_unidad").val();
            if (txt_unidad == 0 ) {
                var msj1 = 'Indique unidad!<br>';
            }


            var txt_precio = document.getElementById("txt_precio").value;
            if (txt_precio == null || txt_precio.length == 0 || /^\s+$/.test(txt_precio)) {
                var msj2 = 'Indique precio!<br>';
            }

            NotifiError(msj+msj1+msj2);
        }
   
});



/*=============================================
    DELETE SERVICIO CLIENTE
=============================================*/
	$(document).on("click", ".btn_delete_servicio", function () {


		var  log_id          = $(this).attr("log_id");
		//var  log_servicio    = $(this).attr("log_servicio");

        
		Swal.fire({
			title: "Desea eliminar tarifa?",
			text: "Tarifa a eliminar: " + $(this).attr("log_descripcion")+ " por el precio de $" + $(this).attr("log_precio")+ "",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si'
		  }).then((result) => {

			if (result.isConfirmed) {
			  
				var value = {
					txt_id             : log_id,
					log_servicio       : 0,
					txt_option         : '12'
				};
				$.ajax(
					{
						url: "../../Controller/Controller_clientes.php",
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
                                    "txt_option": '8',
                                    "txt_id": log_id_cliente_servicio,
                                    "table": "#table_servicios"

                                }
                                table_servicios(parametros);
								AlertaExito('EXITO', 'EXITO');
								NotifiExito('Servicio eliminado!');
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