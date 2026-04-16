
<?php

use PHPUnit\Framework\TestCase;
class crearUsuarioTest extends TestCase
{
public function testFecha()
{
$fechaNac='2000-05-14';
$resultado=$this->validarFecha($fechaNac);
$this->assertTrue($resultado, "La fecha es válida");
}
private function validarFecha ($fecha)
{
    if (empty($fecha)) return false;
    $anio =date('Y', strtotime($fecha));
    return $anio<=2010 && $anio<=date('Y');
}
public function testContrasena()
{
    $contrasena= '123J56@f';
    $resultado=$this->validarContrasena($contrasena);
    $this->assertTrue($resultado, "La contraseña es válida");
}
private function validarContrasena($contrasena)
{
    if(empty($contrasena)) return false;
    $patron=  "/^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W]).{8,}$/" ;
    return (bool)preg_match($patron, $contrasena);
}
}
?>