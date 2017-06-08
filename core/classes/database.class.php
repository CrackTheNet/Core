<?php
	namespace CTN;
	
	class DatabaseFactory extends \PDO {
		private static $instance = NULL;
		
		public static function getInstance() {
			if(self::$instance === NULL) {
				self::$instance = new self(sprintf('mysql:host=%s;port=%d;dbname=%s', DATABASE_HOSTNAME, DATABASE_PORT, DATABASE_NAME), DATABASE_USERNAME, DATABASE_PASSWORD, array(
					\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
				));
			}
			
			return self::$instance;
		}
		
		public function query($query, $parameters = array()) {
			$stmt = $this->prepare($query);
			$stmt->execute($parameters);
			return $stmt;
		}
		
		public function single($query, $parameters = array()) {
			return $this->query($query, $parameters)->fetch(\PDO::FETCH_OBJ);
		}
		
		public function count($query, $parameters = array()) {
			return $this->query($query, $parameters)->rowCount();
		}
		
		public function fetch($query, $parameters = array()) {
			return $this->query($query, $parameters)->fetchAll(\PDO::FETCH_OBJ);
		}
		
		public function update($table, $where, $parameters = array()) {
			$fields = '';
			foreach($parameters AS $name => $value) {
				$fields .= ' `' . $name . '`=:' . $name . ',';
			}
			
			return $this->query(sprintf('UPDATE `%1$s` SET %2$s WHERE `%3$s`=:%3$s', $table, rtrim($fields, ','), $where), $parameters)->fetchAll(\PDO::FETCH_OBJ);
		}
		
		public function reset($table, $where, $old, $new) {
			return $this->query(sprintf('UPDATE `%1$s` SET %2$s=%4$d WHERE `%2$s`=:%3$d', $table, $where, $old, $new));
		}
		
		public function delete($table, $parameters = array()) {
			$where = array();
			
			foreach($parameters AS $name => $value) {
				$where[] = sprintf('`%s`=:%s', $name, $name);
			}
			
			return $this->query(sprintf('DELETE FROM `%s` WHERE %s', $table, implode(', ', $where)), $parameters);
		}
		
		public function deleteWhereNot($table, $delete_not = array(), $parameters = array()) {
			$where				= array();
			$default_parameters	= array();
			
			foreach($parameters AS $name => $value) {
				$default_parameters[] = sprintf('`%s`=:%s', $name, $name);
			}
			
			foreach($delete_not AS $name => $values) {
				if(is_array($values)) {
					foreach($values AS $index => $value) {
						$parameters[$name . '_' . $index]	= $value;
						$where[]							= sprintf('(`%s`!=:%s_%d AND %s)', $name, $name, $index, implode(' AND ', $default_parameters));
					}
				} else {
					$parameters[$name]	= $values;
					$where[]			= sprintf('(`%s`!=:%s AND ?)', $name, $name);
				}
			}
			
			return $this->query(sprintf('DELETE FROM `%s` WHERE %s', $table, implode(' AND ', $where)), $parameters);
		}
		
		public function insert($table, $parameters = array()) {
			$names		= array();
			$values		= array();
			
			foreach($parameters AS $name => $value) {
				$names[]	= '`' . $name . '`';
				$values[]	= ':' . $name;
			}
			
			$this->query(sprintf('INSERT INTO `%s` (%s) VALUES (%s)', $table, implode(', ', $names), implode(', ', $values)), $parameters);
			return $this->lastInsertId();
		}
	}
	
	class Database {
		public static function query($query, $parameters = array()) {
			return DatabaseFactory::getInstance()->query($query, $parameters);
		}
		
		public static function single($query, $parameters = array()) {
			return DatabaseFactory::getInstance()->single($query, $parameters);
		}
		
		public static function count($query, $parameters = array()) {
			return DatabaseFactory::getInstance()->count($query, $parameters);
		}
		
		public static function fetch($query, $parameters = array()) {
			return DatabaseFactory::getInstance()->fetch($query, $parameters);
		}
		
		public static function update($table, $where, $parameters = array()) {
			return DatabaseFactory::getInstance()->update($table, $where, $parameters);
		}
		
		public static function insert($table, $parameters = array()) {
			return DatabaseFactory::getInstance()->insert($table, $parameters);
		}
		
		public static function delete($table, $parameters = array()) {
			return DatabaseFactory::getInstance()->delete($table, $parameters);
		}
		
		public static function deleteWhereNot($table, $delete_not = array(), $parameters = array()) {
			return DatabaseFactory::getInstance()->deleteWhereNot($table, $delete_not, $parameters);
		}
	}
?>