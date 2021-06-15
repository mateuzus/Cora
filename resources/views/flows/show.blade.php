@extends('adminlte::page')
@section('css')
@endsection
@section('content')
    <input type="hidden" id='context'value="{{$pvmContext}}">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div id="graph-container" class="p-4 d-flex justify-content-center"></div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/workflow.js') }}"></script>
    <script>
        $(document).ready(function () {
            var pvmContext = JSON.parse($("#context").val());
            console.log(pvmContext);
            pvm.renderGraph(pvmContext, 'graph-container');
        })

    </script>
@endsection
