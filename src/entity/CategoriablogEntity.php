<?php
namespace Blog\entity;

class CategoriablogEntity
{
    private $id;
    private $nombre;
    private $friendly;
    private $fecha;
    private $status;
    private $visible;
    private $permisos;
    private $imagen;
    private $imagen_portada;
    private $lang;
    private $meta_keywords;
    private $meta_titulo;
    private $meta_descripcion;
 
    public function __construct($data = null)
    {
        if (null != $data) {
            $this->exchangeArray($data);
        }
    }


    public function exchangeArray($data)
    {
        $this->id = (isset($data["id"]) && !empty($data["id"]) ? $data["id"] : null);
        $this->nombre = (isset($data["nombre"]) ? $data["nombre"] : null);
        $this->fecha = (isset($data["fecha"]) ? $data["fecha"] : null);
        $this->friendly = (isset($data["friendly"]) ? $data["friendly"] : null);
        $this->status = (isset($data["status"]) ? $data["status"] : null);
        $this->visible = (isset($data["visible"]) ? $data["visible"] : null);
        $this->permisos = (isset($data["permisos"]) ? $data["permisos"] : null);
        $this->imagen = (isset($data["imagen"]) ? $data["imagen"] : null);
        $this->imagen_portada = (isset($data["imagen_portada"]) ? $data["imagen_portada"] : null);
        $this->lang = (isset($data["friendly"]) ? $data["friendly"] : null);
        $this->meta_keywords = (isset($data["meta_keywords"]) ? $data["meta_keywords"] : null);
        $this->meta_titulo = (isset($data["meta_titulo"]) ? $data["meta_titulo"] : null);
        $this->meta_descripcion = (isset($data["meta_descripcion"]) ? $data["meta_descripcion"] : null);

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

    public function nombre($nombre = null){ if($nombre != null){ $this->nombre=$nombre; }else{ return $this->nombre; } }

    public function fecha($fecha = null){ if($fecha != null){ $this->fecha=$fecha; }else{ return $this->fecha; } }

    public function friendly($friendly = null){ if($friendly != null){ $this->friendly=$friendly; }else{ return $this->friendly; } }

    public function status($status = null){ if($status != null){ $this->status=$status; }else{ return $this->status; } }

    public function visible($visible = null){ if($visible != null){ $this->visible=$visible; }else{ return $this->visible; } }

    public function permisos($permisos = null){ if($permisos != null){ $this->permisos=$permisos; }else{ return $this->permisos; } }

    public function imagen($imagen = null){ if($imagen != null){ $this->imagen=$imagen; }else{ return $this->imagen; } }

    public function imagen_portada($imagen_portada = null){ if($imagen_portada != null){ $this->imagen_portada=$imagen_portada; }else{ return $this->imagen_portada; } }

    public function lang($lang = null){ if($lang != null){ $this->lang=$lang; }else{ return $this->lang; } }

    public function meta_keywords($meta_keywords = null){ if($meta_keywords != null){ $this->meta_keywords=$meta_keywords; }else{ return $this->meta_keywords; } }

    public function meta_titulo($meta_titulo = null){ if($meta_titulo != null){ $this->meta_titulo=$meta_titulo; }else{ return $this->meta_titulo; } }

    public function meta_descripcion($meta_descripcion = null){ if($meta_descripcion != null){ $this->meta_descripcion=$meta_descripcion; }else{ return $this->meta_descripcion; } }

}
?>