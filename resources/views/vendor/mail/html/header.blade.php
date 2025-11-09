@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://bit.ly/43gFjGI" class="logo" alt="PropertyJTG">
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
