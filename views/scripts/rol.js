var tabla;

//Función que se ejecuta al inicio
function init() {
    //Para validación
    //$('#nombre').validacion(' abcdefghijklmnñopqrstuvwxyzáéíóú');
    //$('#descripcion').validacion(' abcdefghijklmnñopqrstuvwxyzáéíóú');

    $('.permiso').select2();
    mostrarform(false);
    listar();

    //Cargamos los items al select categoria
    $.post("../controller/permiso.php?op=5", function(r) {
        $("#idpermiso").html(r);
        $('#idpermiso').selectpicker('refresh');
    });

    $("#formulario").on("submit", function(e) {
        guardaryeditar(e);
    })

}

//Función limpiar
function limpiar() {
    $("#nombre").val("");
    $("#descripcion").val("");
    $("#idrol").val("");
    $("#permiso").select2("val", "");
}

//Función mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}

//Función cancelarform
function cancelarform() {
    limpiar();
    mostrarform(false);
}

//Función Listar
function listar() {
    tabla = $('#tbllistado').dataTable({
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip', //Definimos los elementos del control de tabla
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../controller/rol.php?op=0',
            type: "get",
            dataType: "json",
            error: function(e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 10, //Paginación
        "order": [
                [0, "desc"]
            ] //Ordenar (columna,orden)
    }).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../controller/rol.php?op=1",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos) {
            console.log(datos);
            mensaje = datos.split(":");
            if (mensaje[0] == "1") {
                swal.fire(
                    'Mensaje de Confirmación',
                    mensaje[1],
                    'success'
                );
                mostrarform(false);
                tabla.ajax.reload();
            } else {
                Swal.fire({
                    type: 'error',
                    title: 'Error',
                    text: mensaje[1],
                    footer: 'Verifique la información de Registro, en especial que la información no fué ingresada previamente a la Base de Datos.'
                });
            }
        }

    });
    limpiar();
}

function mostrar(idrol) {
    $.post("../controller/rol.php?op=4", { idrol: idrol }, function(data, status) {
        data = JSON.parse(data);
        mostrarform(true);
        $("#nombre").val(data.rolnombre);
        $("#descripcion").val(data.roldescripcion);
        $("#idrol").val(data.idrol);
        $.post("../controller/permiso.php?op=6&id=" + data.idrol, function(r) {
            $("#idpermiso").html(r);
        });
    })
}

//Función para desactivar registros
function desactivar(idrol) {
    swal.fire({
        title: 'Mensaje de Confirmación',
        text: "¿Desea desactivar el Registro?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Desactivar'
    }).then((result) => {
        if (result.value) {
            $.post("../controller/rol.php?op=2", { idrol: idrol }, function(e) {
                mensaje = e.split(":");
                if (mensaje[0] == "1") {
                    swal.fire(
                        'Mensaje de Confirmación',
                        mensaje[1],
                        'success'
                    );
                    tabla.ajax.reload();
                } else {
                    Swal.fire({
                        type: 'error',
                        title: 'Error',
                        text: mensaje[1],
                        footer: 'Verifique la información de Registro, en especial que la información no fué ingresada previamente a la Base de Datos.'
                    });
                }
            });
        }
    });
}

//Función para activar registros
function activar(idrol) {
    swal.fire({
        title: 'Mensaje de Confirmación',
        text: "¿Desea activar el Registro?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Activar'
    }).then((result) => {
        if (result.value) {
            $.post("../controller/rol.php?op=3", { idrol: idrol }, function(e) {
                mensaje = e.split(":");
                if (mensaje[0] == "1") {
                    swal.fire(
                        'Mensaje de Confirmación',
                        mensaje[1],
                        'success'
                    );
                    tabla.ajax.reload();
                } else {
                    Swal.fire({
                        type: 'error',
                        title: 'Error',
                        text: mensaje[1],
                        footer: 'Verifique la información de Registro, en especial que la información no fué ingresada previamente a la Base de Datos.'
                    });
                }
            });
        }
    });
}

init();