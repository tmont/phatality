<?php

namespace Phatality\Sample;

	use Phatality\Identifiable;

	class Post implements Identifiable {

		private $id;
		private $user;
		private $postData;
		private $title;

		public function getId() {
			return $this->id;
		}

		public function setId($id) {
			$this->id = $id;
		}

		/**
		 * @return User
		 */
		public function getUser() {
			return $this->user;
		}

		public function setUser(User $user) {
			$this->user = $user;
		}

		public function getPostData() {
			return $this->postData;
		}

		public function setPostData($postData) {
			$this->postData = $postData;
		}

		public function getTitle() {
			return $this->title;
		}

		public function setTitle($title) {
			$this->title = $title;
		}
	}

	?>