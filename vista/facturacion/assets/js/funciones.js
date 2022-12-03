document.addEventListener("DOMContentLoaded", function () {
    $('#tbl').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
        "order": [
            [0, "desc"]
        ]
    });

    $(".confirmar").submit(function (e) {
        e.preventDefault();
        Swal.fire({
            title: 'Esta seguro de eliminar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'SI, Eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        })
    })

    //BUSCA AL CLIENTE
    $("#nom_cliente").autocomplete({
        minLength: 2,
        source: function (request, response) {
            $.ajax({
                url: "ajax.php",
                dataType: "json",
                data: {
                    q: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            $("#idcliente").val(ui.item.id);
            $("#nom_cliente").val(ui.item.label);
            $("#tel_cliente").val(ui.item.telefono);
            $("#idt_cliente").val(ui.item.nombre);
        }
    })
    
    //BUSCA EL PRODUCTO
    $("#producto").autocomplete({
        minLength: 2,
        source: function (request, response) {
            $.ajax({
                url: "ajax.php",
                dataType: "json",
                data: {
                    pro: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            $("#id").val(ui.item.id);
            $("#producto").val(ui.item.value);
            $("#precio").val(ui.item.precio);
            $("#cantidad").focus();
        }
    })

    //BUSCA LA PROMOCION
    $("#promocion").autocomplete({
        minLength: 2,
        source: function (request, response) {
            $.ajax({
                url: "ajax.php",
                dataType: "json",
                data: {
                    prom: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            $("#id_prom").val(ui.item.id);
            $("#promocion").val(ui.item.value);
            $("#precio_prom").val(ui.item.precio);
            $("#cantidad_prom").focus();
        }
    })

    //BUSCAR DESCUNETO
    $("#descuento").autocomplete({
        minLength: 2,
        source: function (request, response) {
            $.ajax({
                url: "ajax.php",
                dataType: "json",
                data: {
                    des: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        select: function (event, ui) {
            $("#id_desc").val(ui.item.id);
            $("#descuento").val(ui.item.value);
            $("#descu").val(ui.item.precio);
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Descuento Ingresado',
                showConfirmButton: false,
                timer: 2000
            })
            calcular();
        }
    })

    $('#btn_generar').click(function (e) {
        e.preventDefault();
        var rows = $('#tblDetalle tr').length;
        if (rows > 2) {
            var action = 'procesarVenta';
            var id = $('#idcliente').val();
            var desc = $('#id_desc').val();
            var descrip = $('#descripcion').val();
            var sucur= $('#sucursal').val();
            var pago= $('#Pago').val();
            var id_user= $('#vendedor').val();
            var tipo_pago=$('#pago').val();
            $.ajax({
                url: 'ajax.php',
                async: true,
                data: {
                    procesarVenta: action,
                    id: id,
                    desc:desc,
                    descrip:descrip,
                    sucur:sucur,
                    pago:pago,
                    id_user:id_user,
                    tipo_pago:tipo_pago
                },
                success: function (response) {

                    const res = JSON.parse(response);
                    if (response != 'error') {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Venta Generada',
                            showConfirmButton: false,
                            timer: 2000
                        })
                        setTimeout(() => {
                            generarPDF(res.id_cliente, res.id_venta);
                            location.reload();
                        }, 300);
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Error al generar la venta',
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }
                },
                error: function (error) {

                }
            });
        } else {
            Swal.fire({
                position: 'top-end',
                icon: 'warning',
                title: 'No hay producto para generar la venta',
                showConfirmButton: false,
                timer: 2000
            })
        }
    });
    if (document.getElementById("detalle_venta")) {
        listar();
        listar_prom();
    }
})
//CALCULAR PRECIO DE PRODUCTO
function calcularPrecio(e) {
    e.preventDefault();
    const cant = $("#cantidad").val();
    const precio = $('#precio').val();
    const total = cant * precio;
    $('#sub_total').val(total);
    if (e.which == 13) {
        if (cant > 0 && cant != '') {
            const id = $('#id').val();
            registrarDetalle(e, id, cant, precio);
            $('#producto').focus();
        }else {
            $('#cantidad').focus();
            return false;
        }
    }
}


//CALCULAR PRECIO DE PROMOCION
function calcularPrecioProm(e) {
    e.preventDefault();
    const cant = $("#cantidad_prom").val();
    const precio = $('#precio_prom').val();
    const total = cant * precio;
    $('#sub_total_prom').val(total);
    if (e.which == 13) {
        if (cant > 0 && cant != '') {
            const id = $('#id_prom').val();
            const regi =2;
            registrarDetalleProm(e, id, cant, precio, regi);
            $('#promocion').focus();
        }else {
            $('#cantidad_prom').focus();
            return false;
        }
    }
}

//ENLISTA LOS PRODUCTOS
function listar() {
    let html = '';
    let detalle = 'detalle';
    $.ajax({
        url: "ajax.php",
        dataType: "json",
        data: {
            detalle: detalle
        },
        success: function (response) {

            response.forEach(row => {
                html += `<tr>
                <td>${row['nombre']}</td>
                <td>${row['cantidad']}</td>
                <td>${row['precio_venta']}</td>
                <td>${row['sub_total']}</td>
                <td><button class="btn btn-danger" type="button" onclick="deleteDetalle(${row['id']})">
                <i class="fas fa-trash-alt"></i></button></td>
                </tr>`;
            });
            document.querySelector("#detalle_venta").innerHTML = html;
            calcular();
        }
    });
}

//ENLISTA LAS PROMOCIONES
function listar_prom() {
    let html = '';
    let detalleProm = 'detalleProm';
    $.ajax({
        url: "ajax.php",
        dataType: "json",
        data: {
            detalleProm: detalleProm
        },
        success: function (response) {

            response.forEach(row => {
                html += `<tr>
                <td>${row['nombre']}</td>
                <td>${row['cantidad']}</td>
                <td>${row['precio_venta']}</td>
                <td>${row['sub_total']}</td>
                <td><button class="btn btn-danger" type="button" onclick="deleteDetalleProm(${row['id']})">
                <i class="fas fa-trash-alt"></i></button></td>
                </tr>`;
            });
            document.querySelector("#detalle_venta_prom").innerHTML = html;
            calcular();
        }
    });
}

//REGISTRA LA TRANSACCION DE LOS PRODUCTOS 
function registrarDetalle(e, id, cant, precio) {
    if (document.getElementById('producto').value != '') {
        if (id != null) {
            let action = 'regDetalle';
            $.ajax({
                url: "ajax.php",
                type: 'POST',
                dataType: "json",
                data: {
                    id: id,
                    cant: cant,
                    regDetalle: action,
                    precio: precio
                },
                success: function (response) {
    
                    if (response == 'registrado') {
                        $('#cantidad').val('');
                        $('#precio').val('');
                        $("#producto").val('');
                        $("#sub_total").val('');
                        $("#producto").focus();
                        listar();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Producto Ingresado',
                            showConfirmButton: false,
                            timer: 2000
                        })
                    } else if (response == 'actualizado') {
                        $('#cantidad').val('');
                        $('#precio').val('');
                        $("#producto").val('');
                        $("#sub_total").val('');
                        $("#producto").focus();
                        listar();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Producto Actualizado',
                            showConfirmButton: false,
                            timer: 2000
                        })
                    } else {
                        $('#id').val('');
                        $('#cantidad').val('');
                        $('#precio').val('');
                        $("#producto").val('');
                        $("#sub_total").val('');
                        $("#producto").focus();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: response,
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }
                }
            });
        }
    }
}

//ELIMINA LOS PRODUCTOS DEL PEDIDO
function deleteDetalle(id) {
    let detalle = 'Eliminar'
    $.ajax({
        url: "ajax.php",
        data: {
            id: id,
            delete_detalle: detalle
        },
        success: function (response) {
    
            if (response == 'restado') {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Producto Descontado',
                    showConfirmButton: false,
                    timer: 2000
                })
                document.querySelector("#producto").value = '';
                document.querySelector("#producto").focus();
                listar();
            } else if (response == 'ok') {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Producto Eliminado',
                    showConfirmButton: false,
                    timer: 2000
                })
                document.querySelector("#producto").value = '';
                document.querySelector("#producto").focus();
                listar();
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error al eliminar el producto',
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        }
    });
}


