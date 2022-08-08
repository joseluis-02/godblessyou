var tabla;

//Función que se ejecuta al inicio
function init() {

    mostrarform(false);
    listar();

    $("#formulario_lugar").on("submit", function(e) {
        guardaryeditar(e);
    });
    //Cargamos los items al select
    $.post("../controller/lugarController.php?op=5", function(r) {
        $("#padre").html('<option value="0">Crear nuevo</option>');
        $("#padre").append(r);
        $('#padre').selectpicker('refresh');
    });
}

//Función limpiar
function limpiar() {
    $("#nombre").val("");
    $("#prefijo").val("");
    $("#padre").val("");
    $("#nivel").val("");
    $("#id").val("");
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
    tabla = $('#datatable_lugar').dataTable({
        "aProcessing": true, //Activamos el procesamiento del datatables
        "aServerSide": true, //Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip', //Definimos los elementos del control de tabla
        buttons: [
            'copy',
            'excel',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../controller/lugarController.php?op=0',
            type: "get",
            dataType: "json",
            error: function(e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 5, //Paginación
        "order": [
                [0, "desc"]
            ] //Ordenar (columna,orden)
    }).DataTable();
}
//Función para guardar o editar

function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario_lugar")[0]);

    $.ajax({
        url: "../controller/lugarController.php?op=1",
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
                    footer: 'Verifique la información de Registro, en especial que la información no fué ingresada previamente a la Base de Datos.'
                });
            }
        }

    });
    limpiar();
}

function mostrar(id) {
    console.log(id);
    $.post("../controller/lugarController.php?op=4", { id: id }, function(data, status) {
        data = JSON.parse(data);
        mostrarform(true);

        $("#nombre").val(data.nombre);
        $("#prefijo").val(data.prefijo);
        $("#padre").val(data.padre);
        $('#padre').selectpicker('refresh');
        $("#nivel").val(data.nivel);
        $('#nivel').selectpicker('refresh');
        $("#id").val(data.id);
    })
}

//Función para desactivar registros
function desactivar(id) {
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
            $.post("../controller/lugarController.php?op=2", { id: id }, function(e) {
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
function activar(id) {
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
            $.post("../controller/lugarController.php?op=3", { id: id }, function(e) {
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