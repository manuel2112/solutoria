@extends('layout')

@section('content')
<div class="col-12">
    <h1 class="mt-3">INDICADORES (UF)</h1>

    <div class="d-flex justify-content-end">                    
        <button 
            type="button" 
            class="btn btn-primary float-rigth" 
            data-bs-toggle="modal" 
            data-bs-target="#mdlCreate"
            id="reset-insert">
            CREAR
        </button>
    </div>

    <table class="table table-hover mt-2" id="mytable">
        <thead>
            <tr class="bg-dark text-light">
                <th scope="col">#</th>
                <th scope="col">INDICADOR</th>
                <th scope="col">VALOR</th>
                <th scope="col">FECHA</th>
                <th scope="col">ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            @foreach ( $indicadores as $indicador )
                <tr class="expand">
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $indicador->codigoIndicador }}</td>
                    <td>{{ $indicador->valorIndicador }}</td>
                    <td>{{ \Carbon\Carbon::parse($indicador->fechaIndicador)->format('d-m-Y') }}</td>
                    <td>
                        <div class="btn-group">
                            <button 
                                type="button" 
                                class="btn btn-warning update-ins" 
                                data-bs-toggle="modal" 
                                data-bs-target="#mdlUpdate"
                                data-id="{{ $indicador->id }}"
                                data-valor="{{ $indicador->valorIndicador }}"
                                data-fecha="{{ $indicador->fechaIndicador }}">
                                ACTUALIZAR
                            </button>
                            <button 
                                type="button" 
                                class="btn btn-danger delete" 
                                data-id="{{ $indicador->id }}">
                                ELIMINAR
                            </button>
                        </div>
                    </td>
                </tr>                            
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {!! $indicadores->links() !!}
    </div>

</div>

{{-- INSERT DATA --}}
<div class="row">
    <div class="col-12">

        <div id="mdlCreate" div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!--=====================================
                    CABEZA DEL MODAL
                    ======================================-->

                    <div class="modal-header">
                        <h4 class="modal-title">
                            INGRESAR INFORMACIÓN
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!--=====================================
                    CUERPO DEL MODAL
                    ======================================-->
                    
                    <div class="modal-body">
                        
                                        
                        <div class="row">							
                            <div class="col-12">

                                <div class="mb-3">
                                    <label for="valor">VALOR UF</label>
                                    <input 
                                        type="number"  
                                        class="form-control"
                                        placeholder="VALOR UF"
                                        id="valor"
                                        onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'
                                        autocomplete="off"
                                        required />
                                </div>
                                
                                <div class="mb-3">
                                    <label for="fecha">FECHA</label>
                                    <input 
                                        type="date"  
                                        class="form-control"
                                        placeholder="FECHA"
                                        id="fecha"
                                        autocomplete="off"
                                        required />
                                </div>

                            </div>
                        </div>
                    
                    </div>

                    <!--=====================================
                    PIE DEL MODAL
                    ======================================-->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            CERRAR
                        </button>
                        <button type="button" class="btn btn-primary" id="insert">
                            INGRESAR
                        </button>
                    </div>

                </div>

            </div>

        </div>                

    </div>
</div>

