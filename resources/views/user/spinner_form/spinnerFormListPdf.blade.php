<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 11px; color: #333; margin: 20px; }
        .header-title { text-align: center; margin-bottom: 20px; }
        .header-title h2 { margin: 0; color: #111; font-size: 18px; }
        .header-title p { margin: 5px 0 0; color: #666; font-size: 12px; }
        table.leads-table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 10px; }
        table.leads-table th { background-color: #f1f5f9; color: #1e293b; padding: 7px 5px; border: 1px solid #cbd5e1; font-weight: bold; text-align: left; }
        table.leads-table td { padding: 6px 5px; border: 1px solid #cbd5e1; word-break: break-word; }
        table.leads-table tr:nth-child(even) { background-color: #f8fafc; }
    </style>
</head>
<body>

    <div class="header-title">
        <h2>Campaign Leads Report</h2>
        <p><strong>Campaign:</strong> {{ $camping->title ?? 'Campaign' }} | <strong>Total Leads:</strong> {{ count($SpinnerForm) }} | <strong>Exported:</strong> {{ date('d M Y, h:i A') }}</p>
    </div>

    <table class="leads-table">
        <thead>
            <!-- start row -->
            <tr>
                <th style="border: 1px solid black ;">Sl.</th>
                <th style="border: 1px solid black ;">Date</th>
                <th style="border: 1px solid black ;">Spn Name</th>
                <th style="border: 1px solid black ;">Model</th>
                <th style="border: 1px solid black ;">Name</th>
                <th style="border: 1px solid black ;">Email</th>
                <th style="border: 1px solid black ;">Whatsapp</th>
                <th style="border: 1px solid black ;">Phone</th>
                <th style="border: 1px solid black ;">Screen </th>
                <th style="border: 1px solid black ;">IP Addr</th>
            </tr>
            <!-- end row -->
        </thead>
        <tbody>

            @foreach ($SpinnerForm as $key=> $item)
                <!-- start row -->
                <tr style="border: 1px solid black ;">
                    <td style="border: 1px solid black ;">{{$key+1}}</td>
                    <td style="border: 1px solid black ;">{{$item->created_at}}</td>
                    <td style="border: 1px solid black ;">{{$item->spinner_name}}</td>
                    <td style="border: 1px solid black ;">{{$item->bike_name}}</td>
                    <td style="border: 1px solid black ;">{{$item->name}}</td>
                    <td style="border: 1px solid black ;">{{$item->email}}</td>
                    <td style="border: 1px solid black ;">{{$item->whatsapp_number}}</td>
                    <td style="border: 1px solid black ;">{{$item->phone}}</td>
                    <td style="border: 1px solid black ;">
                        <a href="{{$item->schreenshot}}" download="{{$item->name}}">Download</a>
                    </td>
                    <td  style="border: 1px solid black ;">{{$item->mac_address}}</td>
                    
                </tr>
                <!-- end row --> 
            @endforeach

            
            
        </tbody>
    </table>
          
</body>
</html>