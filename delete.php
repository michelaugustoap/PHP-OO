<?php
/*função __autoload()
 * Carrega uma classe quando ela é necessária, ou seja,
 * quando ela é instancia pela primeira vez
 */

function __autoload($classe)
{
	if (file_exists("app.ado/{$classe}.class.php"))
	{
		include_once "app.ado/{$classe}.class.php";
	}
	
}
//cria o critério de seleção de dados
$criteria = new TCriteria;
$criteria->add(new TFilter('id', '=', '3'));

//cria a instrução de DELETE
$sql = new TSqlDelete;
//define a entidade
$sql->setEntity('aluno');
//define o critério de selção e dados
$sql->setCriteria($criteria);

//processa a instrução SQL
echo $sql->getInstruction();
echo "<br />\n";