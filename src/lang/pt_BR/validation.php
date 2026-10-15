<?php

return [
    'required' => 'O campo :attribute é obrigatório.',
    'string' => 'O campo :attribute deve ser um texto.',
    'email' => 'Informe um e-mail válido.',
    'unique' => 'Este :attribute já está cadastrado.',
    'image' => 'O campo :attribute deve conter uma imagem válida.',
    'mimes' => 'A foto deve ser JPEG, PNG ou WebP.',
    'dimensions' => 'A foto deve ter no máximo :max_width pixels de largura e :max_height pixels de altura.',
    'uploaded' => 'Não foi possível enviar a foto. Use um arquivo de até 2 MB.',

    'max' => [
        'string' => 'O campo :attribute deve ter no máximo :max caracteres.',
        'file' => 'A foto deve ter no máximo :max KB.',
    ],

    'attributes' => [
        'name' => 'nome',
        'email' => 'e-mail',
        'phone' => 'telefone',
        'photo' => 'foto',
    ],
];
