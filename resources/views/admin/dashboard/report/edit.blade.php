<!DOCTYPE html>
<html>
<head>
    <title>Edit Laporan (Admin)</title>
</head>
<body>
    <h2>Edit Laporan</h2>

    <form action="{{ route('admin.reports.update', $report->reportID) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label>Judul</label><br>
        <input type="text" name="title" value="{{ old('title', $report->title) }}"><br><br>

        <label>Deskripsi</label><br>
        <textarea name="description">{{ old('description', $report->description) }}</textarea><br><br>

        <label>Lab</label><br>
        <select name="lab_id">
            @foreach($labs as $lab)
                <option value="{{ $lab->labID }}" {{ $lab->labID == $report->labID ? 'selected' : '' }}>
                    {{ $lab->labName }}
                </option>
            @endforeach
        </select><br><br>

        <label>Komputer</label><br>
        <select name="computer_id">
            @foreach($computersByLab[$report->labID] ?? [] as $pc)
                <option value="{{ $pc->computerID }}" {{ $pc->computerID == $report->computerID ? 'selected' : '' }}>
                    {{ $pc->computerName }}
                </option>
            @endforeach
        </select><br><br>

        <label>Status</label><br>
        <select name="status">
            <option value="new" {{ $report->status == 'new' ? 'selected' : '' }}>New</option>
            <option value="in_progress" {{ $report->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="resolved" {{ $report->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
        </select><br><br>

        <label>Lampiran Baru (opsional)</label><br>
        <input type="file" name="attachment"><br><br>

        <button type="submit">Update</button>
    </form>
</body>
</html>