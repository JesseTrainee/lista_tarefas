<?php


//CRUD
class TarefaService {

	private $conexao;
	private $tarefa;

	public function __construct(Conexao $conexao, Tarefa $tarefa) {
		$this->conexao = $conexao->conectar();
		$this->tarefa = $tarefa;
	}

	public function inserir() { //create
		$query = 'insert into tb_tarefas(tarefa)values(:tarefa)';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));
		$stmt->execute();
	}

	public function recuperar() { //read
		$query = '
		SELECT
			t.id, s.status, t.tarefa
		FROM
			tb_tarefas AS t
			LEFT JOIN tb_status AS s ON (t.id_status = s.id) 
		';
		$stmt = $this->conexao->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function atualizar() { //update
		//using marker parameter ? 
		$query = '
		UPDATE 
			tb_tarefas
		SET 
			tarefa = ? WHERE id= ?';
		$stmt = $this->conexao->prepare($query);
		// 1 = tarefa
		$stmt->bindValue(1, $this->tarefa->__get('tarefa'));
		//2 = id
		$stmt->bindValue(2, $this->tarefa->__get('id'));
		return $stmt->execute();
	}

	public function remover() {
		$query = 'DELETE FROM tb_tarefas WHERE id = ?';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(1, $this->tarefa->__get('id'));
		$stmt->execute();
	}
}

?>