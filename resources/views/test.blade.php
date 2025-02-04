@extends('layouts.candidat')

@section('title', 'jobs')

@section('page-title', 'Mis Solicitudes')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Applications Tracker</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        body {
            display: flex;
            background-color: #f8f9fa;
        }

        .sidebar {
            width: 250px;
            background: white;
            height: 100vh;
            padding: 20px;
            border-right: 1px solid #e9ecef;
        }

        .logo {
            color: #0066ff;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .menu-item {
            padding: 12px;
            margin: 4px 0;
            border-radius: 8px;
            cursor: pointer;
            color: #4a5568;
        }

        .menu-item.active {
            background: #f0f4ff;
            color: #0066ff;
        }

        .main-content {
            flex: 1;
            padding: 20px 40px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .date-range {
            background: white;
            padding: 8px 16px;
            border-radius: 6px;
            border: 1px solid #e9ecef;
        }

        .tabs {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .tab {
            padding: 8px 16px;
            cursor: pointer;
            border-bottom: 2px solid transparent;
        }

        .tab.active {
            border-bottom: 2px solid #0066ff;
            color: #0066ff;
        }

        .applications-table {
            width: 100%;
            background: white;
            border-radius: 8px;
            border-collapse: collapse;
        }

        .applications-table th,
        .applications-table td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }

        .status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
        }

        .status.evaluation {
            background: #fff3e0;
            color: #ff9800;
        }

        .status.confirmed {
            background: #e8f5e9;
            color: #4caf50;
        }

        .status.interview {
            background: #e3f2fd;
            color: #2196f3;
        }

        .status.process {
            background: #f3e5f5;
            color: #9c27b0;
        }

        .status.rejected {
            background: #ffebee;
            color: #f44336;
        }
    </style>
</head>
<body>
    

    <div class="main-content">
        <div class="header">
            <div class="date-range">Jul 19 - Jul 25</div>
        </div>

        <div class="tabs">
            <div class="tab active">Todo (45)</div>
            <div class="tab">Evaluación (34)</div>
            <div class="tab">En proceso (18)</div>
            <div class="tab">Entrevistas (5)</div>
            <div class="tab">Confirmados (2)</div>
            <div class="tab">Descartados (2)</div>
        </div>

        <table class="applications-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ofertas</th>
                    <th>Fecha de aplicación</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Social Media Assistant</td>
                    <td>24 Julio 2021</td>
                    <td><span class="status evaluation">Evaluación</span></td>
                    <td>•••</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Social Media Assistant</td>
                    <td>20 Julio 2021</td>
                    <td><span class="status confirmed">Confirmada</span></td>
                    <td>•••</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Social Media Assistant</td>
                    <td>16 Julio 2021</td>
                    <td><span class="status interview">Entrevista</span></td>
                    <td>•••</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Social Media Assistant</td>
                    <td>14 Julio 2021</td>
                    <td><span class="status process">En proceso</span></td>
                    <td>•••</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Social Media Assistant</td>
                    <td>10 Julio 2021</td>
                    <td><span class="status rejected">Descartado</span></td>
                    <td>•••</td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Social Media Assistant</td>
                    <td>10 Julio 2021</td>
                    <td><span class="status rejected">Descartado</span></td>
                    <td>•••</td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>Social Media Assistant</td>
                    <td>10 Julio 2021</td>
                    <td><span class="status rejected">Descartado</span></td>
                    <td>•••</td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>Social Media Assistant</td>
                    <td>14 Julio 2021</td>
                    <td><span class="status process">En proceso</span></td>
                    <td>•••</td>
                </tr>
                <tr>
                    <td>9</td>
                    <td>Social Media Assistant</td>
                    <td>14 Julio 2021</td>
                    <td><span class="status process">En proceso</span></td>
                    <td>•••</td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>Social Media Assistant</td>
                    <td>14 Julio 2021</td>
                    <td><span class="status process">En proceso</span></td>
                    <td>•••</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
@endsection
