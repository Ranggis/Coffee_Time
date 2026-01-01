<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\ContactModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected $data = [];

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        // GLOBAL AUTH STATE
        $this->data['is_logged_in'] = session()->get('is_logged_in') ?? false;
        $this->data['user_name']   = session()->get('user_name');
        $this->data['user_role']   = session()->get('user_role');

        // SIMPAN HALAMAN TERAKHIR (GLOBAL)
        $currentUrl = current_url();

        if (
            !str_contains($currentUrl, '/auth') &&
            !str_contains($currentUrl, '/admin')
        ) {
            session()->set('last_page', $currentUrl);
        }

        // Kalau belum login admin → stop
        if (!session()->get('user_id') || session()->get('user_role') !== 'admin') {
            return;
        }

        // Load model
        $orderModel   = new OrderModel();
        $contactModel = new ContactModel();

        // GLOBAL ADMIN NOTIFICATION DATA
        $this->data['new_orders'] = $orderModel
            ->whereIn('status', ['pending', 'processing'])
            ->countAllResults();

        $this->data['new_messages'] = $contactModel
            ->where('status', 'unread')
            ->countAllResults();
    }
}
