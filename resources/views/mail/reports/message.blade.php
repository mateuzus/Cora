@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')


    Você recebeu esta mensagem porque é membro cadastrado do Tasktok.
    Acesse a página da sua conta para mudar suas informações de contato, configurações de privacidade e outras configurações. Leia nossa Política de privacidade
    TaskTok, Campinas SP .© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')

@endcomponent
@endslot
@endcomponent
