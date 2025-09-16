<?php

namespace Web;

class Routes {
	private static array $routes = [];

	public static function get(string $path, array $callback): void {
		self::addRoute('GET', $path, $callback);
	}

	public static function post(string $path, array $callback): void {
		self::addRoute('POST', $path, $callback);
	}

	public static function put(string $path, array $callback): void {
		self::addRoute('PUT', $path, $callback);
	}

	public static function delete(string $path, array $callback): void {
		self::addRoute('DELETE', $path, $callback);
	}

	private static function addRoute(string $method, string $path, array $callback): void {
		$cleanPath = self::cleanPath($path);
		self::$routes[$method][$cleanPath] = $callback;
	}

	public static function cleanPath(string $path): string {
		$path = parse_url($path, PHP_URL_PATH);
		return $path === '/' ? '/' : trim($path, '/');
	}

	public static function matchRoute(string $requestPath, string $requestMethod = null): ?array {
		$requestMethod = $requestMethod ?? $_SERVER['REQUEST_METHOD'];
		$requestPath = self::cleanPath($requestPath);
		
		if (!isset(self::$routes[$requestMethod])) {
			return null;
		}
		
		foreach (self::$routes[$requestMethod] as $route => $callback) {
			if (self::matchesRoute($route, $requestPath)) {
				$params = self::extractParams($route, $requestPath);
				return [
					'callback' => $callback, 
					'params' => $params,
					'method' => $requestMethod
				];
			}
		}
		
		return null;
	}

	private static function matchesRoute(string $route, string $requestPath): bool {
		$routePattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $route);
		return preg_match('#^' . $routePattern . '$#', $requestPath);
	}

	private static function extractParams(string $route, string $requestPath): array {
		$routePattern = preg_replace('/\{([^}]+)\}/', '(?P<$1>[^/]+)', $route);
		preg_match('#^' . $routePattern . '$#', $requestPath, $matches);
		
		$params = [];
		foreach ($matches as $key => $value) {
			if (is_string($key)) {
				$params[$key] = $value;
			}
		}
		
		return $params;
	}

	public static function getAllRoutes(): array {
		return self::$routes;
	}
}