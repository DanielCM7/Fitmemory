
<?php

use PHPUnit\Framework\TestCase;
class loginInicioTest extends TestCase
{
public function testUsuario()
{
$usuario='david';
$resultado=$this->validarUsuarioBD($usuario);
$this->assertTrue($resultado, "El usuario existe");
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