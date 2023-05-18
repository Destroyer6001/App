<?php 
    include("../../bd.php");

    if(isset($_GET['txtID']))
    {
        $txtId = (isset($_GET['txtID'])?$_GET['txtID']:"");
        $sentencia = $conexion->prepare("SELECT *,
        (SELECT nombredelpuesto
        FROM tbl_puestos
        WHERE tbl_puestos.id = tbl_empleados.idpuesto limit 1) as puesto
        FROM `tbl_empleados` WHERE id = :id");
        $sentencia->bindParam(":id",$txtId);
        $sentencia->execute();
        $datosempleado = $sentencia->fetch(PDO::FETCH_LAZY);

        $nombrecompleto = $datosempleado['primernombre']." ".$datosempleado['segundonombre']." ".$datosempleado['primerapellido']." ".$datosempleado['segundoapellido'];
        $fechadeingreso = $datosempleado['fechadeingreso'];
        $puesto = $datosempleado['puesto'];
        $fechadeInicio = new DateTime($fechadeingreso);
        $fechaFin = new DateTime(date('Y-m-d'));
        $diferencia= date_diff($fechadeInicio,$fechaFin);


    }
    ob_start();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta De Recomendacion</title>
</head>
<body>
    <h1>Carta De Recomendacion Laboral</h1>
    <br/><br/>
    Medellin Antioquia, Colombia <strong><?php echo date('d M y')?></strong>
    <br/><br/>
    A quien pueda interesar:
    <br/><br/>
    Reciva un cordial y respetuoso saludo.
    <br/><br/>
    A traves de esta carta deseo hacer de su conocimiento que el/la Sr(a) <strong><?php echo $nombrecompleto; ?></strong>
    ,quien laburo en mi organizacion durante <strong><?php echo $diferencia->y; ?> año(s)</strong> es un ciudadano con una conducta intachable
    . Ha demostrado ser un excelente trabajador, comprometido, responsable y fiel cumplidor de sus tareas.
    Siempre ha mostrado preocupacion por mejorar, capacitarse y actualizar sus conocimientos.
    <br/><br/>
    Durente estos años se ha desempeñado como : <strong><?php echo $puesto; ?>,</strong>
    Es por ello le sugieron esta recomendacion, con la confianza de que siempre estara a la altura de sus compromisos
    y resposabilidades
    <br/><br/>
    Sin mas nada a que referirme y, esperando que esta misiva sea tomada en cuenta, dejo mi numero de contacto para cualquier
    informacion de interes 
    <br/><br/><br/><br/><br/><br/>

    Atentamente,
    <br/>
    Ing. Juan Felipe Areiza Ocampo

</body>
</html>

<?php 
    $HTML =ob_get_clean();
    require_once("../../libs/autoload.inc.php");
    use Dompdf\Dompdf;
    $dompdf= new Dompdf();
    $opciones = $dompdf->getOptions();
    $opciones->set(array("isRemoteEnabled"=>true));
    $dompdf->setOptions($opciones);
    $dompdf->loadHTML($HTML);
    $dompdf->setPaper('letter');
    $dompdf->render();
    $dompdf->stream("archivo.pdf",array("Attachment" => false));
?>