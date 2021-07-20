<?php
$menuadminblog = array(
     array('title'=> "Blog",
            'children' =>  array(
            )
    )

);


if(getCoreConfig('blog/calificaciones/enabled') == 1):
  $menuadminblog[0]['children'][] = array(
    "permiso" =>   ADMINISTRAR_BLOG_MIS_CALIFICACIONES,
    "url" => $MyRequest->url(ADMIN_MIS_CALIFICACIONES_BLOG),
    "etiqueta" => "Mis Calificaciones y comentarios"
  );
endif;

return $menuadminblog;
?>
