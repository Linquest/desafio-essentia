<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\View\View;
use App\Http\Requests\StoreCustomerRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Throwable;

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

    public function create(): View
    {
        return view('customers.create');
    }

    public function store(StoreCustomerRequest $request): RedirectResponse
    {
        $data = $request->safe()->only(['name', 'email', 'phone']);

        $photoPath = $request->file('photo')->store('customers', 'public');

        if ($photoPath === false) {
            throw ValidationException::withMessages([
                'photo' => 'Não foi possível salvar a foto. Tente novamente.',
            ]);
        }

        $data['photo_path'] = $photoPath;

        try {
            Customer::create($data);
        } catch (Throwable $exception) {
            try {
                if (!Storage::disk('public')->delete($photoPath)) {
                    Log::warning('Falha ao remover foto após erro no cadastro.', [
                        'photo_path' => $photoPath,
                    ]);
                }
            } catch (Throwable $cleanupException) {
                report($cleanupException);
            }

            throw $exception;
        }

        return to_route('customers.index')
            ->with('success', 'Cliente cadastrado com sucesso.');
    }
}
