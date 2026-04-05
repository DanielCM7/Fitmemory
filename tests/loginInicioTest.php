
<?php

use PHPUnit\Framework\TestCase;
class crearloginInicioTest extends TestCase
{
public function testUsuario()
{
$usuario='estibaliz';
$resultado=$this->validarUsuarioBD($usuario);
$this->assertFalse($resultado, "El usuario no existe");
}
private function validarUsuarioBD ($usuario)
{
    $usuariosRegistrados=['admin','paula','david','daniel', 'itziar'];
    if (in_array($usuario,$usuariosRegistrados)) 
        {
            return true;
        }else{
            return false;
        }
}
}
?>