<?php

	namespace Phatality;

	class EventCommand implements Command {

		private $listeners;
		private $persisterFactory;

		public function __construct(array $listeners, PersisterLocator $persisterFactory) {
			$this->listeners = $listeners;
			$this->persisterFactory = $persisterFactory;
		}

		public function execute(CommandContext $context = null) {
			if (!($context instanceof PersisterEvent)) {
				return;
			}

			foreach ($this->listeners as $listener) {
				if (!$context->shouldProceed()) {
					break;
				}
				
				$listener->notify($context);
			}
		}
	}
	
?>