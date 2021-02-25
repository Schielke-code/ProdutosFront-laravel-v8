@extends('Site.template')
@section('conteudo')
    <style>
        .dataTables_empty, .dataTables_info, #table_id_paginate{
            display: none;
        }
    </style>

    <div class="container mt-5">
        <div class="d-block">
            <a href="{{ env('DOMINIO_FRONT')}}/produtos/list">> Lista Produtos</a><br>
            <a href="{{ env('DOMINIO_FRONT')}}/produtos/create">> Criar um novo Produtos</a>
        </div>
        @if(count($lista->data) > 0)
        <table class="display w-100">
            <tr  style="border-bottom: 1px solid #000000!important;">
                <th class='text-center py-2'>ID</th>
                <th class='text-center  py-2'>Nome Produto</th>
                <th class='text-center  py-2'>Categoria</th>
                <th class='text-center  py-2'>Imagem</th>
                <th class='text-center  py-2'>Preço</th>
                <th class='text-center  py-2'>Tipo</th>
                <th class='text-center  py-2'>Detalhes</th>
                <th class='text-center  py-2'>Delete</th>
            </tr>
            <tbody id="listaClientes">
            @foreach($lista->data as $produto)
                <tr>
                    <th class='text-center  py-2'>{{$produto->id}}</th>
                    <th class='text-center  py-2'>{{$produto->nome}}</th>
                    <th class='text-center  py-2'>{{$produto->categoria}}</th>
                    <th class='text-center  py-2'><img style='width:100px' src="{{ env('DOMINIO_API')}}/storage/imagens/produtos/{{$produto->image}}"></th>
                    <th class='money text-center  py-2'>{{$produto->preco}}</th>
                    <th class='text-center  py-2'>{{$produto->tipo}}</th>
                    <th class='text-center  py-2'><span onclick='teste("{{$produto->id}}")' href='#'  class='btn btn-success'> <i class='far fa-eye'></i> <b>Detalhes</b></span> </th>
                    <th class='text-center  py-2'><a href="{{ env('DOMINIO_FRONT')}}/produtos/delete/{{$produto->id}}"  class='btn btn-danger'> <i class='fas fa-trash-alt'></i> <b>Delete</b></a> </th>
                </tr>
            @endforeach
            </tbody>
            <tfoot style="border-top: 1px solid #000000!important;">
            <tr>
                <th class='text-center  py-2'>ID</th>
                <th class='text-center  py-2'>Nome Produto</th>
                <th class='text-center  py-2'>Categoria</th>
                <th class='text-center  py-2'>Imagem</th>
                <th class='text-center  py-2'>Preço</th>
                <th class='text-center  py-2'>Tipo</th>
                <th class='text-center  py-2'>Detalhes</th>
                <th class='text-center  py-2'>Delete</th>
            </tr>
            </tfoot>
        </table>
        @else

        <h3 class="text-center">Sem produtos cadastrados no momento</h3>

        @endif


    </div>
    <script>
        function teste(id) {
            window.open('{{ env('DOMINIO_FRONT')}}/produtos/show/'+id+'',    '_blank', 'location=yes,height=600,width=600, left='+(window.innerWidth-600)/2+', top='+(window.innerHeight-600)/2+', scrollbars=yes,status=yes');
        }

    </script>

@stop
