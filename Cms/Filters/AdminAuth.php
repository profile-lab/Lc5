<?php
namespace Lc5\Cms\Filters;


use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
// 
use Config\Services;
class AdminAuth implements FilterInterface
{
	public function before(RequestInterface $request, $arguments = null)
    {
        $admins = Services::admins();
		if (!$admins->user_id()) {
			return redirect()->route('lc_login');
		}
        // if (!session()->get('admin_data')) {
        //     return redirect()->to(route_to('lc_login'));
        // }
    }

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		//
	}
}
