<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Novo cliente</title>

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
        <h1>Novo cliente</h1>

        @if ($errors->any())
        <p class="error" role="alert">
            Revise os campos indicados e selecione a foto novamente.
        </p>
        @endif

        <form action="{{ route('customers.store') }}"
            method="POST"
            enctype="multipart/form-data">
            @csrf

            <div>
                <label for="name">Nome</label>
                <input id="name" name="name" type="text"
                    value="{{ is_string(old('name')) ? old('name') : '' }}"
                    maxlength="150" autocomplete="name" required>
                @error('name')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email">E-mail</label>
                <input id="email" name="email" type="email"
                    value="{{ is_string(old('email')) ? old('email') : '' }}"
                    maxlength="254" autocomplete="email" required>
                @error('email')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone">Telefone</label>
                <input id="phone" name="phone" type="tel"
                    value="{{ is_string(old('phone')) ? old('phone') : '' }}"
                    maxlength="30" autocomplete="tel" required>
                @error('phone')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="photo">Foto</label>
                <input id="photo" name="photo" type="file"
                    accept="image/jpeg,image/png,image/webp"
                    aria-describedby="photo-help" required>
                <p id="photo-help">
                    JPEG, PNG ou WebP, até 2 MB.
                    Dimensões máximas: 4096 × 4096 pixels.
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