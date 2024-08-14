/*=============================================
REGISTRAR CADENA
=============================================*/
$(document).on("click", "#btn_save_cadena", function () {

    var comprobar = $('#txt_nombre_cadena').val().length * $('#txt_ciudad_cadena').val().length;
    if (comprobar > 0) {

        var value = {

            txt_nombre_cadena    : $("#txt_nombre_cadena").val(),
            txt_ciudad_cadena    : $("#txt_ciudad_cadena").val(),
            txt_option           : '1'
        };
        $.ajax(
            {
                url: "../../Controller/Controller_corpo.php",
                type: "POST",
                data: value,
                beforeSend: function () {
                    AlertaEspera('esperando');
                },
                success: function (data, textStatus, jqXHR) {
                    var data = jQuery.parseJSON(data);
                    if (data.result == 1) {

                        $("#txt_nombre_cadena").val('');
                        $("#txt_ciudad_cadena").val('');
                        var parametros =
                        {
                            "txt_option": '2',
                            "table": "#table_cadenas"

                        }
                        table_cadenas(parametros);
                        AlertaExito('EXITO', 'EXITO');
                        NotifiExito('Factor registrado!');
                        $("#editar_cadena").hide();
                        $("#btn_save_cadena").show();
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
        var  msj2  = '';
        var txt_nombre_cadena = document.getElementById("txt_nombre_cadena").value;
        if (txt_nombre_cadena == null || txt_nombre_cadena.length == 0 || /^\s+$/.test(txt_nombre_cadena)) {
            var msj = 'Indique nombre!<br>';
            $("#txt_nombre_cadena").focus();
        }

        var txt_ciudad_cadena = document.getElementById("txt_ciudad_cadena").value;
        if (txt_ciudad_cadena == null || txt_ciudad_cadena.length == 0 || /^\s+$/.test(txt_ciudad_cadena)) {
           var msj1 = 'Indique ciudad!<br>';
           $("#txt_ciudad_cadena").focus();
        }

        var txt_direccion_cadena = document.getElementById("txt_direccion_cadena").value;
        if (txt_direccion_cadena == null || txt_direccion_cadena.length == 0 || /^\s+$/.test(txt_direccion_cadena)) {
           var msj2 = 'Indique dirección!<br>';
           $("#txt_direccion_cadena").focus();
        }
		
		 NotifiError(msj+msj1+msj2);
         
    } 
});

/*=============================================
TABLE CADENAS
=============================================*/
var parametros =
{
    "txt_option": '2',
    "table": "#table_cadenas"

}
table_cadenas(parametros);
function table_cadenas(parametros) {

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
			"url": "../../Controller/Controller_corpo.php",
			"data": parametros,
			"type": "POST"
		},
		"columns":
			[
				{ "data": "id" },
				{ "data": "nombre" },
                { "data": "factor" },
                { "data": "button" },
			]
	});
}


/*=============================================
CARGAR DATOS CADENA EDITAR
=============================================*/
pr_id='';
$("#table_cadenas tbody").on("click","button.btn_load_edit_cadena",function(e)
	{
	    e.preventDefault();
	    var table = $('#table_cadenas').DataTable(); 
	    var data=table.row($(this).parents("tr")).data();
	    var cell = table.cell( $(this).parents("td"));
	    $('#table_cadenas  tr').removeClass("success");  
	    table.row($(this).parents("tr").addClass("success"));

        pr_id = $(this).attr("pr_id");
        $("#txt_nombre_cadena").val($(this).attr("pr_nombre"));
        $("#txt_ciudad_cadena").val($(this).attr("pr_ciudad"));
        $("#txt_direccion_cadena").val($(this).attr("pr_direccion"));

        $("#txt_nombre_cadena").focus();

        $("#editar_cadena").show();
        $("#create_cadena").hide();
        
        
});

/*=============================================
CANCELAR EDITAR CADENA
=============================================*/
$(document).on("click", "#btn_cancelar_cadena", function () {

    pr_id ='';
    $("#txt_nombre_cadena").val('');
    $("#txt_ciudad_cadena").val('');
    $("#txt_direccion_cadena").val('');
    $("#editar_cadena").hide();
    $("#create_cadena").show();
});



/*=============================================
EDITAR CADEN
=============================================*/
$(document).on("click", "#btn_editar_cadena", function () {

    var comprobar = $('#txt_nombre_cadena').val().length * $('#txt_ciudad_cadena').val().length * $('#txt_direccion_cadena').val().length;
    if (comprobar > 0) {

        var value = {

            txt_id_cadena        : pr_id,
            txt_nombre_cadena    : $("#txt_nombre_cadena").val(),
            txt_ciudad_cadena    : $("#txt_ciudad_cadena").val(),
            txt_direccion_cadena : $("#txt_direccion_cadena").val(),
            txt_option           : '3'
        };
        $.ajax(
            {
                url: "../../Controller/Controller_corpo.php",
                type: "POST",
                data: value,
                beforeSend: function () {
                    AlertaEspera('esperando');
                },
                success: function (data, textStatus, jqXHR) {
                    var data = jQuery.parseJSON(data);
                    if (data.result == 1) {

                        $("#txt_nombre_cadena").val('');
                        $("#txt_ciudad_cadena").val('');
                        $("#txt_direccion_cadena").val('');
                        pr_id=''
                        var parametros =
                        {
                            "txt_option": '2',
                            "table": "#table_cadenas"
                        }
                        table_cadenas(parametros);
                        AlertaExito('EXITO', 'EXITO');
                        NotifiExito('Cadena editada!');
                        $("#editar_cadena").hide();
                        $("#btn_save_cadena").show();
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
            var  msj2  = '';
            var txt_nombre_cadena = document.getElementById("txt_nombre_cadena").value;
            if (txt_nombre_cadena == null || txt_nombre_cadena.length == 0 || /^\s+$/.test(txt_nombre_cadena)) {
                var msj = 'Indique nombre!<br>';
                $("#txt_nombre_cadena").focus();
            }
    
            var txt_ciudad_cadena = document.getElementById("txt_ciudad_cadena").value;
            if (txt_ciudad_cadena == null || txt_ciudad_cadena.length == 0 || /^\s+$/.test(txt_ciudad_cadena)) {
               var msj1 = 'Indique ciudad!<br>';
               $("#txt_ciudad_cadena").focus();
            }
    
            var txt_direccion_cadena = document.getElementById("txt_direccion_cadena").value;
            if (txt_direccion_cadena == null || txt_direccion_cadena.length == 0 || /^\s+$/.test(txt_direccion_cadena)) {
               var msj2 = 'Indique dirección!<br>';
               $("#txt_direccion_cadena").focus();
            }
            
             NotifiError(msj+msj1+msj2);
             
        } 
});


    /*=============================================
	DESACTIVAR CADENA
	=============================================*/
	$(document).on("click", ".btn_delete_cadena", function () {


		var  pr_id     = $(this).attr("pr_id");
		var  pr_nombre = $(this).attr("pr_nombre");


		Swal.fire({
			title: "Desea desactivar el factor?",
			text: "Factor a desactivar: " + $(this).attr("pr_nombre") + "",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si'
		  }).then((result) => {

			if (result.isConfirmed) {
			  
				var value = {
					txt_id     : pr_id,
					txt_nombre : pr_nombre,
					txt_option : '4'
				};
				$.ajax(
					{
						url: "../../Controller/Controller_corpo.php",
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
                                    "table": "#table_cadenas"
                                }
                                table_cadenas(parametros);
								AlertaExito('EXITO', 'EXITO');
								NotifiExito('Factor desactivado!');
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
	ACTIVAR CADENA
	=============================================*/
	$(document).on("click", ".btn_activar_cadena", function () {


		var  pr_id     = $(this).attr("pr_id");
		var  pr_nombre = $(this).attr("pr_nombre");


		Swal.fire({
			title: "Desea activar cadena?",
			text: "Cadena a activar : " + $(this).attr("pr_nombre") + "",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si'
		  }).then((result) => {

			if (result.isConfirmed) {
			  
				var value = {
					txt_id     : pr_id,
					txt_nombre : pr_nombre,
					txt_option : '5'
				};
				$.ajax(
					{
						url: "../../Controller/Controller_corpo.php",
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
                                    "table": "#table_cadenas"
                                }
                                table_cadenas(parametros);
								AlertaExito('EXITO', 'EXITO');
								NotifiExito('Cadena activada!');
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
CARGAR TIENDAS DE LA CADENA
=============================================*/
pr_id_cadena='';
$("#table_cadenas tbody").on("click","button.btn_select_cadena",function(e)
	{
	    e.preventDefault();
	    var table = $('#table_cadenas').DataTable(); 
	    var data=table.row($(this).parents("tr")).data();
	    var cell = table.cell( $(this).parents("td"));
	    $('#table_cadenas  tr').removeClass("success");  
	    table.row($(this).parents("tr").addClass("success"));

        pr_id_cadena = $(this).attr("pr_id");
        $("#txt_cadena_select").val($(this).attr("pr_nombre"));

        var parametros =
        {
            "txt_option": '6',
            "table": "#table_tiendas",
            "txt_id": pr_id_cadena

        }
        table_tiendas(parametros);

        $("#create_tienda").show();
        $("#editar_tienda").hide();
        $("#txt_nombre_tienda").focus();
});

/*=============================================
TABLE TIENDAS
=============================================*/
var parametros =
{
    "txt_option": '6',
    "table": "#table_tiendas",
    "txt_id": ""

}
table_tiendas(parametros);

function table_tiendas(parametros) {

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
			"url": "../../Controller/Controller_corpo.php",
			"data": parametros,
			"type": "POST"
		},
		"columns":
			[
				{ "data": "id" },
                { "data": "cadena" },
                { "data": "button" },
			]
	});
}



/*=============================================
REGISTRAR TIENDAS
=============================================*/
$(document).on("click", "#btn_save_tienda", function () {

    if(pr_id_cadena == '')
    {
        NotifiError("Seleccione un Factor!!");
        return false;
    }
    
    var comprobar = $('#txt_cliente').val().length ;
    if (comprobar > 0) {
        var value = {

            txt_pr_id_cadena     : pr_id_cadena,
            txt_cliente    : $("#txt_cliente").attr("data"),
            txt_cliente_texto    : $("#txt_cliente").val(),
            txt_option           : '7'
        };
        $.ajax(
            {
                url: "../../Controller/Controller_corpo.php",
                type: "POST",
                data: value,
                beforeSend: function () {
                    AlertaEspera('esperando');
                },
                success: function (data, textStatus, jqXHR) {
                    var data = jQuery.parseJSON(data);
                    if (data.result == 1) {

                        $("#txt_cliente").val('');

                        var parametros =
                        {
                            "txt_option": '6',
                            "table": "#table_tiendas",
                            "txt_id": pr_id_cadena

                        }
                        table_tiendas(parametros);
                        AlertaExito('EXITO', 'EXITO');
                        NotifiExito('Cliente registrado!');
                        $("#editar_tienda").hide();
                        $("#btn_save_tienda").show();
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
        var  msj2  = '';
        var txt_nombre_tienda = document.getElementById("txt_nombre_tienda").value;
        if (txt_nombre_tienda == null || txt_nombre_tienda.length == 0 || /^\s+$/.test(txt_nombre_tienda)) {
            var msj = 'Indique nombre!<br>';
            $("#txt_nombre_tienda").focus();
        }

        var txt_ciudad_tienda = document.getElementById("txt_ciudad_tienda").value;
        if (txt_ciudad_tienda == null || txt_ciudad_tienda.length == 0 || /^\s+$/.test(txt_ciudad_tienda)) {
           var msj1 = 'Indique ciudad!<br>';
           $("#txt_ciudad_tienda").focus();
        }

        var txt_direccion_tienda = document.getElementById("txt_direccion_tienda").value;
        if (txt_direccion_tienda == null || txt_direccion_tienda.length == 0 || /^\s+$/.test(txt_direccion_tienda)) {
           var msj2 = 'Indique dirección!<br>';
           $("#txt_direccion_tienda").focus();
        }
		
		 NotifiError(msj+msj1+msj2);
         
    } 
});


/*=============================================
CARGAR DATOS TIENDA EDITAR
=============================================*/
pr_id='';
$("#table_tiendas tbody").on("click","button.btn_load_edit_tienda",function(e)
	{
	    e.preventDefault();
	    var table = $('#table_tiendas').DataTable(); 
	    var data=table.row($(this).parents("tr")).data();
	    var cell = table.cell( $(this).parents("td"));
	    $('#table_tiendas  tr').removeClass("success");  
	    table.row($(this).parents("tr").addClass("success"));

        pr_id = $(this).attr("pr_id");
        $("#txt_nombre_tienda").val($(this).attr("pr_nombre"));
        $("#txt_ciudad_tienda").val($(this).attr("pr_ciudad"));
        $("#txt_direccion_tienda").val($(this).attr("pr_direccion"));
        $("#txt_nombre_tienda").focus();
        

        $("#editar_tienda").show();
        $("#create_tienda").hide();
        
        
});

/*=============================================
CANCELAR EDITAR CADENA
=============================================*/
$(document).on("click", "#btn_cancelar_tienda", function () {

    pr_id = '';
    $("#txt_nombre_tienda").val('');
    $("#txt_ciudad_tienda").val('');
    $("#txt_direccion_tienda").val('');
    $("#editar_tienda").hide();
    $("#create_tienda").show();
});



/*=============================================
EDITAR CADEN
=============================================*/
$(document).on("click", "#btn_editar_tienda", function () {

    var comprobar = $('#txt_nombre_tienda').val().length * $('#txt_ciudad_tienda').val().length * $('#txt_direccion_tienda').val().length;
    if (comprobar > 0) {

        var value = {

            txt_id_tienda        : pr_id,
            txt_nombre_tienda    : $("#txt_nombre_tienda").val(),
            txt_ciudad_tienda    : $("#txt_ciudad_tienda").val(),
            txt_direccion_tienda : $("#txt_direccion_tienda").val(),
            txt_option           : '8'
        };
        $.ajax(
            {
                url: "../../Controller/Controller_corpo.php",
                type: "POST",
                data: value,
                beforeSend: function () {
                    AlertaEspera('esperando');
                },
                success: function (data, textStatus, jqXHR) {
                    var data = jQuery.parseJSON(data);
                    if (data.result == 1) {

                        $("#txt_nombre_tienda").val('');
                        $("#txt_ciudad_tienda").val('');
                        $("#txt_direccion_tienda").val('');
                        pr_id=''
                        var parametros =
                        {
                            "txt_option": '6',
                            "table": "#table_tiendas",
                            "txt_id": pr_id_cadena

                        }
                        table_tiendas(parametros);
                        AlertaExito('EXITO', 'EXITO');
                        NotifiExito('Tienda editada!');
                        $("#editar_tienda").hide();
                        $("#btn_save_tienda").show();
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
        var  msj2  = '';
        var txt_nombre_tienda = document.getElementById("txt_nombre_tienda").value;
        if (txt_nombre_tienda == null || txt_nombre_tienda.length == 0 || /^\s+$/.test(txt_nombre_tienda)) {
            var msj = 'Indique nombre!<br>';
            $("#txt_nombre_tienda").focus();
        }

        var txt_ciudad_tienda = document.getElementById("txt_ciudad_tienda").value;
        if (txt_ciudad_tienda == null || txt_ciudad_tienda.length == 0 || /^\s+$/.test(txt_ciudad_tienda)) {
           var msj1 = 'Indique ciudad!<br>';
           $("#txt_ciudad_tienda").focus();
        }

        var txt_direccion_tienda = document.getElementById("txt_direccion_tienda").value;
        if (txt_direccion_tienda == null || txt_direccion_tienda.length == 0 || /^\s+$/.test(txt_direccion_tienda)) {
           var msj2 = 'Indique dirección!<br>';
           $("#txt_direccion_tienda").focus();
        }
		
		 NotifiError(msj+msj1+msj2);
    } 
});


 /*=============================================
	DESACTIVAR TIENDA
	=============================================*/
	$(document).on("click", ".btn_delete_tienda", function () {


		var  pr_id     = $(this).attr("pr_id");
		var  pr_nombre = $(this).attr("pr_nombre");


		Swal.fire({
			title: "Desea desactivar tienda?",
			text: "Tienda a desactivar: " + $(this).attr("pr_nombre") + "",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si'
		  }).then((result) => {

			if (result.isConfirmed) {
			  
				var value = {
					txt_id     : pr_id,
					txt_nombre : pr_nombre,
					txt_option : '9'
				};
				$.ajax(
					{
						url: "../../Controller/Controller_corpo.php",
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
                                    "table": "#table_tiendas",
                                    "txt_id": pr_id_cadena
        
                                }
                                table_tiendas(parametros);
								AlertaExito('EXITO', 'EXITO');
								NotifiExito('Tienda desactivada!');
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
	ACTIVAR CADENA
	=============================================*/
	$(document).on("click", ".btn_activar_tienda", function () {


		var  pr_id     = $(this).attr("pr_id");
		var  pr_nombre = $(this).attr("pr_nombre");


		Swal.fire({
			title: "Desea activar tienda?",
			text: "Tienda a activar : " + $(this).attr("pr_nombre") + "",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si'
		  }).then((result) => {

			if (result.isConfirmed) {
			  
				var value = {
					txt_id     : pr_id,
					txt_nombre : pr_nombre,
					txt_option : '10'
				};
				$.ajax(
					{
						url: "../../Controller/Controller_corpo.php",
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
                                    "table": "#table_tiendas",
                                    "txt_id": pr_id_cadena
        
                                }
                                table_tiendas(parametros);
								AlertaExito('EXITO', 'EXITO');
								NotifiExito('Tienda activada!');
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



    var bandera = true;
txt_cliente=0;
txt_cliente2=0;
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
        }
        else {
            $(this).val(ui.item.label);
            $(this).attr("data", ui.item.value5);
            txt_cliente2 = ui.item.value5;            
            txt_cliente = ui.item.value;            
            txt_canalid= ui.item.value2;
            txt_subcanal= ui.item.value3;
            codigovendedor = ui.item.value7;            
            txt_canal= ui.item.value4;
            $("#txt_canal").val(txt_canal);
            $("#txt_subcanal").val(txt_subcanal);

        }
    },
    focus: function (event, ui) {
        event.preventDefault();
        $(this).val(ui.item.label);
        $(this).attr("data", ui.item.value5);
        txt_cliente2 = ui.item.value5;
        codigovendedor = ui.item.value7;            
        txt_cliente = ui.item.value;            
        txt_canalid= ui.item.value2;
        txt_subcanal= ui.item.value3;
        txt_canal= ui.item.value4;
        $("#txt_canal").val(txt_canal);
        $("#txt_subcanal").val(txt_subcanal);
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
    
});
