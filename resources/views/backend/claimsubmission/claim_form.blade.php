<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            padding-top: 0;
            padding-bottom: 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 11px;
            line-height: 24px;
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #000000;

        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            /* padding: 5px; */
            vertical-align: top;
        }

        /* .invoice-box table tr td:nth-child(2) {
            text-align: right;
        } */
        /* .invoice-box table tr.top table td {
            padding-bottom: 20px;
        } */
        .invoice-box table tr.top table td.title {
            font-size: 35px;
            line-height: 45px;
            color: #000000;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .topDiv {
            font-size: 11px;
        }

        p {
            margin: 0;
        }

        h2 {
            text-align: center;
        }

        /* .content-table th,
        .content-table td {
            border: 1px solid #000000;
            text-align: left;
        } */

        .content-table,
        .content-table th,
        .content-table td {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
            /* Ensures equal width for all columns */
            padding: 0%;
            text-align: left;
        }

        .content-table td {
            /* font-size: 75%; */
            padding-left: 1%;
        }

        .content-table tr {
            /* font-size: 75%; */
            line-height: 16px;
        }

        .content-table {
            /* font-size: 75%; */
            font-size: 9px;
        }

        .text-capital {
            text-transform: uppercase;
        }

        .marginLessP {
            margin: 0;
        }

        .underlineT {
            color: #000000;
        }

        /* .bottomG {
            position: fixed;
            bottom: 0;
            width: 100%;
        } */
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="12">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ asset('admin/assets/images/midas.jpg') }}"
                                    style="width: 20%; max-width: 300px;">
                            </td>
                        </tr>
                    </table>
                </td>

            </tr>
            <tr>
                <td>

                    <p class="topDiv p-0">

                        (साविकः आइएमई जनरल इन्स्योरेन्स लिमिटेड र पुडेन्सियल इन्स्योरेन्स कम्पनी एक आपसमा गाभिएर बनेको
                        बीमा कम्पनी) <br>
                        प्रधान कार्यालयः नारायण चौर, नक्साल, पोष्ट बक्स नं. २१७४६, काठमाडौं, नेपाल<br>
                        फोन नं. ०१-४५११५१०, ४५११५२०, ४५११७३५, ४५२५५०८, ४५२५५०९ <br>
                        टोल फ्री नं. १६६००१ ७९ ३५३, फ्याक्सः ०१-४५११७३६<br>
                        E-mail: info@igiprudential.com, Web: www.igiprudential.com <br>

                    </p>
                </td>
            </tr>
            <tr class="information">
                <td colspan="12">
                    <h2 class="text-capital" style="margin: 0%;"><u>Group medical insurance claim form</u> </h2>
                </td>
            </tr>
            <tr>
                <td colspan="12" style="margin-top:2%; margin-botton: 1%;">
                    {{-- <small > --}}
                    This form is issued without admission of liability and should be completed and return to <b>IGI
                        Prudential Insurance Limited </b> Kathmandu as soon as possible and if any event within 30
                    days of commencement of illness or date of accident.
                    {{-- </small> --}}
                </td>
            </tr>
            <table class="content-table">
                <tr>
                    <td class="text-capital" colspan="2">Policy no: <span id="policy_form_no"
                            class="onlyfirstcapital">{{ $request['policy_no'] }}</span></td>
                    <td class="text-capital">Hospital Name: <span id="policy_form_hospital_name"
                            class="onlyfirstcapital">{{ $request['hospital_name'] }}</span></td>
                </tr>
                <tr>
                    <td class="text-capital" colspan="4">table of benefit no:</td>
                </tr>
                <tr>
                    <td class="text-capital" colspan="2">Insured Name: <span id="policy_form_no"
                            class="onlyfirstcapital">{{ $member?->client?->name }}</span></td>
                    <td class="text-capital">Branch : <span id="policy_form_no"
                            class="onlyfirstcapital">{{ $member?->branch }}</span></td>
                </tr>
                <tr>
                    <td class="text-capital" colspan="2">Address: <span id="policy_form_no"
                            class="onlyfirstcapital">{{ $member?->address }}</span></td>
                    <td class="text-capital">Phone no: <span id="policy_form_no"
                            class="onlyfirstcapital">{{ $member?->mobile }}</span></td>
                </tr>
                <tr>
                    <td class="text-capital" colspan="2">Employee Name: <span id="policy_form_no"
                            class="onlyfirstcapital">{{ $member?->user?->fname . ' ' . $member?->user?->mname . ' ' . $member?->user?->lname }}</span>
                    </td>
                    <td class="text-capital">Designation: <span id="policy_form_no"
                            class="onlyfirstcapital">{{ $member?->designation }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="text-capital" colspan="2">Name of the dependent: <span id="policy_form_no"
                            class="onlyfirstcapital">{{ isset($member?->relatives[0]) ? $member?->relatives[0]?->rel_name : '' }}
                        </span></td>
                    <td class="text-capital">Relationship: <span id="policy_form_no"
                            class="onlyfirstcapital">{{ isset($member?->relatives[0]) ? $member?->relatives[0]?->rel_relation : '' }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="text-capital">Date Of Birth: <span id="policy_form_no"
                            class="onlyfirstcapital">{{ isset($member?->relatives[0]) ? $member?->relatives[0]?->rel_dob : $member?->date_of_birth_ad }}</span><br>(patient)
                    </td>
                    <td class="text-capital">expenses details</td>
                    <td class="text-capital">Cause of illeness: <span id="policy_form_no"
                            class="onlyfirstcapital">{{ $request['treatment'] }}</span></td>
                </tr>
                <tbody>
                    <tr>
                        <!-- Nested table inside a single cell for S.N. and Test -->
                        <td class="text-capital" style="padding: 0; border: none;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr>
                                    <td style="width: 11%; border:none; border-right:1px solid black; font-size: 100%">
                                        S.N.
                                    </td>
                                    <td style="width: 89%;  border:none; font-size: 100%">Particulars</td>
                                </tr>
                            </table>
                        </td>

                        <!-- Regular columns for Particulars and Amount -->
                        <td class="text-capital"></td>
                        <td class="text-capital">Amount: <span id="policy_form_no" class="onlyfirstcapital"></span></td>
                    </tr>
                    @foreach ($request['headingAmountData'] as $headingAmount)
                        <tr>
                            <td class="text-capital" style="padding: 0; border: none;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tr>
                                        <td
                                            style="width: 12%; border:none; border-right:1px solid black; font-size: 100%; border-top:1px solid black;">
                                            {{ $loop->iteration }}</td>
                                        <td
                                            style="width: 88%;  border:none; font-size: 100%; border-top:1px solid black;">
                                            {{ $headingAmount['headingName'] }}</td>
                                    </tr>
                                </table>
                            </td>

                            <td class="text-capital">{{ $headingAmount['remark'] }}</td>
                            <td class="text-capital">{{ numberFormatter($headingAmount['AmountValue']) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        @php
                            $totalAmount = array_sum(array_column($request['headingAmountData'], 'AmountValue'));
                        @endphp
                        <td>Total (Figure) NRs.</td>
                        <td>{{ numberFormatter($totalAmount) }}</td>
                    </tr>
                </tfoot>
            </table>
            <tr>
                <td colspan="12">
                    <P style="margin-top: 2%;">
                        <b class="underlineT">Amount in Words:
                        </b>
                        <span class="m-0 p-0 text-decoration-underline"
                            style="text-decoration: underline !important;">{{ trim(numberToWordsNp($totalAmount)) }}</span><br>
                        {{-- <small> --}}
                        I declare that I have/my dependent has suffered the above described injuries/illness and
                        that to the best of my knowledge And belief the forgoing particulars are in every respect
                        true. I also declare that there is no other insurance or other source to recover the item
                        claimed.
                        {{-- </small> --}}
                    </P>
                </td>
            </tr>
        </table>
        <div class="bottomG row">

            <b>Official Stamp</b>
            <div class="col-3" style="border: 1px solid black; width:29%;">
                <br>
                <br>
            </div>
            <div style="width: 100%; display: flex;">
                <div style="width: 50%; padding-right: 20px;">
                    <br>
                    <p class="marginLessP underlineT">_______________</p>
                    <p class="marginLessP">Verified By</p>
                    <p class="marginLessP">Name:</p>
                    <p class="marginLessP">Designation:</p>
                    <p class="marginLessP">Date:</p>
                </div>
                <div style="width: 50%; padding-left: 20px;">
                    <p class="marginLessP underlineT">Chairman's signature:___________________</p>
                    <p class="marginLessP underlineT">Name:_______________________________</p>
                </div>
            </div>

        </div>
    </div>
</body>

</html>
