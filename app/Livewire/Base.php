<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class Base extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $sortDirection = 'asc';
    public $sortBy = '';

    public $perPage = 10;

    public $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }


    public function sortBy($field)
    {
        if ($this->sortDirection == 'asc') {
            $this->sortDirection = 'desc';
        } else {
            $this->sortDirection = 'asc';
        }
        return $this->sortBy = $field;
    }
}
