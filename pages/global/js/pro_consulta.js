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
BUSCADOS PREDICTIVO DE PROMOTOR
=============================================*/
var bandera = true;
txt_promotor=0;
$("#txt_promotor").autocomplete({

    source: function (request, response) {

        if (bandera) {
            $.ajax({
                url: "../../Controller/Controller_pro_consulta.php",
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
 
    var txt_promotorb  = txt_promotor;
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
    
    
    var txt_cadena = $("#txt_cadena").val();
    var txt_tienda = $("#txt_tienda").val();

    var parametros =
    {
        "txt_option"      : '2',
        "table"           : "#table_ventas",
        "txt_fechain"     : txt_fechain,
        "txt_fechafin"    : txt_fechafin,
        "txt_promotor"    : txt_promotorb,
        "txt_cadena"      : txt_cadena,
        "txt_tienda"      : txt_tienda,
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
    
}
table_ventas(parametros);

function table_ventas(parametros) {

$(parametros.table).dataTable().fnDestroy();
var dt = $(parametros.table).DataTable({                    
    "bProcessing": true,
    "serverSide": true,
    "paging": true,
    "lengthChange": false,
    "searching": false,
    "ordering": false,
    "info": false,
    "responsive": true,
    "autoWidth": true,
   "language": {
     "url": "vistas/dist/js/Spanish.json"
   },    
    jQueryUI: false,
  "iDisplayLength":	500,
   "ajax": {
    "url": "../../Controller/Controller_pro_consulta.php", 
     "type": "POST",
     "data": parametros,
   },
   "columns":
        [
            { "data": "id" },
            { "data": "datos" },
            { "data": "promotor" },
            { "data": "cadena" },
            { "data": "item" },
            { "data": "forma_pago" },
            { "data": "cantidad" },
            { "data": "valor" },
            { "data": "button" },
        ],
 }); 	
}

function saludos(){
    $("#search").keyup(); 
   // alert('oks');
 }


 setInterval('saludos()',1000);

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
                "url": "../../Controller/Controller_pro_consulta.php",
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



    

    /*=============================================
	DESACTIVAR CADENA
	=============================================*/
	$(document).on("click", ".btn_delete_registro", function () {


		var  nombre = $(this).attr("nombre");


		Swal.fire({
			title: "Desea elimar el registro?",
			text: "Registro a Eliminar: " + $(this).attr("nombre") + "",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Si'
		  }).then((result) => {

			if (result.isConfirmed) {
			  
				var value = {
					txt_nombre : nombre,
					txt_option : '4'
				};
				$.ajax(
					{
						url: "../../Controller/Controller_pro_consulta.php",
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
    
}
table_ventas(parametros);
								AlertaExito('EXITO', 'EXITO');
								NotifiExito('Registro eliminado!');
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
