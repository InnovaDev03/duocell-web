/*=============================================
CARGAR GRUPO
=============================================*/
load_grupo();
function load_grupo() {
    var parametros = {
        "txt_option": "1"
    };
    $.ajax({
        url: "../../Controller/Controller_bonificaciones.php",
        type: "POST",
        data: parametros,
        success: function (option) {
            $("#txt_grupo").html(option);
        }
    });
}

/*=============================================
CARGAR GRUPO MODAL
=============================================*/
load_grupo_m();
function load_grupo_m() {
    var parametros = {
        "txt_option": "1"
    };
    $.ajax({
        url: "../../Controller/Controller_bonificaciones.php",
        type: "POST",
        data: parametros,
        success: function (option) {
            $("#txt_grupo_e").html(option);
        }
    });
}


/*=============================================
TABLE DETALLE LABORES
=============================================*/
var parametros =
{
    "txt_option"   : '3',
    "table"        : "#table_labor"
}



table_labores(parametros);
function table_labores(parametros) {

	$(parametros.table).dataTable().fnDestroy();
	var dt = $(parametros.table).DataTable({
		"processing": true,
		"paging": true,
		"lengthChange": false,
		"searching": true,
		"ordering": true,
		"info": true,
		"responsive": false,
		"autoWidth": true,
		"pageLength": 50,
		"ajax": {
			"url": "../../Controller/Controller_bonificaciones.php",
			"data": parametros,
			"type": "POST"
		},
		"columns":
			[
				{ "data": "id" },
                { "data": "labor" },
                { "data": "unidad" },
                { "data": "valorunitario" },
				{ "data": "rendimiento_semanal" },
				{ "data": "grupo" },
				{ "data": "tipo_labor" },
                { "data": "button" },
			]
	});

    
}



/*=============================================
REGISTRAR LABOR
=============================================*/
$(document).on("click", "#btn_save_labor", function () {
    
		if($('#txt_producto').val().length != '' )
        	 {
             } else {
            NotifiError("Coloque el item");
            return true;
                }  
	

        var value = {
            txt_ano:$("#txt_ano").val(),
            txt_labor       : $("#txt_rubro").val(),
            txt_nivel2  :txt_producto,
            mes1       : $("#mes1").val(),
            mes2 : $("#mes2").val(),
            mes3       : $("#mes3").val(),
            mes4       : $("#mes4").val(),
            mes5       : $("#mes5").val(),
            mes6       : $("#mes6").val(),
            mes7       : $("#mes7").val(),
            mes8       : $("#mes8").val(),
            mes9       : $("#mes9").val(),
            mes10      : $("#mes10").val(),
            mes11      : $("#mes11").val(),
            mes12       : $("#mes12").val(),
            txt_option      : '2'
        };
        $.ajax(
            {
                "url": "../../Controller/Controller_bonificaciones.php",
                type: "POST",
                data: value,
                beforeSend: function () {
                    AlertaEspera('esperando');
                },
                success: function (data, textStatus, jqXHR) {
                    var data = jQuery.parseJSON(data);
                    if (data.result == 1) {
                       // $("#txt_ano").val('');
                      //  $("#txt_rubro").val('');
                        $("#txt_producto").val('');
                        txt_producto='';
                        $("#mes1").val('');
                        $("#mes2").val('');
                        $("#mes3").val('');
                        $("#mes4").val('');
                        $("#mes5").val('');
                       $("#mes6").val('');
                        $("#mes7").val('');
                         $("#mes8").val('');
                        $("#mes9").val('');
                         $("#mes10").val('');
                        $("#mes11").val('');
                        $("#mes12").val('');
                    
                       var table = $('#table_labor').DataTable(); 
                       table.ajax.reload( null, false );

                        AlertaExito('EXITO', 'EXITO');
                        NotifiExito('Bonificación Registrada!');                        
                        nivel1($("#txt_rubro").val());
                    }
                    else {
                        NotifiError(data.error);
                        AlertaExito('EXITO', 'EXITO');
                    }
                }
            });


});



