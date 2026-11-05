<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Lead Details - Enquiry #{{ $SpinnerForm->id }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #0f172a;
            margin: 24px;
            font-size: 12px;
        }
        .dossier-header {
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 14px;
            margin-bottom: 18px;
        }
        .dossier-title {
            font-size: 18px;
            font-weight: bold;
            color: #0f172a;
            margin: 0 0 4px 0;
        }
        .dossier-subtitle {
            font-size: 11px;
            color: #64748b;
            margin: 0;
        }
        .customer-strip {
            background: #fff7ed;
            border: 1px solid #fed7aa;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 18px;
        }
        .customer-name {
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
            margin: 0 0 5px 0;
        }
        .customer-meta {
            font-size: 11px;
            color: #475569;
        }
        .badge-enquiry {
            display: inline-block;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 4px;
            padding: 2px 6px;
            font-weight: bold;
            color: #0f172a;
        }
        table.spec-grid {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px;
            margin: -10px -10px 10px -10px;
        }
        td.spec-box {
            width: 50%;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 14px;
            vertical-align: top;
        }
        td.spec-box-full {
            width: 100%;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 14px;
            vertical-align: top;
        }
        .spec-label {
            font-size: 10px;
            font-weight: bold;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 6px;
        }
        .spec-value {
            font-size: 13px;
            font-weight: bold;
            color: #0f172a;
            word-break: break-word;
        }
        .prize-badge {
            display: inline-block;
            background: #fef08a;
            color: #854d0e;
            padding: 4px 10px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 12px;
        }
        .proof-section {
            margin-top: 16px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 14px;
            background: #ffffff;
        }
        .proof-title {
            font-size: 12px;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 10px;
        }
        .proof-img-wrap {
            text-align: center;
            background: #f8fafc;
            padding: 12px;
            border-radius: 8px;
        }
        .proof-img-wrap img {
            max-width: 100%;
            max-height: 280px;
        }
    </style>
</head>
<body>

    <div class="dossier-header">
        <div class="dossier-title">Customer Lead Details</div>
        <div class="dossier-subtitle">Full dossier of customer spin and prize enquiry</div>
    </div>

    @php
        $rawCampLabel = $SpinnerForm->campaign_name ?: ($SpinnerForm->camp_short_name ?? '');
        // If campaign title contains Indic/non-Latin characters unsupported by DomPDF DejaVu Sans, fallback to ASCII campaign_name
        if (!empty($rawCampLabel) && preg_match('/[\x{0900}-\x{0DFF}]/u', $rawCampLabel)) {
            $asciiCandidate = $SpinnerForm->camp_short_name ?? '';
            if (!empty($asciiCandidate) && !preg_match('/[\x{0900}-\x{0DFF}]/u', $asciiCandidate)) {
                $rawCampLabel = $asciiCandidate;
            } else {
                $rawCampLabel = 'Campaign #' . ($SpinnerForm->camping_id ?? '');
            }
        }
    @endphp
    <div class="customer-strip">
        <div class="customer-name">{{ $SpinnerForm->name ?: 'Anonymous Customer' }}</div>
        <div class="customer-meta">
            <span class="badge-enquiry">Enquiry #{{ $SpinnerForm->id }}</span>
            @if(!empty($rawCampLabel))
                &bull; <strong style="color: #ea580c;">{{ $rawCampLabel }}</strong>
            @endif
            &bull; {{ date('d M Y, h:i A', strtotime($SpinnerForm->created_at)) }}
        </div>
    </div>

    <table class="spec-grid">
        <tr>
            <td class="spec-box">
                <div class="spec-label">Prize Result / Slice Won</div>
                <div class="spec-value">
                    @if(!empty($SpinnerForm->spinner_name))
                        <span class="prize-badge">{{ $SpinnerForm->spinner_name }}</span>
                    @else
                        <span style="color: #94a3b8; font-style: italic;">No Prize / Slices Deleted</span>
                    @endif
                </div>
            </td>
            <td class="spec-box">
                <div class="spec-label">Interested Model / Option</div>
                <div class="spec-value">{{ $SpinnerForm->bike_name ?: 'None Selected' }}</div>
            </td>
        </tr>
        <tr>
            <td class="spec-box">
                <div class="spec-label">Primary Phone</div>
                <div class="spec-value">{{ $SpinnerForm->phone ?: 'Not Provided' }}</div>
            </td>
            <td class="spec-box">
                <div class="spec-label">WhatsApp Contact</div>
                <div class="spec-value">{{ $SpinnerForm->whatsapp_number ?: 'Not Provided' }}</div>
            </td>
        </tr>
        <tr>
            <td class="spec-box">
                <div class="spec-label">Email Address</div>
                <div class="spec-value">{{ $SpinnerForm->email ?: 'Not Provided' }}</div>
            </td>
            <td class="spec-box">
                <div class="spec-label">Device IP Address</div>
                <div class="spec-value" style="font-family: monospace;">{{ $SpinnerForm->mac_address ?: 'N/A' }}</div>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="spec-box-full">
                <div class="spec-label">Delivery / Home Address</div>
                <div class="spec-value">{{ $SpinnerForm->address ?: 'Not Provided' }}</div>
            </td>
        </tr>
    </table>

    <div class="proof-section">
        <div class="proof-title">Attached Customer Bill / Proof</div>
        @if(!empty($proofImageSrc))
            <div class="proof-img-wrap">
                <img src="{{ $proofImageSrc }}" alt="Attached Proof">
            </div>
        @elseif(!empty($SpinnerForm->schreenshot))
            <div style="font-size: 11px; color: #3b82f6;">
                Proof File URL: {{ $SpinnerForm->schreenshot }}
            </div>
        @else
            <div style="text-align: center; color: #94a3b8; font-style: italic; padding: 10px 0;">
                No receipt or bill proof uploaded for this enquiry.
            </div>
        @endif
    </div>

</body>
</html>

