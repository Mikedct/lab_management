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
                <th>Edit</th>
                <th>Delete</th>
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
                    <td><a href="{{ route('admin.reports.edit', [$report->reportID]) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                    </td>
                    <td>
                        <form action="{{ route('admin.reports.destroy', $report->reportID) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus laporan ini?')" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </td>

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