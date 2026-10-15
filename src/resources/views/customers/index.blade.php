<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clientes</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .customer {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .customer img {
            object-fit: cover;
            border-radius: 6px;
        }

        nav {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-top: 24px;
        }
    </style>
</head>

<body>
    <main>
        <h1>Clientes</h1>

        <p>Total de clientes: {{ $customers->total() }}</p>

        <table>
            <thead>
                <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Telefone</th>
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
                    <td>{{ $customer->phone }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">Nenhum cliente cadastrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

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