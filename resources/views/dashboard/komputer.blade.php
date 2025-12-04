<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Komputer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        table thead {
            background: #2c3e50;
            color: #fff;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        table tr:hover {
            background: #f0f0f0;
        }
        .status-available {
            color: green;
            font-weight: bold;
        }
        .status-unavailable {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>Dashboard Daftar Komputer</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Komputer</th>
            <th>Status</th>
            <th>Storage (GB)</th>
            <th>OS</th>
            <th>CPU</th>
            <th>GPU</th>
            <th>RAM (GB)</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($komputers as $k)
        <tr>
            <td>{{ $k->computerID }}</td>
            <td>{{ $k->computerName }}</td>

            <td>
                @if($k->status === 'Active')
                    <span class="status-available">{{ $k->status }}</span>
                @else
                    <span class="status-unavailable">{{ $k->status }}</span>
                @endif
            </td>

            <td>{{ $k->storage }}</td>
            <td>{{ $k->OS }}</td>
            <td>{{ $k->CPU }}</td>
            <td>{{ $k->GPU }}</td>
            <td>{{ $k->RAM }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="8" style="text-align:center; padding:20px;">Tidak ada data komputer.</td>
        </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
