<?php
namespace Blog\Form;

class articulosBlogForm extends \Franky\Form\Form
{
    public function __construct($name)
    {

        parent::__construct();

       $this->setAtributos(array(
            'name' => $name,
            'action' => "/admin/blog/articulos/submit.php",
            'method' => 'post',
           'enctype' => "multipart/form-data"
        ));

         $this->add(array(
                'name' => 'id',
                'type'  => 'hidden',

            )
        );
       $this->add(array(
                'name' => 'callback',
                'type'  => 'hidden',

            )
        );

       $this->add(array(
                'name' => 'borrador',
                'type'  => 'hidden',

            )
        );


        $this->add(array(
                 'name' => 'data_img',
                 'type'  => 'hidden',

             )
         );


        $this->add(array(
                'name' => 'titulo',
                'label' => _blog('Titulo'),
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'class'       => 'required',
                    'maxlength' => 255
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

         $this->add(array(
                'name' => 'categoria',
                'label' => _blog('Categoria'),
                'type'  => 'select',
                'required'  => true,
               'required'  => true,
                'atributos' => array(
                    'class'       => 'required'
                 ),
                'options' => array(

                ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

        $this->add(array(
                'name' => 'autortext',
                'label' => _blog('Autor'),
                'type'  => 'text',
                'required'  => false,
                'atributos' => array(
                    'class'       => '',
                    'maxlength' => 255
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_no_obligatorio'
                 )
            )
        );
           $this->add(array(
                'name' => 'contenido',
                'label' => _blog('Contenido'),
                'type'  => 'textarea',
                'required'  => true,
                'atributos' => array(
                    'class' => 'required',
                    'rows'  => 5
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );


        $this->add(array(
                'name' => 'keywords',
                'label' => _blog('Keywords'),
                'type'  => 'text',
                'required'  => false,
                'atributos' => array(
                    'class'       => '',
                    'maxlength' => 255,
                    'id'    => "keywords"
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_no_obligatorio'
                 )
            )
        );

        $this->add(array(
                'name' => 'meta_titulo',
                'label' => _blog('Meta titulo'),
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'class'       => 'required',
                    'maxlength' => 255

                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

        $this->add(array(
                'name' => 'meta_descripcion',
                'label' => _blog('Meta descripcion'),
                'type'  => 'text',
                'required'  => true,
                'atributos' => array(
                    'class'       => 'required',
                    'maxlength' => 255
                 ),
                'label_atributos' => array(
                    'class'       => 'desc_form_obligatorio'
                 )
            )
        );

       $this->add(array(
                'name' => 'comentarios',

                'type'  => 'checkbox',

                'options' =>  array("1" => _blog("Permitir comentarios en este articulo")),

            )
        );
        $this->add(array(
                'name' => 'destacado',

                'type'  => 'checkbox',

                'options' =>  array("1" => _blog("Articulo destacado")),


            )
        );


        $this->add(array(
                'name' => 'imagen',
                'label' => _blog('Imagen principal'),
                'type'  => 'file',
                'atributos' => array(
                    'id' => "imagen"
                 )
            )
        );

        $this->add(array(
                'name' => 'visible_in_search',
                'type'  => 'checkbox',
                'atributos' => array(
                    'class' => ''
                 ),
                'options' =>  array("1" => _blog("Esta articulo aparece en listas de resultados")),


            )
        );
        $this->add(array(
                'label' => _blog('Restringir acceso a'),
                'name' => 'permisos[]',
                'type'  => 'checkbox',
                'options' => array(
                ),

            )
        );

         $this->add(array(
                'name' => 'guardar',
                'type'  => 'submit',
                'atributos' => array(
                    'class'       => 'btn btn-primary btn-big float_right',
                    'value' => _blog("Guardar")
                 )

            )
        );

           $this->add(array(
                'name' => 'guardar_borrador',
                'type'  => 'submit',
                'atributos' => array(
                    'class'       => 'btn btn-secondary btn-big float_right guardar_borrador',
                    'value' => _blog("Guardar borrador")
                 )


            )
        );

        $this->add(array(
            'name' => 'descartar_borrador',
            'type'  => 'submit',
            'atributos' => array(
                'class'       => 'btn btn-primary btn-big float_right descartar_borrador',
                'value' => _blog("Descartar borrador")
             )


        )
    );


    }

    function addLang()
    {
        $this->add(array(
            'name' => 'lang',
            'type'  => 'select',
            'label' => _blog('Idioma'),
            'require' => true,
            'atributos' => array(
                'class' => 'required'
             ),
            'options' =>  array(),


        )
    );
    }


}
?>
