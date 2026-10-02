<?php
namespace Blog\entity;

class BlogEntity
{
    private $id;
    private $categoria;
    private $titulo;
    private $contenido;
    private $destacado;
    private $friendly;
    private $comentarios;
    private $fecha;
    private $fecha_modificado;
    private $lang;
    private $status;
    private $autor;
    private $autortext;
    private $keywords;
    private $meta_titulo;
    private $meta_descripcion;
    private $visible_in_search;
    private $permisos;
    private $imagen;
    private $imagen_portada;
    private $showimage;
   
 
    public function __construct($data = null)
    {
        if (null != $data) {
            $this->exchangeArray($data);
        }
    }


    public function exchangeArray($data)
    {
        $this->id = (isset($data["id"]) && !empty($data["id"]) ? $data["id"] : null);
        $this->categoria = (isset($data["categoria"]) ? $data["categoria"] : null);
        $this->titulo = (isset($data["titulo"]) ? $data["titulo"] : null);
        $this->contenido = (isset($data["contenido"]) ? $data["contenido"] : null);
        $this->destacado = (isset($data["destacado"]) ? $data["destacado"] : null);
        $this->friendly = (isset($data["friendly"]) ? $data["friendly"] : null);
        $this->comentarios = (isset($data["comentarios"]) ? $data["comentarios"] : null);
        $this->fecha = (isset($data["fecha"]) ? $data["fecha"] : null);
        $this->fecha_modificado = (isset($data["fecha_modificado"]) ? $data["fecha_modificado"] : null);
        $this->lang = (isset($data["friendly"]) ? $data["friendly"] : null);
        $this->status = (isset($data["status"]) ? $data["status"] : null);
        $this->autor = (isset($data["autor"]) ? $data["autor"] : null);
        $this->keywords = (isset($data["keywords"]) ? $data["keywords"] : null);
        $this->meta_titulo = (isset($data["meta_titulo"]) ? $data["meta_titulo"] : null);
        $this->meta_descripcion = (isset($data["meta_descripcion"]) ? $data["meta_descripcion"] : null);
        $this->visible_in_search = (isset($data["visible_in_search"]) ? $data["visible_in_search"] : null);
        $this->permisos = (isset($data["permisos"]) ? $data["permisos"] : null);
        $this->imagen = (isset($data["imagen"]) ? $data["imagen"] : null);
        $this->imagen_portada = (isset($data["imagen_portada"]) ? $data["imagen_portada"] : null);
        $this->showimage = (isset($data["showimage"]) ? $data["showimage"] : null);
        $this->autortext = (isset($data["autortext"]) ? $data["autortext"] : null);
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function setValidation()
    {
        return array();
    }
    
    
    public function id($id = null){ if($id != null){ $this->id=$id; }else{ return $this->id; } }

    public function categoria($categoria = null){ if($categoria != null){ $this->categoria=$categoria; }else{ return $this->categoria; } }

    public function titulo($titulo = null){ if($titulo != null){ $this->titulo=$titulo; }else{ return $this->titulo; } }

    public function contenido($contenido = null){ if($contenido != null){ $this->contenido=$contenido; }else{ return $this->contenido; } }

    public function destacado($destacado = null){ if($destacado != null){ $this->destacado=$destacado; }else{ return $this->destacado; } }

    public function friendly($friendly = null){ if($friendly != null){ $this->friendly=$friendly; }else{ return $this->friendly; } }

    public function comentarios($comentarios = null){ if($comentarios != null){ $this->comentarios=$comentarios; }else{ return $this->comentarios; } }

    public function fecha($fecha = null){ if($fecha != null){ $this->fecha=$fecha; }else{ return $this->fecha; } }

    public function fecha_modificado($fecha_modificado = null){ if($fecha_modificado != null){ $this->fecha_modificado=$fecha_modificado; }else{ return $this->fecha_modificado; } }

    public function lang($lang = null){ if($lang != null){ $this->lang=$lang; }else{ return $this->lang; } }

    public function status($status = null){ if($status != null){ $this->status=$status; }else{ return $this->status; } }

    public function autor($autor = null){ if($autor != null){ $this->autor=$autor; }else{ return $this->autor; } }

    public function keywords($keywords = null){ if($keywords != null){ $this->keywords=$keywords; }else{ return $this->keywords; } }

    public function meta_titulo($meta_titulo = null){ if($meta_titulo != null){ $this->meta_titulo=$meta_titulo; }else{ return $this->meta_titulo; } }
    
    public function meta_descripcion($meta_descripcion = null){ if($meta_descripcion != null){ $this->meta_descripcion=$meta_descripcion; }else{ return $this->meta_descripcion; } }

    public function visible_in_search($visible_in_search = null){ if($visible_in_search != null){ $this->visible_in_search=$visible_in_search; }else{ return $this->visible_in_search; } }

    public function permisos($permisos = null){ if($permisos != null){ $this->permisos=$permisos; }else{ return $this->permisos; } }

    public function imagen($imagen = null){ if($imagen != null){ $this->imagen=$imagen; }else{ return $this->imagen; } }

    public function imagen_portada($imagen_portada = null){ if($imagen_portada !== null){ $this->imagen_portada=$imagen_portada; }else{ return $this->imagen_portada; } }

    public function showimage($showimage = null){ if($showimage != null){ $this->showimage=$showimage; }else{ return $this->showimage; } }

    public function autortext($autortext = null){ if($autortext != null){ $this->autortext=$autortext; }else{ return $this->autortext; } }

}
?>