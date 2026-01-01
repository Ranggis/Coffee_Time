<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\ContactModel;
use App\Models\UserModel;
use App\Models\CategoryModel;
use App\Models\OrderItemModel;
use App\Models\BlogModel;
use App\Models\BlogCategoryModel;
use App\Models\GalleryModel;

class Admin extends BaseController
{
    protected $orderModel;
    protected $productModel;
    protected $contactModel;
    protected $userModel;
    protected $categoryModel;
    protected $orderItemModel;
    protected $blogModel;
    protected $blogCatModel;
    protected $galleryModel;

    public function __construct()
    {
        $this->orderModel     = new OrderModel();
        $this->productModel   = new ProductModel();
        $this->contactModel   = new ContactModel();
        $this->userModel      = new UserModel();
        $this->categoryModel  = new CategoryModel();
        $this->orderItemModel = new OrderItemModel();
        $this->blogModel      = new BlogModel();
        $this->blogCatModel   = new BlogCategoryModel();
        $this->galleryModel   = new GalleryModel();
    }

    /**
     * ===============================
     * GLOBAL SIDEBAR DATA (BADGE)
     * ===============================
     */
    private function sidebarData(): array
    {
        return [
            'new_orders' => $this->orderModel
                ->whereIn('status', ['pending', 'processing', 'out-for-delivery']) // Tambahkan out-for-delivery
                ->countAllResults(),

            'new_messages' => $this->contactModel
                ->where('status', 'unread')
                ->countAllResults(),
        ];
    }

    /**
     * ===============================
     * DASHBOARD
     * ===============================
     */
    public function index()
    {
        if (session()->get('user_role') !== 'admin') {
            return redirect()->to('/auth/login')->with('error', 'Sovereign access only.');
        }

        $data = array_merge($this->sidebarData(), [
            'net_revenue' => $this->orderModel
                ->whereIn('status', ['processing', 'out-for-delivery', 'completed']) // Tambahkan out-for-delivery
                ->selectSum('total_amount')
                ->get()->getRow()->total_amount ?? 0,

            'low_stock' => $this->productModel
                ->where('stock <', 10)
                ->countAllResults(),

            'recent_reservations' => $this->orderModel
                ->orderBy('id', 'DESC')
                ->limit(5)
                ->findAll(),

            'user_name' => session()->get('user_name')
        ]);

        return view('admin/dashboard', array_merge($this->data, $data));
    }

    /**
     * ===============================
     * ORDERS
     * ===============================
     */
    public function orders()
    {
        $data = array_merge($this->sidebarData(), [
            'title'  => 'Manage Reservations | Coffee Time',
            // Kita join ke tabel users untuk ambil kolom phone
            'orders' => $this->orderModel->select('orders.*, users.phone as customer_phone')
                        ->join('users', 'users.id = orders.user_id', 'left')
                        ->orderBy('orders.id', 'DESC')
                        ->findAll(),
            'user_name' => session()->get('user_name')
        ]);

        return view('admin/orders/index', array_merge($this->data, $data));
    }
    

    public function update_order_status($id)
    {
        $status = $this->request->getPost('status');

        // Ambil data order dulu untuk cek apakah stok sudah pernah dikurangi (opsional untuk keamanan)
        $order = $this->orderModel->find($id);

        // Update status order
        $updated = $this->orderModel->update($id, ['status' => $status]);

        // 🔥 JIKA COMPLETED → KURANGI STOCK
        // Logika ini akan jalan saat Admin klik 'Serve' (untuk Dine-in) 
        // ATAU saat User klik 'Pesanan Diterima' (untuk Delivery)
        if ($updated && $status === 'completed') {
            $items = $this->orderItemModel
                ->where('order_id', $id)
                ->findAll();

            foreach ($items as $item) {
                $this->productModel
                    ->set('stock', 'stock - ' . (int)$item['quantity'], false)
                    ->where('id', $item['product_id'])
                    ->update();
            }
        }

        // Custom message jika status adalah out-for-delivery
        $displayStatus = ($status === 'out-for-delivery') ? 'DISPATCHED' : strtoupper($status);

        return redirect()->back()
            ->with('success', 'Transmission status updated to ' . $displayStatus);
    }

