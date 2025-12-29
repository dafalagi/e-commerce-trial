<?php

namespace App\Livewire\Product;

use App\Traits\WithToast;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class ProductListing extends Component
{
    use WithPagination, WithToast;
    
    #[Rule('nullable|string|max:255')]
    public $search = '';
    
    public $sortBy = 'updated_at';
    public $sortDirection = 'desc';
    public $perPage = 12;
    
    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'updated_at'],
        'sortDirection' => ['except' => 'desc'],
    ];
    
    public function updatedSearch()
    {
        $this->resetPage();
    }
    
    public function updatedSortBy()
    {
        $this->sortDirection = 'asc';
        $this->resetPage();
    }
    
    public function changeSorting($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
            $this->sortBy = $field;
        }
        
        $this->resetPage();
    }
    
    public function addToCart($productUuid)
    {
        // TODO: Implement cart functionality
        $this->showSuccessToast('Product added to cart successfully!');
    }
    
    public function getProducts()
    {
        $dto = [
            'search_param' => $this->search,
            'sort_by' => $this->sortBy,
            'sort_type' => $this->sortDirection,
            'per_page' => $this->perPage,
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
