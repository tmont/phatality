<?php

	namespace Phatality;

	use Phatality\Persistence\PersisterLocator;
	use Phatality\Cache\Cache;

	class InsertEntityCommand implements Command {

		private $cache;
		private $persisterLocator;

		public function __construct(Cache $cache, PersisterLocator $persisterLocator) {
			$this->cache = $cache;
			$this->persisterLocator = $persisterLocator;
		}

		public function execute(CommandContext $context = null) {
			if (!($context instanceof InsertEvent)) {
				return;
			}

			$entity = $context->getEntity();
			$type = $entity->getType();
			$id = $entity->getId();

			if ($entity->requiresIdOnInsert()) {
				if ($id === null) {
					//generate id
					$id = $entity->generateId($context->getSession());
				}
			} else if ($id !== null) {
				//id was assigned but is not required, i.e. an autoincrement column which the server should generate, not the client
				throw new InvalidIdException(sprintf('Entity of type "%s" cannot have an ID assigned prior to insertion', $type));
			}

			$cacheEntry = $this->cache->get($entity->getId(), get_class($entity));
			if ($cacheEntry !== null) {
				$entity = $cacheEntry->getValue();
			} else {
				$entity = $this->persisterLocator->getPersister($type)->insert($entity);
				$this->cache->set($entity);
			}

			$context->setReturnValue($entity->getObject()->getId());
		}
	}

?>