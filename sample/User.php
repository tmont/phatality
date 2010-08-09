<?php

	namespace Phatality\Sample;

	use Phatality\Identifiable;

	class User implements Identifiable {

		private $id;
		private $firstName;
		private $lastName;
		private $locale;
		private $username;
		private $password;
		private $created;

		public function getId() {
			return $this->id;
		}

		public function getFirstName() {
			return $this->firstName;
		}

		public function setFirstName($firstName) {
			$this->firstName = $firstName;
		}

		public function getLastName() {
			return $this->lastName;
		}

		public function setLastName($lastName) {
			$this->lastName = $lastName;
		}

		public function getLocale() {
			return $this->locale;
		}

		public function setLocale($locale) {
			$this->locale = $locale;
		}

		public function getUsername() {
			return $this->username;
		}

		public function setUsername($username) {
			$this->username = $username;
		}

		public function getPassword() {
			return $this->password;
		}

		public function getCreated() {
			return $this->created;
		}

	}
	
?>