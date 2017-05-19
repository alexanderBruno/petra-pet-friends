@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Pàgina no trobada</h3></div>

                <div class="panel-body">
                  <h4>Ens sap greu! Aquesta pàgina no existeix en la nostra web.</h4><br/>
                  <h5>Si creus que es un error, posa't en contacte amb nosaltres.</h5><br/>
                  <a href="/home"><button type="button" class="btn btn-primary" style="margin-left:40%;"><i class="fa fa-home" aria-hidden="true"></i> Tornar a l'inici</button></a>
                </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
