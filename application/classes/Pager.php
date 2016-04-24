<?php

class Pager {

	const ON_PAGE = 5;

	private $totalCount;
	private $url;
	private $params;
	private $currentPage = 1;
	private $onPage = self::ON_PAGE;

	public function __construct($url, $totalCount, $currentPage = 1, $onPage = self::ON_PAGE, array $params = []) {
		$this->setUrl($url)
			->setParams($params)
			->setTotalCount($totalCount)
			->setCurrentPage(max($currentPage, 1))
			->setOnPage($onPage);
	}

	/**
	 * @return mixed
	 */
	public function getParams() {
		return $this->params;
	}

	/**
	 * @param mixed $params
	 */
	public function setParams(array $params) {
		$this->params = $params;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getTotalCount() {
		return (int)$this->totalCount;
	}

	/**
	 * @param mixed $totalCount
	 * @return Pager
	 */
	public function setTotalCount($totalCount) {
		$this->totalCount = $totalCount;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCurrentPage() {
		return (int)$this->currentPage;
	}

	/**
	 * @param mixed $currentPage
	 * @return Pager
	 */
	public function setCurrentPage($currentPage) {
		$this->currentPage = $currentPage;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getOnPage() {
		return (int)$this->onPage;
	}

	/**
	 * @param mixed $onPage
	 * @return Pager
	 */
	public function setOnPage($onPage) {
		$this->onPage = $onPage;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * @param mixed $url
	 * @return Pager
	 */
	public function setUrl($url) {
		$this->url = $url;
		return $this;
	}

	/**
	 * @param mixed $url
	 * @return Pager
	 */
	public function getCountPage() {
		return (int)ceil($this->getTotalCount()/$this->getOnPage());
	}

	public function getPageUrl($page) {
		if ($page < 2) {
			return rtrim(
				sprintf( "%s?%s",
					rtrim($this->getUrl(), "/"),
					http_build_query($this->getParams())),
			'?');
		}
		return rtrim(
			sprintf("%s/%s-%d?%s",
				rtrim($this->getUrl(), "/"),
				"page",
				$page,
				http_build_query($this->getParams())),
		'?');
	}

	public function getPrevPageUrl() {
		if ($this->getCurrentPage() <= 2) {
			return $this->getPageUrl(1);
		} else {
			return $this->getPageUrl($this->getCurrentPage() - 1);
		}
	}

	public function getNextPageUrl() {
		return $this->getPageUrl(min($this->getCurrentPage() + 1, $this->getCountPage()));
	}
}