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
        url: "../../Controller/Controller_oc_inventario.php",
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
        url: "../../Controller/Controller_oc_inventario.php",
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
            url: "../../Controller/Controller_oc_inventario.php",
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
                url: "../../Controller/Controller_oc_inventario.php",
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
    
    
    var txt_cadena = $("#txt_cadena").val();
    var txt_estado = $("#txt_estado").val();

    var txt_promotor = $("#txt_promotor").val();

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
        "txt_bodega"    : $("#txt_bodega").val(),
    }
    table_ventas(parametros);
    
});


/*=============================================
CARGAR CADENAS
=============================================*/
function buscarbodega(valor) {

    var parametros =
    {
        "txt_option"          : '2',
            "table"           : "#table_ventas",
            "txt_promotor"    : '',
            "txt_cadena"      : '',
            "txt_tienda"      : '',
            "txt_estado"    : '',
            "txt_bodega"    : valor,
    }
    table_ventas(parametros);
}

var txt_bodega =  $("#txt_bodega").val();
var parametros =
{
    "txt_option"          : '2',
        "table"           : "#table_ventas",
        "txt_promotor"    : '',
        "txt_cadena"      : '',
        "txt_tienda"      : '',
        "txt_estado"    : '',
        "txt_bodega"    : 12,
}
table_ventas(parametros);

function table_ventas(parametros) {
//    "buttons": [ 'copy', 'csv', 'excel', 'pdf', 'print' ],
//    "dom": 'Bfrtip',

$(parametros.table).dataTable().fnDestroy();
var dt = $(parametros.table).DataTable({                    
    "bProcessing": true,
    "serverSide": false,
    "paging": false,
    "lengthChange": true,
    "searching": false,
    "ordering": false,
    "info": false,
    "responsive": true,
    "autoWidth": true,
 
    jQueryUI: true,
    "dom": 'Bfrtip',
    "buttons": [ 'copy', 'csv', 'excel', 'pdf', 'print' ],
   "lengthMenu":		[[5, 10, 20, 25, 50], [5, 10, 20, 25, 50]],
  "iDisplayLength":	500,
   "ajax": {
    "url": "../../Controller/Controller_oc_inventario.php", 
     "type": "POST",
     "data": parametros,
   },
   "columns":
        [
            { "data": "id" },
            { "data": "item" },
            { "data": "descripcion" },
            { "data": "stockfragata" },
            { "data": "ocsproceso" },
            { "data": "totalreserva" },
            { "data": "stock" },
            { "data": "accion" },            
        ],
 }); 	
}

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
                "url": "../../Controller/Controller_oc_inventario.php",
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
EDIT USER
=============================================*/

$(document).on("click", ".btn_edit_estado", function () {
var id = $(this).attr("log_id");
    var value = {
        txt_id_edit    :  id,
        txt_option            : '5'
    };
    $.ajax(
        {
            url: "../../Controller/Controller_oc_inventario.php",
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
                    NotifiExito('Orden de Compra Despachada con exito!');
                  
               
           // }
        //});




}
});



});








var id_guia = '';
$("#table_ventas tbody").on("click","button.btn_verreservas",function(e)
{
   
    id_guia = $(this).attr("pr_item");
     var parametros =
    {
        "txt_option": '7',
        "ordencompra":id_guia,
        "table": "#table_venta"
    
    }
    table_venta(parametros);

   
    $("#modal_editar_orden").modal('show'); 
  
});





function table_venta(parametros) {
    //    "buttons": [ 'copy', 'csv', 'excel', 'pdf', 'print' ],
    //    "dom": 'Bfrtip',
    
    $(parametros.table).dataTable().fnDestroy();
    var dt = $(parametros.table).DataTable({                    
        "bProcessing": false,
        "serverSide": false,
        "paging": false,
        "lengthChange": true,
        "searching": false,
        "ordering": false,
        "info": false,
        "responsive": true,
        "autoWidth": true,
     
        jQueryUI: false,
       "lengthMenu":		[[5, 10, 20, 25, 50], [5, 10, 20, 25, 50]],
      "iDisplayLength":	500,
       "ajax": {
        "url": "../../Controller/Controller_oc_inventario.php", 
         "type": "POST",
         "data": parametros,
       },
       "columns":
            [
                { "data": "id" },
                { "data": "fecha" },
                { "data": "cliente" },
                { "data": "reservada" },
            ],
     }); 	
    }