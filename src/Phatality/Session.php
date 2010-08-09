<?php

	namespace Phatality;

	use Phatality\Persistence\PersisterLocator;
	use Phatality\Persistence\PersisterEvent;
	use Phatality\Mapping\EntityMap;
	use Phatality\Cache\Cache;

	class Session implements Observable, PersisterLocator, Identifiable {

		private $id;
		private $entityMap;
		private $cache;
		private $listeners = array();
		private static $events = array(
			'beforeDelete', 'afterDelete',
			'beforeEvict', 'afterEvict',
			'beforeLoad', 'afterLoad',
			'beforeInsert', 'afterInsert',
			'beforeUpdate', 'afterUpdate',
			'beforeMerge', 'afterMerge'
		);

		public function __construct(EntityMap $entityMap, Cache $cache) {
			$this->id = Util::generateId();
			$this->entityMap = $entityMap;
			$this->cache = $cache;
		}

		public function getId() {
			return $this->id;
		}

		public function getCachingStrategy() {
			return $this->cache;
		}

		public function getEntityMap() {
			return $this->entityMap;
		}

		public final function addListener($eventName, EventListener $listener) {
			if (!in_array($eventName, self::$events)) {
				throw new InvalidEventException(sprintf('The event "%s" does not exist in class "%s"', $eventName, __CLASS__));
			}

			$this->listeners[$eventName][] = $listener;
			return $this;
		}

		public final function getListeners($eventName = null) {
			if ($eventName === null) {
				return $this->listeners;
			}

			return @$this->listeners[$eventName] ?: array();
		}

		protected function notifyListeners($eventName, PersisterEvent $event) {
			foreach ($this->getListeners($eventName) as $listener) {
				$listener->notify($event);
			}
		}

		/**
		 * @param mixed $id
		 * @param string $type
		 */
		public function delete($id, $type) {
			Commander::create()
				->add(new EventCommand($this->getListeners('beforeDelete'), $this))
				->add(new DeleteEntityCommand($this->cache, $this))
				->add(new EventCommand($this->getListeners('afterDelete'), $this))
				->execute(new DeleteEvent($id, $type, $this));
		}

		/**
		 * @param Identifiable $entity
		 * @return mixed The new ID of the inserted entity
		 */
		public function insert(Identifiable $entity) {
			$context = new InsertEvent(new Entity($entity, $this->entityMap[get_class($entity)]), $this);
			Commander::create()
				->add(new EventCommand($this->getListeners('beforeInsert'), $this))
				->add(new InsertEntityCommand($this->cache, $this))
				->add(new EventCommand($this->getListeners('afterInsert'), $this))
				->execute($context);

			return $context->returnValue;
		}

		public function update(Identifiable $entity) {}
		public function insertOrUpdate(Identifiable $entity) {}
		public function mergeAndUpdate(Identifiable $entity) {}

		/**
		 * Removes an entity from the session
		 *
		 * @param mixed $id
		 * @param string $type
		 */
		public function evict($id, $type) {
			$this->cache->remove($id, $type);
		}

		/**
		 * Removes all entities from the session
		 */
		public function purge() {
			$this->cache->clear();
		}

		/**
		 * @param mixed $id
		 * @param string $type
		 * @return object
		 */
		public function load($id, $type) {
			$context = new LoadEvent($id, $type, $this);
			
			Commander::create()
				->add(new EventCommand($this->getListeners('beforeLoad'), $this))
				->add(new LoadEntityCommand($this->cache, $this))
				->add(new EventCommand($this->getListeners('afterLoad'), $this))
				->execute($context);

			return $context->getReturnValue();
		}

		/**
		 * @param string $entityType
		 * @return Persister
		 */
		public function getPersister($entityType) {
			return $this->entityMap[$entityType]->getPersister();
		}

	}

?>