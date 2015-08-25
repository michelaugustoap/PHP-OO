<?php
/*
 * função __autoload()
 * carrrega uma classe quando ela é necessária
 * ou seja , quando ela é instancia pela primeira vez
 */
function __autoload($classe)
{
	$pastas = array('app.ado', 'app.model');
	foreach($pastas as $pasta){
		if (file_exists("{$pasta}/{$classe}.class.php")){
			include_once "{$pasta}/{$classe}.class.php";
		}
	}	
}
/*
 * classe ClienteFacade
 * Remote Facade para cadastro de Clientes
 */
class ClienteFacade 
{
	/*
	 * método salvar()
	 * recebe um array com dados de cliente e armazena no banco de dados
	 */
	function salvar($dados)
	{
		try{
			//inicia a transação com o banco 'pg_loja'
			TTransaction::open('pg_loja');
			//define o arquivo de log
			TTransaction::setLogger(new TLoggerTXT('/tmp/log.txt'));
			//instancia um Active Record para cliente
			$cliente = new Cliente;//alimenta o registro com dados do array
			$cliente->fromArray($dados);
			$cliente->store(); //armazena o objeto
			//fecha transação
			TTransaction::close();
		}
		catch(Exception $e)
		{
			//caso ocorra erros, volta a transação
			TTransaction::rollback();
			//retorna o erro na forma de um objeto SoapFault
			return new SoapFault("Server", $e->getMessage()); 
		}
	}
}	

//instamncia o servidor SOAP
$server = new SoapServer(NULL, array('encoding' => 'ISO-8859-1', 'uri' => 'http://test-uri'));
$server->setClass('ClienteFacade');
//prepara-se para receber as chamadas remotas
$server->handle();