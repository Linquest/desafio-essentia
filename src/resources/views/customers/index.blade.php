<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clientes</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/customer-phone-mask.js') }}" defer></script>
</head>

<body class="page--list">
    <main>
        <h1>Clientes</h1>

        @if (session('success'))
        <p class="success" role="status">{{ session('success') }}</p>
        @endif

        <div class="list-toolbar">
            <a class="button button--primary"
                href="{{ route('customers.create') }}">
                Novo cliente
            </a>

            <p>Total de clientes: {{ $customers->total() }}</p>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $customer)
                    <tr>
                        <td>
                            <div class="customer">
                                <img
                                    src="{{ asset('storage/' . $customer->photo_path) }}"
                                    alt="Foto de {{ $customer->name }}"
                                    width="48"
                                    height="48">
                                <span>{{ $customer->name }}</span>
                            </div>
                        </td>
                        <td>{{ $customer->email }}</td>
                        <td data-phone-mask>{{ $customer->phone }}</td>
                        <td>
                            <div class="actions">
                                <a class="button" href="{{ route('customers.edit', $customer) }}">
                                    Editar
                                </a>

                                <form action="{{ route('customers.destroy', $customer) }}"
                                    method="POST"
                                    onsubmit="return confirm('Deseja excluir este cliente? Esta ação não pode ser desfeita.');">
                                    @csrf
                                    @method('DELETE')

                                    <button class="button button--danger" type="submit">Excluir</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">Nenhum cliente cadastrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($customers->hasPages())
        <nav aria-label="Paginação de clientes">
            @if ($customers->onFirstPage())
            <span>Anterior</span>
            @else
            <a href="{{ $customers->previousPageUrl() }}">Anterior</a>
            @endif

            <span>
                Página {{ $customers->currentPage() }}
                de {{ $customers->lastPage() }}
            </span>

            @if ($customers->hasMorePages())
            <a href="{{ $customers->nextPageUrl() }}">Próxima</a>
            @else
            <span>Próxima</span>
            @endif
        </nav>
        @endif
    </main>
</body>

</html>