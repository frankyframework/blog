<?php
namespace Blog\model;

class Blog  extends \Franky\Database\Mysql\objectOperations
{

    var $busca;
    var $is_admin;
    var $nivel;


    public function __construct()
      {
        parent::__construct();
        $this->from()->addTable('blog');
        $this->is_admin = 0;
        $this->busca = "";
      }

      public function setBusca(string $busca)
      {
        $this->busca = $busca;
      }
      
      public function setNivel($nivel)
      {
        $this->nivel = $nivel;
      }
      
      public function setIsAdmin($val)
      {
        $this->is_admin = $val;
      }
    


      function getData($blog = array(),$categoria = array(),$user = array())
      {
        $blog = $this->optimizeEntity($blog);
        $categoria = $this->optimizeEntity($categoria);
        $user = $this->optimizeEntity($user);
            $campos = array("blog.id","blog.categoria","titulo","contenido","destacado","blog.friendly","comentarios","blog.fecha","fecha_modificado","blog.lang",
                "blog.status","autor","keywords","blog.meta_titulo","blog.meta_descripcion","visible_in_search","blog.permisos","blog.imagen","blog.imagen_portada",
                "categorias_blog.nombre as categoria_nombre","categorias_blog.friendly as amigable_categoria","categorias_blog.visible","categorias_blog.permisos as acl_categoria"
                ,"users.nombre as nombre_user","users.id as id_user","autortext");



              foreach($blog as $k => $v)
              {
                    if(!empty($v) || is_numeric($v))
                  {
                      if(is_array($v))
                      {
                          $this->where()->concat('AND (');
                          foreach ($v as $_v)
                          {
                              $this->where()->addOr("blog.".$k,$_v,'=');
      
                          }
                          $this->where()->concat(')');
                      }
                      else
                      {
                          if(in_array($k,['id','fecha','friendly'])) {
                              $this->where()->addAnd("blog.".$k,$v,'=');
                          } else {
                              $this->where()->addAnd("blog.".$k,"%".$v."%",'like');
                          }
                      } 
                  }
              }

              foreach($categoria as $k => $v)
              {
                    if(!empty($v) || is_numeric($v))
                    {
                      if(is_array($v))
                      {
                          $this->where()->concat('AND (');
                          foreach ($v as $_v)
                          {
                              $this->where()->addOr("categorias_blog.".$k,$_v,'=');
      
                          }
                          $this->where()->concat(')');
                      }
                      else
                      {
                          if(in_array($k,['id','fecha','friendly'])) {
                              $this->where()->addAnd("categorias_blog.".$k,$v,'=');
                          } else {
                              $this->where()->addAnd("categorias_blog.".$k,"%".$v."%",'like');
                          }
                      } 
                  }
              }

              foreach($user as $k => $v)
              {
                    if(!empty($v) || is_numeric($v))
                    { 
                      if(is_array($v))
                      {
                          $this->where()->concat('AND (');
                          foreach ($v as $_v)
                          {
                              $this->where()->addOr("users.".$k,$_v,'=');
      
                          }
                          $this->where()->concat(')');
                      }
                      else
                      {
                          if(in_array($k,['id'])) {
                              $this->where()->addAnd("users.".$k,$v,'=');
                          } else {
                              $this->where()->addAnd("users.".$k,"%".$v."%",'like');
                          }
                      } 
                  }
              }
            
            if(!empty($this->busca))
            {
                    $this->where()->concat('AND (');
                    $this->where()->addOr("blog.titulo","%".$this->busca."%",'like');
                    $this->where()->addOr("blog.contenido","%".$this->busca."%",'like');
                    $this->where()->addOr("blog.keywords","%".$this->busca."%",'like');
                    $this->where()->addOr("categorias_blog.nombre","%".$this->busca."%",'like');
                    $this->where()->concat(')');
            }

            if(empty($this->is_admin))
            {

                if(empty($this->nivel))
                {
                  $this->where()->concat('AND (');
                  $this->where()->addOr("blog.permisos","[]",'=');
                  $this->where()->addOr("blog.permisos","",'=');
                  $this->where()->concat(')');
                }
                else {
                  $this->where()->concat('AND (');
                  $this->where()->addOr("blog.permisos","[]",'=');
                  $this->where()->addOr("blog.permisos","",'=');
                    $this->where()->addOr("blog.permisos",'%'.$this->nivel.'%','like');
                  $this->where()->concat(')');
                }
            }
            
            $this->from()->addInner('categorias_blog','blog.categoria','categorias_blog.id');
            $this->from()->addInner('users','blog.autor','users.id');

            return $this->getColeccion($campos);

        }