//REGISTRA LA TRANSACCION DE LOS PROMOCION 
function registrarDetalleProm(e, id, cant, precio) {
    if (document.getElementById('promocion').value != '') {
        if (id != null) {
            let action = 'regDetalleProm';
            $.ajax({
                url: "ajax.php",
                type: 'POST',
                dataType: "json",
                data: {
                    id: id,
                    cant: cant,
                    regDetalleProm: action,
                    precio: precio
                },
                success: function (response) {
    
                    if (response == 'registrado') {
                        $('#cantidad_prom').val('');
                        $('#precio_prom').val('');
                        $("#promocion").val('');
                        $("#sub_total_prom").val('');
                        $("#promocion").focus();
                        listar_prom();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Promocion Ingresada',
                            showConfirmButton: false,
                            timer: 2000
                        })
                    } else if (response == 'actualizado') {
                        $('#cantidad_prom').val('');
                        $('#precio_prom').val('');
                        $("#promocion").val('');
                        $("#sub_total_prom").val('');
                        $("#promocion").focus();
                        listar_prom();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Promocion Actualizada',
                            showConfirmButton: false,
                            timer: 2000
                        })
                    } else {
                        $('#id_prom').val('');
                        $('#cantidad_prom').val('');
                        $('#precio_prom').val('');
                        $("#promocion").val('');
                        $("#sub_total_prom").val('');
                        $("#promocion").focus();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: response,
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }
                }
            });
        }
    }
}

