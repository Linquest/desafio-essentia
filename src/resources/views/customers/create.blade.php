<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Novo cliente</title>
    <script src="{{ asset('js/customer-photo-preview.js') }}" defer></script>
    <script src="{{ asset('js/customer-phone-mask.js') }}" defer></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="page--form">
    <main>
        <h1>Novo cliente</h1>

        @if ($errors->any())
        <p class="error" role="alert">
            Revise os campos indicados e selecione a foto novamente.
        </p>
        @endif

        <form class="customer-form" action="{{ route('customers.store') }}"
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
                <input inputmode="numeric"
                    placeholder="(48) 99999-9999" id="phone" name="phone" type="tel"
                    value="{{ is_string(old('phone')) ? old('phone') : '' }}"
                    maxlength="15" autocomplete="tel" required>
                @error('phone')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div>

                <img
                    id="photo-preview"
                    alt="Prévia da foto do cliente"
                    width="96"
                    height="96"
                    style="object-fit: cover; margin-bottom: 16px;"
                    hidden>
                <label for="photo">Foto</label>
                <input id="photo" name="photo" type="file"
                    accept="image/jpeg,image/png,image/webp"
                    aria-describedby="photo-help" required>
                <p id="photo-help">
                    JPEG, PNG ou WebP, até 2 MB.
                    Dimensões máximas: 4096 x 4096 pixels.
                </p>
                @error('photo')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="actions">
                <button class="button button--primary" type="submit">
                    Salvar
                </button>

                <a class="button" href="{{ route('customers.index') }}">
                    Cancelar
                </a>
            </div>
        </form>
    </main>
</body>

</html>