<?php

	namespace Phatality;

	class Commander implements Command {

		/**
		 * @var array
		 */
		private $commands = array();

		/**
		 * Factory so that we can chain stuff
		 * 
		 * @return Commander
		 */
		public static function create() {
			return new self();
		}

		/**
		 * @param Command $command
		 * @return Commander
		 */
		public function add(Command $command) {
			$this->commands[] = $command;
			return $this;
		}

		public function execute(CommandContext $context = null) {
			foreach ($this->commands as $command) {
				if ($context !== null && !$context->shouldProceed()) {
					break;
				}

				$command->execute($context);
			}
		}
	}
	
?>