<table class="panel" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td class="panel-content">
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td class="panel-item">
                        <p>
                            <strong>Perfil: </strong> {!! $questions['role']->nome !!} <br>
                            <strong>Total de Perguntas Criadas:</strong>  {!! $questions['qtdQuestions'] !!} <br>
                            <strong>Quantidade de Respondidas:</strong>  {!! $questions['qtdQuestionsAnswers'] !!} <br>
                            <strong>Efetividade:</strong>  {!! $questions['effectiveness']  !!} %<br>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
