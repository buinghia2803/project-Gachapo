@foreach ($reviews as $reivew)
    <tr>
        <th scope="row"> {{ $reivew->id }}</th>
        <td>
            <span class="text-overflow-ellipsis">
                {{ $reivew->content }}</span>
        </td>
        <td>{{ $reivew->order->user->name }}</td>
        <td>{{ \Carbon\Carbon::parse($reivew->created_at)->format('Y年m月d日') }}
        </td>
        <td>
            <a href="#">{{ __('labels.AC001_B001') }}</a>
        </td>
    </tr>
@endforeach
