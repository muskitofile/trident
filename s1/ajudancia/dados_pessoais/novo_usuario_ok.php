<?php

include_once '../../componente1/Html1.class.php';
include_once '../../componente1/Header1.class.php';
include_once '../../componente1/Paragraph1.class.php';
include_once '../../componente1/Anchor1.class.php';

$html = new Html1("Bem-Vindo ao Poseidon");

$body = $html->getBody();
$body->add(new Header1("Bem-vindo, {$_GET['novo_usuario']}, ao sistema Poseidon."));
$body->add(new Paragraph1("Seu perfil de usuário foi criado com sucesso e sua senha enviada para".
        " o email que você informou durante seu cadastro."));
$body->add(new Anchor1("../../index.php","Retornar à página de login"));

$html->show();
?>
