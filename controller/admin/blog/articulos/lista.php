<?php
use Blog\model\Blog;
use Blog\entity\BlogEntity;
use Blog\entity\CategoriablogEntity;
use Blog\model\BorradorblogModel;
use Blog\entity\BorradorblogEntity;
use Franky\Haxor\Tokenizer;
use Base\entity\users as UserEntity;

if ($MyRequest->isAjax()) {
    $callback	= $MyRequest->getRequest('callback');
    $filters = $MyRequest->getRequest('filters');
    $dataPost = json_decode(stripslashes($filters),true);
    $dataPost = $dataPost['rules'];
    $requestFranky = [];
    $request = [];
    foreach($dataPost as $data) {
      
      $request[$data['field']] = $MyRequest->Sanitizacion($data['data']);
      
    }
  
    $Tokenizer = new Tokenizer();
    $MyBlog = new Blog();
    $BlogEntity = new BlogEntity();
    $BorradorblogModel = new BorradorblogModel();
    $BorradorblogEntity = new BorradorblogEntity();
    $CategoriablogEntity = new CategoriablogEntity();
    $UserEntity = new UserEntity();
    $sortInput  = (!empty($MyRequest->getRequest('sidx',"blog.fecha")) ? : "blog.fecha");


    $BorradorblogModel->setPage(1);
    $BorradorblogModel->setTampag(10000);
    $borrador = [];
    if($BorradorblogModel->getData($BorradorblogEntity->getArrayCopy()) == REGISTRO_SUCCESS)
    {
        while($registro = $BorradorblogModel->getRows()){
            $borrador[] = $registro['id_blog'];
        }  
    }


    if(getCoreConfig('blog/idioma/multi-idioma') == 1)
    {
        $lang_b	= $MyRequest->getRequest('lang_b',$_SESSION['lang'] );
        $idiomas_disponibles = getCoreConfig('base/theme/langs');
        $BlogEntity->lang($lang_b);

    }

    if(getCoreConfig('blog/registers/showdelete') == 0){
        $BlogEntity->status(1);
    }
    $UserEntity->setNombre($request['nombre_user']);
    $BlogEntity->titulo($request['titulo']);
    $BlogEntity->friendly($request['friendly']);
    $BlogEntity->lang($request['lang']);
    $BlogEntity->fecha($request['fecha']);
    $CategoriablogEntity->nombre($request['categoria_nombre']);

    $MyBlog->setPage($MyRequest->getRequest('page',1));
    $MyBlog->setTampag($MyRequest->getRequest('rows',12));
    $MyBlog->setOrdensql($sortInput." ".$MyRequest->getRequest('sord',"ASC"));

    $MyBlog->setIsAdmin(1);
    $result	 = $MyBlog->getData($BlogEntity->getArrayCopy(),$CategoriablogEntity->getArrayCopy(),$UserEntity->getArrayCopy());
    $dataRows = ["rows" => [], "total" => ceil($MyBlog->getTotal() / $MyRequest->getRequest('rows',12)), "page" => (int)$MyRequest->getRequest('page',1),"records" => $MyBlog->getTotal()];

    if($MyBlog->getTotal() > 0)
    {	
        
        while($registro = $MyBlog->getRows())
        {
            $registro = array_filter($registro, function($llave) {
                    return !is_numeric($llave);
            }, ARRAY_FILTER_USE_KEY);


            $dataRows['rows'][] = array(
                        "id" => $Tokenizer->token('articulo_blog',$registro["id"]),
                        "fecha"             => getFechaUI($registro["fecha"]),
                        "friendly"          => '<a href="'.$MyRequest->url(BLOG_DETALLE,array("categoria" => $registro["amigable_categoria"],"articulo" => $registro["friendly"])).'" target="_blank">'.$registro['titulo'].'</a>',
                        "nuevo_estado"  =>($registro["status"] == 1 ?  "desactivar" : "activar"),
                        "borrador" =>in_array($registro['id'],$borrador) ? 1: 0,
                        "callback" => $Tokenizer->token('anuncios',$MyRequest->getURI()),
                        "titulo" => $registro['titulo'],
                        "lang" => $registro['lang'],
                        "categoria_nombre" => $registro['categoria_nombre'],
                        "nombre_user" => $registro['nombre_user']
                    );
                    
        }
    }
    header('Content-Type: application/json; charset=utf-8');
    echo $callback . '(' . json_encode($dataRows). ');';
    die;
} else {
    $MyMetatag->setJs("/public/plugins/jqGrid/js/jquery.jqGrid.js");
    $MyMetatag->setJs("/public/plugins/jqGrid/js/i18n/grid.locale-$lang_root.js");
    $MyMetatag->setCSS("/public/plugins/jqGrid/css/ui.jqgrid.css");
  
}

?>