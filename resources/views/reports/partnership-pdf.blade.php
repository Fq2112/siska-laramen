<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SISKA Partnership Credentials: API Key & API Secret</title>
    <style>
        h1, h2, h3, h4, h5, h6 {
            text-align: center;
        }

        #data-table {
            width: auto;
            border-collapse: collapse;
            margin: 0 auto;
        }

        #data-table td, th {
            border: 1px solid #ddd;
            text-align: left;
            padding: 8px;
        }

        #data-table tr:nth-child(even) {
            background-color: #eee;
        }

    </style>
</head>
<body>
<h1 style="margin-bottom: 5px">{{$partnership->name}}</h1>
<h3 style="margin-top: 0;margin-bottom: 5px">Credentials API Key & API Secret</h3>
<hr style="margin-bottom: .5em">
<table border="0" cellpadding="0" cellspacing="0" align="center" id="data-table">
    <tr>
        <td>API Key</td>
        <td>{{$partnership->api_key}}</td>
    </tr>
    <tr>
        <td>API Secret</td>
        <td>{{$partnership->api_secret}}</td>
    </tr>
    <tr>
        <td>API Expiry</td>
        <td>{{\Carbon\Carbon::parse($partnership->api_expiry)->format('l, j F Y')}}</td>
    </tr>
</table>
</body>
</html>