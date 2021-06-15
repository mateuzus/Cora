@component('mail.reports.message')
    Olá {{ $user->nome }}, <br>
    Estamos enviando seu relatório das listas criadas pelo Tasktok
    @component('mail::button', ['url' => $url])
        Veja mais no seu app Tasktok
    @endcomponent
    @component('mail::panel')
        Perguntas Cadastradas:  {{ $listingArray['total'] }} <br>
        Perguntas Respondidas:  {{ $listingArray['answers'] }} <br>
        Efetividade da Rede:  {{ $listingArray['effectiveness'] }} %

    @endcomponent

@endcomponent


