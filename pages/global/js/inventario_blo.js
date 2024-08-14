var parametros =
{
    "txt_option"          : '1',
        "table"           : "#table_ventas_bloeuqeo",
}
table_ventas_bloeuqeo(parametros);

function table_ventas_bloeuqeo(parametros) {
$(parametros.table).dataTable().fnDestroy();
var dt = $(parametros.table).DataTable({                    
    "bProcessing": false,
    "serverSide": false,
    "paging": false,
    "lengthChange": false,
    "searching": false,
    "ordering": false,
    "info": false,
    "responsive": false,
    "autoWidth": true,
 
    jQueryUI: false,
   "lengthMenu":		[[5, 10, 20, 25, 50], [5, 10, 20, 25, 50]],
  "iDisplayLength":	500,
   "ajax": {
    "url": "../../Controller/Controller_inventario_blo.php", 
     "type": "POST",
     "data": parametros,
   },
   "columns":
        [
            { "data": "id" },
            { "data": "perfil" },
            { "data": "estado" },
        ],
 }); 	
}

function mostrar(id,estado) 
{
    var value = {
        id:id,
        estado:estado,
        txt_option           : '2'
    };
    $.ajax(
        {
            url: "../../Controller/Controller_inventario_blo.php",
            type: "POST",
            data: value,
            beforeSend: function () {
              //  AlertaEspera('esperando');
            },
            success: function (data, textStatus, jqXHR) {
                var data = jQuery.parseJSON(data);
                if (data.result == 1) {
                  
                    var parametros =
                    {
                        "txt_option"          : '1',
                            "table"           : "#table_ventas_bloeuqeo",
                    }
                    table_ventas_bloeuqeo(parametros);
                   NotifiExito('Actualizacion exitosa!');
                }
                else {
                    NotifiError(data.error);
                    AlertaExito('EXITO', 'EXITO');
                }
            }
        });
}