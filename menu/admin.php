<?php
$menuadminblog = array(
     array('title'=> "Blog",
            'children' =>  array(
                array(
                 "permiso" =>   "administrar_categorias_blog",
                 "url" => $MyRequest->url(ADMIN_LISTA_CATEGORIAS_BLOG),
                 "etiqueta" => "Categorías"
                ),
                array(
                 "permiso" =>   "administrar_articulo_blog",
                 "url" => $MyRequest->url(ADMIN_LISTA_ARTICULOS_BLOG),
                 "etiqueta" => "Artículos"
                )
            )
    )

);


if(getCoreConfig('blog/calificaciones/enabled') == 1):
  if(getCoreConfig('blog/calificaciones/moderado') == 1):
      
    $menuadminblog[0]['children'][] = array(
      "permiso" =>   "administrar_blog_calificaciones_pendientes",
      "url" => $MyRequest->url(ADMIN_CALIFICACIONES_PENDIENTES_BLOG),
      "etiqueta" => "Calificaciones y comentarios pendientes"
    );
  endif;

  $menuadminblog[0]['children'][] = array(
    "permiso" =>   "administrar_blog_calificaciones",
    "url" => $MyRequest->url(ADMIN_CALIFICACIONES_BLOG),
    "etiqueta" => "Calificaciones y comentarios"
  );
endif;

return $menuadminblog;
?>
