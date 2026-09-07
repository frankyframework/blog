<?php
use Blog\entity\CategoriablogEntity;
use Blog\model\categoriasBlog;
use Franky\Haxor\Tokenizer;


if ($MyRequest->isAjax()) {
    $callback	= $MyRequest->getRequest('callback');
    $filters = $MyRequest->getRequest('filters');
    $dataPost = json_decode(stripslashes($filters),true);
    $dataPost = $dataPost['rules'];
    $requestFranky = [];
    $request = [];
    foreach($dataPost as $data) {
      
      $request[$data['field']] = $MyRequest->Sanitizacion($data['data']);
      
    }
  
  
    $Tokenizer = new Tokenizer();
    $sortInput  = (!empty($MyRequest->getRequest('sidx',"fecha")) ? : "fecha");
   
  
   
    if(getCoreConfig('blog/idioma/multi-idioma') == 1)
    {
        $lang_b	= $MyRequest->getRequest('lang_b',$_SESSION['lang'] );
        $idiomas_disponibles = getCoreConfig('base/theme/langs');
        $request['lang'] = $lang_b;

    }

    $MyCategoriaBlog = new categoriasBlog();
    $CategoriablogEntity = new CategoriablogEntity($request);


    $MyCategoriaBlog->setPage($MyRequest->getRequest('page',1));
    $MyCategoriaBlog->setTampag($MyRequest->getRequest('rows',12));
    $MyCategoriaBlog->setOrdensql($sortInput." ".$MyRequest->getRequest('sord',"ASC"));


    if(getCoreConfig('blog/registers/showdelete') == 0){
        $CategoriablogEntity->status(1);
    }

    $result	 = $MyCategoriaBlog->getData($CategoriablogEntity->getArrayCopy());
    $dataRows = ["rows" => [], "total" => ceil($MyCategoriaBlog->getTotal() / $MyRequest->getRequest('rows',12)), "page" => (int)$MyRequest->getRequest('page',1),"records" => $MyCategoriaBlog->getTotal()];

    if($MyCategoriaBlog->getTotal() > 0)
    {

        while($registro = $MyCategoriaBlog->getRows())
        {
            $registro = array_filter($registro, function($llave) {
                    return !is_numeric($llave);
            }, ARRAY_FILTER_USE_KEY);
    
    
            $dataRows['rows'][] = array_merge($registro,array(
                    "fecha" 	=> getFechaUI($registro["fecha"]),
                    "status"  => ($registro["status"] == 1 ?"desactivar" : "activar"),
                    "callback" => $Tokenizer->token('categories_blog',$MyRequest->getURI()),
                    ));
                    $iRow++;
            }
    }
    header('Content-Type: application/json; charset=utf-8');
    echo $callback . '(' . json_encode($dataRows). ');';
    die;
} else {
    $MyMetatag->setJs("/public/plugins/jqGrid/js/jquery.jqGrid.js");
    $MyMetatag->setJs("/public/plugins/jqGrid/js/i18n/grid.locale-$lang_root.js");
    $MyMetatag->setCSS("/public/plugins/jqGrid/css/ui.jqgrid.css");
  
}

?>