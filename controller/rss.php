<?php
use Blog\model\Blog;
use Blog\entity\BlogEntity;
use Blog\model\categoriasBlog;
use Blog\entity\CategoriablogEntity;
use Base\entity\users;


$MyBlog = new Blog();
$BlogEntity = new BlogEntity();
$MyCategoriaBlog = new categoriasBlog();
$MyCategoriaBlogEntity = new categoriasBlog();
$users = new users();
$CategoriablogEntity = new CategoriablogEntity();
$amigable_categoria_context =  $MyRequest->getRequest("categoria");;

$busca_b	= $MyRequest->getRequest('busca_b');
$autor_b = $MyRequest->getRequest('autor_b');
$destacado_b = $MyRequest->getRequest('destacado_b');

$MyBlog->setPage(1);
$MyBlog->setTampag(10000);
$MyBlog->setOrdensql("blog.fecha DESC");

if(empty($amigable_categoria_context))
{
    $BlogEntity->visible_in_search(1);
}
$users->setNombre($autor_b);
$MyBlog->setBusca($busca_b);
$MyBlog->setNivel($MySession->GetVar('role'));
$BlogEntity->destacado($destacado_b);
$BlogEntity->status(1);
$CategoriablogEntity->friendly($amigable_categoria_context);
$result	 = $MyBlog->getData($BlogEntity->getArrayCopy(),$CategoriablogEntity->getArrayCopy(),$users->getArrayCopy());

if($MyBlog->getTotal() > 0)
{
	$iRow = 0;

	while($registro = $MyBlog->getRows())
	{
        $lista_articulos_blog[$iRow] = array(
            "id"		=> $registro["id"],
            "titulo"		=> $registro["titulo"],
            "categoria"		=> $registro["categoria_nombre"],
            "contenido"		=>  previewBlog($registro["contenido"]),
            "articulo"		=>  $registro["contenido"],
            "autor"		=> $registro["nombre_user"],
            "status"    	=> $registro["status"],
            "friendly_categoria"=> $registro["amigable_categoria"],
            "friendly"          => $registro["friendly"],
            "autortext"          => $registro["autortext"],
            "destacado"          => $registro["destacado"],
            "fecha"             => $registro["fecha"],
            "link"              => $MyRequest->url(BLOG_DETALLE,array("categoria" => $registro["amigable_categoria"],"articulo" =>$registro["friendly"]),true)
        );
        
        if(!empty($registro["imagen"]) && file_exists($MyConfigure->getServerUploadDir()."/blog/".$registro["id"]."/".$registro["imagen"]))
        {
            $img = imageResize($MyConfigure->getUploadDir()."/blog/".$registro["id"]."/".$registro["imagen"],400,400, true);
            $lista_articulos_blog[$iRow]['contenido']["img"] = $img;
        }
        $iRow++;
    }
}

if(!empty($amigable_categoria_context))
{
    $CategoriablogEntity->friendly($amigable_categoria_context);
    $MyCategoriaBlog->getData($CategoriablogEntity->getArrayCopy());
    $registro = $MyCategoriaBlog->getRows();

    $permisos = json_decode($registro['permisos'],true);
    if(!empty($permisos) && !$MySession->LoggedIn())
    {
        $MyRequest->redirect($MyRequest->Url(LOGIN).'?callback='.urlencode($MyRequest->url(BLOG_CATEGORIA,array("categoria" => $amigable_categoria_context))));
    }
    if(!empty($permisos) && !in_array($MySession->GetVar('role'),$permisos))
    {
        $MyRequest->redirect();
    }
}

header('Content-Type: text/xml'); 
echo '<?xml version="1.0" encoding="iso-8859-1"?>';
?>

<rss version="2.0">
<channel>
    <title><?=getCoreConfig('blog/rss/titulo')?></title>
    <link><?=$MyRequest->getPROTOCOLO().$MyRequest->getSERVER().($_SERVER['SERVER_PORT'] != 80 ? ':'.$_SERVER['SERVER_PORT'] : '')?>/</link>
    <language><?=$locale?></language>
    <description><?=getCoreConfig('blog/rss/descripcion')?></description>
    <generator><?=getCoreConfig('blog/rss/autor')?></generator>
    <?php if(!empty($lista_articulos_blog)): ?>
    <?php foreach($lista_articulos_blog as $articulo): ?>
    <item>
        <title><?=$articulo['titulo']?></title>
        <link><?=$articulo['link']?></link>
        <pubDate><?=$articulo['fecha']?></pubDate>
        <category><?=$articulo['categoria']?></category>
        <description><![CDATA[<?=$articulo['contenido']['p']?>]]></description>
    </item>
    <?php endforeach; ?>
    <?php endif; ?>
</channel>
</rss>