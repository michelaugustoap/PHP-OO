<?php
/*
 * classe ProdutoGateway
 * implementa Table Data Gateway
 */
class ProdutoGateway
{
	/*
	 * método insert()
	 * insere dados na tabela de Produtos
	 * @param $id			= ID do produto
	 * @param $descricao	= descrição do produto
	 * @param $estoque		= estoque atual
	 * @param $preco_custo	= preço de custo
	 */
	function insert($id, $descricao, $estoque, $preco_custo)
	{
		//cria instrução SQL de insert
		$sql = "INSERT INTO Produtos (id, descricao, estoque, preco_custo)" .
				"VALUES ('$id', '$descricao', '$estoque', '$preco_custo')";
		
		//instancia o objeto PDO
		$conn = new PDO('sqlite:produtos.db');
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		//executa instrução SQL
		$conn->exec($sql);
		unset($conn); 
	}
	
	/*
	 * método update()
	 * altera os dados na tabela de Produtos
	 * @param $id			= ID do produto
	 * @param $descricao	= descrição do produto
	 * @param $estoque		= estoque atual
	 * @param $preco_custo	= preço de custo
	 */
	function update($id, $descricao, $estoque, $preco_custo)
	{
		//cria instrução SQL de UPDATE
		$sql = "UPDATE produtos set descricao = '$descricao'," .
		" estoque = '$estoque', preco_custo = '$preco_custo' ".
		" WHERE id = '$id'";
		
		//instancia o objeto PDO
		$conn = new PDO('sqlite:produtos.db');
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		//executa a instrução SQL
		$conn->exec($sql);
		unset($conn);
	}
	/*
	 * método delete()
	 * deleta um registro na tabela de Produtos
	 * @param $id = ID do produto
	 */
	function delete($id)
	{
		//cria a instrução SQL de DELETE
		$sql = "DELETE FROM produtos where id = '$id'";
		//instancia o objeto PDO
		$conn = new PDO('sqlite:produtos.db');
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		//executa instrução SQL
		$conn->exec($sql);
		unset($conn); 
	}
	/*
	 * método getObject
	 * busca um registro da tabela de produtos
	 * @param $id = ID do produto
	 */
	function getObject($id)
	{
		//cria instrução SQL de SELECT
		$sql = "SELECT * FROM produtos where id='$id'";
		//instancia objeto PDO
		$conn = new PDO('sqlite:produtos.db');
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		//executa a consulta SQL
		$result = $conn->query($sql);
		$data = $resulkt->fetch(PDO::FETCH_ASSOC);
		unset($conn);
		return $data;
	}
	/*método get Objects
	 * lista todos os registros da tablea de produtos
	 */
	function getObjects()
	{
		//cria a instrução SQL de SELECT
		$sql = "SELECT * FROM produtos";
		
		//instancia objeto PDO
		$conn = new PDO('sqlite:produtos.db');
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
		// executa a consulta SQL
		$result = $conn->query($sql);
		$data = $result->fetchAll(PDO::FETCH_ASSOC);
		unset($conn);
		return $data;
	}
}

//instancia um objeto ProdutoGateway
$gateway = new ProdutoGateway();

//insere alguns registros na tabela
$gateway->insert(1, 'Vinho', 10, 10);
$gateway->insert(2, 'Salame', 20, 20);
$gateway->insert(3, 'Queijo', 30, 30);

//efetua algumas alterações
$gateway->update(1, 'Vinho', 20, 20);
$gateway->update(2, 'Salame', 40, 40);
//exclui o produto 3
$gateway->delete(3);
//exibe novamente os registros
echo "Lista de Produtos<br/>\n";
print_r($gateway->getObjects());