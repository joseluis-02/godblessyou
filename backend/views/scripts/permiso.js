var tabla;

//Función que se ejecuta al inicio
function init() {
    mostrarform(false);
    listar();
    $("#formulario_permiso").on("submit", function(e) {
        guardaryeditar(e);
    })
}
//Función limpiar
function limpiar() {
    $("#nombre").val("");
    $("#idpermiso").val("");
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
    tabla = $('#datatable_permiso').dataTable({
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
            url: '../controller/permiso.php?op=0',
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
    var formData = new FormData($("#formulario_permiso")[0]);

    $.ajax({
        url: "../controller/permiso.php?op=1",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos) {
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
                    footer: 'Revise la información de registro...'
                });
            }
        }

    });
    limpiar();
}

function mostrar(idpermiso) {
    $.post("../controller/permiso.php?op=4", { idpermiso: idpermiso }, function(data, status) {
        data = JSON.parse(data);
        mostrarform(true);
        $("#nombre").val(data.permisonombre);
        $("#idpermiso").val(data.idpermiso);
        console.log(data);
    })
}

//Función para desactivar registros
function desactivar(idpermiso) {
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
            $.post("../controller/permiso.php?op=2", { idpermiso: idpermiso }, function(e) {
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
                        footer: 'Revise la información cuidadosamente por favor'
                    });
                }
            });
        }
    });
}

//Función para activar registros
function activar(idpermiso) {
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
            $.post("../controller/permiso.php?op=3", { idpermiso: idpermiso }, function(e) {
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
                        footer: 'Revise la información cuidadosamente por favor'
                    });
                }
            });
        }
    });
}
init();