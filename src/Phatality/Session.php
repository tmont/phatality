<?php

	namespace Phatality;

	class Session implements Observable {

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

		public function delete($id, $type) {}
		public function insert($entity) {}
		public function update($entity) {}
		public function insertOrUpdate($entity) {}
		public function mergeAndUpdate($entity) {}
		public function evict($id, $type) {}
		public function purge() {}

		/**
		 * @param mixed $id
		 * @param string $type
		 * @return object
		 */
		public function load($id, $type) {
			$event = new LoadEvent($id, $type, $this);

			$this->notifyListeners('beforeLoad', $event);

			$entity = $this->cache->get($id, $type);
			if ($entity === null) {
				$entity = $this->getPersister($type)->load($id, $type);
				$this->cache->set(new Entity($entity, $id));
			}
			$event->setReturnValue($entity);

			$this->notifyListeners('afterLoad', $event);

			return $event->getReturnValue();
		}

		/**
		 * @param string $entityType
		 * @return Persister
		 */
		protected function getPersister($entityType) {
			return $this->entityMap[$entityType]->getPersister();
		}

	}

?>