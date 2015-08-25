<?php
/**
 * classe ClientesForm
 * formulário de Clientes
 */
class ClientesForm extends TPage
{
	private $form; //formulário
	/**
	 * +métodos construtor
	 * cria a página e o formuláriop de cadastro
	 */
	function __construct()
	{
		parent::__construct();
		//instancia um formulário
		$this->form = new TForm('form_clientes');
		//instancia uma tabela
		$table = new TTable();
		
		//aducuina a tabela ao formulário
		$this->form->add($table);
		
		//cria os campos do formulário
		$codigo = new TEntry('id');
		$nome = new TEntry('nome');
		$endereco = new TEntry('endereco');
		$telefone = new TEntry('telefone');
		$cidade = new TCombo('id_cidade');
		
		//define alguns atributos para os campos do formulário
		$codigo->setEditable(FALSE);
		$codigo->setSize(100);
		$nome->setSize(300);
		$endereco->setSize(300);
		
		//carrega as cidades do banco de dados
		TTransaction::open('pg_loja');
		//instancia ujm repositório de cidade
		$repository = new TRepository('Cidade');
		//carrega todos os objetos
		$collection = $repository->load(new TCriteria);
		//adiciona objetos na combo
		foreach($collection as $object)
		{
			$items[$object->id] = $object->nome;
		}
		$cidade->addItems($items);
		TTransaction::close();
		
		//adiciona uma linha para o campo código
		$row = $table->addRow();
		$row->addCell(new TLabel('Código'));
		$row->addCell($codigo);
		
		//adiciona uma linha para o campo nome
		$row=$table->addRow();
		$row->addCell(new TLabel('Nome:'));
		$row->addCell($nome);
		
		//adiciona uma linha para o campo Endereço
		$row=$table->addRow();
		$row->addCell(new TLabel('Endereco:'));
		$row->addCell($endereco);
		
		//adiciona uma linha para o campo do telefone
		$row = $table->addRow();
		$row->addCell(new TLabel('Telefone:'));
		$row->addCell($telefone);
		
		//adiciona uma linha para o campo cidade
		$row = $table->addRow();
		$row->addCell(new TLabel('Cidade:'));
		$row->addCell($cidade);
		
		//cria um botão de ação para o formulário
		$button1 = new TButton('action1');
		//define a ação do botão
		$button1->setAction(new TAction(array($this, 'onSave')), 'Salvar');
		
		//adiciona uma linha para a ação do formulário
		$row = $table->addRow();
		$row->addCell('');
		$row->addCell($button1);
		
		//define quaos são os campos do formulário
		$this->form->setFields(array($codigo, $nome, $endereco, $telefone, $cidade, $button1));
		
		//adiciona o formulário na página
		parent::add($this->form);
	}
	
	/*
	 * método onEdit
	* edita os dados de um reistro
	*/
	function onEdit($param)
	{
		try {
			if(isset($param['key'])){
				//inicia transação com o banco 'pg_loja'
				TTransaction::open('pg_loja');
	
				//obtém o Cliente de acordo com o parâmetro
				$cliente = new Cliente($param['key']);
				//lança os dados do cliente no formulário
				$this->form->setData($cliente);
	
				//finaliza a transação
				TTransaction::close();
			}
		}
		catch (Exception $e){
			//exibe a mensagem gerada pela exceção
			new TMessage('error', '<b>Erro</b>' . $e->getMessage());
			//desfaz todas alterações no banco de dados
			TTransaction::rollback();
		}
	}
	
	/*
	 *método onSave
	 *executado quando o usuário clicar no botão salvar
	 * 
	 */
	function onSave()
	{
		try {
			//inicia a transação com o banco 'pg_loja'
			TTransaction::open('pg_loja');
			
			//lê os dados do formulário e instancia um objeto Cliente
			$cliente = $this->form->getData('Cliente');
			//armazena o objeto no banco de dados
			$cliente->store();
			
			//finaliza a transação
			TTransaction::close();
			//exibe a mensagem de sucesso
			new TMessage('info', 'Dados armazenados com sucesso');
		}
		catch (Exception $e){
			//exibe a mensagem gerada pela exceção
			new TMessage('error', '<b>Erro</b>' . $e->getMessage());
			//desfaz todas as alterações no banco de dados
			TTransaction::rollback();
		}
	}
}