@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" style="text-align:center;">
                <div class="panel-heading"><h3>Error 404: Pàgina no trobada!</h3></div>

                <div class="panel-body">
                  <h4>Ens sap greu! Aquesta pàgina no existeix en la nostra web.</h4>
                  <h5>Si creus que es un error, posa't en contacte amb nosaltres.</h5><br/>
                  <img src="/images/avatars/404img.png" style="width:40%; height:40%;"/><br/><br/>
                  <a href="/home"><button type="button" class="btn btn-primary"><i class="fa fa-home" aria-hidden="true"></i> Tornar a l'inici</button></a>
                  <a href="/contact"><button type="button" class="btn btn-primary"><i class="fa fa-envelope" aria-hidden="true"></i> Anar a contacte</button></a>
                </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
