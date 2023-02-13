<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Links;
use App\Models\Blogs;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class LinksController extends Controller
{
    public function getLinks(){

        $result = Links::select('links.*')->get();

        return view('perfil', ['linksArray' => $result]);

    }

    public function meusBlogs(){

        $result = Blogs::select('blogs.*')
        ->get();
        return view('meusblogs', ['linksArray' => $result]);

    }

    
    public function editarLink(Request $request){



        //Validacao do dados//
        $validator = Validator::make($request->all(), 
        ['li_titulo' => 'required|max:255', 'li_url' => 'required|max:255'], 
        [
            'li_titulo.required' => 'O CAMPO TÍTULO É OBRIGATÓRIO', 'li_url.required' => 'O CAMPO URL OBRIGATÓRIO',
            'li_titulo.max' => 'INSIRA NO MÁXIMO 255 CARACTERES', 'li_url.max' => 'INSIRA NO MÁXIMO 255 CARACTERES',
        ],   
                  
        );

        if ($validator->fails()) {
            return redirect("/../blogdetalhes/{$request->li_blog_id}")
                            ->withErrors($validator)
                            ->withInput();
        }
    

       
        Links::where('li_id', '=', $request->li_id)
        ->update(['li_id' => $request->li_id, 'li_titulo' => $request->li_titulo, 'li_url' => $request->li_url, 'li_blog_id' => $request->li_blog_id]);


        return redirect("../blogdetalhes/{$request->li_blog_id}")->with('mensagem_alteracao_sucesso', 'ALTERAÇÃO REALIZADA COM SUCESSO!');



    }
}
