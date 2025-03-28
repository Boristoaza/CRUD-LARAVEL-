
document.addEventListener("DOMContentLoaded", function () {
  // Delegación de eventos para los botones de la tabla
  document.querySelector(".Tabla_datos").addEventListener("click", function (event) {
      if (event.target.closest(".botonPerfil")) {
          let id = event.target.closest(".botonPerfil").dataset.id;
          alert("Ver perfil de ID: " + id);
      }
      if (event.target.closest(".btneditar")) {
          let id = event.target.closest(".btneditar").dataset.id;
          alert("Editar usuario con ID: " + id);
      }
      if (event.target.closest(".btnBorrar")) {
          let name = event.target.closest(".btnBorrar").dataset.nombre;
          let nombre = event.target.closest(".btnBorrar").dataset.borrar;
          let url = event.target.closest(".btnBorrar").dataset.delete;
      }
  });

  // Función para filtrar la tabla
  function filtrarTabla() {
      let filtro = document.getElementById("Buscador").value.toLowerCase();
      let filas = document.querySelectorAll(".Tabla_datos tr");

      filas.forEach(fila => {
          let nombre = fila.querySelector("td:first-child").textContent.toLowerCase();
          if (nombre.includes(filtro)) {
              fila.style.display = "";
          } else {
              fila.style.display = "none";
          }
      });
  }

  document.getElementById("Buscador").addEventListener("input", filtrarTabla);

  document.getElementById("btnBuscador").addEventListener("click", function (event) {
      event.preventDefault(); // Evita que se recargue la página
      filtrarTabla();
  });
});

// buscador
$(document).ready(function () {
  $('#btnBuscador').click(function () {
      const inputData = $('#Buscador').val();
      const url = $(this).data('url');
      $.ajax({
          url: url,
          type: 'POST',
          data: { datos: inputData },
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function (respuesta) {
            console.log('Respuesta recibida:', respuesta);
            var tablaContainer = $('.Tabla_datos');
            tablaContainer.empty();
            if (respuesta.resultado && Array.isArray(respuesta.resultado) && respuesta.resultado.length > 0) {
                respuesta.resultado.forEach(element => {
                    var tabla = `
                      <tr>
                      <td> ${ element.nombre }</td>
                      <td> ${ element.edad }</td>
                      <td> ${ element.actividad }</td>
                      <td> ${ element.datos_curiosos }</td>
                      <td>
                        <div id="btnDinamicos" class="btnDinamicos btn-group d-flex gap-1" role="group" aria-label="Acciones">
                          <button type="button" class="botonPerfil btn btn-primary px-4 py-2 fw-bold shadow-sm text-light"
                            data-bs-toggle="modal" data-bs-target="#perfil" data-id="{{$idol->id}}"
                            data-perfil="{{route('perfil.idol')}}">
                            Perfil <i class="bi bi-person-check"></i></i>
                          </button>
                          <button type="button" class="btneditar btn btn-warning px-4 py-2 fw-bold shadow-sm text-dark"
                            data-bs-toggle="modal" data-bs-target="#editar" data-id="{{$idol->id}}">
                            <i class="fas fa-edit"></i> Editar <i class="bi bi-pen"></i>
                          </button>
                          <button class="btnBorrar btn btn-danger px-4 py-2 fw-bold shadow-sm"
                            data-borrar="{{ $idol->id }}" data-nombre="{{ $idol->nombre }}" data-delete="{{ route('eliminar.trabajador') }}">
                            <i class="fas fa-trash-alt"></i> Borrar ajajajhp <i class="bi bi-trash3"></i>
                          </button>
                        </div>
                      </td>
                    </tr>`;
                    tablaContainer.append(tabla);
                });
            } else {
                console.log('No se recibieron datos o el formato es incorrecto.');
            }
         },
          error: function (xhr, status, error) {
              console.error('Error en AJAX:', status, error);
              alert('Ocurrió un error en la solicitud.');
          }
      });
  });
});


