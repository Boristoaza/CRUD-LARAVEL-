$(document).ready(function () {
  // === BUSCADOR ===
  $('#btnBuscador').click(function (event) {
    event.preventDefault();
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

        const tablaContainer = $('.Tabla_datos');
        tablaContainer.empty();

        if (respuesta.resultado && Array.isArray(respuesta.resultado) && respuesta.resultado.length > 0) {
          respuesta.resultado.forEach(idol => {
            const tabla = `
              <tr>
                <td>${idol.nombre}</td>
                <td>${idol.edad}</td>
                <td>${idol.actividad}</td>
                <td>${idol.datos_curiosos}</td>
                <td>
                  <div class="btnDinamicos btn-group d-flex gap-1" role="group" aria-label="Acciones">
                    <button type="button" class="botonPerfil btn btn-primary px-4 py-2 fw-bold shadow-sm text-light"
                      data-bs-toggle="modal" data-bs-target="#perfil"
                     data-id="${idol.id}" data-edad="${idol.edad}" data-actividad="${idol.actividad}" data-curiosidad="${idol.datos_curiosos}"
                      data-perfil="${$('#btnBuscador').val()}">
                      Perfil <i class="bi bi-person-check"></i>
                    </button>
                    <button type="button" class="btneditar btn btn-warning px-4 py-2 fw-bold shadow-sm text-dark"
                      data-bs-toggle="modal" data-bs-target="#editar" data-id="${idol.id}">
                      <i class="fas fa-edit"></i> Editar <i class="bi bi-pen"></i>
                    </button>
                    <button class="btnBorrar btn btn-danger px-4 py-2 fw-bold shadow-sm"
                      data-borrar="${idol.id}">
                      <i class="fas fa-trash-alt"></i> Borrar <i class="bi bi-trash3"></i>
                    </button>
                  </div>
                </td>
              </tr>
            `;
            tablaContainer.append(tabla);
            $('#Buscador').val(' ');
          });
        } else {
          tablaContainer.append('<tr><td colspan="5">No se encontraron registros.</td></tr>');
        }

        $('.Tabla_datos').show();
      },
      error: function (xhr, status, error) {
        console.error('Error en AJAX:', status, error);
        alert('Ocurrió un error en la solicitud.');
      }
    });
  });

  //  == buscaodr dinamico ==
  $('#Buscador').on('keyup', function() {
    const valor = $(this).val().toLowerCase();
    $('.Tabla_datos tr').filter(function() {
      $(this).toggle($(this).text().toLowerCase().includes(valor));
    });
  });

  // == eliminar ==
  $(document).on('click', '.btnBorrar', function (event) {
    event.preventDefault();
    const ID = $(this).data('borrar');
    $.ajax({
      url: rutaEliminar,
      method: 'POST',
      data: { id: ID },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      success: function (respuesta) {
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: 'Eliminado correctamente',
          timer: 2000,
          showConfirmButton: false
        }).then(() => {
          location.reload();
        });
      },
      error: function (xhr) {
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Hubo un problema al eliminar.',
        });
        console.error(xhr.responseText);
      }
    });
  });

  // === PERFIL DINÁMICO ===
  $(document).on('click', '.botonPerfil', function (event) {
    event.preventDefault()
    const id = $(this).data('id');
    const url = perfilURL;
    console.log(id);

    $('.modal-body.datoPerfil').html(`
      <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
        <div class="spinner-border text-warning" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    `);
    $.ajax({
      url: url,
      method: 'POST',
      data: { perfilData: id },
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      },
      success: function (respuesta) {
        const perfilInfo = respuesta['query perfil controller '] || [];
        $('.modal-body.datoPerfil').empty();
        if (perfilInfo.length > 0) {
          perfilInfo.forEach(idol => {
            const content = `
              <div class="perfil">
                <h3 class="perfil-titulo">Perfil de ${idol.nombre}</h3>
                <div class="foto-perfil">
                  <p><strong>Edad:</strong> ${idol.edad} años</p>
                  <p><strong>Datos Curiosos:</strong> ${idol.datos_curiosos}</p>
                  <p><strong>Actividad:</strong> ${idol.actividad}</p>
                </div>
              </div>
            `;
            $('.modal-body.datoPerfil').append(content);
          });

          identificadorPorID(id);
        } else {
          alert("No se encontró información del perfil.");
        location.reload();
        }
      },
      error: function (xhr) {
        // alert('Error crítico: ' + JSON.stringify(xhr));
      }
    });
  });
  // === GUARDAR NUEVO IDOL ===
  $('#guardar').click(function () {
    const url = $(this).data('url');
    const trabajadorData = {
      nombre: $('#nombre').val(),
      edad: $('#edad').val(),
      datos_curiosos: $('#curiosidades').val(),
      actividad: $('#actividad').val(),
    };

      // Ocultar el modal
    $('#agregar').modal('hide');

  // Mostrar alerta de carga
  // Swal.fire({
  //   title: 'Guardando...',
  //   text: 'Por favor, espera.',
  //   allowOutsideClick: false,
  //   didOpen: () => {
  //     Swal.showLoading();
  //   }
  // });

    $.ajax({
      url: url,
      method: 'POST',
      data: trabajadorData,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (respuesta) {
        $('modal-body agregar').empty();
        Swal.fire({
          icon: 'success',
          title: '¡Éxito!',
          text: 'Agregado correctamente',
          timer: 2000,
          showConfirmButton: false
        }).then(() => {
          location.reload();
        });
      },
      error: function (xhr) {
        alert('No se pudo agregar.');
        console.error(xhr.responseText);
      }
    });
  });
  // === EDITAR IDOL ===
  $(document).on('click', '.btneditar', function () {
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
      $('#editar').hide()
      $.ajax({
        url: urlEditar,
        data: { datos: Data },
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (respuesta) {
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'Datos actualizados correctamente',
            timer: 1000,
            showConfirmButton: false
          }).then(() => {
            location.reload();
          });;
        },
        error: function (xhr) {
          Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: 'No se puedo correctamente',
            timer: 2000,
            showConfirmButton: false
          }).then(() => {
            location.reload();
          });
        }
      });
    });
  });

  // === GENERAR PDF ===
  function identificadorPorID(id) {
    $('.generarPDF').off('click').on('click', function () {
      const urlPDF = $(this).data('pdf');
      $.ajax({
        url: urlPDF,
        method: 'GET',
        data: { ID: id },
        success: function (respuesta) {
          alert('PDF generado correctamente.');
          console.log(respuesta);
        },
        error: function (xhr) {
          alert('Error al generar PDF.');
          console.error(xhr.responseText);
        }
      });
    });
  }
});