
@extends('Site.template')
@section('conteudo')


    <section id="buttom">
        <div class="container text-center pt-5 mt-5">
            <div class="d-block">
                <img  style="width: 400px" src="{{ env('DOMINIO_FRONT')}}/imagem/online_store_.png">

            </div>
            <div class="d-block">
                <a href="{{ env('DOMINIO_FRONT')}}/produtos/list">> Lista Produtos</a><br>
                <a href="{{ env('DOMINIO_FRONT')}}/produtos/create">> Criar um novo Produtos</a>
            </div>
        </div>
    </section>

@stop