        function getPrevData(int $id, string|null $lang)
        {
            $campos = array("blog.id","titulo","blog.friendly","categorias_blog.friendly as amigable_categoria");

            
            $this->where()->addAnd("blog.id",$id,'<');
           
            $this->where()->addAnd("blog.status",'1','=');
            if(!empty($lang))
            {
                $this->where()->addAnd("blog.lang",$lang,'=');
            }
            
            $this->from()->addInner('categorias_blog','blog.categoria','categorias_blog.id');

            return $this->getColeccion($campos);
        }

        function getNextData(int $id, string|null $lang)
        {
            $campos = array("blog.id","titulo","blog.friendly","categorias_blog.friendly as amigable_categoria");

            
            $this->where()->addAnd("blog.id",$id,'>');
           
            $this->where()->addAnd("blog.status",'1','=');
            if(!empty($lang))
            {
                $this->where()->addAnd("blog.lang",$lang,'=');
            }
            
            $this->from()->addInner('categorias_blog','blog.categoria','categorias_blog.id');

            return $this->getColeccion($campos);
        }

        private function optimizeEntity($array)
        {
            foreach ($array as $k => $v )
            {
                if (!isset($v)) {
                    unset($array[$k]);
                }
            }
            return $array;
        }

        public function save(array $data)
        {
            $data = $this->optimizeEntity($data);


          if (isset($data['id']))
          {
                $this->where()->addAnd('id',$data['id'],'=');

                return $this->editarRegistro($data);
          }
          else {

                return $this->guardarRegistro( $data);
          }

        }
/*
        function save($categoria,$titulo,$friendly,$autortext,$contenido,$comentarios,$autor,$keywords,$destacado,$imagen,$imagen_portada,$visible_in_search,$permisos,$meta_titulo="", $meta_descripcion="")
        {
            $nvoregistro = array(
                "categoria" => $categoria,
                "titulo" => $titulo,
                "contenido" => $contenido,
                "friendly" => $friendly,
                "comentarios" => $comentarios,
                "fecha" => date('Y-m-d')." ".date('H:i:s'),
                "autor" => $autor,
                "keywords" => $keywords,
                "status" => "1",
                "destacado" => $destacado,
                "autortext" => $autortext,
                "imagen" => $imagen,
                "imagen_portada" => $imagen_portada,
                "visible_in_search" => $visible_in_search,
                "permisos" => $permisos,
                "meta_titulo" => $meta_titulo,
                "meta_descripcion" => $meta_descripcion
            );

            if(!empty($this->lang))
            {
              $nvoregistro['lang'] = $this->lang;
            }

            return $this->guardarRegistro( $nvoregistro);
        }
*/
        function edit($id,$categoria,$titulo,$friendly,$autortext,$contenido,$comentarios,$keywords,$destacado,$imagen,$imagen_portada,$visible_in_search,$permisos,$meta_titulo="", $meta_descripcion="")
        {
           $nvoregistro = array(
                "categoria" => $categoria,
                "titulo" => $titulo,
               "autortext" => $autortext,
                "contenido" => $contenido,
                "friendly" => $friendly,
                "comentarios" => $comentarios,
                "keywords" => $keywords,
                "destacado" => $destacado,
                "visible_in_search" => $visible_in_search,
                "permisos" => $permisos,
                "meta_titulo" => $meta_titulo,
                "meta_descripcion" => $meta_descripcion
            );
            if(!empty($this->lang))
            {
              $nvoregistro['lang'] = $this->lang;
            }

            if(!empty($imagen))
            {
              $nvoregistro['imagen'] = $imagen;
              $nvoregistro['imagen_portada'] = $imagen_portada;
            }
              $this->where()->addAnd('id',$id,'=');

            return $this->editarRegistro($nvoregistro);
        }
        function delete($id,$status)
        {
            $nvoregistro = array(
                "status" => "$status"
            );

              $this->where()->addAnd('id',$id,'=');

            return $this->editarRegistro($nvoregistro);
        }

    function existe($titulo,$categoria,$id='')
    {
            $campos = array("id");

						$this->where()->addAnd('titulo',$titulo,'=');
						$this->where()->addAnd('categoria',$categoria,'=');

            if(!empty($id))
            {
							$this->where()->addAnd('id',$id,'<>');
            }

            return $this->getColeccion($campos);
    }

}

?>
