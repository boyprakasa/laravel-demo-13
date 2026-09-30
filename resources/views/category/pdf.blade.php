@php
    $rows = collect($data);
    $headers = $rows->isNotEmpty() ? array_keys((array) $rows->first()) : [];
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Laporan</title>
    <style>
        @page {
            margin: 20px 24px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: auto;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 4px 6px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
        }

        th {
            background: #e9ecef;
            font-weight: bold;
        }

        tr {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                @foreach ($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
                <tr>
                    @foreach ((array) $row as $cell)
                        <td>{{ is_array($cell) ? implode(', ', $cell) : $cell }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
