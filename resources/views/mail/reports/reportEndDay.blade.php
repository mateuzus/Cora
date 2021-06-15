@component('mail.reports.message')
    Olá {{ $user->nome }}, <br>
    Estamos enviando seu relatório de todas as atividades realizadas no Tasktok
    @component('mail::button', ['url' => $url])
        Veja mais no seu app Tasktok
    @endcomponent
    @php($panel = "")
    @foreach($questionsByRole as $questions)
        @php($panel .= view('mail.reports.panelByRole', compact('questions'))->render())
    @endforeach
    @foreach($questionByUsers as $questionByUser)
        @php($panel .= view('mail.reports.panelByUser', compact('questionByUser'))->render())
    @endforeach
    {!! $panel !!}
@endcomponent


