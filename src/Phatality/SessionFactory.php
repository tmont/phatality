<?php

	namespace Phatality;

	class SessionFactory {
		
		public function create(Persister $persister) {
			return new Session($persister);
		}
	
	}

?>