/*=============================================
DELETE LABOR
=============================================*/
$(document).on("click", ".btn_delete_labor", function () {

		var  id_labor     = $(this).attr("id_labor");

		Swal.fire({
			title: "Desea eliminar la bonificación?",
			text: "Bonificación a eliminar del item: " + $(this).attr("nombre") + "",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si'
		  }).then((result) => {

			if (result.isConfirmed) {
			  
				var value = {
					txt_id  : id_labor,
					txt_option : '4'
				};
				$.ajax(
					{
						url: "../../Controller/Controller_bonificaciones.php",
						type: "POST",
						data: value,
						beforeSend: function () {
							AlertaEspera('esperando');
						},
						success: function (data, textStatus, jqXHR) {
							var data = jQuery.parseJSON(data);
							if (data.result == 1) {
                                
                              
                        AlertaExito('EXITO', 'EXITO');
                        NotifiExito('Bonificación eliminada!');                        
                        nivel1($("#txt_rubro").val());

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
ACTIVAR LABOR
=============================================*/
$(document).on("click", ".btn_activar", function () {

		var  id_labor     = $(this).attr("id_labor");
		var  labor = $(this).attr("labor");

		Swal.fire({
			title: "Desea activar labor?",
			text: "Labor a activar: " + $(this).attr("labor") + "",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si'
		  }).then((result) => {

			if (result.isConfirmed) {
			  
				var value = {
					txt_id  : id_labor,
					labor   : labor,
					txt_option : '5'
				};
				$.ajax(
					{
						url: "../../Controller/Controller_bonificaciones.php",
						type: "POST",
						data: value,
						beforeSend: function () {
							AlertaEspera('esperando');
						},
						success: function (data, textStatus, jqXHR) {
							var data = jQuery.parseJSON(data);
							if (data.result == 1) {

                                var table = $('#table_labor').DataTable(); 
                                table.ajax.reload( null, false );
								AlertaExito('EXITO', 'EXITO');
								NotifiExito('Labor Activada!');
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
CARGAR MODAL LABOR
=============================================*/
id_labor='';

$(document).on("click", ".btn_load_edit_labor", function () {
    
        id_labor = $(this).attr("id_labor");
        $("#mes1").val($(this).attr("enero"));
        $("#mes2").val($(this).attr("febrero"));
        $("#mes3").val($(this).attr("marzo"));
        $("#mes4").val($(this).attr("abril"));
        $("#mes5").val($(this).attr("mayo"));
        $("#mes6").val($(this).attr("junio"));
        $("#mes7").val($(this).attr("julio"));
        $("#mes8").val($(this).attr("agosto"));
        $("#mes9").val($(this).attr("septiembre"));
        $("#mes10").val($(this).attr("octubre"));
        $("#mes11").val($(this).attr("noviembre"));
        $("#mes12").val($(this).attr("diciembre"));
        document.getElementById("txt_producto").style.display = "none";
        document.getElementById("nivel1txt").style.display = "inherit";
        document.getElementById("nivel1txt").innerHTML=$(this).attr("nombre");
        document.getElementById("btn_save_labor").style.display = "none";
        document.getElementById("btn_editar_labor").style.display = "inherit";
        
		//$("#modal_labor").modal("show");
	});


/*=============================================
EDITAR LABOR
=============================================*/
$(document).on("click", "#btn_editar_labor", function () {

    //var comprobar = $('#txt_labor_e').val().length * $('#txt_unidad_e').val().length * $('#txt_valor_e').val().length * $('#txt_rendimiento_e').val().length * $('#txt_grupo_e').val().length * $('#txt_tipo_labor_e').val().length;
    
    /*
    if($('#txt_labor_e').val().length == '' )
        	 {
            NotifiError("Coloque nombre labor");
            return true
                }  
		if($('#txt_unidad_e').val().length == '' )
        	 {
                NotifiError("Coloque unidad");
            return true
                } 
		if($('#txt_rendimiento_e').val().length == '' )
        	 {
                NotifiError("Coloque rendimiento");
            return true
                }
		if($('#txt_valor_e').val().length == '' )
        	 {
                NotifiError("Coloque valor");
            return true
             
                }
*/
        var value = {

            txt_id                : id_labor,
            mes1       : $("#mes1").val(),
            mes2 : $("#mes2").val(),
            mes3       : $("#mes3").val(),
            mes4       : $("#mes4").val(),
            mes5       : $("#mes5").val(),
            mes6       : $("#mes6").val(),
            mes7       : $("#mes7").val(),
            mes8       : $("#mes8").val(),
            mes9       : $("#mes9").val(),
            mes10      : $("#mes10").val(),
            mes11      : $("#mes11").val(),
            mes12       : $("#mes12").val(),
            txt_option            : '6'
        };
        $.ajax(
            {
                url: "../../Controller/Controller_bonificaciones.php",
                type: "POST",
                data: value,
                beforeSend: function () {
                    //AlertaEspera('esperando');
                },
                success: function (data, textStatus, jqXHR) {
                    var data = jQuery.parseJSON(data);
                    if (data.result == 1) {

                        $("#txt_nivel1").val('');
                        $("#mes1").val('');
                        $("#mes2").val('');
                        $("#mes3").val('');
                        $("#mes4").val('');
                        $("#mes5").val('');
                       $("#mes6").val('');
                        $("#mes7").val('');
                         $("#mes8").val('');
                        $("#mes9").val('');
                         $("#mes10").val('');
                        $("#mes11").val('');
                        $("#mes12").val('');
                    
                       nivel1($("#txt_rubro").val());
                        AlertaExito('EXITO', 'EXITO');
                        NotifiExito('Bonificación actualizada!');
                    }
                    else {
                        NotifiError(data.error);
                        AlertaExito('EXITO', 'EXITO');
                    }
                }
            });

     
});



/*=============================================
HISTORIAL CAMBIO DE PRECIO
=============================================*/

$(document).on("click",".btn_historial_precio",function(){
        
    var  id_labor  = $(this).attr("id_labor");
    var  labor  = $(this).attr("labor");
    $("#labor_historial").val(labor); 
    var parametros =
    {
        "txt_option"    : '7',
        "table"         : "#table_historial_precio",
        "id_labor"      : id_labor,
    }
    table_historial_precios(parametros);

});

function table_historial_precios(parametros) {
$(parametros.table).dataTable().fnDestroy();
var dt = $(parametros.table).DataTable({
    
    
     "bProcessing": false,
    "serverSide": false,  
    "processing": true,
    "paging": true,
    "lengthChange": false,
    "searching": true,
    "ordering": true,
    "info": true,
    "responsive": false,
    "autoWidth": false,
    "pageLength": 10,
    "ajax": {
        "url": "../../Controller/Controller_bonificaciones.php",
        "data": parametros,
        "type": "POST"
    },
    "columns":
        [
            { "data": "id" },
            { "data": "precio_anterior" },
            { "data": "precio_nuevo" },
            { "data": "fecha_cambio" },
            { "data": "usuario" },
        ]
});
$("#modal_historial_precio").modal('show');

}



/*=============================================
CARGAR RUBRO
=============================================*/
load_rubro();
function load_rubro() {
    var parametros = {
        "txt_option": "1"
    };
    $.ajax({
        url: "../../Controller/Controller_bonificaciones.php",
        type: "POST",
        data: parametros,
        success: function (option) {
            $("#txt_rubro").html(option);
        }
    });
}

function nivel1(valor){
 var dato1 = $("#txt_ano").val();
   /* var parametros = {
        "txt_option": "8",
        "dato1":dato1,
        "idn0":valor,
    };
    $.ajax({
        url: "../../Controller/Controller_bonificaciones.php",
        type: "POST",
        data: parametros,
        success: function (option) {
            $("#txt_nivel1").html(option);
        }
    });
*/
    var parametros =
    {
        "txt_option"   : '11',
        "idn0":valor,
        "dato1":dato1,
        "table"        : "#table_ventas"
    }
    table_ventas(parametros);
}



/*=============================================
TABLE PRESUPUESTO
=============================================*/

function table_ventas(parametros) {

	$(parametros.table).dataTable().fnDestroy();
	var dt = $(parametros.table).DataTable({
		"processing": true,
		"paging": true,
		"lengthChange": false,
		"searching": true,
		"ordering": true,
		"info": true,
		"responsive": false,
		"autoWidth": true,
		"pageLength": 50,
		"ajax": {
			"url": "../../Controller/Controller_bonificaciones.php",
			"data": parametros,
			"type": "POST"
		},
		"columns":
			[
				{ "data": "id" },
                { "data": "nombre" },
                { "data": "enero" },
                { "data": "febrero" },
                { "data": "marzo" },
                { "data": "abril" },
                { "data": "mayo" },
                { "data": "junio" },
                { "data": "julio" },
                { "data": "agosto" },
                { "data": "septiembre" },
                { "data": "octubre" },
                { "data": "noviembre" },
                { "data": "diciembre" },
                { "data": "button" },
			]
	});

    
}

function nivel2(valor){
    var parametros = {
        "txt_option": "9",
        "idn0":valor,
    };
    $.ajax({
        url: "../../Controller/Controller_bonificaciones.php",
        type: "POST",
        data: parametros,
        success: function (option) {
            $("#txt_nivel2").html(option);
        }
    });
}


function nivel3(valor){
    var parametros = {
        "txt_option": "10",
        "idn0":valor,
    };
    $.ajax({
        url: "../../Controller/Controller_bonificaciones.php",
        type: "POST",
        data: parametros,
        success: function (option) {
            $("#txt_nivel3").html(option);
        }
    });
}




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
            txt_producto = ui.item.value  + " " + ui.item.label;

        }
    },
    focus: function (event, ui) {
        event.preventDefault();
        $(this).val(ui.item.label);
        $(this).attr("data", ui.item.value);
        txt_producto = ui.item.value + " " + ui.item.label;

    },
});

$("#txt_producto").on("dblclick", function () {
    $(this).val("");
    $(this).attr("data","");
    txt_producto=0;
 
    
});

