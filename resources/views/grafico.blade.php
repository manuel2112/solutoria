@extends('layout')

@section('content')
    <div class="container" id="app">
        <div class="row">
            <div class="col-12">
                <h1 class="mt-3">GRÁFICO</h1>
            </div>
        </div>
        <div class="row my-4">
            <div class="col-12">
                <h6>BUSCAR POR FECHAS</h6>
            </div>
            <div class="col">
                <label for="desde-search">DESDE</label>
                <input type="date" id="desde-search" v-model.trim="desde" class="form-control" placeholder="DESDE...">
            </div>
            <div class="col">
                <label for="hasta-search">HASTA</label>
                <input type="date" id="hasta-search" v-model.trim="hasta" class="form-control" placeholder="HASTA...">
            </div>
            <div class="col">
                <button type="button" class="btn btn-primary mt-4" @click="buscar">BUSCAR</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div id="container"></div>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <script>
        new Vue({
            el: '#app',
            data: {
                indicadores: {},
                desde: '',
                hasta: '',
            },
            created() {
                this.instanciar();
            },
            methods: {
                async instanciar() {
                    Swal.showLoading();
                    const url = 'api/getIndicadores';

                    await axios.get(url).then( res => {
                        this.indicadores = res.data.indicadores;
                        this.highcharts();
                        Swal.close();
                    });
                },
                async buscar(){
                    if( this.desde == '' || this.hasta == '' ){
                        toastr.error("AMBOS CAMPOR OBLIGATORIOS");
                        return;
                    }
                    Swal.showLoading();
                    const url = 'api/search';
                    const data = {
                        desde: this.desde,
                        hasta: this.hasta
                    };

                    await axios.post(url,data).then( res => {
                        
                        if( !res.data.error ){
                            toastr.error('NO SE ENCONTRARON RESULTADOS');
                        }else{
                            this.indicadores = res.data.indicadores;
                            this.highcharts();
                        }                                                                
                        Swal.close();
                        
                    });

                },
                highcharts(){
                    const categories    = this.indicadores.map((value) => `${value.fechaIndicador.substring(8, 10)}-${value.fechaIndicador.substring(5, 7)}-${value.fechaIndicador.substring(0, 4)}`);
                    // const categories    = this.indicadores.map((value) => value.fechaIndicador);
                    const values        = this.indicadores.map((value) => Number(value.valorIndicador));
                    Highcharts.chart('container', {
                        title: {
                            text: 'INDICADOR ECONÓMICO UF'
                        },
                        subtitle: {
                            text: 'VALOR HISTÓRICO'
                        },
                        xAxis: {
                            categories: categories.reverse()
                        },
                        yAxis: {
                            title: {
                                text: 'VALOR $'
                            }
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle'
                        },
                        plotOptions: {
                            series: {
                                allowPointSelect: true
                            }
                        },
                        series: [{
                            name: 'VALOR',
                            data: values.reverse()
                        }],
                        responsive: {
                            rules: [{
                                condition: {
                                    maxWidth: 500
                                },
                                chartOptions: {
                                    legend: {
                                        layout: 'horizontal',
                                        align: 'center',
                                        verticalAlign: 'bottom'
                                    }
                                }
                            }]
                        }
                    });
                },
            }
        });
    </script>
@endpush