/*=============================================
CARGAR CATEGORIAS
=============================================*/
load_categorias();
function load_categorias() {
    var parametros = {
        "txt_option": "1"
    };
    $.ajax({
        url: "../../Controller/Controller_usuario.php",
        type: "POST",
        data: parametros,
        success: function (option) {
            $("#txt_categoria").html(option);
        }
    });
}


/*=============================================
REGISTER USER
=============================================*/
$(document).on("click", "#btn_save_usuario", function () {

    var comprobar = $('#txt_nombre').val().length * $('#txt_usuario').val().length
    * $('#txt_email').val().length  * $('#txt_clave').val().length * $('#txt_categoria').val().length*
     $('#txt_tfno').val().length;
    if (comprobar > 0) {

        var value = {
            txt_nombre            : $("#txt_nombre").val(),
            txt_usuario           : $("#txt_usuario").val(),
            txt_email             : $("#txt_email").val(),
            txt_clave             : $("#txt_clave").val(),
            txt_categoria         : $("#txt_categoria").val(),
            txt_tfno         : $("#txt_tfno").val(),
            txt_codvendedor         : $("#txt_codvendedor").val(),
            txt_option            : '2'
        };
        $.ajax(
            {
                url: "../../Controller/Controller_usuario.php",
                type: "POST",
                data: value,
                beforeSend: function () {
                    AlertaEspera('esperando');
                },
                success: function (data, textStatus, jqXHR) {
                    var data = jQuery.parseJSON(data);
                    if (data.result == 1) {

                        $("#txt_nombre").val('');
                        $("#txt_usuario").val('');
                        $("#txt_email").val('');
                        $("#txt_clave").val('');
                        $("#txt_categoria").val('');
                        var parametros =
                        {
                            "txt_option": '3',
                            "table": "#table_usuario"

                        }
                        table_empresas(parametros);
                        AlertaExito('EXITO', 'EXITO');
                        NotifiExito('Usuario Registrado');
                        $("#editar_usuario").hide();
                        $("#create_usuario").show();
                    }
                    else {
                        NotifiError(data.error);
                        AlertaExito('EXITO', 'EXITO');
                    }
                }
            });

    }
    else {

        var txt_nombre = document.getElementById("txt_nombre").value;
        if (txt_nombre == null || txt_nombre.length == 0 || /^\s+$/.test(txt_nombre)) {
            NotifiError('Indicar nombre!');
        }

        var txt_usuario = document.getElementById("txt_usuario").value;
        if (txt_usuario == null || txt_usuario.length == 0 || /^\s+$/.test(txt_usuario)) {
            NotifiError('Indicar usuario!');
        }


        var txt_email = document.getElementById("txt_email").value;
        if (txt_email == null || txt_email.length == 0 || /^\s+$/.test(txt_email)) {
            NotifiError('Indicar email!');
        }


        var txt_clave = document.getElementById("txt_clave").value;
        if (txt_clave == null || txt_clave.length == 0 || /^\s+$/.test(txt_clave)) {
            NotifiError('Indicar clave!');
        }

        var txt_categoria = document.getElementById("txt_categoria").value;
        if (txt_categoria == null || txt_categoria.length == 0 || /^\s+$/.test(txt_categoria)) {
            NotifiError('Indicar categoria!');
        }

    } 
});


/*=============================================
TABLE USER
=============================================*/
var parametros =
{
    "txt_option": '3',
    "table": "#table_usuario"

}
table_empresas(parametros);
function table_empresas(parametros) {

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
			"url": "../../Controller/Controller_gb_usuario.php",
			"data": parametros,
			"type": "POST"
		},
		"columns":
			[
				{ "data": "id" },
				{ "data": "Nombre" },
                { "data": "usuario" },
                { "data": "telefono" },
                { "data": "cod_vendedor" },
                { "data": "email" },
				{ "data": "categoria" },
                { "data": "button" },
			]
	});
}



