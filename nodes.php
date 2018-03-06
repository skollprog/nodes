<?php

	class Nodes
	{
		private $nodes = array();

		public function add($node = NULL, $script = NULL)
		{
			if (!is_null($node) && !is_null($script))
			{
				$this->nodes[$node][] = array(
					"script" => $script
				);
			}
			if (is_null($node)) echo ":node_undeclared";
			if (is_null($script)) echo ":script_undeclared";
		}

		public function trigger($node = NULL)
		{
			if (!is_null($node))
			{
				$num = func_num_args();
				if ($num < 2)
				{
					$argv = array();
				}
				else
				{
					for ($i = 1; $i < $num; $i++)
					{
						$argv[] = func_get_args()[$i];
					}
				}
				foreach ($this->nodes[$node] as $data)
				{
					if (count($argv) > 0)
					{
						if (function_exists($data["script"]))
						{
							foreach ($argv as $arg)
							{
								$args[] = "'".$arg."'";
							}
							$args = implode(", ", $args);
							eval('call_user_func($data["script"], '.$args.');');
						}
					}
					else
					{
						if (function_exists($data["script"]))
						{
							call_user_func($data["script"]);
						}
					}
				}
			}
			if (is_null($node)) echo ":empty_trigger";
		}

		public function debug()
		{
			print_r($this->nodes);
		}
	}

	$node = new Nodes();

?>
