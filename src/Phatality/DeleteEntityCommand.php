<?php

	namespace Phatality;

	class DeleteEntityCommand implements Command {

		private $cache;
		private $persisterLocator;

		public function __construct(Cache $cache, PersisterLocator $persisterLocator) {
			$this->cache = $cache;
			$this->persisterLocator = $persisterLocator;
		}

		public function execute(CommandContext $context = null) {
			if (!($context instanceof DeleteEvent)) {
				return;
			}

			$id = $context->getEntityId();
			$type = $context->getEntityType();
			$this->persisterLocator->getPersister($type)->delete($id, $type);
			$this->cache->remove($id, $type);
		}
	}

?>