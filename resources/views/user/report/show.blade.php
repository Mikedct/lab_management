<!DOCTYPE html>
<html>
<head>
    <title>Detail Report</title>
</head>
<body>
    <h2>Detail Laporan</h2>

    <p><strong>Report ID:</strong> {{ $report->reportID }}</p>
    <p><strong>Judul:</strong> {{ $report->title }}</p>
    <p><strong>Deskripsi:</strong> {{ $report->description }}</p>
    <p><strong>Computer:</strong> {{ $report->computer_name }}</p>
    <p><strong>Lab:</strong> {{ $report->lab_name }}</p>
    <p><strong>Updated At:</strong> {{ $report->updated_at }}</p>
</body>
</html>