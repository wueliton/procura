<?php 
	class crud {
		private $host = "localhost";
		private $user = "root";
		private $pass = "";
		private $db = "procura";
		private $driver = "mysql";

		private function connect() {
			$conn = NULL;

			try {
				$conn = new PDO($this->driver.":host=".$this->host.";dbname=".$this->db,$this->user,$this->pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			}
			catch (PDOException $e) {
				$e->getMessage();
				exit();
			}
			return $conn;
		}

		//CONSULTAR VALORES NO BANCO
		function query($query) {
			try {
				if(!empty($query)) {
					$pdo = $this->connect();
					if($stmt = $pdo->query($query)) {
						$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
						return $res;
					}
					else {
						echo "Consulta inválida";
						return false;
					}
				}
			}
			catch(Exception $e) {
				echo $e->getMessage();
			}
			$pdo = NULL;
		}

		//INSERIR VALORES NO BANCO
		function insert($table,$fields,$values) {
			$valores_query = "";
			$valores = array();
			$campos = "";
			$valores_verify = "";

			try {
				if(!empty($table) && !empty($fields) && !empty($values)) {
					foreach ($fields as $field) {
						if($campos=="") {
							$valores_query = ":".$field;
							$campos = $field;
						}
						else {
							$valores_query .= ", :".$field;
							$campos .= ", ".$field;
						}
					}

					for($i=0;$i<count($fields);$i++) {
						$valores[$fields[$i]] = $values[$i];

						$valores_verify .= $fields[$i]."='".$values[$i]."'";

						if(count($fields)-1>	$i) {
							$valores_verify .= " AND ";
						}
					}

					$pdo = $this->connect();

					$exists = $this->query("SELECT * FROM ".$table." WHERE ".$valores_verify);
					if($exists=="") {
						
					}
					else if(count($exists)>0 && $table!="log") {
						echo "O valor já existe";
					}
					else {
						$sql = "INSERT INTO ".$table." (".$campos.") VALUES (".$valores_query.")";
						$insert_pdo = $pdo->prepare($sql);

						if($insert_pdo->execute($valores)) {
							return true;
						}
						else {
							echo "Ocorreu um erro";
							return false;
							
						}
					}
				}
			}
			catch(Exception $e) {
				echo $e->getMessage();
			}
			$pdo = NULL;
		}

		//ATUALIZAR VALORES DO BANCO
		function update($table,$fields,$values,$id) {
			$valores = array();
			$campos = "";
			$valores_verify = "";
			$valores_query = "";

			try {
				if(!empty($table) && !empty($fields) && !empty($values)) {
					foreach ($fields as $field) {
						if($campos=="") {
							$valores_query = $field."=:".$field;
							$campos = $field;
						}
						else {
							$valores_query .= ", ".$field."=:".$field;
							$campos .= ", ".$field;
						}
					}

					for($i=0;$i<count($fields);$i++) {
						$valores[$fields[$i]] = $values[$i];

						$valores_verify .= $fields[$i]."='".$values[$i]."'";

						if(count($fields)-1>	$i) {
							$valores_verify .= " AND ";
						}
					}

					$valores["id"] = $id;
					$pdo = $this->connect();
					$sql = "UPDATE ".$table." SET ".$valores_query." WHERE id=:id";
					$atualizar = $pdo->prepare($sql);
					if($atualizar->execute($valores)) {
						return true;
					}
					else {
						echo "Erro na consulta";
					}
				}
			}
			catch(Exception $e) {
				echo $e->getMessage();
			}
			$pdo = NULL;
		}

		//EXCLUIR VALORES DO BANCO
		function delete($table,$fields,$values) {
			$valores_query = "";
			$valores = array();
			$campos = "";
			$valores_verify = "";

			try {
				if(!empty($table) && !empty($fields) && !empty($values)) {
					foreach ($fields as $field) {
						if($campos=="") {
							$valores_query = ":".$field;
							$campos = $field;
						}
						else {
							$valores_query .= ", :".$field;
							$campos .= ", ".$field;
						}
					}

					for($i=0;$i<count($fields);$i++) {
						$valores[$fields[$i]] = $values[$i];

						$valores_verify .= $fields[$i]."='".$values[$i]."'";

						if(count($fields)-1>	$i) {
							$valores_verify .= " AND ";
						}
					}

					$pdo = $this->connect();

					$exists = $this->query("SELECT * FROM ".$table." WHERE ".$valores_verify);

					if(count($exists)==0) {
						echo "O valor não existe";
					}
					else if(count($exists)>0) {
						$sql = "DELETE FROM ".$table." WHERE ".$campos."=".$valores_query."";
						$insert_pdo = $pdo->prepare($sql);
						if($insert_pdo->execute($valores)) {
							return true;
						}
						else {
							echo "Ocorreu um erro";
							return false;
						}
					}
				}
			}
			catch(Exception $e) {
				echo $e->getMessage();
			}
			$pdo = NULL;
		}
	}
?>