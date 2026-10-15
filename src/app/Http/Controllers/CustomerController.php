<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(): View
    {
        $customers = Customer::query()
            ->orderBy('name')
            ->orderBy('id')
            ->paginate(10);

        return view('customers.index', [
            'customers' => $customers,
        ]);
    }
}
