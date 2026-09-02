<?php

declare(strict_types=1);

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <title>System Information</title>

    <style>
        body {
            font-family: monospace;
            max-width: 700px;
            margin: 80px auto;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td {
            border-bottom: 1px solid #ccc;
            padding: 10px;
        }

        .hint {
            margin-top: 40px;
            padding: 20px;
            border: 1px solid #aaa;
        }
    </style>
</head>

<body>

<h1>System Information</h1>

<table>

<tr>
    <td>Hostname</td>
    <td>the-end-and-the-beginning</td>
</tr>

<tr>
    <td>Operating System</td>
    <td>goodluck</td>
</tr>

<tr>
    <td>HTTP Server</td>
    <td>apache/2.4.62</td>
</tr>

<tr>
    <td>PHP</td>
    <td>8.3.12</td>
</tr>

</table>


<div class="hint">

<h2>Administrator Naming Convention</h2>

<p>
Username:
&lt;hostname&gt;-admin
</p>

<p>
Password:
&lt;os&gt;
</p>

</div>


<p>
<a href="/goodjob/secret-admin-page/">
Back to Login
</a>
</p>

</body>
</html>
