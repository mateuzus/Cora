<table class="panel" width="100%" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
        <td class="panel-content">
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
                <tr>
                    <td class="panel-item">
                        <p>
                            <strong>Nome do Operador: </strong> {!! $questionByUser['usersOperator']->nome !!} <br>
                            <strong>Total de Perguntas Criadas:</strong>  {!! $questionByUser['qtdQuestions'] !!} <br>
                            <strong>Quantidade de Respondidas:</strong>  {!! $questionByUser['qtdQuestionsAnswers'] !!} <br>
                            <strong>Efetividade do Operador:</strong>  {!! $questionByUser['effectiveness'] !!} %<br>
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

