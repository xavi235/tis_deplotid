@extends('adminlte::page')

@section('title', 'EDICION')

@section('content_header')
    <h1>Editar Ambiente</h1>
@stop

@section('content')
    <form action="/Ambiente/{{$Ambiente->id}}" method="POST" id="ambienteForm">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="departamento" class="form-label">Departamento</label>
                    <input id="departamento" name="departamento" type="text" class="form-control" value="{{$Ambiente->departamento}}" tabindex="1" maxlength="30">
                    <div id="departamentoError" class="text-danger"></div>
                </div>

                <div class="mb-3">
                    <label for="capacidad" class="form-label">Capacidad</label>
                    <input id="capacidad" name="capacidad" type="text" class="form-control" value="{{$Ambiente->capacidad}}" tabindex="2">
                    <div id="capacidadError" class="text-danger"></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de ambiente</label>
                    <input id="tipo" name="tipo" type="text" class="form-control" value="{{$Ambiente->tipoDeAmbiente}}" tabindex="3" maxlength="30">
                    <div id="tipoError" class="text-danger"></div>
                </div>
                
                <div class="mb-3">
                    <label for="ubicacion" class="form-label">Ubicación</label>
                    <select id="ubicacion" name="ubicacion" class="form-control" tabindex="4">
                        <option value="">Seleccione una ubicación</option>
                        @foreach($ubicaciones as $ubicacion)
                            <option value="{{ $ubicacion->id }}" @if($Ambiente->id_ubicacion == $ubicacion->id) selected @endif>{{ $ubicacion->nombre }}</option>
                        @endforeach
                    </select>
                    <div id="ubicacionError" class="text-danger"></div>
                </div>
            </div>
        </div>
        
        <div class="mb-3">
            <a href="/Ambiente" class="btn btn-secondary" tabindex="5">Cancelar</a>
            <button type="submit" class="btn btn-primary" id="guardarBtn" tabindex="6" disabled>Actualizar</button>
        </div>
    </form>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function() {
            checkFormValidity();

            function checkFormValidity() {
                var departamento = $('#departamento').val();
                var capacidad = $('#capacidad').val();
                var tipo = $('#tipo').val();
                var ubicacion = $('#ubicacion').val();

                // Validar que los campos no estén vacíos
                if (!departamento || !capacidad || !tipo || !ubicacion) {
                    $('#guardarBtn').prop('disabled', true);
                    return;
                }

                // Validar campo Departamento
                var departamentoRegex = /^[a-zA-Z0-9\s]*$/u;
                if (!departamentoRegex.test(departamento.trim()) && departamento.trim() !== '') {
                    $('#departamentoError').text('El campo departamento solo debe contener letras, números y espacios.');
                    $('#guardarBtn').prop('disabled', true);
                } else {
                    $('#departamentoError').text('');
                    if (departamento.trim().length < 4 || departamento.trim().length > 30) {
                        $('#guardarBtn').prop('disabled', true);
                    }
                }

                // Validar campo Capacidad
                if (isNaN(capacidad.trim()) || capacidad.trim() < 25 || capacidad.trim() > 120) {
                    $('#capacidadError').text('La capacidad debe estar entre 25 y 120.');
                    $('#guardarBtn').prop('disabled', true);
                } else {
                    $('#capacidadError').text('');
                    $('#guardarBtn').prop('disabled', false);
                }

                // Verificar si la capacidad es un número
                if (!$.isNumeric(capacidad.trim()) && capacidad.trim() !== '') {
                    $('#capacidadError').text('Solo se permiten caracteres numéricos.');
                    $('#guardarBtn').prop('disabled', true);
                } else {
                    $('#capacidadError').text('');
                }

                // Validar campo Tipo de Ambiente
                var tipoRegex = /^[a-zA-Z0-9\s]*$/u;
                if (!tipoRegex.test(tipo.trim()) && tipo.trim() !== '') {
                    $('#tipoError').text('El campo tipo solo debe contener letras, números y espacios.');
                    $('#guardarBtn').prop('disabled', true);
                } else {
                    $('#tipoError').text('');
                    if (tipo.trim().length < 4 || tipo.trim().length > 30) {
                        $('#guardarBtn').prop('disabled', true);
                    }
                }
            }

            $('#departamento, #capacidad, #tipo, #ubicacion').change(function() {
                checkFormValidity();
            });

            $('form#ambienteForm').submit(function(event) {
                event.preventDefault(); // Evita que el formulario se envíe automáticamente

                checkFormValidity();

                if ($('#guardarBtn').prop('disabled')) {
                    return false;
                }

                // Si todos los campos son válidos, puedes enviar el formulario manualmente
                var form = this; // Obtén una referencia al formulario
                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    success: function(response) {
                        // Muestra el mensaje de actualización exitosa
                        Swal.fire({
                            title: 'Actualización exitosa!',
                            text: 'El ambiente ha sido actualizado correctamente.',
                            icon: 'success',
                            timer: 2000, // Duración en milisegundos (3 segundos)
                            timerProgressBar: true,
                            showConfirmButton: false
                        }).then((result) => {
                            window.location.href = "/Ambiente";
                        });
                    }
                });
            });
        });
    </script>
@stop
