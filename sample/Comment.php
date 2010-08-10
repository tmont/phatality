<?php

	namespace Phatality\Sample;
	
	class Comment implements Identifiable {

		private $id;
		private $author;
		private $text;
		private $created;

		public function getId() {
			return $this->id;
		}

		public function setId($id) {
			$this->id = $id;
		}

		/**
		 * @return User
		 */
		public function getAuthor() {
			return $this->author;
		}

		public function setAuthor(User $author) {
			$this->author = $author;
		}

		public function getText() {
			return $this->text;
		}

		public function setText($text) {
			$this->text = $text;
		}

		public function getCreated() {
			return $this->created;
		}

	}

?>