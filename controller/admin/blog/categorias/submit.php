<?php
use Franky\Core\validaciones; 
use Blog\model\categoriasBlog;
use Blog\entity\CategoriablogEntity;
$MyCategoriaBlog = new categoriasBlog();
$CategoriablogEntity = new CategoriablogEntity($MyRequest->getRequest());

$id                 = $MyRequest->getRequest('id');
$permisos                 = $MyRequest->getRequest('permisos');
$error = false;
            
$rules = array(
            "Nombre de la categoria" => array("valor" => $CategoriablogEntity->nombre(),"required","length" => array("max" => "255")),
            );
        

$validaciones =  new validaciones();
$valid = $validaciones->validRules($rules);
if(!$valid)
{
    $MyFlashMessage->setMsg("error",$validaciones->getMsg());
    $error = true;
}

if($MyCategoriaBlog->existe($CategoriablogEntity->nombre(),$id) == REGISTRO_SUCCESS)
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("blog_categoria_duplicado"));
    $error = true;
}

if(!$MyAccessList->MeDasChancePasar("administrar_categorias_blog"))
{
    $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("sin_privilegios"));
    $error = true;
}

if($error == false)        
{
    $CategoriablogEntity->friendly(getFriendly($CategoriablogEntity->nombre()));
    $CategoriablogEntity->permisos(json_encode($permisos));
    if(empty($id))
    {
        $CategoriablogEntity->fecha(date('Y-m-d H:i:s'));
        $CategoriablogEntity->status(1);
        $result = $MyCategoriaBlog->save($CategoriablogEntity->getArrayCopy());
        if($result == REGISTRO_SUCCESS)
        {
            
            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("guardar_generico_success"));
            $location =  $MyRequest->url(ADMIN_LISTA_CATEGORIAS_BLOG);
        }
        else
        {
     
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("guardar_generico_error"));
            $location = $MyRequest->getReferer();
        }
    }
    else
    {
        
         
         
        $result = $MyCategoriaBlog->save($CategoriablogEntity->getArrayCopy());
        if($result == REGISTRO_SUCCESS)
        {
            $MyFlashMessage->setMsg("success",$MyMessageAlert->Message("editar_generico_success"));
            $location = (!empty($callback) ? ($callback) : $MyRequest->url(ADMIN_LISTA_CATEGORIAS_BLOG));
	}
        else
        {
            $MyFlashMessage->setMsg("error",$MyMessageAlert->Message("editar_generico_error"));
            $location = $MyRequest->getReferer();
        }
    }
	
}
else
{

    $location = $MyRequest->getReferer();
}

$MyRequest->redirect($location);
?>