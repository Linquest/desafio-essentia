<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar cliente</title>
    <script src="{{ asset('js/customer-photo-preview.js') }}" defer></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 680px;
            margin: 40px auto;
            padding: 0 16px;
        }

        form {
            display: grid;
            gap: 20px;
        }

        label {
            display: block;
            margin-bottom: 6px;
        }

        input {
            box-sizing: border-box;
            width: 100%;
            padding: 8px;
        }

        .error {
            color: #b91c1c;
            margin: 6px 0 0;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        button {
            padding: 10px 16px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <main>
        <h1>Editar cliente</h1>

        @if ($errors->any())
        <p class="error" role="alert">
            Revise os campos indicados. Se selecionou uma nova foto, selecione-a novamente.
        </p>
        @endif

        <form action="{{ route('customers.update', $customer) }}"
            method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <label for="name">Nome</label>
                <input id="name" name="name" type="text"
                    value="{{ is_string(old('name', $customer->name)) ? old('name', $customer->name) : '' }}"
                    maxlength="150" autocomplete="name" required>
                @error('name')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email">E-mail</label>
                <input id="email" name="email" type="email"
                    value="{{ is_string(old('email', $customer->email)) ? old('email', $customer->email) : '' }}"
                    maxlength="254" autocomplete="email" required>
                @error('email')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone">Telefone</label>
                <input id="phone" name="phone" type="tel"
                    value="{{ is_string(old('phone', $customer->phone)) ? old('phone', $customer->phone) : '' }}"
                    maxlength="30" autocomplete="tel" required>
                @error('phone')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <p>Prévia da foto</p>

                <img
                    id="photo-preview"
                    src="{{ asset('storage/' . $customer->photo_path) }}"
                    alt="Prévia da foto do cliente"
                    width="96"
                    height="96"
                    style="object-fit: cover; margin-bottom: 16px;">

                <label for="photo">Substituir foto (opcional)</label>
                <input id="photo" name="photo" type="file"
                    accept="image/jpeg,image/png,image/webp"
                    aria-describedby="photo-help">

                <p id="photo-help">
                    Sem selecionar outra imagem, a foto atual será mantida.
                    JPEG, PNG ou WebP, até 2 MB.
                    Dimensões máximas: 4096 x 4096 pixels.
                </p>

                @error('photo')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="actions">
                <button type="submit">Salvar</button>
                <a href="{{ route('customers.index') }}">Cancelar</a>
            </div>
        </form>
    </main>
</body>

</html>