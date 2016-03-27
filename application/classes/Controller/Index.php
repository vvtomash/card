<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Index extends Controller {

	private $profile = true;
	protected $content;
	protected $activeMenu;
	protected $pageName = 'Главная';
	/**
	 * @var Model_User;
	 */
	protected $currentUser;

	public function before() {
		$this->currentUser = Auth::instance()->get_user();
		try {
			$this->_checkPermission();
		} catch (HTTP_Exception_403 $e) {
			$this->redirect('/login');
		}
		View::set_global('user', Auth::instance()->get_user());
	}

	public function action_index() {
		$this->content = $this->getMain();
	}

	public function after() {

		if ($this->request->is_ajax()) {
			if (!empty($this->errors)) {
				$this->response->status('500');
				echo json_encode(
					['errors' => $this->errors]
				);
				return;
			}
			echo json_encode(
				['data' => $this->content]
			);
			return;
		}
		if ($this->content === null) {
			throw new HTTP_Exception_400;
		}
		View::set_global('activeMenu', $this->getActiveMenu());
		View::set_global('pageName', $this->pageName);
		$this->response->body(View::factory('index')
			->set('header', $this->getHeader())
		    ->set('searchBar', View::factory('searchBar')->render())
			->set('content', $this->content)
			->set('footer', $this->getFooter())
			->set('profiler', '')
		);
	}

	protected function getHeader() {
		$topMenu = $this->getTopMenu();
		return View::factory('header')
			->set('menu', $topMenu)
			->render();
	}

	protected function getMain() {
		return View::factory('main')->set('content', 'main')->render();
	}

	protected function getFooter() {
		return View::factory('footer')->set('content', '')->render();
	}

	private function getTopMenu() {
		$userCardsMenu = View::factory('menu/userCards');
		$userTradesMenu = View::factory('menu/userTrades');
		return View::factory('menu/topUserMenu')
			->set('userCardsMenu', $userCardsMenu)
			->set('userTradesMenu', $userTradesMenu)
			->render();
	}

	private function getActiveMenu() {
		$menu = explode('/', $this->activeMenu);
		return [
			'menu' => Arr::get($menu, 0, ''),
			'submenu' => Arr::get($menu, 1, '')
		];
	}

	private function _checkPermission() {
		$acl = Arr::get(Kohana::$config->load('acl')->as_array(), get_called_class());
		$action = $this->request->action();

		if ($roles = Arr::get($acl, $action)) {
			if (in_array('public', $roles)) {
				return true;
			}
			if (empty($this->currentUser)) {
				throw new HTTP_Exception_403;
			}
			$userRoles = $this->currentUser->roles;
			foreach($userRoles->find_all() as $userRole) {
				if (in_array($userRole->name, $roles)) {
					return true;
				}
			}
			throw new HTTP_Exception_403;
		}
		throw new HTTP_Exception_404;
	}
}