{{-- UPDATE DATA --}}
<div class="row">
    <div class="col-12">

        <div id="mdlUpdate" div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!--=====================================
                    CABEZA DEL MODAL
                    ======================================-->

                    <div class="modal-header">
                        <h4 class="modal-title">
                            ACTUALIZAR INFORMACIÓN
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!--=====================================
                    CUERPO DEL MODAL
                    ======================================-->
                    
                    <div class="modal-body">
                        
                                        
                        <div class="row">							
                            <div class="col-12">

                                <input type="hidden" id="id-upd" />

                                <div class="mb-3">
                                    <label for="valor-upd">VALOR UF</label>
                                    <input 
                                        type="number"  
                                        class="{{ $errors->has('valor-upd') ? 'is-invalid' : '' }} form-control"
                                        placeholder="VALOR UF"
                                        id="valor-upd"
                                        onkeypress='return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)'
                                        :value="old('valor-upd')"
                                        autocomplete="off"
                                        required />
                                </div>
                                
                                <div class="mb-3">
                                    <label for="fecha-upd">FECHA</label>
                                    <input 
                                        type="date"  
                                        class="{{ $errors->has('fecha-upd') ? 'is-invalid' : '' }} form-control"
                                        placeholder="FECHA"
                                        id="fecha-upd"
                                        :value="old('fecha-upd')"
                                        autocomplete="off"
                                        required />
                                </div>

                            </div>
                        </div>
                    
                    </div>

                    <!--=====================================
                    PIE DEL MODAL
                    ======================================-->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            CERRAR
                        </button>
                        <button type="button" class="btn btn-primary" id="update">
                            ACTUALIZAR
                        </button>
                    </div>

                </div>

            </div>

        </div>                

    </div>
</div>

@stop

@push('scripts')
    <script>
        $( document ).ready(function() {

            $( "#reset-insert" ).click(function() {
                $('#valor').val('');
                $('#fecha').val('');
            });

            function isNumeric(n) {
                return !isNaN(parseFloat(n)) && isFinite(n);
            }
            
            $( "#insert" ).click(function() {
                
                const valor     = $('#valor').val();
                const fecha     = $('#fecha').val();

                if( !isNumeric(valor) ){
                    toastr.error("EL VALOR DEBE SER NUMÉRICO");
                    return;
                }

                if( !valor || !fecha ){
                    console.log(valor,fecha);
                    toastr.error("TODOS LOS CAMPOS SON OBLIGATORIOS");
                    return;
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: '{{ route('home.create')}}',
                    data: { valor: valor, fecha: fecha},
                    success:function(res){ 
                        if( res.ok ){
                            toastr.success("CAMPO INGRESADO EXITOSAMENTE");
                            location.reload();
                        }else{
                            toastr.error(res.errors);
                        }
                    }
                });

            });

            $( ".delete" ).click(function() {
                const id = $(this).data("id");
                Swal.fire({
                    title: 'ELIMINAR INDICADOR',
                    text: "¿ESTÁS SEGURO?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'SI, ELIMINAR',
                    cancelButtonText: 'CANCELAR'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                type: "DELETE",
                                url: "/"+id,
                                data: { id: 1 },
                                success:function(res){  
                                    if( res.ok ){
                                        toastr.success("EL INDICADOR HA SIDO ELIMINADO EXITOSAMENTE.");
                                        location.reload();
                                    }else{
                                        toastr.error("SE HA PRODUCIDO UN ERROR FAVOR VOLVER A INTENTAR.");
                                    }
                                }
                            });
                    }
                })
            });

            $( ".update-ins" ).click(function() {
                const id    = $(this).data("id");
                const valor = $(this).data("valor");
                const fecha = $(this).data("fecha");
                
                $('#id-upd').val(id);
                $('#valor-upd').val(valor);
                $('#fecha-upd').val(fecha);
            });
            
            $( "#update" ).click(function() {
                
                const id        = $('#id-upd').val();
                const valor     = $('#valor-upd').val();
                const fecha     = $('#fecha-upd').val();

                if( !isNumeric(valor) ){
                    toastr.error("EL VALOR DEBE SER NUMÉRICO");
                    return;
                }

                if( !valor || !fecha ){
                    console.log(valor,fecha);
                    toastr.error("TODOS LOS CAMPOS SON OBLIGATORIOS");
                    return;
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "PUT",
                    url: "/"+id,
                    data: { valor: valor, fecha: fecha},
                    success:function(res){
                        if( res.ok ){
                            toastr.success("EL VALOR SE HA ACTUALIZADO EXITOSAMENTE.");
                            location.reload();
                        }else{
                            toastr.error(res.errors);
                        }
                    }
                });

            });

        });
    </script>
@endpush