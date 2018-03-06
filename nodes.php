<?php

	class Nodes
	{
		private $nodes = array();

		public function add($node = NULL, $script = NULL)
		{
			$num = func_num_args();
			if ($num < 3)
			{
				$args = array();
			}
			else
			{
				for ($i = 2; $i < $num; $i++)
				{
					$args[] = func_get_args()[$i];
				}
			}
			if (!is_null($node) && !is_null($script))
			{
				$this->nodes[$node][] = array(
					"script" => $script,
					"args" => $args
				);
			}
			if (is_null($node)) echo ":node_undeclared";
			if (is_null($script)) echo ":script_undeclared";
		}

		public function trigger($node = NULL)
		{
			if (!is_null($node))
			{
				foreach ($this->nodes[$node] as $data)
				{
					if (count($data["args"]) > 0)
					{
						if (function_exists($data["script"]))
						{
							foreach ($data["args"] as $arg)
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