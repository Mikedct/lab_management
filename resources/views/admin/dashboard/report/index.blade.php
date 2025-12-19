<!DOCTYPE html>
<html>
<head>
    <title>Daftar Reports</title>
</head>
<body>
    <h2>Daftar Reports</h2>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Report ID</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Computer</th>
                <th>Lab</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $report)
                <tr>
                    <td>{{ $report->reportID }}</td>
                    <td>{{ $report->title }}</td>
                    <td>{{ $report->description }}</td>
                    <td>{{ $report->computerName }}</td>
                    <td>{{ $report->labName }}</td>
                    <td>{{ $report->updated_at }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" align="center">Tidak ada data laporan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>