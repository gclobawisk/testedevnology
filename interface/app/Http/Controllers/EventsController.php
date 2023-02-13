<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\HTTP;
use Illuminate\Support\Facades\DB;
use App\Models\Event;
use App\Models\Links;
use App\Models\Blogs;
use App\Models\User;


class EventsController extends Controller
{
    public function destroyLink($li_id, $li_blog_id){
      
        Links::where('li_id',$li_id)->delete();
        return redirect("/blogdetalhes/$li_blog_id")->with('mensagem_exclusao', 'LINK DELETADO COM SUCESSO');
    

    } 

    public function destroyAllLinks(){

        DB::table('links')->truncate();
      
        return redirect("/blogdetalhes/1")->with('mensagem_exclusao', 'LINKS DELETADOS COM SUCESSO');
    
    } 

    public function destroyBlog($blog_id){
      
        Links::where('blog_id',$blog_id)->delete();
        return redirect('/blogs')->with('mensagem_exclusao', 'Blog Excluído com Sucesso');
    
    } 

    public function uploadImage(Request $request){

        $event = new User;

        if ($request->hasfile('image') && $request->file('image')->isValid() ){


            //Obtendo a extensao do arquivo
            $extensao = $request->image->extension();

            // Verificando se o formato é valido
            if ($extensao == "png" || $extensao =='jpg' || $extensao == 'BMP'){
        
            
                //GERANDO NOME DO ARQUIVO RANDOMICAMENTE
                $novo_nome = md5(random_int(1, 1000)) . time().'.jpg';
                $caminhoAtualArquivo = $_FILES['image']['tmp_name'];
                $caminhoSalvar = 'assets_admin/assets/img/avatars/'.$novo_nome;
                move_uploaded_file($caminhoAtualArquivo, $caminhoSalvar);

                echo $novo_nome;


                //SALVANDO NO BANCO DE DADOS
                User::where('id', '=', Auth::user()->id)
                ->update(['image' => $novo_nome]);

                return redirect('/perfil');

            }else{
                return redirect('/perfil')->with('formato_invalido', 'Formato de Arquivo Inválido');
            }



        }



    }
 

}
