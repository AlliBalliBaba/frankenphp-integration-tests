<div>

    <table>
        <thead>
        <tr>
            <th>Row</th>
            <th>Random #</th>
        </thead>
        <tbody>
        @for($i = 0; $i < $rows; $i++)
            @include('row', ['row' => $i])
        @endfor
        </tbody>
    </table>

</div>
