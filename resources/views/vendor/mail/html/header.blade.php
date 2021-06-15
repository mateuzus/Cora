<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="http://app.tasktok.com.br/img/logo_tasktok_branco.png" class="logo" alt="Tasktok Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
