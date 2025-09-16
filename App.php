<?php

namespace Web;

class App {
	private Routes $routes;
	
	public function __construct() {
		$this->routes = new Routes();
	}

	public function run() {
		$cleanPath = $this->routes::cleanPath($_SERVER['REQUEST_URI']);
		
		$requestMethod = $_SERVER['REQUEST_METHOD'];
		if ($requestMethod === 'POST' && isset($_POST['_method'])) {
			$requestMethod = strtoupper($_POST['_method']);
		}
	
		$match = $this->routes::matchRoute($cleanPath, $requestMethod);

		if ($match) {
			$class = $match['callback'][0];
			$method = $match['callback'][1];
			$params = $match['params'] ?? [];
			
			$entityManager = require_once 'config/doctrine.php';
			$instance = new $class($entityManager);

			if (is_callable([$instance, $method])) {
				$convertedParams = [];
				foreach ($params as $key => $value) {
					if ($key === 'id' && is_numeric($value)) {
						$convertedParams[] = (int) $value;
					} else {
						$convertedParams[] = $value;
					}
				}
				
				if (empty($convertedParams)) {
					$convertedParams = array_values($params);
				}
				
				call_user_func_array([$instance, $method], $convertedParams);
			}
		} else {
			echo "404 route {$cleanPath} Not Found";
		}
	}
}