//ELIMINA LOS PRODUCTOS DEL PEDIDO
function deleteDetalleProm(id) {
    let detalle = 'Eliminar'
    $.ajax({
        url: "ajax.php",
        data: {
            id: id,
            delete_detalle_prom: detalle
        },
        success: function (response) {
    
            if (response == 'restado') {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'promocion Descontada',
                    showConfirmButton: false,
                    timer: 2000
                })
                document.querySelector("#promocion").value = '';
                document.querySelector("#promocion").focus();
                listar_prom();
            } else if (response == 'ok') {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'promocion Eliminada',
                    showConfirmButton: false,
                    timer: 2000
                })
                document.querySelector("#promocion").value = '';
                document.querySelector("#promocion").focus();
                listar_prom();
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error al eliminar el producto',
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        }
    });
}

//CALCULA LOS PRODUCTOS
function calcular() {
    // obtenemos todas las filas del tbody
    var filas = document.querySelectorAll("#tblDetalle tbody tr");
    
    var total = 0;
    
    // recorremos cada una de las filas
    filas.forEach(function (e) {
    
        // obtenemos las columnas de cada fila
        var columnas = e.querySelectorAll("td");
    
        // obtenemos los valores de la cantidad y importe
        var importe = parseFloat(columnas[3].textContent);
    
        total += importe;
    });
    


    var valor=document.getElementById("descu").value;
    // mostramos EL SUB TOTAL
    var filas = document.querySelectorAll("#tblDetalle tfoot tr td");
    filas[1].textContent = total.toFixed(2);
    // mostramos EL ISV
    var filas = document.querySelectorAll("#tblDetalle tfoot tr td");
    filas[3].textContent = ((filas[1].textContent*15)/100).toFixed(2);
    // mostramos EL DESCUENTO
    var filas = document.querySelectorAll("#tblDetalle tfoot tr td");
    filas[5].textContent = ((filas[1].textContent*valor)/100).toFixed(2);
    // mostramos EL TOTAL A PAGAR
    var filas = document.querySelectorAll("#tblDetalle tfoot tr td");
    filas[7].textContent = (parseFloat(filas[1].textContent) + parseFloat(filas[3].textContent) - parseFloat(filas[5].textContent)).toFixed(2);

    var pago=document.getElementById("Pago").value;

    var filas = document.querySelectorAll("#tblDetalle tfoot tr td");
    filas[11].textContent = (parseFloat(pago)-parseFloat(filas[7].textContent)).toFixed(2) ;

}

function generarPDF(cliente, id_venta) {
    url = 'pdf/generar.php?cl=' + cliente + '&v=' + id_venta;
    window.open(url, '_blank');
}

///////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////