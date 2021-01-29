<?php

function valida_inputs($tipo_input = 0, $input)
{
	/*
	TIPOS:
	0 -> VALIDA NUMEROS
	1 -> TODOS OS CARACTERES INCLUINDOS ESPAÇOS ETC
	2 -> valida email
	3-> valida data
	*/

	if ($tipo_input == 0) {
		$regex = '/^[1234567890]+$/';
	} //fim if ($tipo_input == 0){

	if ($tipo_input == 1) {
		$regex = '/^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ1234567890@. ]+$/';
	} //fim if ($tipo_input == 1){

	if ($tipo_input == 2) {
		$regex = '/^[A-Za-z@.]+$/';
	} //fim if ($tipo_input == 2){

	if ($tipo_input == 3) {
		$regex = '/^[0-9-]+$/';
	} //fim if ($tipo_input == 3){


	$analisa_input = preg_match($regex, $input);
	if ($analisa_input) {
		return true;
	} //fim if ($analisa_input){
	else {
		return false;
	} //fim else{
} //fim function valida_inputs($tipo_input=0){

function menu($menu)
{
	$pagina = "index.php";
	if ($menu == 1) {
		echo $pagina . "?page=cad_alunos";
	}
	if ($menu == 2) {
		echo $pagina . "?page=cad_turma";
	}
	if ($menu == 3) {
		echo $pagina . "?page=cad_escola";
	}
}//fim function menu($menu){
