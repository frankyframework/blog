<?php
namespace Blog\model;

class categoriasBlog  extends \Franky\Database\Mysql\objectOperations
{
        var $lang;

        public function __construct()
        {
          parent::__construct();
          $this->from()->addTable('categorias_blog');
        }

        function getData($data = [])
        {
            $data = $this->optimizeEntity($data);
            $campos = array("id","nombre","friendly as amigable_categoria","fecha",
            "status","visible","permisos","imagen","imagen_portada","lang","meta_keywords","meta_titulo","meta_descripcion");

            foreach($data as $k => $v)
            {
              if(!empty($v))
              {
                  if(is_array($v))
                  {
                      $this->where()->concat('AND (');
                      foreach ($v as $_v)
                      {
                          $this->where()->addOr($k,$_v,'=');

                      }
                      $this->where()->concat(')');
                  }
                  else
                  {
                      if(in_array($k,['id','friendly','fecha'])) {
                          $this->where()->addAnd($k,$v,'=');
                      } else {
                          $this->where()->addAnd($k,"%".$v."%",'like');
                      }
                  } 
              }
          }
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

        function setStatus($id,$status)
        {
            $nvoregistro = array(
                "status" => "$status"
            );

            $this->where()->addAnd('id',$id,'=');
            return $this->editarRegistro( $nvoregistro);
        }




    function existe($categoria,$id='')
    {
            $campos = array("id");
            $this->where()->addAnd('nombre',$categoria,'=');
            if(!empty($id))
            {
							$this->where()->addAnd('id',$id,'<>');
            }

            return $this->getColeccion($campos);
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
    
    public function eliminar(array $data)
    {
        $data = $this->optimizeEntity($data);
        foreach($data as $k => $v)
        {
            $this->where()->addAnd($k,$v,'=');
        }
        
        return $this->eliminarRegistro($data);
    }

}
?>
