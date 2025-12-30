<?php

namespace App\Livewire\Product;

use App\Traits\WithToast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class ProductListing extends Component
{
    use WithPagination, WithToast;
    
    #[Rule('nullable|string|max:255')]
    public $search = '';
    
    public $sort_by = 'updated_at';
    public $sort_direction = 'desc';
    public $per_page = 12;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'sort_by' => ['except' => 'updated_at'],
        'sort_direction' => ['except' => 'desc'],
    ];
    
    public function updatedSearch()
    {
        $this->resetPage();
    }
    
    public function updatedSortBy()
    {
        $this->sort_direction = 'asc';
        $this->resetPage();
    }
    
    public function changeSorting($field)
    {
        if ($this->sort_by === $field) {
            $this->sort_direction = $this->sort_direction === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort_direction = 'asc';
            $this->sort_by = $field;
        }
        
        $this->resetPage();
    }
    
    public function addToCart($product_uuid)
    {
        if (!Auth::check()) {
            $this->showErrorToast('Please login to add items to cart.');
            return;
        }

        DB::beginTransaction();
        try {
            $product = app('GetProductService')->execute([
                'product_uuid' => $product_uuid
            ], true)['data'];

            if (!$product || $product->stock <= 0) {
                DB::rollBack();
                $this->showErrorToast('Product is out of stock.');
                return;
            }

            $cart_result = app('GetCartService')->execute([
                'user_id' => Auth::user()->id,
                'status' => 'active',
                'with' => ['cartItems.product']
            ], true)['data'];

            if ($cart_result->isEmpty()) {
                app('CreateCartService')->execute([
                    'user_uuid' => Auth::user()->uuid,
                    'items' => [
                        [
                            'product_uuid' => $product_uuid,
                            'quantity' => 1,
                            'price' => $product->price
                        ]
                    ]
                ], true);
            } else {
                $cart = $cart_result->first();
                $existing_items = $cart->cartItems->map(function($item) {
                    return [
                        'product_uuid' => $item->product->uuid,
                        'quantity' => $item->quantity,
                        'price' => $item->price
                    ];
                })->toArray();

                $product_exists = false;
                foreach ($existing_items as $index => $item) {
                    if ($item['product_uuid'] === $product_uuid) {
                        $existing_items[$index]['quantity'] += 1;
                        $product_exists = true;
                        break;
                    }
                }

                if (!$product_exists) {
                    $existing_items[] = [
                        'product_uuid' => $product_uuid,
                        'quantity' => 1,
                        'price' => $product->price
                    ];
                }

                app('EditCartService')->execute([
                    'cart_uuid' => $cart->uuid,
                    'user_uuid' => Auth::user()->uuid,
                    'version' => $cart->version,
                    'items' => $existing_items
                ], true);
            }

            $this->showSuccessToast('Product added to cart successfully!');
            $this->dispatch('cart-updated');
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $this->showErrorToast('Failed to add product to cart. Please try again.');
        }
    }
    
    #[On('product-updated')]
    public function getProducts()
    {
        $dto = [
            'search_param' => $this->search,
            'sort_by' => $this->sort_by,
            'sort_type' => $this->sort_direction,
            'per_page' => $this->per_page,
            'page' => $this->getPage(),
            'with_pagination' => true
        ];
        $results = app('GetProductService')->execute($dto);
        
        return [
            'data' => $results['data'],
            'pagination' => $results['pagination'] ?? null
        ];
    }

    public function render()
    {
        $result = $this->getProducts();
        
        return view('livewire.product.product-listing', [
            'products' => $result['data'],
            'paginationData' => $result['pagination']
        ]);
    }
}
