<?php
	namespace CTN;
	
	use \CTN\Auth;
	use \CTN\Database;
	
	class Messages {
		private $statistics = [
			'read'		=> 0,
			'unread'	=> 0,
			'send'		=> 0
		];
		
		public function __construct() {
			$result = Database::single('SELECT COUNT(CASE WHEN `receiver`=:user AND `time_read`>`time_send` THEN `id` END) AS `read`, COUNT(CASE WHEN `receiver`=:user AND `time_send`>`time_read` THEN `id` END) AS `unread`, COUNT(CASE WHEN `sender`=:user THEN `id` END) `send` FROM `' . DATABASE_PREFIX . 'messages`', [
				'user'	=> Auth::getID()
			]);
			
			$this->statistics['read']	= $result->read;
			$this->statistics['unread']	= $result->unread;
			$this->statistics['send']	= $result->send;
		}
		
		public function countInbox() {
			return $this->countRead() + $this->countUnread();
		}
		
		public function countOutbox() {
			return $this->countSend();
		}
		
		public function countRead() {
			return $this->statistics['read'];
		}
		
		public function countSend() {
			return $this->statistics['send'];
		}
		
		public function countUnread() {
			return $this->statistics['unread'];
		}
	}
?>