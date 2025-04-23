<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <title>CRUD DE BORIS TOAZA</title>
</head>

<body>
  <style>
  html,
  body {
    margin: 0;
    padding: 0;
    width: 100%;
    overflow-x: hidden;
    background-color: whitesmoke;
  }
  </style>

  <div class="d-flex flex-column min-vh-100 ">

    <!-- Navegación principal -->
    <nav class="navbar navbar-expand-lg bg-dark sfy"
      style="height: 70px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); margin: 0; padding: 0;">
      <div class="container-fluid" style="width: 100%; padding: 0;">
        <a class="navbar-brand text-white fw-bold" href="#"
          style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
          <span style="color: #f39c12;">El SUPER CRUD DE</span> BORIS TOAZA =D
        </a>
      </div>
    </nav>

    <style>
    .navbar-toggler {
      margin: 6px;
    }

    @media (width < 537px) {
      .navbar-brand {
        display: none;
      }

      .d-flex gap-2 {
        flex-direction: row;
        background-color: #00758F;
      }

      .btn-Buscar {
        margin: 3px;
      }

      .btn-Agregar {
        margin: 3px;
      }
    }

    @media (width<178px) {
      .btn-Buscar {
        display: none;
      }

      .btn-Agregar {
        display: none;
      }

      .buscasdor {
        display: none;
      }
    }
    </style>

    <!-- Contenido principal -->
    <div class="flex-grow-1">
      <div class="container my-5">
        <!-- Buscador -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-warning shadow">
          <div class="container-fluid">
            <a class="navbar-brand fw-bold text-white" href="#">BUSCAR IDOL</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSearch"
              aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"> </span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSearch">
              <form class="d-flex flex-grow-1 flex-wrap align-items-center gap-2 mx-3 justify-content-between"
                role="search">
                <div class="flex-grow-1" style="display: flex; align-items: center;" style="padding-top:100px;">
                  <input class="buscasdor form-control shadow-sm" type="search" placeholder="Buscar..."
                    aria-label="Search" id="Buscador" style="border: 2px solid #f39c12; min-width: 200px; max-width: none; width: 100%;
                    flex-grow: 1; min-width: 0; transition: all 0.3s ease-in-out; margin-right: 10px;" />
                </div>

                <div class="d-flex gap-2">

                  <div class="containerBotones">
                    <button class=" btn-Buscar btn btn-dark fw-bold shadow-sm flex-shrink-0" type="submit"
                      id="btnBuscador" data-url="{{ route('buscador.trabajador') }}"
                      style="width: auto; min-width: 100px; transition: all 0.3s ease;">
                      <i class="fas fa-search"></i> Buscar <i class="bi bi-search-heart-fill"></i>
                    </button>

                    <button type="button" class="btn-Agregar btn btn-primary btn-sm fw-bold shadow-sm flex-shrink-0"
                      data-bs-toggle="modal" data-bs-target="#agregar"
                      style="width: auto; min-width: 100px; transition: all 0.3s ease; height: 38px;">
                      <i class="fas fa-plus"></i> Agregar <i class="bi bi-plus-circle-fill"></i>
                    </button>
                  </div>

                </div>
              </form>
            </div>
          </div>
        </nav>

        <!-- Tabla -->
        <div class="table-responsive ">
          <table class="table table-hover">
            <thead class="table-dark">
              <tr>
                <!-- <th scope="col">ID</th> -->
                <th scope="col">Nombre</th>
                <th scope="col">Edad</th>
                <th scope="col">Actividad</th>
                <th scope="col">Curiosidades</th>
                <th scope="col">Acciones</th>
              </tr>
            </thead>
            <tbody class="Tabla_datos">
              @foreach($infoIdols as $idol)
              <tr>
                <td>{{ $idol->nombre }}</td>
                <td>{{ $idol->edad }}</td>
                <td>{{ $idol->actividad }}</td>
                <td>{{ $idol->datos_curiosos }}</td>
                <td>
                  <div id="btnDinamicos" class="btnDinamicos btn-group d-flex gap-1" role="group" aria-label="Acciones">
                    <button type="button" class="botonPerfil btn btn-primary px-4 py-2 fw-bold shadow-sm text-light"
                      data-bs-toggle="modal" data-bs-target="#perfil" data-id="{{ $idol->id }}"
                      data-perfil="{{ route('perfil.idol') }}">
                      Perfil <i class="bi bi-person-check"></i>
                    </button>
                    <button type="button" class="btneditar btn btn-warning px-4 py-2 fw-bold shadow-sm text-dark"
                      data-bs-toggle="modal" data-bs-target="#editar" data-id="{{ $idol->id }}">
                      <i class="fas fa-edit"></i> Editar <i class="bi bi-pen"></i>
                    </button>
                    <button class="btnBorrar btn btn-danger px-4 py-2 fw-bold shadow-sm" data-borrar="{{ $idol->id }}"
                      data-nombre="{{ $idol->nombre }}" data-eliminarurl="{{ route('eliminar.trabajador') }}">
                      <i class="fas fa-trash-alt"></i> Borrar <i class="bi bi-trash3"></i>
                    </button>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>

          </table>
          <div class="container text-center">
            <div class="w-10">
              <nav aria-label="Page navigation example">
                <p class="padding-top:10px">Paginas</p>
                <ul class="pagination pagination-md justify-content-center">
                  {!! $infoIdols->links() !!}
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <!-- Modales -->
  <!-- Modal Agregar -->
  <div class="modal fade" id="agregar" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">Agregar Idols</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addForm">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="nombre" placeholder="Nombre">
            </div>
            <div class="mb-3">
              <label for="edad" class="form-label">Edad</label>
              <input type="number" class="form-control" id="edad" placeholder="Edad">
            </div>
            <div class="mb-3">
              <label for="curiosidades" class="form-label">Curiosidades </label>
              <input type="text" class="form-control" id="curiosidades" placeholder="Curiosidades ">
            </div>
            <div class="mb-3">
              <label for="actividad" class="form-label">Actividad</label>
              <input type="text" class="form-control" id="actividad" placeholder="Actividad">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary" id="guardar"
            data-url="{{ route('agregar.trabajador') }}">Guardar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Editar -->
  <div class="modal fade" id="editar" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content rounded-4 shadow-lg">
        <div class="modal-header" style="background: linear-gradient(45deg, #f39c12, #f1c40f);">

          <h5 class="modal-title text-white" id="editModalLabel"><i class="bi bi-pen"></i> Editar información </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row contendorEditar">
            <!-- Primera columna -->
            <div class="col-12 col-md-6 mb-4">
              <input type="text" class="form-control shadow-sm p-3 rounded-3" placeholder="Nombre" id="nombreEditar"
                name="nombreEditar" required>
              <br>
              <input type="number" class="form-control shadow-sm p-3 rounded-3" placeholder="Edad" id="edadEditar"
                name="edadEditar" min="0" required>
            </div>
            <!-- Segunda columna -->
            <div class="col-12 col-md-6 mb-4">
              <input type="text" class="form-control shadow-sm p-3 rounded-3" placeholder="Curiosidades"
                id="curiosidadesEditar" name="CuriosidadesEditar" maxlength="240" required>
              <br>
              <input type="text" class="form-control shadow-sm p-3 rounded-3" placeholder="Actividad"
                id="actividadEditar" name="actividadEditar">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary rounded-pill px-4 py-2" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="guardarCambios btn btn-primary rounded-pill px-4 py-2"
            data-url="{{ route('editar.trabajdor') }}">Guardar cambios</button>
        </div>
      </div>
    </div>
  </div>
  <style>
  /* Estilos generales del modal */
  .modal-content {
    background-color: #ffffff;
    border-radius: 10px;
    color: #333;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  }

  /* Encabezado del modal */
  .modal-header {
    background-color: #007bff;
    color: white;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
  }

  .modal-header .modal-title {
    font-size: 24px;
    font-weight: bold;
  }

  .modal-body {
    padding: 20px;
    font-size: 16px;
  }

  /* Estilo del perfil dentro del modal */
  .perfil {
    text-align: center;
    padding: 20px;
    background-color: #f4f6f9;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 15px;
  }

  .perfil .perfil-titulo {
    font-size: 24px;
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
  }

  .foto-perfil {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 10px;
    color: #333;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .foto-perfil p {
    font-size: 16px;
    line-height: 1.6;
  }

  .foto-perfil p strong {
    font-weight: bold;
  }

  /* Estilos del footer del modal */
  .modal-footer {
    background-color: #f4f6f9;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
  }

  .modal-footer .btn {
    border-radius: 20px;
    padding: 10px 20px;
    font-size: 16px;
    box-shadow: none;
  }

  /* Eliminar sombra en el botón secundario */
  .btn-secondary {
    background-color: #f1f1f1;
    color: #333;
    border-color: #ddd;
  }

  /* El botón primario mantendrá el azul por defecto de Bootstrap */
  .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
  }
  </style>

  <!-- perfil modal  -->
  <div class="modal fade" id="perfil" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header" style="background: linear-gradient(45deg, #f39c12, #f1c40f)">
          <h5 class="modal-title" id="staticBackdropLabel"> <i class="bi bi-info-circle"></i> Información </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body datoPerfil">

        </div>
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary generarPDF " data-bs-toggle="modal"
            data-pdf="{{route('Archivo.PDF')}}" data-bs-target="#pdfModal">Generar PDF</button>
        </div> -->
      </div>
    </div>
  </div>

  <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"
          style="max-height: 800px; max-width: 800px; overflow: hidden; display: flex; justify-content: center; align-items: center;">
          <iframe src="{{ route('Archivo.PDF') }}" frameborder="0"
            style="height: 100%; width: 100%; max-height: 100%; max-width: 100%;"></iframe>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="text-white py-5" style="background-color: #f39c12;">
    <div class="container text-center">
      <h5 class="fw-bold mb-3 text-uppercase" style="letter-spacing: 1px;"> Información Importante</h5>

      <p class="mb-4 p-3 rounded" style="
    font-size: 18px;
    font-weight: 500;
    line-height: 1.8;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(5px);
    border-radius: 10px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    display: inline-block;
    padding: 15px 20px;
    color: white;
">
        Este CRUD fue desarrollado por
        <strong style="
        background: linear-gradient(45deg,rgb(7, 7, 7),rgb(18, 18, 19));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: bold;
        font-size: 22px;
        text-shadow: 2px 2px 5px rgba(17, 18, 19, 0.6);
        transition: all 0.3s ease-in-out;
        cursor: pointer;
    " onmouseover="this.style.textShadow='4px 4px 10px rgba(17, 18, 19, 0.6)';"
          onmouseout="this.style.textShadow='2px 2px 5px rgba(17, 18, 19, 0.6)';">
          Boris Toaza
        </strong> con las siguientes tecnologías:
      </p>


      <div class="d-flex justify-content-center gap-3 flex-wrap">
        <span class="badge text-white px-3 py-2"
          style="background-color: #FF2D20; font-size: 16px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);">
          Laravel 11
        </span>
        <span class="badge text-white px-3 py-2"
          style="background-color: #7952B3; font-size: 16px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);">
          Bootstrap 5
        </span>
        <span class="badge text-white px-3 py-2"
          style="background-color: #00758F; font-size: 16px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);">
          MySQL
        </span>
        <span class="badge text-white px-3 py-2"
          style="background-color: #F7DF1E; color: black; font-size: 16px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);">
          JavaScript (AJAX)
        </span>

        <span class="badge text-white px-3 py-2"
          style="background-color: #F7DF1E; color: black; font-size: 16px; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);">
          CSS
        </span>
      </div>
    </div>
  </footer>


  </div>

  <!-- Scripts -->
  <script>
  // const RUTA_DATA_IDOL = "{{ route('data.idol') }}";
  const rutaEliminar = "{{route('eliminar.trabajador')}}";
  </script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/registrarUsuario.js') }}"></script>
</body>

</html>