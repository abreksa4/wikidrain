<?php
/**
 * Created by Andrew Breksa <andrew@andrewbreksa.com>
 */

namespace AndrewBreksa\Wikidrain;


use GuzzleHttp\Psr7\Request;

class Client {

	/**
	 * @var \GuzzleHttp\ClientInterface
	 */
	private $httpClient;
	private $lang          = 'en';
	private $useragent     = 'wikidrain/2.0';
	private $endpoint      = 'https://{lang}.wikipedia.org/w/api.php';
	private $default_query = [
		'format'        => 'json',
		'formatversion' => 2,
	];

	public function __construct($httpClient = NULL) {
		if (is_null($httpClient)) {
			$this->httpClient = new \GuzzleHttp\Client();
		}
	}

	/**
	 * @param       $query
	 * @param array $parameters
	 *
	 * @return mixed
	 */
	public function search($query, $parameters = []) {
		$curr_params = array_merge([
			'action'   => 'query',
			'list'     => 'search',
			'srsearch' => $query,
		], $parameters);

		return $this->get($curr_params);
	}

	private function get(array $parameters) {
		$options = array_merge($parameters, $this->getDefaultQuery());
		$uri = $this->getGeneratedURI() . '?' . http_build_query($options);
		$request = new Request("get", $uri, ['User-Agent' => $this->getUseragent()]);
		$resp = $this->getHttpClient()->send($request);
		$body = $resp->getBody()->getContents();

		return json_decode($body, TRUE);
	}

	/**
	 * @return array
	 */
	public function getDefaultQuery() {
		return $this->default_query;
	}

	/**
	 * @param array $default_query
	 *
	 * @return Client
	 */
	public function setDefaultQuery($default_query) {
		$this->default_query = $default_query;

		return $this;
	}

	public function getGeneratedURI() {
		return str_replace("{lang}", $this->getLang(), $this->getEndpoint());
	}

	/**
	 * @return string
	 */
	public function getLang() {
		return $this->lang;
	}

	/**
	 * @param string $lang
	 *
	 * @return Client
	 */
	public function setLang($lang) {
		$this->lang = $lang;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getEndpoint() {
		return $this->endpoint;
	}

	/**
	 * @param string $endpoint
	 *
	 * @return Client
	 */
	public function setEndpoint($endpoint) {
		$this->endpoint = $endpoint;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getUseragent() {
		return $this->useragent;
	}

	/**
	 * @param string $useragent
	 *
	 * @return Client
	 */
	public function setUseragent($useragent) {
		$this->useragent = $useragent;

		return $this;
	}

	/**
	 * @return \GuzzleHttp\ClientInterface
	 */
	public function getHttpClient() {
		return $this->httpClient;
	}

	/**
	 * @param \GuzzleHttp\ClientInterface $httpClient
	 *
	 * @return Client
	 */
	public function setHttpClient($httpClient) {
		$this->httpClient = $httpClient;

		return $this;
	}

	public function getPagePropertiesByTitles($titles, array $properties, $parameters = []) {
		$curr_params = array_replace([
			'prop'   => implode('|', $properties),
			'titles' => implode('|', $titles),
			'action' => 'query',
		], $parameters);

		return $this->get($curr_params);
	}

	public function getPagePropertiesByPageIds($pageIds, array $properties, $parameters = []) {
		$curr_params = array_replace([
			'prop'    => implode('|', $properties),
			'pageids' => implode('|', $pageIds),
			'action'  => 'query',
		], $parameters);

		return $this->get($curr_params);
	}

	public function getPageListByTitles($titles, array $lists, $parameters = []) {
		$curr_params = array_replace([
			'list'   => implode('|', $lists),
			'titles' => implode('|', $titles),
			'action' => 'query',
		], $parameters);

		return $this->get($curr_params);
	}

	public function getPageListByPageIds($pageIds, array $lists, $parameters = []) {
		$curr_params = array_replace([
			'list'    => implode('|', $lists),
			'pageids' => implode('|', $pageIds),
			'action'  => 'query',
		], $parameters);

		return $this->get($curr_params);
	}

	public function getParsedPropertiesByTitle($title, array $properties, $parameters = []) {
		$curr_params = array_replace([
			'prop'   => implode('|', $properties),
			'page'   => $title,
			'action' => 'parse',
		], $parameters);

		return $this->get($curr_params);
	}

	public function getParsedPropertiesByPageId($pageId, array $properties, $parameters = []) {
		$curr_params = array_replace([
			'prop'   => implode('|', $properties),
			'pageid' => $pageId,
			'action' => 'parse',
		], $parameters);

		return $this->get($curr_params);
	}
}