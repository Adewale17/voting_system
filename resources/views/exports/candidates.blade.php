<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Candidates List</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Candidates List</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Matric No</th>
                <th>Position</th>
                <th>Election</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($candidates as $index => $candidate)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $candidate->first_name }} {{ $candidate->last_name }} {{ $candidate->other_name }}</td>
                    <td>{{ $candidate->matric_no }}</td>
                    <td>{{ $candidate->position }}</td>
                    <td>{{ $candidate->election?->title }}</td>
                    <td>{{ ucfirst($candidate->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