// Evento para el botón de perfil
$(document).on('click', '.botonPerfil', function () {
   var urlPerfil = $(this).data('perfil');
   console.log('Redirigiendo a perfil:', urlPerfil);
});



$(document).ready(function ( ) {
  $('#guardar').click(function () {
    const url = $(this).data('url');
    const trabajadorData = {
      nombre: $('#nombre').val(),
      edad: $('#edad').val(),
      datos_curiosos: $('#curiosidades').val(),
      actividad: $('#actividad').val(),
  };
    $.ajax({
      url:url,
      method:'POST',
      data :  trabajadorData,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success : function (respuesta) {
        // alert(' se agrego el ido' +  JSON.stringify(respuesta));
        // console.log('data con exito ' + respuesta);
      },
      error : function (xhr) {
        // alert('no se puedo agregar al idol')
        // console.error(xhr.respuesta);
      }
    })
  })
})



$(document).ready(function () {
  // Delegación de eventos para los botones de borrar
  $(document).on('click', '.btnBorrar', function () {
    const id = $(this).data('borrar');
    const nombre = $(this).data('nombre');
    var urlEliminar = $(this).data('delete');
    if (confirm(` ¿Seguro que deseas eliminar a ${nombre}? ` )) {
      $.ajax({
        url: urlEliminar,
        method: 'POST',
        data: {id: id},
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (respuesta) {
          alert('Eliminación exitosa');
        },
        error: function (xhr) {
          alert('Error fatal en la eliminación');
          console.error('Detalles del error:', xhr);
        }
      });
    }
  });
});


$(document).ready(function () {
  $('.btneditar').click(function () {
    const id = $(this).data('id');

    $('.guardarCambios').off('click').on('click', function () {
      const urlEditar = $(this).data('url');

      const Data = {
        identificador: id,
        nombre: $('#nombreEditar').val(),
        edad: $('#edadEditar').val(),
        datos_curiosos: $('#curiosidadesEditar').val(),
        actividad: $('#actividadEditar').val(),
      };
      $.ajax({
        url: urlEditar,
        data: { datos: Data },
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (respuesta) {
          alert('Datos actualizados correctamente: ' + JSON.stringify(respuesta));
        },
        error: function (respuestaTxt) {
          alert('Error al actualizar: ' + JSON.stringify(respuestaTxt));
        }
      });
    });
  });
});

// imprimir
$(document).ready(function () {
  $('.botonPerfil').click(function () {
    const id = $(this).data('id');
    const perfilData = { perfilData: id };
    const urlTEST = $(this).data('perfil');

    $.ajax({
      url: urlTEST,
      method: 'POST',
      data: perfilData,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      success: function (respuesta) {
        if (respuesta['query perfil controller '] && respuesta['query perfil controller '].length > 0) {
          $('.modal-body.datoPerfil').empty();

          respuesta['query perfil controller '].forEach(element => {
            const content = `
              <div class="perfil">
                <h3 class="perfil-titulo">Perfil de ${element.nombre}</h3>
                <div class="foto-perfil">
                  <p><strong>Edad:</strong> ${element.edad} años</p>
                  <p><strong>Datos Curiosos:</strong> ${element.datos_curiosos}</p>
                  <p><strong>Actividad:</strong> ${element.actividad}</p>
                </div>
              </div>
            `;
            $('.modal-body.datoPerfil').append(content);
          });

          identificadorPorID(perfilData);
        } else {
          alert("No se encontró información del perfil.");
        }
      },
      error: function (respuestaTxt) {
        alert('Error crítico: ' + respuestaTxt);
      }
    });
  });
});


function identificadorPorID(id) {
  $('.generarPDF').off('click').on('click', function () {
    const urlPDF = $(this).data('pdf');
    $.ajax({
      url: urlPDF,
      method: 'GET',
      data:  {ID: id},

      success: function (respuesta) {
        alert('Éxito en el proceso: ' + JSON.stringify(respuesta));
      },
      error: function (respuestaTxt) {
        console.error('Error en la petición AJAX:', respuestaTxt);
        alert('Error fatal: ' + JSON.stringify(respuestaTxt));
      }
    });
  });
}
