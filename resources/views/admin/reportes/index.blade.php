@extends('adminlte::page')

@section('title', 'Reportes')

@section('content_header')
    <h1><i class="fas fa-chart-bar mr-2"></i>Reportes del Sistema</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-light">
            <form action="{{ route('admin.reportes.filtrar') }}" method="POST" class="form-inline">
                @csrf
                <label for="tipo" class="mr-2">Tipo de Reporte:</label>
                <select name="tipo" id="tipo" class="form-control mr-3">
                    <option value="">Seleccione...</option>
                    <option value="aprobado" {{ $tipo === 'aprobado' ? 'selected' : '' }}>Usuarios con más publicaciones aprobadas</option>
                    <option value="finalizado" {{ $tipo === 'finalizado' ? 'selected' : '' }}>Usuarios con más publicaciones finalizadas</option>
                    <option value="rechazado" {{ $tipo === 'rechazado' ? 'selected' : '' }}>Usuarios con más publicaciones rechazadas</option>
                    <option value="pendiente" {{ $tipo === 'pendiente' ? 'selected' : '' }}>Usuarios con más publicaciones pendientes</option>
                </select>

                <button class="btn btn-primary"><i class="fas fa-filter mr-1"></i>Filtrar</button>
                </form>
        </div>
        <div class="card-body">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if (isset($resultados) && count($resultados))
                <table>
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Correo</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resultados as $fila)
                            <tr>
                                <td>{{ $fila->name }}</td>
                                <td>{{ $fila->email }}</td>
                                <td>
                                <td>
                                    @if ($tipo === 'aprobado')
                                        {{ $fila->aprobado ?? 0 }}
                                    @elseif ($tipo === 'finalizado')
                                        {{ $fila->finalizado ?? 0 }}
                                    @elseif ($tipo === 'rechazado')
                                        {{ $fila->rechazado ?? 0 }}
                                    @elseif ($tipo === 'pendiente')
                                        {{ $fila->pendiente ?? 0 }}
                                    @else
                                        0
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @elseif(request()->isMethod('post'))
    <div class="alert alert-info">No se encontraron resultados con los filtros aplicados.</div>
@endif
        </div>
    </div>
@stop

@section('css')
    <style>
        .form-inline label {
            font-weight: 600;
        }
        .table th, .table td {
            vertical-align: middle;
        }
    </style>
@endsection
