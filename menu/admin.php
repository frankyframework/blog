<?php
$menuadminblog = array(
     array('title'=> "Blog",
            'children' =>  array(
                array(
                 "permiso" =>   ADMINISTRAR_CATEGORIAS_BLOG,
                 "url" => $MyRequest->url(ADMIN_LISTA_CATEGORIAS_BLOG),
                 "etiqueta" => "Categorías"
                ),
                array(
                 "permiso" =>   ADMINISTRAR_ARTICULOS_BLOG,
                 "url" => $MyRequest->url(ADMIN_LISTA_ARTICULOS_BLOG),
                 "etiqueta" => "Artículos"
                )
            )
    )

);


if(getCoreConfig('blog/calificaciones/enabled') == 1):
  if(getCoreConfig('blog/calificaciones/moderado') == 1):
      
    $menuadminblog[0]['children'][] = array(
      "permiso" =>   ADMINISTRAR_BLOG_CALIFICACIONES_PENDIENTES,
      "url" => $MyRequest->url(ADMIN_CALIFICACIONES_PENDIENTES_BLOG),
      "etiqueta" => "Calificaciones y comentarios pendientes"
    );
  endif;

  $menuadminblog[0]['children'][] = array(
    "permiso" =>   ADMINISTRAR_BLOG_CALIFICACIONES,
    "url" => $MyRequest->url(ADMIN_CALIFICACIONES_BLOG),
    "etiqueta" => "Calificaciones y comentarios"
  );
endif;

return $menuadminblog;
?>
