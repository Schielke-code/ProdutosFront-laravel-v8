<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\CommonMark\Inline\Element\Image;

class ProdutosController extends Controller
{
    public function index()
    {

        return view('Site.index');
    }

    public function create()
    {
        $curl = curl_init('https://api.mercadolibre.com/sites/MLA/categories');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);
        curl_close($curl);
        $jsonCategoriaMl = json_decode( $result );



        $headers = array(
            "cache-control: no-cache",
        );
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('DOMINIO_API').'/produtos/list',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => $headers,
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $produtos = json_decode($response);

        return view('Site.cadastro')->with(compact('jsonCategoriaMl','produtos'));
    }

    public function store(Request $request)
    {

        if($_FILES['image']['size'] == 0){
            if(isset($request->produto)){
                $arrayData = $request->produto;
                $produtos = implode(",", $arrayData);
                $post = [
                    'nomeProduto' => $request->nomeProduto,
                    'categoria' => $request->categoria,
                    'descricao' => $request->descricao,
                    'preco' => $request->preco,
                    'produto' => $produtos,
                    'kit' => $request->kit,
                ];
            }else{
                $post = [
                    'nomeProduto' => $request->nomeProduto,
                    'categoria' => $request->categoria,
                    'descricao' => $request->descricao,
                    'preco' => $request->preco,
                    'kit' => $request->kit,
                ];
            }
        }else{
            if(isset($request->produto)){
                $arrayData = $request->produto;
                $produtos = implode(",", $arrayData);
                $post = [
                    'nomeProduto' => $request->nomeProduto,
                    'categoria' => $request->categoria,
                    'descricao' => $request->descricao,
                    'preco' => $request->preco,
                    'produto' => $produtos,
                    'kit' => $request->kit,
                    '_method' => 'PUT',
                    'fileImage'=> new \CURLFILE($_FILES['image']['tmp_name'], $_FILES['image']['type'], $_FILES['image']['name'])
                ];
            }else{
                $post = [
                    'nomeProduto' => $request->nomeProduto,
                    'categoria' => $request->categoria,
                    'descricao' => $request->descricao,
                    'preco' => $request->preco,
                    'kit' => $request->kit,
                    '_method' => 'PUT',
                    'fileImage'=> new \CURLFILE($_FILES['image']['tmp_name'], $_FILES['image']['type'], $_FILES['image']['name'])
                ];
            }
        }

        $cookie = csrf_token();
        $headers = array(
            "cache-control: no-cache",
            "Authorization: Bearer $request->token",
        );

        if (!isset($post['produto'])){
            $post['produto'] = null;
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('DOMINIO_API').'/produtos/store',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => [
                'nomeProduto' =>  $post['nomeProduto'],
                'categoria' => $post['categoria'],
                'descricao' => $post['descricao'],
                'preco' => $post['preco'],
                'fileImage'=> $post['fileImage'],
                'kit' => $post['kit'],
                'produto' => $post['produto']
            ],
            CURLOPT_HTTPHEADER => [
                'cache-control: no-cache',
                'Authorization: Bearer '. $request->token,
            ],
        ));



        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);


        return redirect()->route('produtos.list');

    }


    public function list()
    {

        $headers = array(
            "cache-control: no-cache",
            "Authorization: Bearer pmwememewm6151541"
        );


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('DOMINIO_API').'/produtos/list',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => $headers,
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);

        return view('Site.list')->with('lista', $response);


    }

    public function show($id)
    {
        $headers = array(
            "cache-control: no-cache",
        );

        $curl = curl_init(env('DOMINIO_API')."/produtos/show/$id");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER,  $headers);
        $result  = curl_exec($curl);
        curl_close($curl);
        $produtos = json_decode( $result );

        if(isset($produtos->sucesso)){
            $sucesso = $produtos->sucesso;
            return view('Site.show')->with(compact('produtos', 'sucesso'));
        }
    }

    public function destroy($id)
    {

        $headers = array(
            "cache-control: no-cache",
        );
        $curl = curl_init(env('DOMINIO_API')."/produtos/delete/$id");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER,  $headers);
        $result  = curl_exec($curl);
        curl_close($curl);
        $produtos = json_decode( $result );

        if(isset($produtos->sucesso)){
            $sucesso = $produtos->sucesso;
            return redirect()->route('produtos.list')->with(compact('sucesso'));
        }
    }
}
