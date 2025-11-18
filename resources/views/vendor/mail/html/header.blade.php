@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://lh3.googleusercontent.com/a/ACg8ocIlm9a2wmzZ2IzQRVbYgmNHSpYMGDA_Od_BWCcNRSZanjFYrAc=s288-c-no" class="logo" alt="PropertyJTG">
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
