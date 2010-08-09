<?php

	namespace Phatality;

	use Phatality\Persistence\PersisterLocator;
	use Phatality\Cache\Cache;

	class LoadEntityCommand implements Command {

		private $cache;
		private $persisterLocator;

		public function __construct(Cache $cache, PersisterLocator $persisterLocator) {
			$this->cache = $cache;
			$this->persisterLocator = $persisterLocator;
		}

		public function execute(CommandContext $context = null) {
			if (!($context instanceof LoadEvent)) {
				return;
			}

			$id = $context->getEntityId();
			$type = $context->getEntityType();
			$cacheEntry = $this->cache->get($id, $type);
			if ($cacheEntry !== null) {
				$entity = $cacheEntry->getValue();
			} else {
				$entity = $this->persisterLocator->getPersister($type)->load($id, $type);
				$this->cache->set(new Entity($entity));
			}

			$context->setReturnValue($entity);
		}
	}
	
?>