    public function order_items($orderId)
    {
        $items = $this->orderItemModel
            ->select('order_items.*, products.name as product_name')
            ->join('products', 'products.id = order_items.product_id')
            ->where('order_id', $orderId)
            ->findAll();

        return $this->response->setJSON($items);
    }

    /**
     * ===============================
     * PRODUCTS
     * ===============================
     */
    public function products()
    {
        $data = array_merge($this->sidebarData(), [
            'title'      => 'Product Catalog | Coffee Time',
            'products'   => $this->productModel->orderBy('id', 'DESC')->findAll(),
            'categories' => $this->categoryModel->findAll(),
            'user_name'  => session()->get('user_name')
        ]);

        return view('admin/products/index', array_merge($this->data, $data));
    }

    public function save_product()
    {
        $id = $this->request->getPost('id');

        $data = [
            'category_id' => $this->request->getPost('category_id'),
            'name'        => $this->request->getPost('name'),
            'slug'        => url_title($this->request->getPost('name'), '-', true),
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'stock'       => $this->request->getPost('stock'),
            'status'      => $this->request->getPost('status'),
        ];

        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('uploads/products', $newName);
            $data['image'] = base_url('uploads/products/' . $newName);
        }

        $id
            ? $this->productModel->update($id, $data)
            : $this->productModel->insert($data);

        return redirect()->to('/admin/products')->with('success', 'Product saved successfully.');
    }

    public function delete_product($id)
    {
        $this->productModel->delete($id);
        return redirect()->to('/admin/products')->with('success', 'Product deleted.');
    }

    /**
     * ===============================
     * JOURNAL
     * ===============================
     */
    public function journal()
    {
        $data = array_merge($this->sidebarData(), [
            'title' => 'Roast Journal | Coffee Time',
            'blogs' => $this->blogModel
                ->select('blogs.*, blog_categories.name as category_name')
                ->join('blog_categories', 'blog_categories.id = blogs.category_id', 'left')
                ->orderBy('blogs.id', 'DESC')
                ->findAll(),
            'categories' => $this->blogCatModel->findAll(),
            'user_name'  => session()->get('user_name')
        ]);

        return view('admin/journal/index', array_merge($this->data, $data));
    }

    /**
     * ===============================
     * GALLERY
     * ===============================
     */
    public function gallery()
    {
        $data = array_merge($this->sidebarData(), [
            'title'   => 'Visual Archive | Coffee Time',
            'gallery' => $this->galleryModel->orderBy('id', 'DESC')->findAll(),
            'user_name' => session()->get('user_name')
        ]);

        return view('admin/gallery/index', array_merge($this->data, $data));
    }

    /**
     * ===============================
     * INBOX
     * ===============================
     */
    public function inbox()
    {
        $data = array_merge($this->sidebarData(), [
            'title'    => 'Concierge Inbox | Coffee Time',
            'messages' => $this->contactModel->orderBy('id', 'DESC')->findAll(),
            'user_name'=> session()->get('user_name')
        ]);

        return view('admin/inbox/index', $data);
    }

    public function mark_message_read($id)
    {
        $this->contactModel->update($id, ['status' => 'read']);
        return $this->response->setJSON(['success' => true]);
    }

    /**
     * ===============================
     * USERS
     * ===============================
     */
    public function users()
    {
        $data = array_merge($this->sidebarData(), [
            'title' => 'Access Control | Coffee Time',
            'users' => $this->userModel->orderBy('id', 'DESC')->findAll(),
            'user_name' => session()->get('user_name')
        ]);

        return view('admin/users/index', array_merge($this->data, $data));
    }

    public function notifications()
    {
        return $this->response->setJSON([
            'orders' => $this->orderModel
                ->whereIn('status', ['pending', 'processing'])
                ->countAllResults(),

            'messages' => $this->contactModel
                ->where('status', 'unread')
                ->countAllResults()
        ]);
    }
}