/*=============================================
CARGAR DATOS EMPLEADO A EDITAR
=============================================*/
id_empleado='';
$("#table_usuario tbody").on("click","button.btn_load_edit_user",function(e)
	{
	    e.preventDefault();
	    var table = $('#table_usuario').DataTable(); 
	    var data=table.row($(this).parents("tr")).data();
	    var cell = table.cell( $(this).parents("td"));
	    $('#table_usuario  tr').removeClass("success");  
	    table.row($(this).parents("tr").addClass("success"));

        var dp_perfil = $(this).attr("dp_perfil");
        id_usuario=$(this).attr("dp_id");
        $("#txt_nombre").val($(this).attr("dp_nombre"));
        $("#txt_usuario").val($(this).attr("dp_usuario"));
        $("#txt_tfno").val($(this).attr("telefono"));
        $("#txt_codvendedor").val($(this).attr("cod_vendedor"));
        $("#txt_email").val($(this).attr("dp_email"));

        
        $("#txt_categoria").val(dp_perfil);

        $("#editar_usuario").show();
        $("#create_usuario").hide();
});



/*=============================================
EDIT USER
=============================================*/
$(document).on("click", "#btn_editar_usuario", function () {

    var comprobar = $('#txt_nombre').val().length * $('#txt_usuario').val().length
    * $('#txt_email').val().length  * $('#txt_categoria').val().length* $('#txt_tfno').val().length;
    if (comprobar > 0) {

        var value = {

            txt_id_user           : id_usuario,
            txt_nombre            : $("#txt_nombre").val(),
            txt_usuario           : $("#txt_usuario").val(),
            txt_codvendedor           : $("#txt_codvendedor").val(),
            txt_tfno           : $("#txt_tfno").val(),
            txt_email             : $("#txt_email").val(),
            txt_categoria         : $("#txt_categoria").val(),
            txt_clave             : $("#txt_clave").val(),
            txt_option            : '4'
        };
        $.ajax(
            {
                url: "../../Controller/Controller_usuario.php",
                type: "POST",
                data: value,
                beforeSend: function () {
                    AlertaEspera('esperando');
                },
                success: function (data, textStatus, jqXHR) {
                    var data = jQuery.parseJSON(data);
                    if (data.result == 1) {

                        $("#txt_nombre").val('');
                        $("#txt_usuario").val('');
                        $("#txt_email").val('');
                        $("#txt_clave").val('');
                        $("#txt_tfno").val('');
                        $("#txt_codvendedor").val('');
                        $("#txt_categoria").val('');
                        var parametros =
                        {
                            "txt_option": '3',
                            "table": "#table_usuario"

                        }
                        table_empresas(parametros);
                        AlertaExito('EXITO', 'EXITO');
                        NotifiExito('Usuario editado con exito!');
                        $("#editar_usuario").hide();
                        $("#create_usuario").show();
                    }
                    else {
                        NotifiError(data.error);
                        AlertaExito('EXITO', 'EXITO');
                    }
                }
            });

    }
    else {

        var txt_nombre = document.getElementById("txt_nombre").value;
        if (txt_nombre == null || txt_nombre.length == 0 || /^\s+$/.test(txt_nombre)) {
            NotifiError('Indicar nombre!');
        }

        var txt_usuario = document.getElementById("txt_usuario").value;
        if (txt_usuario == null || txt_usuario.length == 0 || /^\s+$/.test(txt_usuario)) {
            NotifiError('Indicar usuario!');
        }


        var txt_email = document.getElementById("txt_email").value;
        if (txt_email == null || txt_email.length == 0 || /^\s+$/.test(txt_email)) {
            NotifiError('Indicar email!');
        }


        var txt_categoria = document.getElementById("txt_categoria").value;
        if (txt_categoria == null || txt_categoria.length == 0 || /^\s+$/.test(txt_categoria)) {
            NotifiError('Indicar categoria!');
        }

    } 
});


/*=============================================
DELETE USER
=============================================*/
$(document).on("click", ".btn_delete_user", function () {


    var  dp_id     = $(this).attr("dp_id");
    var  dp_usuario = $(this).attr("dp_usuario");


    Swal.fire({
        title: "Desea eliminar usuario?",
        text: "Usuario a eliminar: " + $(this).attr("dp_usuario") + "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si'
      }).then((result) => {

        if (result.isConfirmed) {
          
            var value = {
                txt_id     : dp_id,
                txt_nombre : dp_usuario,
                txt_option : '6'
            };
            $.ajax(
                {
                    url: "../../Controller/Controller_usuario.php",
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
                                "txt_option": '3',
                                "table": "#table_usuario"
                            }
                            table_empresas(parametros);
                            AlertaExito('EXITO', 'EXITO');
                            NotifiExito('Usuario eliminado!');
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